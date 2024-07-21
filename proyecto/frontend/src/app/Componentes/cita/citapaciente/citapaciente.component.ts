import { Component, OnInit } from '@angular/core';
import { DataViewModule } from 'primeng/dataview';
import { ButtonModule } from 'primeng/button';
import { TagModule } from 'primeng/tag';
import { CommonModule } from '@angular/common';
import { ApiService } from '../../../servicios/api.service';
import { ToastModule } from 'primeng/toast';
import { MessageService } from 'primeng/api';
import {RouterModule} from '@angular/router';

@Component({
  selector: 'app-citapaciente',
  standalone: true,
  imports: [DataViewModule, ButtonModule, TagModule, CommonModule,ToastModule,RouterModule],
  providers: [MessageService],
  templateUrl: './citapaciente.component.html',
  styleUrl: './citapaciente.component.css'
})
export class CitapacienteComponent implements OnInit{
  medicos!: any[];
  constructor( private api: ApiService,private messageService: MessageService){
  }
  ngOnInit(): void {
    this.medicos = [];
    this.ListarMedicos();
  }
  ListarMedicos() {
    this.medicos = [];
    this.api.GetMedicosEspecialidad().subscribe((result: any) => {
      if(result)
      {
        result.data.forEach((element: any) => {
          this.medicos.push(
            { 
              id:element.id,
              nombre: element.Titulo+' '+element.Nombres+" "+element.Apellidos,
              especialidad: element.Especialidad,
              foto: element.Foto
            }
          );
        });
      }
      });
  }
}
