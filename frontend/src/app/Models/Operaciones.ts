import { Component, inject, Injectable } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { catchError, map, of, Observable } from 'rxjs';
import { ApiService } from '../servicios/api.service';
import { Alertas } from '../Control/Alerts';
import { Fechas } from '../Control/Fechas';
import { HttpErrorResponse } from '@angular/common/http';

@Injectable({
  providedIn: 'root',
})
export class Operaciones {
  constructor(
    private api: ApiService,
    private alerta: Alertas,
    public fechas: Fechas
  ) {}

  ListarElementos(entidad:string,fraccion: number, rango: number) {
    return this.api.Get(entidad,fraccion, rango).pipe(
      map((tracks) => {
        let exito = tracks['exito'];
        let datos = tracks['data'];
        let mensaje = tracks['mensaje'];
        if (exito == '200') {
          if (
            (Array.isArray(datos) && datos.length > 0) ||
            (typeof datos === 'object' && datos !== null)
          ) {
            return datos;
          } else {
            this.alerta.NoExistenDatos();
            return [];
          }
        } else {
          this.alerta.ErrorEnLaPeticion(mensaje);
          return [];
        }
      }),
      catchError((error: HttpErrorResponse) => {
        throw this.alerta.ErrorAlRecuperarElementos();
      })
    );
  }
  FiltrarElementos(entidad:string, tipo: number, valor: string) {
    return this.api.GetFiltro(entidad,tipo, valor).pipe(
      map((tracks) => {
        let exito = tracks['exito'];
        let datos = tracks['data'];
        let mensaje = tracks['mensaje'];
        if (exito == '200') {
          if (
            (Array.isArray(datos) && datos.length > 0) ||
            (typeof datos === 'object' && datos !== null)
          ) {
            return datos;
          } else {
            this.alerta.NoExistenDatos();
            return [];
          }
        } else {
          this.alerta.ErrorEnLaPeticion(mensaje);
          return [];
        }
      }),
      catchError((error) => {
        throw this.alerta.ErrorAlRecuperarElementos();
        // throw new Error(error);
      })
    );
  }

  GuardarElemento(entidad:string, elemento: any) {
    if (elemento.id != 0) {
      return this.api.Put(entidad,elemento).pipe(
        map((tracks) => {
          let exito = tracks['exito'];
          let mensaje = tracks['mensaje'];
          let datos = tracks['data'];
          if (exito == '201' || exito == '200') {
            return exito;
          }
          if (exito == '400') {
            let dat = Object.entries(datos)
              .map(([clave, valor]) => {
                if (Array.isArray(valor)) {
                  return `${clave}: ${valor.join(', ')}`;
                } else {
                  return `${clave}: ${valor}`;
                }
              })
              .join('\n');
            return this.alerta.ErrorEnVariablesRequeridas(mensaje, dat);
          } else {
            return this.alerta.ErrorEnLaPeticion(mensaje);
          }
        }),
        catchError((error) => {
          throw this.alerta.ErrorEnLaPeticion(error.mensaje);
          // throw new Error(error);
        })
      );
    } else {
      return this.api.Post(entidad,elemento).pipe(
        map((tracks) => {
          let exito = tracks['exito'];
          let mensaje = tracks['mensaje'];
          let datos = tracks['data'];

          if (exito == '200' || exito == '201') {
            return exito;
          }
          if (exito == '400') {
            let dat = Object.entries(datos)
              .map(([clave, valor]) => {
                if (Array.isArray(valor)) {
                  return `${clave}: ${valor.join(', ')}`;
                } else {
                  return `${clave}: ${valor}`;
                }
              })
              .join('\n');
            return this.alerta.ErrorEnVariablesRequeridas(mensaje, dat);
          } else {
            return this.alerta.ErrorEnLaPeticion(mensaje);
          }
        }),
        catchError((error) => {
          throw this.alerta.ErrorEnLaPeticion(error.mensaje);
        })
      );
    }
  }
  EditarParcialElemento(entidad:string,elemento: any) {
    return this.api.EditarParcial(entidad, elemento).pipe(
      map((tracks) => {
        let exito = tracks['exito'];
        let mensaje = tracks['mensaje'];
        let datos = tracks['data'];
        if (exito == '201' || exito == '200') {
          return exito;
        }
        if (exito == '400') {
          let dat = Object.entries(datos)
            .map(([clave, valor]) => {
              if (Array.isArray(valor)) {
                return `${clave}: ${valor.join(', ')}`;
              } else {
                return `${clave}: ${valor}`;
              }
            })
            .join('\n');
          return this.alerta.ErrorEnVariablesRequeridas(mensaje, dat);
        } else {
          return this.alerta.ErrorEnLaPeticion(mensaje);
        }
      }),
      catchError((error) => {
        throw this.alerta.ErrorEnLaPeticion(error.mensaje);
        // throw new Error(error);
      })
    );
  }
  EliminarElemento(entidad:string, id: number) {
    return this.api.Delete(entidad, id).pipe(
      map((tracks) => {
        let exito = tracks['exito'];
        let mensaje = tracks['mensaje'];
        let datos = tracks['data'];
        if (exito == '201' || exito == '200') {
          return exito;
        }
        if (exito == '400' || exito == '404') {
          return this.alerta.ErrorEnLaPeticion(mensaje);
        } else {
          return this.alerta.ErrorEnLaPeticion(mensaje);
        }
      }),
      catchError((error) => {
        throw this.alerta.ErrorEnLaPeticion(error.mensaje);
      })
    );
  }
}
