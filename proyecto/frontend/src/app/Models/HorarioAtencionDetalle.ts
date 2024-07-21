import { Component, Injectable } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { catchError, map,of, Observable } from 'rxjs';
import { ApiService } from '../servicios/api.service';
import { Alertas } from '../Control/Alerts';
import { Fechas } from '../Control/Fechas';

@Injectable({
  providedIn: 'root',
})
export class HorarioAtencionDetalle {
  constructor(
    private api: ApiService,
    private alerta: Alertas,
    public fechas: Fechas,
  ) {}

 
}