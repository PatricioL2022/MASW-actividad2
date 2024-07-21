import { Injectable } from '@angular/core';
import { Observable, map } from 'rxjs';
import {
  AbstractControl,
  FormGroup,
  ValidationErrors,
  ValidatorFn,
} from '@angular/forms';

@Injectable({
  providedIn: 'root',
})
export class TipoDeTexto {
  constructor() {}
  
  // mostrarErrores() {
  //   Object.keys(this.ElementoForm.controls).forEach(key => {
  //     const controlErrors = this.ElementoForm.get(key)?.errors;
  //     if (controlErrors) {
  //       console.log(`Errores en el campo ${key}:`, controlErrors);
  //     }
  //   });
  // }
  ///////////////////////////////////////// VALIDAR CAMPOS DE ACUERDO AL TIPO  //////////////////////////////////////////////////////////
  V_ValidadorGeneral(tipo: string, valor: any): boolean {

    switch (tipo) {
      case 'number':
        return this.V_SoloNumeros(valor);
      case 'NumFija':
        return this.V_SoloNumeros(valor);
      case 'numberDes':
        return this.V_NumerosDesimales(valor);
      case 'Text':
        return this.V_SoloLetras(valor);
      case 'TextAlfa':
        return this.V_AlfaNumerico(valor);
      case 'TextCar':
        return true;
      case 'textNoNull':
        return this.V_AlfaNumericoNoNulo(valor);
        break;
      case 'email':
        return this.V_Correo(valor);
        break;
      default:
        return true;
    }
  }

  ///////////////////////////////////////// VALIDAR ALFA NUMERICO  //////////////////////////////////////////////////////////
  V_AlfaNumericoNoNulo(parametro: string) {
    var parm = parametro.trim();
    let resultado = false;
    if (parm.length == 0) {
      return false;
    }
    for (let i = 0; i < parm.length; i++) {
      let caracterActual = parm[i];
      if (!caracterActual.match(/^[0-9a-zñA-ZÑ\s]*$/)) {
        return false;
      }
    }
    return true;
  }
  V_AlfaNumerico(parametro: string) {
    // var parm = parametro.trim()
    let resultado = false;
    for (let i = 0; i < parametro.length; i++) {
      let caracterActual = parametro[i];
      if (!caracterActual.match(/^[0-9a-zñáéíóúA-ZÑÁÉÍÓÚ\s]*$/)) {
        return false;
      }
    }
    return true;
  }
  
