import { Routes } from '@angular/router';
import { PersonasComponent } from './Componentes/personas/personas.component';
import { InicioComponent } from './Componentes/inicio/inicio.component';
import { AgendaComponent } from './Componentes/agenda/agenda.component';
import { CitapacienteComponent } from './Componentes/cita/citapaciente/citapaciente.component';
import { CitaagendapacienteComponent } from './Componentes/cita/citaagendapaciente/citaagendapaciente.component';


export const routes: Routes = [
  { path: '', redirectTo: 'inicio', pathMatch: 'full' },
  { path: 'inicio', component: InicioComponent },
  { path: 'personas', component: PersonasComponent },
  { path: 'agenda/:medico_id', component: AgendaComponent },
  { path: 'cita/agenda', component: CitapacienteComponent},
  { path: 'cita/agenda/paciente/:medico_id/:medico_nombre', component: CitaagendapacienteComponent}
];
