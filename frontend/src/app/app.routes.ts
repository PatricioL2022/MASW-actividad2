import { NgModule } from '@angular/core';
import { Routes } from '@angular/router';
import { PersonasComponent } from './Componentes/personas/personas.component';
import { InicioComponent } from './Componentes/inicio/inicio.component';
import { ConsultoriosComponent } from './Componentes/consultorios/consultorios.component';
import { MedicosComponent } from './Componentes/medicos/medicos.component';
import { PacientesComponent } from './Componentes/pacientes/pacientes.component';
import { LoginComponent } from './Login/login/login.component';
import { RolComponent } from './Componentes/rol/rol.component';
import { UsuarioComponent } from './Componentes/usuario/usuario.component';

export const routes: Routes = [
  { path: '', redirectTo: 'login', pathMatch: 'full' },
  { path: 'login', component: LoginComponent },
  { path: 'inicio', component: InicioComponent },
  { path: 'personas', component: PersonasComponent },
  { path: 'consultorios', component: ConsultoriosComponent },
  { path: 'medicos', component: MedicosComponent },
  { path: 'pacientes', component: PacientesComponent },
  { path: 'rol', component: RolComponent },
  { path: 'usuario', component: UsuarioComponent },
];
