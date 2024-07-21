import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { Operaciones } from '../../Models/Operaciones';
import { map } from 'rxjs';
import { Router } from '@angular/router';
import { SidebarComponent } from '../../Plantillas/sidebar/sidebar.component';
import { HeaderComponent } from '../../Plantillas/header/header.component';
import { FooterComponent } from '../../Plantillas/footer/footer.component';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    CommonModule,
    ReactiveFormsModule,
    SidebarComponent,
    HeaderComponent,
    FooterComponent,
  ],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css',
})
export class LoginComponent implements OnInit {
  constructor(
    private OperacionesM: Operaciones,
    private router: Router
  ) {}
  ngOnInit(): void {
    this.checkLocal();
  }
  checkLocal() {
    if (localStorage.getItem('usuario') && localStorage.getItem('rol')) {
      this.router.navigate(['inicio']);
    }
  }

  loginForm = new FormGroup({
    Usuario: new FormControl('', Validators.required),
    Password: new FormControl('', Validators.required),
    cambio: new FormControl(),
  });
  onLoginPost(login: any) {
    login.id = login.id == undefined ? 0 : Number(login.id);
    console.log(login);
    this.OperacionesM.Login(login)
      .pipe(
        map((x) => {
          if (x == '200' || x == '201') {
            this.router.navigate(['inicio']);
          }
        })
      )
      .subscribe();
  }
}
