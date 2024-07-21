import { NgModule } from '@angular/core';
import { Routes } from '@angular/router';
import { PersonasComponent } from './Componentes/personas/personas.component';
import { InicioComponent } from './Componentes/inicio/inicio.component';
import { AgendaComponent } from './Componentes/agenda/agenda.component';
import { CitapacienteComponent } from './Componentes/cita/citapaciente/citapaciente.component';
import { CitaagendapacienteComponent } from './Componentes/cita/citaagendapaciente/citaagendapaciente.component';

import { ConsultoriosComponent } from './Componentes/consultorios/consultorios.component';
import { MedicosComponent } from './Componentes/medicos/medicos.component';
import { PacientesComponent } from './Componentes/pacientes/pacientes.component';
import { CitaagendamedicoComponent } from './Componentes/cita/citaagendamedico/citaagendamedico.component';

import { HorarioatencionComponent } from './Componentes/horarioatencion/horarioatencion.component';
import { LoginComponent } from './Login/login/login.component';
import { RolComponent } from './Componentes/rol/rol.component';
import { UsuarioComponent } from './Componentes/usuario/usuario.component';

export const routes: Routes = [
  { path: '', redirectTo: 'login', pathMatch: 'full' },
  { path: 'login', component: LoginComponent },
  { path: 'inicio', component: InicioComponent },
  { path: 'personas', component: PersonasComponent },
  { path: 'agenda/:medico_id', component: AgendaComponent },
  { path: 'cita/agenda', component: CitapacienteComponent},
  { path: 'cita/agenda/paciente/:medico_id/:medico_nombre', component: CitaagendapacienteComponent},
  { path: 'cita/agenda/medico', component: CitaagendamedicoComponent},
  { path: 'medicos', component: MedicosComponent },
  { path: 'pacientes', component: PacientesComponent },
  { path: 'consultorios', component: ConsultoriosComponent },
  { path: 'horarioatencion', component: HorarioatencionComponent },
  { path: 'rol', component: RolComponent },
  { path: 'usuario', component: UsuarioComponent },
];
