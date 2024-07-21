import { Component, OnInit } from '@angular/core';
import { Operaciones } from '../../Models/Operaciones';
import { TipoDeTexto } from '../../Control/TipoDeTexto';
import { Alertas } from '../../Control/Alerts';
import { map } from 'rxjs';
import { CommonModule } from '@angular/common';
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { FooterComponent } from "../../Plantillas/footer/footer.component";
import { SidebarComponent } from "../../Plantillas/sidebar/sidebar.component";
import { HeaderComponent } from "../../Plantillas/header/header.component";

@Component({
  selector: 'app-pacientes',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, FooterComponent, SidebarComponent, HeaderComponent],
  templateUrl: './pacientes.component.html',
  styleUrl: './pacientes.component.css',
})
export class PacientesComponent implements OnInit {
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
  NombrePagina: string = 'Paciente';
  TituloFormulario: string = '';
  ParametrosDeBusqueda: Array<string> = [
    'Identificacion',
    'Nombres Completos',
    'Apellidos Completos',
    'Nombres Incompletos',
    'Apellidos Incompletos',
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
      'Pacientes/',
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
    if (this.itemBusqueda.value === 'Identificacion') {
      tipo = 1;
      this.GetFiltrarElemento(valor, tipo);
    }
    if (this.itemBusqueda.value === 'Nombres Completos') {
      tipo = 2;
      this.GetFiltrarElemento(valor, tipo);
    }
    if (this.itemBusqueda.value === 'Nombres Incompletos') {
      tipo = 3;
      this.GetFiltrarElemento(valor, tipo);
    }
    if (this.itemBusqueda.value === 'Apellidos Completos') {
      tipo = 4;
      this.GetFiltrarElemento(valor, tipo);
    }
    if (this.itemBusqueda.value === 'Apellidos Incompletos') {
      tipo = 5;
      this.GetFiltrarElemento(valor, tipo);
    }
  }

  GetFiltrarElemento(valor: string, tipo: number) {
    this.ListaElementos = [];
    this.OperacionesM.FiltrarElementos('PacientesFiltro/', tipo, valor)
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
    //     this.Persona.patchValue('')
    // this.Id_Persona.patchValue('')
  }

  ElementoForm!: FormGroup;
  formControls = [
    {
      tipo: 'text',
      tipovalue: 'number',
      name: 'NumeroExpediente',
      label: 'Numero Expediente',
      longitudMin: 1,
      longitudMax: 100,
      validators: [
        Validators.required,
        this.validar.validarLongitudMinMax(1, 100),
        this.validar.VFN_SoloNumeros(),
      ],
    },
    {
      tipo: 'text',
      tipovalue: '',
      name: 'persona_id',
      label: 'Persona id',
      validators: [Validators.required, this.validar.VFN_SoloNumeros()],
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
      NumeroExpediente: '',
      persona_id: '',
      Estado: true,
    });
    this.ElementoForm.removeControl('id');
  }

  GuardarElemento(elemento: any) {
    elemento.id = elemento.id == undefined ? 0 : Number(elemento.id);
    elemento.Estado = elemento.Estado == true ? 'Activo' : 'Inactivo';
    this.OperacionesM.GuardarElemento('Pacientes', elemento)
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
      NumeroExpediente: datos.NumeroExpediente,
      persona_id: datos.persona_id,
      Estado: datos.Estado == 'Activo' ? true : false,
    });
    this.Persona = datos.Nombres + ' ' + datos.Apellidos;
    this.AgregarEditarElemento(tipo);
  }
  // ****************************************** PAGINACION *****************************************************************

  ActualizaEstado(elemento: any) {
    let edit = {
      id: elemento.id,
      Estado: elemento.Estado == 'Activo' ? 'Inactivo' : 'Activo',
    };
    this.OperacionesM.EditarParcialElemento('Pacientes', edit)
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
        this.OperacionesM.EliminarElemento('Pacientes/', elemento.id)
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
  // ****************************************** EXTRAS *****************************************************************
  BuscarCliente(reciv: any) {
    let recivido = reciv.target.value.trim();
    this.Persona = '';
    this.ElementoForm.patchValue({ persona_id: '' });
    if (recivido.length > 0) {
      this.OperacionesM.FiltrarElementos('PersonasFiltro/', 1, recivido)
        .pipe(
          map((datos) => {
            let person = datos[0];
            if (datos.length != 0) {
              this.ElementoForm.patchValue({ persona_id: person.id });
              this.Persona = person.Nombres + ' ' + person.Apellidos;
            }
          })
        )
        .subscribe();
    }
  }
  Persona: string = '';
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