  VFN_AlfaNumerico(): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const value = control.value;
      if (value === '' || value === null || this.V_AlfaNumerico(value)) {
        return null;
      } else {
        return { soloNumerosDesimales: { value: control.value } };
      }
    };
  }
  VFN_AlfaNumericoNoNulo(): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const value = control.value;
      if (value === '' || value === null || this.V_AlfaNumericoNoNulo(value)) {
        return null;
      } else {
        return { soloNumerosDesimales: { value: control.value } };
      }
    };
  }
  ///////////////////////////////////////// VALIDAR SOLO TEXTO  //////////////////////////////////////////////////////////
  V_SoloLetras(parametro: string) {
    let resultado = false;
    for (let i = 0; i < parametro.length; i++) {
      let caracterActual = parametro[i];
      if (!caracterActual.match(/^[a-zñáéíóúA-ZÑÁÉÍÓÚ\s]*$/)) {
        return false;
      }
    }
    return true;
  }
  VFN_SoloLetras(): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const value = control.value;
      if (value === '' || value === null || this.V_AlfaNumerico(value)) {
        return null;
      } else {
        return { soloNumerosDesimales: { value: control.value } };
      }
    };
  }
  ///////////////////////////////////////// VALIDAR SOLO NUMEROS  //////////////////////////////////////////////////////////
  V_SoloNumeros(parametro: string) {
    if (parametro === '' || parametro === null) {
      return true;
    } else {
      for (let i = 0; i < parametro.length; i++) {
        let caracterActual = parametro[i];
        if (!caracterActual.match('^[0-9]*$')) {
          return false;
        }
      }
      return true;
    }
  }
  VFN_SoloNumeros(): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const value = control.value;
      if (value === '' || value === null || this.V_SoloNumeros(value)) {
        return null;
      } else {
        return { soloNumerosDesimales: { value: control.value } };
      }
    };
  }
  ///////////////////////////////////////// VALIDAR SOLO NUMEROS DIFERENTE DE CERO  //////////////////////////////////////////////////////////
  V_NumDiferDeCero(parametro: string) {
    // definir bien para utilizarlo
    if (parametro === '' || parametro === null) {
      return true;
    } else {
      for (let i = 0; i < parametro.length; i++) {
        let caracterActual = parametro[i];
        if (!caracterActual.match('^[0-9]*$')) {
          return false;
        }
      }
      return true;
    }
  }
  VFN_NumDiferDeCero(): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const value = control.value;
      if (value != 0 && this.V_SoloNumeros(value)) {
        return null;
      } else {
        return { soloNumerosDesimales: { value: control.value } };
      }
    };
  }
  ///////////////////////////////////////// VALIDAR SOLO NUMEROS DECIMALES //////////////////////////////////////////////////////////

  V_NumerosDesimales(parametro: string) {
    if (parametro === '' || parametro === null) {
      return true;
    } else {
      let comaEncontrada = false;
      for (let i = 0; i < parametro.length; i++) {
        let caracterActual = parametro[i];
        if (caracterActual === '.') {
          if (comaEncontrada) {
            return false;
          } else {
            comaEncontrada = true;
          }
        } else if (!caracterActual.match('^[0-9]*$')) {
          return false;
        }
      }
      return true;
    }
  }

  VFN_NumerosDesimales(): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const value = control.value;
      if (value === '' || value === null || this.V_NumerosDesimales(value)) {
        return null;
      } else {
        return { soloNumerosDesimales: { value: control.value } };
      }
    };
  }

  ///////////////////////////////////////// VALIDAR FORMATO CORREO  //////////////////////////////////////////////////////////

  V_Correo(correo: string): boolean {
    const regex = /^[^\s@]+@[^\s@]+\.(com|ec|co|org|net|edu|gov|mil|es|mx|ar|cl|br|info|biz|name|pro|xyz)$/;
    return regex.test(correo);
  }
  
  VFN_Correo(): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const value = control.value;
      if (value === '' || value === null || this.V_Correo(value)) {
        return null;
      } else {
        return { TipoCorreo: { value: control.value } };
      }
    };
  }

  ///////////////////////////////////////// VALIDAR LONGITUD FIJA  //////////////////////////////////////////////////////////
  V_LongitudFija(numero: string, longitud: number) {
    return numero.length === longitud;
  }
  validarLongitudFija(longitud: number): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const value = control.value;
      if (
        value === '' ||
        value === null ||
        this.V_LongitudFija(value, longitud)
      ) {
        return null;
      } else {
        return { TipoLongitudFija: { value: control.value } };
      }
    };
  }

  ///////////////////////////////////////// VALIDAR LONGITUD DOBLE  //////////////////////////////////////////////////////////
  V_LongitudDoble(numero: string, longitud1: number, longitud2: number) {
    return numero.length === longitud1 || numero.length === longitud2;
  }
  validarLongitudDoble(longitud1: number, longitud2: number): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const value = control.value;
      if (
        value === '' ||
        value === null ||
        this.V_LongitudDoble(value, longitud1, longitud2)
      ) {
        return null;
      } else {
        return { TipoLongitudDoble: { value: control.value } };
      }
    };
  }
  ///////////////////////////////////////// VALIDAR LONGITUD MAX Y MIN //////////////////////////////////////////////////////////
  V_LongitudMinMax(texto: string, min: number, max: number) {
    return texto.length >= min && texto.length <= max;
  }
  validarLongitudMinMax(min: number, max: number): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const value = control.value;
      if (
        value === '' ||
        value === null ||
        this.V_LongitudMinMax(value, min, max)
      ) {
        return null;
      } else {
        return { TipoLongitudMinMax: { value: control.value } };
      }
    };
  }
}
