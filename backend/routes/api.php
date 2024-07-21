<?php

use App\Http\Controllers\API\AgendaController;
use App\Http\Controllers\API\CitaController;
use App\Http\Controllers\API\HorarioatencionController;
use App\Http\Controllers\API\HorarioatenciondetalleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\PersonController;
use App\Http\Controllers\API\ConsultorioController;
use App\Http\Controllers\API\PersonaController;
use App\Http\Controllers\API\MedicoController;
use App\Http\Controllers\API\PacienteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1/persons')->group(function () {
    Route::get('/',[ PersonController::class, 'get']);
    Route::post('/',[ PersonController::class, 'create']);
    Route::delete('/{id}',[ PersonController::class, 'delete']);
    Route::get('/{id}',[ PersonController::class, 'getById']);
    Route::put('/{id}',[ PersonController::class, 'update']);
});


Route::get('/Consultorios/{codigo},{rango}', [ConsultorioController::class, 'ListarConsultorios']);
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
Route::get('/Medicos/Especialidad', [MedicoController::class, 'ListarMedicos']);
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
Route::get('/PacientesFiltro/{tipo},{valor}', [PacienteController::class, 'Filtrar']);
Route::post('/Pacientes', [PacienteController::class, 'Agregar']);
Route::put('/Pacientes', [PacienteController::class, 'Editar']);
Route::patch('/Pacientes', [PacienteController::class, 'EditarParcial']);
Route::delete('/Pacientes/{id}',[PacienteController::class, 'Eliminar']);


Route::get('/HorarioAtencionDetalle/{medico_id}', [HorarioatencionDetalleController::class, 'detalles']);
Route::post('/Agenda', [AgendaController::class, 'Agregar']);
Route::get('/Agenda/Medicos', [AgendaController::class, 'obtenMedicos']);
Route::get('/Agenda/Horarios/{medico_id}/{fecha}', [AgendaController::class, 'obtenHorarioDeAgenda']);

Route::post('/Cita', [CitaController::class, 'Agregar']);
