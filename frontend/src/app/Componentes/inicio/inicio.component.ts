import { Component } from '@angular/core';
import { HeaderComponent } from '../../Plantillas/header/header.component';
import { SidebarComponent } from '../../Plantillas/sidebar/sidebar.component';
import { FooterComponent } from '../../Plantillas/footer/footer.component';

@Component({
  selector: 'app-inicio',
  standalone: true,
  imports: [HeaderComponent, SidebarComponent, FooterComponent],
  templateUrl: './inicio.component.html',
  styleUrl: './inicio.component.css'
})
export class InicioComponent {

}
