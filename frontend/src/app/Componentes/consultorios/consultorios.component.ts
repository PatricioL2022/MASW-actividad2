import { Component, OnInit } from '@angular/core';
import { Operaciones } from '../../Models/Operaciones';
import { TipoDeTexto } from '../../Control/TipoDeTexto';
import { Alertas } from '../../Control/Alerts';
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { map } from 'rxjs';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-consultorios',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './consultorios.component.html',
  styleUrl: './consultorios.component.css',
})
export class ConsultoriosComponent implements OnInit {
  constructor(
    private OperacionesM: Operaciones,
    public validar: TipoDeTexto,
    private alerta: Alertas
  ) {
    this.ElementoForm = new FormGroup({});
    this.formControls.forEach((control) => {
      this.ElementoForm.addControl(
        control.name,
        new FormControl(control.value || '', control.validators)
      );
    });
  }
  ngOnInit(): void {
    this.ListarElementos();
    this.checkLocal();
  }
  checkLocal() {
    if (!localStorage.getItem('usuario') || !localStorage.getItem('rol')) {
      this.OperacionesM.Logout();
    }
  }
  NombrePagina: string = 'Consultorio';
  TituloFormulario: string = '';
  ParametrosDeBusqueda: Array<string> = [
    '',
    'Ruc',
    'Nombre Completo',
    'Nombre Comercial Completo',
    'Nombre Incompleto',
    'Nombre Comercial Incompleto',
    'Estado',
  ];
  ParametrosEstado: any[] = [
    { name: 'Activo', value: 'Activo' },
    { name: 'Inactivo', value: 'Inactivo' },
    // { name: 'Eliminados', value: 3 },
  ];

  itemBusqueda = new FormControl('', [
    Validators.required,
    this.validar.VFN_SoloNumeros(),
  ]);
  txtBusqueda = new FormControl('', [
    Validators.required,
    this.validar.VFN_SoloNumeros(),
  ]);

  GetBusquedaPor(item: string) {
    this.itemBusqueda.patchValue(item);
    this.txtBusqueda.patchValue('');
    const inputElement = document.getElementById(
      'txtValorBusqueda'
    ) as HTMLInputElement;

    if (item.length > 0 && inputElement != null) {
      inputElement.focus();
    }
  }
  ConvertirMayusculas() {
    this.txtBusqueda.patchValue(this.txtBusqueda.value!.toUpperCase());
  }
  // ****************************************** LISTAR ELEMENTOS *****************************************************************
  ListaElementos: any[] = [];
  headers: string[] = [];
  ListarElementos(num?: number) {
    if (num == 1) {
      this.FraccionDatos = 0;
      this.RangoDatos = 20;
    }
    this.GetBusquedaPor('');
    this.OperacionesM.ListarElementos(
      'Consultorios/',
      this.FraccionDatos,
      this.RangoDatos
    )
      .pipe(
        map((datos) => {
          this.ListaElementos = datos;
          this.FraccionarValores(0, datos, this.ConstanteFraccion);
          this.headers = Object.keys(this.DatosCargaMasiva[0]);
        })
      )
      .subscribe();
  }
  FiltrarElemento() {
    const valor: any = this.txtBusqueda.value?.toString();
    let tipo: number;
    if (this.itemBusqueda.value === 'Estado') {
      tipo = 0;
      this.GetFiltrarElemento(valor, tipo);
    }
    if (this.itemBusqueda.value === 'Ruc') {
      tipo = 1;
      this.GetFiltrarElemento(valor, tipo);
    }
    if (this.itemBusqueda.value === 'Nombre Completo') {
      tipo = 2;
      this.GetFiltrarElemento(valor, tipo);
    }
    if (this.itemBusqueda.value === 'Nombre Incompleto') {
      tipo = 3;
      this.GetFiltrarElemento(valor, tipo);
    }
    if (this.itemBusqueda.value === 'Nombre Comercial Completo') {
      tipo = 4;
      this.GetFiltrarElemento(valor, tipo);
    }
    if (this.itemBusqueda.value === 'Nombre Comercial Incompleto') {
      tipo = 5;
      this.GetFiltrarElemento(valor, tipo);
    }
  }

