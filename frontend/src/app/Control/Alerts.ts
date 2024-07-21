import { Injectable } from '@angular/core';
import Swal from 'sweetalert2';

@Injectable({
  providedIn: 'root',
})
export class Alertas {
  
  ErrorAlRecuperarElementos() {
    Swal.fire({
      title: 'Oops....!',
      text: 'Error al intentar recuperar la información!',
      icon: 'error',
      confirmButtonColor: 'var(--color-terciario)',
      confirmButtonText: 'OK',
    });
  }
  ErrorAlRecuperarElementosError(cod:string,error:string) {
    Swal.fire({
      title: 'Error "'+cod+'"',
      text: error,
      icon: 'error',
      confirmButtonColor: 'var(--color-terciario)',
      confirmButtonText: 'OK',
    });
  }
  ErrorEnVariablesRequeridas(cod:string,error:string) {
    Swal.fire({
      title: cod,
      text: error,
      icon: 'error',
      confirmButtonColor: 'var(--color-terciario)',
      confirmButtonText: 'OK',
    });
  }
  ErrorEnLaPeticion(mensaje: string) {
    Swal.fire({
        title: "Error inesperado!",
        text: mensaje,
        icon: "error",
        confirmButtonColor: "var(--color-terciario)",
        confirmButtonText: "OK"
      });
  }
  ExitoEnLaPeticion(mensaje: string) {
    Swal.fire({
        title: "Exito!",
        text: mensaje,
        icon: "success",
        confirmButtonColor: "var(--color-terciario)",
        confirmButtonText: "OK"
      });
  }
  

  NoExistenDatos() {
    Swal.fire('Oops....!', 'No Existen Datos?', 'warning');
  }

  RegistroAgregado() {
    const alerta = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
      },
    });

    alerta.fire({
      icon: 'success',
      title: 'Registro Agregado',
    });
  }
  RegistroActualizado() {
    const alerta = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
      },
    });

    alerta.fire({
      icon: 'success',
      title: 'Registro Actualizado',
    });
  }
  EliminarRegistroTipo(elemento:string): Promise<boolean> {
    return Swal.fire({
      title: '¿Está seguro de eliminar el registro?',
      text: elemento,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#32c2de',
      cancelButtonColor: '#f33734',
    }).then((result) => {
      if (result.isConfirmed) {
        return true;
      } else {
        return false;
      }
    });
  }
  EliminarRegistro(): Promise<boolean> {
    return Swal.fire({
      title: '¿Está seguro de eliminar el registro?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#32c2de',
      cancelButtonColor: '#f33734',
    }).then((result) => {
      if (result.isConfirmed) {
        return true;
      } else {
        return false;
      }
    });
  }
  RegistroEliminado() {
    const alerta = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
      },
    });

    alerta.fire({
      icon: 'error',
      title: 'Registro Eliminado',
    });
  }


  


}
