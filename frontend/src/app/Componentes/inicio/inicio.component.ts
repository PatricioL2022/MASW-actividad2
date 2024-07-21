import { Component, OnInit } from '@angular/core';
import { HeaderComponent } from '../../Plantillas/header/header.component';
import { SidebarComponent } from '../../Plantillas/sidebar/sidebar.component';
import { FooterComponent } from '../../Plantillas/footer/footer.component';
import { Router } from '@angular/router';
import { Operaciones } from '../../Models/Operaciones';

@Component({
  selector: 'app-inicio',
  standalone: true,
  imports: [
    HeaderComponent,
    SidebarComponent,
    FooterComponent,
    SidebarComponent,
    HeaderComponent,
    FooterComponent,
  ],
  templateUrl: './inicio.component.html',
  styleUrl: './inicio.component.css',
})
export class InicioComponent implements OnInit {
  constructor(private router: Router, private OperacionesM: Operaciones) {}
  ngOnInit(): void {
    this.checkLocal();
  }
  checkLocal() {
    if (!localStorage.getItem('usuario') || !localStorage.getItem('rol')) {
      this.OperacionesM.Logout();
    }
  }
}