  GetFiltrarElemento(valor: string, tipo: number) {
    this.ListaElementos = [];
    this.OperacionesM.FiltrarElementos('ConsultoriosFiltro/', tipo, valor)
      .pipe(
        map((datos) => {
          this.ListaElementos = datos;
          this.FraccionarValores(0, datos, this.ConstanteFraccion);
          this.headers = Object.keys(this.DatosCargaMasiva[0]);
        })
      )
      .subscribe();
  }
  AgregarEditarElemento(num: number) {
    if (num === 1) {
      this.TituloFormulario = 'Agregar';
    }
    if (num === 2) {
      this.TituloFormulario = 'Editar';
    }
    if (num === 3) {
      this.TituloFormulario = 'Visualizar';
    }
  }
  EncerarComponentes() {
    this.TituloFormulario = '';
    this.resetForm();
  }

  ElementoForm!: FormGroup;
  formControls = [
    {
      tipo: 'text',
      tipovalue: 'Text',
      name: 'Nombre',
      label: 'Nombre',

      longitudMin: 1,
      longitudMax: 120,
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(1, 120),
        this.validar.VFN_SoloLetras(),
      ],
    },
    {
      tipo: 'text',
      tipovalue: 'NumFija',
      name: 'Ruc',
      label: 'Ruc',
      longitudMax: 13,
      validators: [
        Validators.required,
        this.validar.validarLongitudFija(13),
        this.validar.VFN_SoloNumeros(),
      ],
    },
    {
      tipo: 'text',
      tipovalue: 'TextAlfa',
      name: 'NombreComercial',
      label: 'Nombre Comercial',
      longitudMin: 1,
      longitudMax: 120,
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(1, 120),
        this.validar.VFN_AlfaNumerico(),
      ],
    },
    {
      tipo: 'text',
      tipovalue: 'TextCar',
      name: 'Direccion',
      label: 'Direccion',

      longitudMin: 1,
      longitudMax: 250,
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(1, 250),
      ],
    },
    {
      tipo: 'text',
      tipovalue: 'number',
      name: 'Telefono',
      label: 'Telefono',

      longitudMin: 7,
      longitudMax: 10,
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(7, 10),
        this.validar.VFN_SoloNumeros(),
      ],
    },
    {
      tipo: 'text',
      tipovalue: 'numberDes',
      name: 'PorcentajeIva',
      label: 'Porcentaje del Iva',
      validators: [Validators.required, this.validar.VFN_NumerosDesimales()],
    },
    {
      tipo: 'text',
      tipovalue: 'TextCar',
      name: 'Logo',
      label: 'Logo',

      longitudMin: 1,
      longitudMax: 250,
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(1, 250),
      ],
    },
    {
      tipo: 'text',
      tipovalue: 'email',
      name: 'Correo',
      label: 'Correo',

      longitudMin: 1,
      longitudMax: 50,
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(1, 50),
        this.validar.VFN_Correo(),
      ],
    },
    {
      tipo: 'text',
      tipovalue: 'TextCar',
      name: 'DireccionMatriz',
      label: 'Direccion Matriz',

      longitudMin: 1,
      longitudMax: 250,
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(1, 250),
      ],
    },
    {
      tipo: 'checkbox',
      tipovalue: 'checkbox',
      name: 'Estado',
      label: 'Estado',
      value: true,
    },
  ];
  resetForm() {
    this.ElementoForm.reset({
      Nombre: '',
      Ruc: '',
      NombreComercial: '',
      Direccion: '',
      Telefono: '',
      PorcentajeIva: '',
      Logo: '',
      Correo: '',
      DireccionMatriz: '',
      Estado: false,
    });
    this.ElementoForm.removeControl('id');
  }
  GuardarElemento(elemento: any) {
    elemento.id = elemento.id == undefined ? 0 : Number(elemento.id);
    elemento.Estado = elemento.Estado == true ? 'Activo' : 'Inactivo';
    this.OperacionesM.GuardarElemento('Consultorios', elemento)
      .pipe(
        map((x) => {
          if (x == '200' || x == '201') {
            if (elemento.id != 0) {
              this.ListarElementos();
              this.EncerarComponentes();
              // this.TextoFiltro.patchValue('');
              this.alerta.RegistroActualizado();
            } else {
              this.ListarElementos();
              this.EncerarComponentes();
              // this.TextoFiltro.patchValue('');
              this.alerta.RegistroAgregado();
            }
          }
        })
      )
      .subscribe();
  }
  CargarElemento(datos: any, tipo: number) {
    this.ElementoForm.addControl('id', new FormControl());
    this.ElementoForm.reset({
      id: datos.id,
      Nombre: datos.Nombre,
      Ruc: datos.Ruc,
      NombreComercial: datos.NombreComercial,
      Direccion: datos.Direccion,
      Telefono: datos.Telefono,
      PorcentajeIva: datos.PorcentajeIva,
      Logo: datos.Logo,
      Correo: datos.Correo,
      DireccionMatriz: datos.DireccionMatriz,
      Estado: datos.Estado == 'Activo' ? true : false,
    });
    this.AgregarEditarElemento(tipo);
  }
  // ****************************************** PAGINACION *****************************************************************

  ActualizaEstado(elemento: any) {
    let edit = {
      id: elemento.id,
      Estado: elemento.Estado == 'Activo' ? 'Inactivo' : 'Activo',
    };
    this.OperacionesM.EditarParcialElemento('Consultorios', edit)
      .pipe(
        map((x) => {
          if (x == '200' || x == '201') {
            this.ListarElementos();
            this.alerta.RegistroActualizado();
          }
        })
      )
      .subscribe();
  }

  EliminarElemento(elemento: any) {
    this.alerta.EliminarRegistro().then((confirmado) => {
      if (confirmado) {
        this.OperacionesM.EliminarElemento('Consultorios/', elemento.id)
          .pipe(
            map((x) => {
              if (x == '200' || x == '201') {
                this.ListarElementos();
                this.alerta.RegistroEliminado();
              }
            })
          )
          .subscribe();
      }
    });
  }
  // ****************************************** PAGINACION *****************************************************************
  DatosCargaMasiva!: any[];
  DatosTemporales: any[] = [];
  ContadorDatos: number = 0;
  RangoPaginacion: number = 0;
  InicioPaginacion: number = 0;
  FinalPaginacion: number = 0;
  FraccionDatos: number = 0;
  RangoDatos: number = 20;
  ConstanteFraccion: number = 10;
  ContadorDatosGeneral: number = 0;
  FraccionarValores(tipo: number, datos?: any, rango?: number) {
    if (rango != null && datos != null) {
      if (tipo == 0) {
        this.EncerarVariablesPaginacion(0);
        this.ContadorDatos = datos.length;
        this.DatosTemporales = datos;
        this.RangoPaginacion = rango;
        this.FinalPaginacion = rango;
        this.DatosCargaMasiva = datos.slice(
          this.InicioPaginacion,
          this.FinalPaginacion
        );
      }
    } else {
      if (tipo == 0) {
        this.DatosCargaMasiva = this.DatosTemporales.slice(
          this.InicioPaginacion,
          this.FinalPaginacion
        );
      }
    }
  }

  BtnNext(tipo: number, rango?: number) {
    if (tipo == 0) {
      if (rango != null) {
        this.FraccionDatos = this.FraccionDatos + this.RangoDatos;
        this.ListarElementos();
      }
      this.InicioPaginacion = this.InicioPaginacion + this.RangoPaginacion;
      this.FinalPaginacion = this.FinalPaginacion + this.RangoPaginacion;
      this.FraccionarValores(0);
    }
  }

  BtnPrevious(tipo: number, rango?: number) {
    if (tipo == 0) {
      if (rango != null) {
        this.FraccionDatos = this.FraccionDatos - this.RangoDatos;
        this.ListarElementos();
      }

      if (this.InicioPaginacion >= this.RangoPaginacion) {
        this.InicioPaginacion = this.InicioPaginacion - this.RangoPaginacion;
        this.FinalPaginacion = this.FinalPaginacion - this.RangoPaginacion;
        this.FraccionarValores(0);
      }
    }
  }

  EncerarVariablesPaginacion(tipo: number) {
    if (tipo == 0) {
      this.ContadorDatos = 0;
      this.RangoPaginacion = 0;
      this.InicioPaginacion = 0;
      this.FinalPaginacion = 0;
      this.DatosTemporales = [];
    }
  }
}
