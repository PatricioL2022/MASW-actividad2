
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
    
];

calendarProps = calendarProps;
projectProps = projectProps;

@ViewChild('calendar') calendarComponent!: BryntumCalendarComponent;
@ViewChild('project') projectComponent!: BryntumCalendarProjectModelComponent;
}
