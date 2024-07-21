import { Component, OnInit } from '@angular/core';
import { HorarioAtencionDetalle } from '../../Models/HorarioAtencionDetalle';
import { map } from 'rxjs';
import { ApiService } from '../../servicios/api.service';
import {ActivatedRoute} from '@angular/router';
import { DropdownModule } from 'primeng/dropdown';
import { FormsModule } from '@angular/forms';
import { CommonModule, DatePipe } from '@angular/common';
import { CalendarModule } from 'primeng/calendar';
import { ToastModule } from 'primeng/toast';
import { MessageService } from 'primeng/api';
import { RippleModule } from 'primeng/ripple';
interface Horario {
  name: string;
  code: string;
}
interface City {
  name: string;
  code: string;
}

@Component({
  selector: 'app-agenda',
  standalone: true,
  imports: [FormsModule,DropdownModule,CommonModule,CalendarModule,ToastModule,RippleModule],
  providers: [MessageService],
  templateUrl: './agenda.component.html',
  styleUrl: './agenda.component.css'
})
export class AgendaComponent implements OnInit{
  dates: Date[] | undefined;
  medico:string='';
  medico_id:number=0;
  horarios!: Horario[];

  cities: City[] | undefined;

    selectedCity: City | undefined;

  selectedHorario: string ='';
  constructor( private route:ActivatedRoute,  private api: ApiService,private messageService: MessageService){
  }
  ngOnInit(): void {
    this.medico_id = this.route.snapshot.params['medico_id'];
    this.horarios = [];
    this.dates=[]
   
    this.ListarElementos(this.medico_id);

    this.cities = [
      { name: 'New York', code: 'NY' },
      { name: 'Rome', code: 'RM' },
      { name: 'London', code: 'LDN' },
      { name: 'Istanbul', code: 'IST' },
      { name: 'Paris', code: 'PRS' }
  ];
    
  }

  guardarAgenda(){
   if(this.selectedHorario && this.dates!.length > 0)
   {
     this.dates!.forEach(element => {
      var datePipe = new DatePipe('en-US');
      var fecha = datePipe.transform(element, 'yyyy/MM/dd');
      this.api.PostAgenda({ "Fecha":fecha,
      "horarioatenciondetalle_id": parseInt(this.selectedHorario) }).subscribe((result: any) => {
        if(result)
        {
          if(result.exito==201)
          {
            this.messageService.add({ severity: 'success', summary: 'Aviso', detail: 'Agregado correctamente' });
          }
          else {
            this.messageService.add({ severity: 'error', summary: 'Aviso', detail: 'Error al guardar la agenda' });
          }
        }
        });
    });
   }
   else {
    this.messageService.add({ severity: 'warn', summary: 'Aviso', detail: 'Ingrese todos los datos requeridos' });
   }
  }
  ListarElementos(medico_id: number) {
    this.horarios = [];
    this.api.GetHorarioAtencionDetallePorMedico(medico_id).subscribe((result: any) => {
      if(result)
      {
        result.data.forEach((element: any) => {
          this.medico = element.Nombres+" "+element.Apellidos;
          this.horarios.push(
            { 
              name: element.Nombre+" "+element.HoraInicio+" a "+element.HoraFin,
              code: element.id.toString()
            }
          );
        });
      }
      });
  }
}
