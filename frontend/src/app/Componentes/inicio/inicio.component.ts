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
    this.startSlideInterval();
  }
  checkLocal() {
    if (!localStorage.getItem('usuario') || !localStorage.getItem('rol')) {
      this.OperacionesM.Logout();
    }
  }

  currentSlide = 0;
  slideInterval: any;

  nextSlide() {
    const items = document.querySelectorAll('.carousel-item');
    if (this.currentSlide >= items.length - 1) {
      this.currentSlide = 0;
    } else {
      this.currentSlide++;
    }
    this.updateSlide();
  }

  prevSlide() {
    const items = document.querySelectorAll('.carousel-item');
    if (this.currentSlide <= 0) {
      this.currentSlide = items.length - 1;
    } else {
      this.currentSlide--;
    }
    this.updateSlide();
  }

  updateSlide() {
    const items = document.querySelectorAll('.carousel-item');
    items.forEach((item, index) => {
      item.classList.remove('active');
      if (index === this.currentSlide) {
        item.classList.add('active');
      }
    });
  }

  startSlideInterval() {
    this.slideInterval = setInterval(() => {
      this.nextSlide();
    }, 3000);
  }
}
