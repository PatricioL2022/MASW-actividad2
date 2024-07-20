import { Component, inject } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { HeaderComponent } from './Plantillas/header/header.component';
import { SidebarComponent } from './Plantillas/sidebar/sidebar.component';
import { FooterComponent } from './Plantillas/footer/footer.component';
import { ApiService } from './servicios/api.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet,HeaderComponent, SidebarComponent, FooterComponent,CommonModule],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})

export class AppComponent {
  title = 'frontend';
}
