import { Component, OnInit } from '@angular/core';
import { Operaciones } from '../../Models/Operaciones';

@Component({
  selector: 'app-footer',
  standalone: true,
  imports: [],
  templateUrl: './footer.component.html',
  styleUrl: './footer.component.css'
})
export class FooterComponent implements OnInit{
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
