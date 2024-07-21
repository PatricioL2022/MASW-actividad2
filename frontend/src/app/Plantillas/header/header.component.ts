import { Component, OnInit } from '@angular/core';
import { Operaciones } from '../../Models/Operaciones';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [],
  templateUrl: './header.component.html',
  styleUrl: './header.component.css',
})
export class HeaderComponent implements OnInit {
  constructor(private OperacionesM: Operaciones) {}
  ngOnInit(): void {
    this.checkLocal();
  }
  Rol: string = '';
  Usuario: string = '';
  checkLocal() {
    if (localStorage.getItem('usuario') || localStorage.getItem('rol')) {
      this.Usuario = localStorage.getItem('usuario')!;
      this.Rol = localStorage.getItem('rol')!;
    }
  }
  Logout() {
    Swal.fire({
      title: 'Cerrar Sesión !',
      text: '',
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar',
    }).then((result) => {
      if (result.isConfirmed) {
        this.OperacionesM.Logout();
      }
    });
  }
}
