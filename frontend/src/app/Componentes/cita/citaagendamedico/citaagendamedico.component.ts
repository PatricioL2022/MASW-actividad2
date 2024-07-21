
import { BryntumCalendarModule } from '@bryntum/calendar-angular';
import { Component, ViewChild } from '@angular/core';
import { BryntumCalendarComponent, BryntumCalendarProjectModelComponent } from '@bryntum/calendar-angular';
import { calendarProps, projectProps } from '../../../app.config';
import { ApiService } from '../../../servicios/api.service';
import { MessageService } from 'primeng/api';
import { CommonModule } from '@angular/common';
@Component({
  selector: 'app-citaagendamedico',
  standalone: true,
  imports: [BryntumCalendarModule,CommonModule],
  providers: [MessageService],
  templateUrl: './citaagendamedico.component.html',
  styleUrl: './citaagendamedico.component.css'
})
export class CitaagendamedicoComponent {
  events:any=[];
  constructor(private api: ApiService,private messageService: MessageService){
  }
  calendarProps = calendarProps;
projectProps = projectProps;


  ngOnInit(): void {
    this.events = [];
    this.ListarCitas(20);
   // Object.assign(this, this.events);
    
  }
  @ViewChild('calendar') calendarComponent!: BryntumCalendarComponent;
  @ViewChild('project') projectComponent!: BryntumCalendarProjectModelComponent;

  ListarCitas(medico_id:any) {
    this.events = [];
    this.api.GetCitasPorMedico(medico_id).subscribe((result: any) => {
      if(result)
      {
        result.data.forEach((element: any) => {
          var item = {
            id         : element.id,
            name       : 'Cita '+element.Nombres+' '+element.Apellidos,
            startDate  : element.Fecha+'T'+element.HoraInicio,
            endDate    : element.Fecha+'T'+element.HoraFin,
            resourceId : element.id
        };
          this.events.push(item)
         
        });  
      }
      console.log(this.events);
      });
  }
  resources = [
    {
        id         : 1,
        name       : 'Default Calendar',
        eventColor : 'green'
        
          
  
    }
];

  


/**events = [
  {
      id         : 1,
      name       : 'Meeting',
      startDate  : '2024-07-21T10:00:00',
      endDate    : '2024-07-21T11:00:00',
      resourceId : 1
  }
];*/


}
