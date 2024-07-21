import { NgModule } from '@angular/core';
import { Routes } from '@angular/router';
import { PersonasComponent } from './Componentes/personas/personas.component';
import { InicioComponent } from './Componentes/inicio/inicio.component';
import { ConsultoriosComponent } from './Componentes/consultorios/consultorios.component';
import { MedicosComponent } from './Componentes/medicos/medicos.component';
import { PacientesComponent } from './Componentes/pacientes/pacientes.component';

export const routes: Routes = [
  { path: '', redirectTo: 'inicio', pathMatch: 'full' },
  { path: 'inicio', component: InicioComponent },
  { path: 'personas', component: PersonasComponent },
  { path: 'consultorios', component: ConsultoriosComponent },
  { path: 'medicos', component: MedicosComponent },
  { path: 'pacientes', component: PacientesComponent },
];
