import { CommonModule } from '@angular/common';
import { Component, inject, OnInit } from '@angular/core';
import { FooterComponent } from "../../Plantillas/footer/footer.component";
import { HeaderComponent } from "../../Plantillas/header/header.component";
import { SidebarComponent } from "../../Plantillas/sidebar/sidebar.component";
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators
} from '@angular/forms';
import { map } from 'rxjs';
import { ApiService } from '../../servicios/api.service';
import { TipoDeTexto } from '../../Control/TipoDeTexto';
import { Alertas } from '../../Control/Alerts';
import { Operaciones } from '../../Models/Operaciones';


@Component({
  selector: 'app-horarioatencion',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, FooterComponent, HeaderComponent, SidebarComponent],
  templateUrl: './horarioatencion.component.html',
  styleUrl: './horarioatencion.component.css'
})
export class HorarioatencionComponent {
  constructor(
    private OperacionesM: Operaciones, 
    public validar: TipoDeTexto,
    private alerta: Alertas
  ) {
    this.ElementoForm = new FormGroup({});
    this.formControls.forEach((control) => {
      this.ElementoForm.addControl(
        control.name,
        new FormControl('', control.validators)
      );
    });
  }
  ngOnInit(): void {
    this.ListarElementos();
  }
  NombrePagina: string = 'Horario Atención';
  TituloFormulario: string = '';
  ParametrosDeBusqueda: Array<string> = [
    '',
    'Nombre',
    'Hora Inicio',
    'Hora Fin',
    'Hora Receso',
    'Hora Fin Receso',
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
      'Horarioatenciones/',
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
    if (this.itemBusqueda.value === 'Nombre') {
      tipo = 0;
      this.GetFiltrarElemento(valor, tipo);
    } 
    if (this.itemBusqueda.value === 'Hora Inicio') {
      tipo = 1;
      this.GetFiltrarElemento(valor, tipo);
    }
    if (this.itemBusqueda.value === 'Hora Fin') {
      tipo = 2;
      this.GetFiltrarElemento(valor, tipo);
    }
    if (this.itemBusqueda.value === 'Hora Receso') {
      tipo = 3;
      this.GetFiltrarElemento(valor, tipo);
    }
    if (this.itemBusqueda.value === 'Hora Fin Receso') {
      tipo = 4;
      this.GetFiltrarElemento(valor, tipo);
    }  
  }

  GetFiltrarElemento(valor: string, tipo: number) {
    this.ListaElementos = [];
    this.OperacionesM.FiltrarElementos('HorarioatencionesFiltro/', tipo, valor)
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
      name: 'Nombre',
      label: 'Nombre',
      longitudMin: 1,
      longitudMax: 120,
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(1, 120),
        this.validar.VFN_AlfaNumerico(),
      ]
    },
    {
      tipo: 'text',
      name: 'HoraInicio',
      label: 'Hora Inicio',
      longitudMin: 1,
      longitudMax: 5, 
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(1, 5),
        this.validar.VFN_AlfaNumerico(),
      ],
    },  
    {
      tipo: 'text',
      name: 'HoraFin',
      label: 'Hora Fin',
      longitudMin: 1,
      longitudMax: 5,
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(1, 5),
        this.validar.VFN_AlfaNumerico(),
      ],
    }, 
    {
      tipo: 'text',
      name: 'HoraInicioReceso',
      label: 'Hora Inicio Receso',
      longitudMin: 1,
      longitudMax: 5,
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(1, 5),
        this.validar.VFN_AlfaNumerico(),
      ],
    },
    {
      tipo: 'text',
      name: 'HoraFinReceso',
      label: 'Hora Fin Receso',
      longitudMin: 1,
      longitudMax: 5,
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(1, 5),
        this.validar.VFN_AlfaNumerico(),
      ],
    },
  ];
  resetForm() {
    this.ElementoForm.reset({
      Nombre: '',
      FechaInicio: '',
      FechaFin: '',
      FechaInicioReceso: '',
    });
    this.ElementoForm.removeControl('id');
  }

  GuardarElemento(elemento: any) {
    elemento.id = elemento.id == undefined ? 0 : Number(elemento.id);
    this.OperacionesM.GuardarElemento('Horarioatenciones', elemento)
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
      HoraInicio: datos.HoraInicio,
      HoraFin: datos.HoraFin,
      HoraInicioReceso: datos.HoraInicioReceso,
      HoraFinReceso: datos.HoraFinReceso,
    });
    this.AgregarEditarElemento(tipo);
  }
  // ****************************************** PAGINACION *****************************************************************

  ActualizaEstado(elemento: any) {
    let edit = {
      id: elemento.id,
      Estado: elemento.Estado == 'Activo' ? 'Inactivo' : 'Activo',
    };
    this.OperacionesM.EditarParcialElemento('Personas', edit)
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
        this.OperacionesM.EliminarElemento('Horarioatenciones/', elemento.id)
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
