import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ConsultorioI, PersonaI, ResponseI } from './response.interface';
import { catchError, map, Observable } from 'rxjs';
import { Alertas } from '../Control/Alerts';

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  constructor(private alerta: Alertas, private http: HttpClient) {}

  url: string = 'http://127.0.0.1:8000/api/';

  /////////////////////////////////   CONSULTORIO    ////////////////////////////////////////////////////////////
  Get(entidad:string, codigo: number, rango: number): Observable<any> {
    let direccion = this.url + entidad + codigo + ',' + rango;
    return this.http.get<any>(direccion).pipe(
      map((data) => {
        console.log(data);
        return data;
      }),
      catchError((error) => {
        this.alerta.ErrorAlRecuperarElementosError(
          'Error al Conectar con el servidor',
          error
        );
        throw error;
      })
    );
  }
  GetFiltro(entidad:string, tipo: number, valor: string): Observable<any> {
    let direccion = this.url + entidad + tipo + ',' + valor;
    return this.http.get<any>(direccion).pipe(
      map((data) => {
        console.log(data);
        return data;
      }),
      catchError((error) => {
        this.alerta.ErrorAlRecuperarElementosError(
          'Error al Conectar con el servidor',
          error
        );
        throw error;
      })
    );
  }
  Post(entidad:string, elemento: any): Observable<any> {
    let direccion = this.url + entidad;
    return this.http.post<any>(direccion, elemento).pipe(
      map((data) => {
        console.log(data);
        return data;
      }),
      catchError((error) => {
        this.alerta.ErrorAlRecuperarElementosError(
          'Error al Conectar con el servidor',
          error
        );
        throw error;
      })
    );
  }
  Put(entidad:string, elemento: any): Observable<any> {
    let direccion = this.url + entidad;
    return this.http.put<any>(direccion, elemento).pipe(
      map((data) => {
        console.log(data);
        return data;
      }),
      catchError((error) => {
        this.alerta.ErrorAlRecuperarElementosError(
          'Error al Conectar con el servidor',
          error
        );
        throw error;
      })
    );
  }
  Delete(entidad:string, id: number): Observable<any> {
    let direccion = this.url + entidad + id;
    return this.http.delete<any>(direccion).pipe(
      map((data) => {
        console.log(data);
        return data;
      }),
      catchError((error) => {
        this.alerta.ErrorAlRecuperarElementosError(
          'Error al Conectar con el servidor',
          error
        );
        throw error;
      })
    );
  }
  EditarParcial(entidad:string, elemento: any): Observable<any> {
    let direccion = this.url + entidad;
    return this.http.patch<any>(direccion, elemento).pipe(
      map((data) => {
        console.log(data);
        return data;
      }),
      catchError((error) => {
        this.alerta.ErrorAlRecuperarElementosError(
          'Error al Conectar con el servidor',
          error
        );
        throw error;
      })
    );
  }
}
