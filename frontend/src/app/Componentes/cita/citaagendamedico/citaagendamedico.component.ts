
import { BryntumCalendarModule } from '@bryntum/calendar-angular';
import { Component, ViewChild } from '@angular/core';
import { BryntumCalendarComponent, BryntumCalendarProjectModelComponent } from '@bryntum/calendar-angular';
import { calendarProps, projectProps } from '../../../app.config';
@Component({
  selector: 'app-citaagendamedico',
  standalone: true,
  imports: [BryntumCalendarModule],
  templateUrl: './citaagendamedico.component.html',
  styleUrl: './citaagendamedico.component.css'
})
export class CitaagendamedicoComponent {
  resources = [
    {
        id         : 1,
        name       : 'Default Calendar',
        eventColor : 'green'
        
          
  
    }
];

  


events = [
  {
      id         : 1,
      name       : 'Meeting',
      startDate  : '2024-07-21T10:00:00',
      endDate    : '2024-07-21T11:00:00',
      resourceId : 1
  }
];

calendarProps = calendarProps;
projectProps = projectProps;

@ViewChild('calendar') calendarComponent!: BryntumCalendarComponent;
@ViewChild('project') projectComponent!: BryntumCalendarProjectModelComponent;
}
