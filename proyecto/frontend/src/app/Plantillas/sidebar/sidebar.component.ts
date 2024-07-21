import { Component, OnInit } from '@angular/core';
import { Operaciones } from '../../Models/Operaciones';

@Component({
  selector: 'app-sidebar',
  standalone: true,
  imports: [],
  templateUrl: './sidebar.component.html',
  styleUrl: './sidebar.component.css'
})
export class SidebarComponent implements OnInit {
  constructor(private OperacionesM:Operaciones){}
  ngOnInit(): void {
    this.checkLocal();
  }
  Rol:string = '';
  Usuario:string = '';
  checkLocal() {
    if (localStorage.getItem('usuario') || localStorage.getItem('rol')) {
      this.Usuario = localStorage.getItem('usuario')!;
      this.Rol = localStorage.getItem('rol')!;
    }
  }
}
