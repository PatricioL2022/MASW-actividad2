import { CommonModule } from '@angular/common';
import { Component, inject, OnInit } from '@angular/core';
import { Alertas } from '../../Control/Alerts';

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './header.component.html',
  styleUrl: './header.component.css'
})
export class HeaderComponent {

  constructor(private alerta: Alertas) {}
    
  CerrarSesion() {
    this.alerta.CerrarSesion().then((confirmado) => {
      if (confirmado) {
      }
    });
  }
}
