export interface ResponseI {
  exito: string;
  mensaje: string;
  data: any;
}
export interface PersonaI {
  id: number;
  Identificacion: string;
  Nombres: string;
  Apellidos: string;
  TipoIdentificacion: string;
  Genero: string;
  Direccion: string;
  Telefono: string;
  Correo: string;
  Titulo: string;
  FechaNacimiento: string;
  Foto: string;
  GrupoSanguineo: string;
  Estado: string;
}
export interface ConsultorioI {
Nombre: string;
Ruc: string;
NombreComercial: string;
Direccion: string;
Telefono: string;
PorcentajeIva: string;
Logo: string;
Correo: string;
DireccionMatriz: string;
FechaIn: string;
FechaUp: string;
Estado: string;
}
export interface PersonasI {
  id: number;
  Especialidad: string;
  Subespecialidad: string;
  NumeroCarnet: string;
  persona_id: string;
  consultorio_id: string;
}
