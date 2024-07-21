import { Component } from '@angular/core';
import { ConfirmationService, MessageService } from 'primeng/api';
import { ApiService } from '../../../servicios/api.service';
import { CommonModule, DatePipe } from '@angular/common';
import { CalendarModule } from 'primeng/calendar';
import { FormsModule } from '@angular/forms';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { ButtonModule } from 'primeng/button';
import { ToastModule } from 'primeng/toast';
import { ActivatedRoute } from '@angular/router';
@Component({
  selector: 'app-citaagendapaciente',
  standalone: true,
  imports: [CommonModule,CalendarModule,FormsModule,ConfirmDialogModule,ButtonModule,ToastModule],
  providers: [ConfirmationService, MessageService],
  templateUrl: './citaagendapaciente.component.html',
  styleUrl: './citaagendapaciente.component.css'
})
export class CitaagendapacienteComponent {
  horarios!: any[];
  pacientes!: any[];
  medico_id:any;
  medico_nombre:any;
  selectedPaciente:number=0;
  fecha:any;
  constructor(private route:ActivatedRoute,private confirmationService: ConfirmationService,private api: ApiService,private messageService: MessageService){
  }
  ngOnInit(): void {
    this.horarios = [];
    this.pacientes = [];
    this.selectedPaciente = 0;
    this.medico_id = this.route.snapshot.params['medico_id'];
    this.medico_nombre = this.route.snapshot.params['medico_nombre'];
    //console.log(this.medico_id);
    var fechaActual = new Date();
    var datePipe = new DatePipe('en-US');
    var fechaActualFormato = datePipe.transform(fechaActual, 'yyyy-MM-dd');
    console.log(fechaActualFormato);
    this.ListarHorariosDeAgenda(this.medico_id,fechaActualFormato);
    this.ListarPacientes();
  }
  ListarHorariosDeAgenda(medico_id:any,fecha:any) {
    this.horarios = [];
    this.api.GetAgendaHorarioPorMedico(medico_id,fecha).subscribe((result: any) => {
      if(result)
      {
        this.horarios = result.data;     
      }
      });
  }
  ListarPacientes() {
    this.pacientes = [];
    this.api.GetPacientes().subscribe((result: any) => {
      if(result)
      {
        this.pacientes = result.data;     
        console.log(this.pacientes);
      }
      });
      
  }
  mostrarHorarios(){
    if(this.fecha)
    {
      var datePipe = new DatePipe('en-US');
      var fechaFormato = datePipe.transform(this.fecha, 'yyyy-MM-dd');
      this.ListarHorariosDeAgenda(this.medico_id,fechaFormato);
      console.log(fechaFormato);

    }
    console.log(this.fecha);
  }
  registrarCita(agendadetalle_id:any,paciente_id:any){
    if(agendadetalle_id>0 && paciente_id>0){
      this.api.PostCita({
        "agendadetalle_id": agendadetalle_id,
        "paciente_id": paciente_id }).subscribe((result: any) => {
          if(result)
          {
            if(result.exito==201)
            {
              this.messageService.add({ severity: 'success', summary: 'Aviso', detail: 'Agendado correctamente' });
              this.mostrarHorarios();
            }
            else {
              this.messageService.add({ severity: 'error', summary: 'Aviso', detail: 'Error al agendar la cita' });
            }
          }
          });
    }
    else {
      this.messageService.add({ severity: 'warn', summary: 'Aviso', detail: 'Ingrese todos los datos' });
    }
    
  }
  confirmaAsistencia(event: Event,horarioInicio:any,horarioFin:any,id:any) {
    //console.log('id: '+id);
    this.confirmationService.confirm({
        target: event.target as EventTarget,
        message: 'Confirma tu asistencia con <strong>'+this.medico_nombre+'</strong> en el horario de '+horarioInicio+" a "+horarioFin,
        header: 'Confirmación',
        icon: 'pi pi-exclamation-triangle',
        acceptIcon:"none",
        acceptLabel:"Confirmar",
        rejectLabel:"Cancelar",
        rejectIcon:"none",
        rejectButtonStyleClass:"p-button-text",
        accept: () => {
          this.registrarCita(id,this.selectedPaciente);
        },
        reject: () => {
           // this.messageService.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
}
}
