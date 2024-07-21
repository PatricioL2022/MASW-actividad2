<?php

use App\Http\Controllers\API\AgendaController;
use App\Http\Controllers\API\CitaController;
use App\Http\Controllers\API\HorarioatencionController;
use App\Http\Controllers\API\HorarioatenciondetalleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ConsultorioController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\PersonaController;
use App\Http\Controllers\API\MedicoController;
use App\Http\Controllers\API\PacienteController;
use App\Http\Controllers\API\RolController;
use App\Http\Controllers\API\UsuarioController;

Route::post('/Login', [LoginController::class, 'Agregar']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/Usuarios', [UsuarioController::class, 'ListarUsuarios']);
Route::post('/login', [UsuarioController::class, 'login']);
Route::post('/register', [UsuarioController::class, 'signup']);



Route::get('/Consultorios/{codigo},{rango}', [ConsultorioController::class, 'ListarConsultorios']);
Route::get('/Consultorios/{id}', [ConsultorioController::class, 'BuscarId']);
Route::get('/ConsultoriosFiltro/{tipo},{valor}', [ConsultorioController::class, 'Filtrar']);
Route::post('/Consultorios', [ConsultorioController::class, 'Agregar']);
Route::put('/Consultorios', [ConsultorioController::class, 'Editar']);
Route::patch('/Consultorios', [ConsultorioController::class, 'EditarParcial']);
Route::delete('/Consultorios/{id}',[ConsultorioController::class, 'Eliminar']);



Route::get('/Consultorios', [ConsultorioController::class, 'ListarConsultorios']);
Route::get('/Consultorios/{codigo},{rango}', [ConsultorioController::class, 'ListarConsultoriosPag']);
Route::get('/Consultorios/{id}', [ConsultorioController::class, 'BuscarId']);
Route::get('/ConsultoriosFiltro/{tipo},{valor}', [ConsultorioController::class, 'Filtrar']);
Route::post('/Consultorios', [ConsultorioController::class, 'Agregar']);
Route::put('/Consultorios', [ConsultorioController::class, 'Editar']);
Route::patch('/Consultorios', [ConsultorioController::class, 'EditarParcial']);
Route::delete('/Consultorios/{id}',[ConsultorioController::class, 'Eliminar']);



Route::get('/Personas', [PersonaController::class, 'ListarPersonas']);
Route::get('/Personas/{codigo},{rango}', [PersonaController::class, 'ListarPersonasPag']);
Route::get('/Personas/{id}', [PersonaController::class, 'BuscarId']);
Route::get('/PersonasFiltro/{tipo},{valor}', [PersonaController::class, 'Filtrar']);
Route::post('/Personas', [PersonaController::class, 'Agregar']);
Route::put('/Personas', [PersonaController::class, 'Editar']);
Route::patch('/Personas', [PersonaController::class, 'EditarParcial']);
Route::delete('/Personas/{id}',[PersonaController::class, 'Eliminar']);


Route::get('/Medicos', [MedicoController::class, 'ListarMedicos']);
Route::get('/Medicos/Especialidad', [MedicoController::class, 'ListarMedicosConEspecialidad']);
Route::get('/Medicos/{codigo},{rango}', [MedicoController::class, 'ListarMedicosPag']);
Route::get('/Medicos/{id}', [MedicoController::class, 'BuscarId']);
Route::get('/MedicosFiltro/{tipo},{valor}', [MedicoController::class, 'Filtrar']);
Route::post('/Medicos', [MedicoController::class, 'Agregar']);
Route::put('/Medicos', [MedicoController::class, 'Editar']);
Route::patch('/Medicos', [MedicoController::class, 'EditarParcial']);
Route::delete('/Medicos/{id}',[MedicoController::class, 'Eliminar']);


Route::get('/Pacientes', [PacienteController::class, 'ListarPacientes']);
Route::get('/Pacientes/{codigo},{rango}', [PacienteController::class, 'ListarPacientesPag']);
Route::get('/Pacientes/{id}', [PacienteController::class, 'BuscarId']);
Route::get('/PacienteSelecciona', [PacienteController::class, 'ListarPacientesSelecciona']);
Route::get('/PacientesFiltro/{tipo},{valor}', [PacienteController::class, 'Filtrar']);
Route::post('/Pacientes', [PacienteController::class, 'Agregar']);
Route::put('/Pacientes', [PacienteController::class, 'Editar']);
Route::patch('/Pacientes', [PacienteController::class, 'EditarParcial']);
Route::delete('/Pacientes/{id}',[PacienteController::class, 'Eliminar']);


Route::get('/Rol', [RolController::class, 'ListarRol']);
Route::get('/Rol/{codigo},{rango}', [RolController::class, 'ListarRolPag']);
Route::get('/Rol/{id}', [RolController::class, 'BuscarId']);
Route::get('/RolFiltro/{tipo},{valor}', [RolController::class, 'Filtrar']);
Route::post('/Rol', [RolController::class, 'Agregar']);
Route::put('/Rol', [RolController::class, 'Editar']);
Route::patch('/Rol', [RolController::class, 'EditarParcial']);
Route::delete('/Rol/{id}',[RolController::class, 'Eliminar']);


Route::get('/Usuario', [UsuarioController::class, 'ListarUsuarios']);
Route::get('/Usuario/{codigo},{rango}', [UsuarioController::class, 'ListarUsuariosPag']);
Route::get('/Usuario/{id}', [UsuarioController::class, 'BuscarId']);
Route::get('/UsuarioFiltro/{tipo},{valor}', [UsuarioController::class, 'Filtrar']);
Route::post('/Usuario', [UsuarioController::class, 'Agregar']);
Route::put('/Usuario', [UsuarioController::class, 'Editar']);
Route::patch('/Usuario', [UsuarioController::class, 'EditarParcial']);
Route::delete('/Usuario/{id}',[UsuarioController::class, 'Eliminar']);


Route::get('/test/{medico_id}', [HorarioatencionDetalleController::class, 'detalles']);
Route::post('/Agenda', [AgendaController::class, 'Agregar']);
Route::get('/Agenda/Medicos', [AgendaController::class, 'obtenMedicos']);
Route::get('/Agenda/Horarios/{medico_id}/{fecha}', [AgendaController::class, 'obtenHorarioDeAgenda']);

Route::post('/Cita', [CitaController::class, 'Agregar']);
Route::get('/Cita/Medicos/{medico_id}', [CitaController::class, 'ObtenCitasDeMedico']);
Route::get('/test/{medico_id}', [HorarioatencionDetalleController::class, 'detalles']);

Route::get('/Horarioatenciones', [HorarioatencionController::class, 'ListarHorarioatenciones']);
Route::get('/Horarioatenciones/{codigo},{rango}', [HorarioatencionController::class, 'ListarHoraAtencionPag']);
Route::get('/HorarioatencionesFiltro/{tipo},{valor}', [HorarioatencionController::class, 'Filtrar']);
Route::get('/Horarioatenciones/{id}', [HorarioatencionController::class, 'BuscarId']);
Route::post('/Horarioatenciones', [HorarioatencionController::class, 'Agregar']);
Route::put('/Horarioatenciones', [HorarioatencionController::class, 'Editar']);
Route::delete('/Horarioatenciones/{id}',[HorarioatencionController::class, 'Eliminar']);
