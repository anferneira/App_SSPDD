<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\ProvinciaController;
use App\Http\Controllers\Backend\MunicipioController;
use App\Http\Controllers\Backend\ProgramarEstrategicoController;
use App\Http\Controllers\Backend\AvanceEstrategicoController;
use App\Http\Controllers\Backend\AvanceActividadController;
use App\Http\Controllers\Backend\AvanceFinancieroController;
use App\Http\Controllers\Backend\ProgramarFinancieroController;
use App\Http\Controllers\Backend\UsuarioController;
use App\Http\Controllers\Backend\ActividadController;
use App\Http\Controllers\Backend\DependenciaController;
use App\Http\Controllers\Backend\EstrategiaController;
use App\Http\Controllers\Backend\DimensionController;
use App\Http\Controllers\Backend\ApuestaController;
use App\Http\Controllers\Backend\GrupoPoblacionController;
use App\Http\Controllers\Backend\SectorController;
use App\Http\Controllers\Backend\ProgramaController;
use App\Http\Controllers\Backend\IndicadorMgaController;
use App\Http\Controllers\Backend\IndicadorResultadoController;
use App\Http\Controllers\Backend\IndicadorProductoController;
use App\Http\Controllers\Backend\IndicadorProductoMetaOdsController;
use App\Http\Controllers\Backend\OdsController;
use App\Http\Controllers\Backend\MetaOdsController;
use App\Http\Controllers\Backend\EdpmController;
use App\Http\Controllers\Backend\LogroController;
use App\Http\Controllers\Backend\DimensionPobrezaController;
use App\Http\Controllers\Backend\VariablePobrezaController;
use App\Http\Controllers\Backend\DependenciaEstrategiaController;
use App\Http\Controllers\Backend\DependenciaDimensionController;
use App\Http\Controllers\Backend\DependenciaApuestaController;
use App\Http\Controllers\Backend\MedidaResultadoController;
use App\Http\Controllers\Backend\MedidaProductoController;
use App\Http\Controllers\Backend\ProyectoMunicipioController;
use App\Http\Controllers\Backend\HojaVidaIndicadorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta para llevar el control del login y la página de inicio
Route::get('/', function () {
    if(!Auth::check()) {
        return Redirect::action([AdminController::class, 'login']);
    }
    return Redirect::action([AdminController::class, 'home']);
})->name('home');

// Ruta para llevar el control del login y página de inicio, verificando si está autenticado
Route::prefix('admin')
    ->group(function () {
        Route::middleware('admin-logueado:0')->group(function() {
            Route::get('/', [AdminController::class, 'login'])->name('login');
            Route::post('/loginInicio', [AdminController::class, 'loginInicio'])->name('loginInicio');
        });
        Route::middleware('admin-logueado:1')->group(function() {
            Route::get('/home', [AdminController::class, 'home'])->name('home.home');
            Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
        });
    });



/************************************************************************
*                      Rutas del Módulo de Administración               *
************************************************************************/

// Ruta del CRUD de Usuarios
Route::prefix('usuario')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarusuarios', [UsuarioController::class, 'listarusuarios'])->name('listarusuarios');
            Route::post('/guardarusuario', [UsuarioController::class, 'guardarusuario'])->name('guardarusuario');
            Route::get('/verusuario/{id}', [UsuarioController::class, 'verusuario'])->name('verusuario');
            Route::get('/editarusuario/{id}', [UsuarioController::class, 'editarusuario'])->name('editarusuario');
            Route::post('/actualizarusuario', [UsuarioController::class, 'actualizarusuario'])->name('actualizarusuario');
            Route::post('/eliminarusuario/{id}', [UsuarioController::class, 'eliminarusuario'])->name('eliminarusuario');
            Route::post('/importar', [UsuarioController::class, 'csvusuarios'])->name('csvusuarios');
        });

// Ruta del CRUD de Grupos Poblacionales
Route::prefix('grupob')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listargrupobs', [GrupoPoblacionController::class, 'listargrupobs'])->name('listargrupobs');
            Route::post('/guardargrupob', [GrupoPoblacionController::class, 'guardargrupob'])->name('guardargrupob');
            Route::get('/vergrupob/{id}', [GrupoPoblacionController::class, 'vergrupob'])->name('vergrupob');
            Route::get('/editargrupob/{id}', [GrupoPoblacionController::class, 'editargrupob'])->name('editargrupob');
            Route::post('/actualizargrupob', [GrupoPoblacionController::class, 'actualizargrupob'])->name('actualizargrupob');
            Route::post('/eliminargrupob/{id}', [GrupoPoblacionController::class, 'eliminargrupob'])->name('eliminargrupob');
            Route::post('/importar', [GrupoPoblacionController::class, 'csvgrupobs'])->name('csvgrupobs');
        });

// Ruta del CRUD de Provincias
Route::prefix('provincia')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarprovincias', [ProvinciaController::class, 'listarprovincias'])->name('listarprovincias');
            Route::post('/guardarprovincia', [ProvinciaController::class, 'guardarprovincia'])->name('guardarprovincia');
            Route::get('/verprovincia/{id}', [ProvinciaController::class, 'verprovincia'])->name('verprovincia');
            Route::get('/editarprovincia/{id}', [ProvinciaController::class, 'editarprovincia'])->name('editarprovincia');
            Route::post('/actualizarprovincia', [ProvinciaController::class, 'actualizarprovincia'])->name('actualizarprovincia');
            Route::post('/eliminarprovincia/{id}', [ProvinciaController::class, 'eliminarprovincia'])->name('eliminarprovincia');
            Route::post('/importar', [ProvinciaController::class, 'csvprovincias'])->name('csvprovincias');
        });

// Ruta del CRUD de Municipios
Route::prefix('municipio')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarmunicipios', [MunicipioController::class, 'listarmunicipios'])->name('listarmunicipios');
            Route::post('/guardarmunicipio', [MunicipioController::class, 'guardarmunicipio'])->name('guardarmunicipio');
            Route::get('/vermunicipio/{id}', [MunicipioController::class, 'vermunicipio'])->name('vermunicipio');
            Route::get('/editarmunicipio/{id}', [MunicipioController::class, 'editarmunicipio'])->name('editarmunicipio');
            Route::post('/actualizarmunicipio', [MunicipioController::class, 'actualizarmunicipio'])->name('actualizarmunicipio');
            Route::post('/eliminarmunicipio/{id}', [MunicipioController::class, 'eliminarmunicipio'])->name('eliminarmunicipio');
            Route::post('/importar', [MunicipioController::class, 'csvmunicipios'])->name('csvmunicipios');
        });

// Ruta del CRUD Asignar Proyectos a Municipios
Route::prefix('promun')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarpromuns', [ProyectoMunicipioController::class, 'listarpromuns'])->name('listarpromuns');
            Route::post('/guardarpromun', [ProyectoMunicipioController::class, 'guardarpromun'])->name('guardarpromun');
            Route::get('/verpromun/{id}', [ProyectoMunicipioController::class, 'verpromun'])->name('verpromun');
            Route::get('/editarpromun/{id}', [ProyectoMunicipioController::class, 'editarpromun'])->name('editarpromun');
            Route::post('/actualizarpromun', [ProyectoMunicipioController::class, 'actualizarpromun'])->name('actualizarpromun');
            Route::post('/eliminarpromun/{id}', [ProyectoMunicipioController::class, 'eliminarpromun'])->name('eliminarpromun');
            Route::post('/importar', [ProyectoMunicipioController::class, 'csvpromuns'])->name('csvpromuns');
        });

// Ruta del CRUD de Dependencias
Route::prefix('dependencia')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listardependencias', [DependenciaController::class, 'listardependencias'])->name('listardependencias');
            Route::post('/guardardependencia', [DependenciaController::class, 'guardardependencia'])->name('guardardependencia');
            Route::get('/verdependencia/{id}', [DependenciaController::class, 'verdependencia'])->name('verdependencia');
            Route::get('/editardependencia/{id}', [DependenciaController::class, 'editardependencia'])->name('editardependencia');
            Route::post('/actualizardependencia', [DependenciaController::class, 'actualizardependencia'])->name('actualizardependencia');
            Route::post('/eliminardependencia/{id}', [DependenciaController::class, 'eliminardependencia'])->name('eliminardependencia');
            Route::post('/importar', [DependenciaController::class, 'csvdependencias'])->name('csvdependencias');
        });

// Ruta del CRUD de Asignar Estratégias a Dependencias
Route::prefix('depest')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listardepests', [DependenciaEstrategiaController::class, 'listardepests'])->name('listardepests');
            Route::post('/guardardepest', [DependenciaEstrategiaController::class, 'guardardepest'])->name('guardardepest');
            Route::get('/verdepest/{id}', [DependenciaEstrategiaController::class, 'verdepest'])->name('verdepest');
            Route::get('/editardepest/{id}', [DependenciaEstrategiaController::class, 'editardepest'])->name('editardepest');
            Route::post('/actualizardepest', [DependenciaEstrategiaController::class, 'actualizardepest'])->name('actualizardepest');
            Route::post('/eliminardepest/{id}', [DependenciaEstrategiaController::class, 'eliminardepest'])->name('eliminardepest');
            Route::post('/importar', [DependenciaEstrategiaController::class, 'csvdepests'])->name('csvdepests');
        });

// Ruta del CRUD de Asignar Dimensiones a Dependencias
Route::prefix('depdim')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listardepdims', [DependenciaDimensionController::class, 'listardepdims'])->name('listardepdims');
            Route::post('/guardardepdim', [DependenciaDimensionController::class, 'guardardepdim'])->name('guardardepdim');
            Route::get('/verdepdim/{id}', [DependenciaDimensionController::class, 'verdepdim'])->name('verdepdim');
            Route::get('/editardepdim/{id}', [DependenciaDimensionController::class, 'editardepdim'])->name('editardepdim');
            Route::post('/actualizardepdim', [DependenciaDimensionController::class, 'actualizardepdim'])->name('actualizardepdim');
            Route::post('/eliminardepdim/{id}', [DependenciaDimensionController::class, 'eliminardepdim'])->name('eliminardepdim');
            Route::post('/importar', [DependenciaDimensionController::class, 'csvdepdims'])->name('csvdepdims');
        });

// Ruta del CRUD de Asignar Apuestas a Dependencias
Route::prefix('depapu')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listardepapus', [DependenciaApuestaController::class, 'listardepapus'])->name('listardepapus');
            Route::post('/guardardepapu', [DependenciaApuestaController::class, 'guardardepapu'])->name('guardardepapu');
            Route::get('/verdepapu/{id}', [DependenciaApuestaController::class, 'verdepapu'])->name('verdepapu');
            Route::get('/editardepapu/{id}', [DependenciaApuestaController::class, 'editardepapu'])->name('editardepapu');
            Route::post('/actualizardepapu', [DependenciaApuestaController::class, 'actualizardepapu'])->name('actualizardepapu');
            Route::post('/eliminardepapu/{id}', [DependenciaApuestaController::class, 'eliminardepapu'])->name('eliminardepapu');
            Route::post('/importar', [DependenciaApuestaController::class, 'csvdepapus'])->name('csvdepapus');
        });

// Ruta del CRUD de Sectoriales
Route::prefix('sector')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarsectores', [SectorController::class, 'listarsectores'])->name('listarsectores');
            Route::post('/guardarsector', [SectorController::class, 'guardarsector'])->name('guardarsector');
            Route::get('/versector/{id}', [SectorController::class, 'versector'])->name('versector');
            Route::get('/editarsector/{id}', [SectorController::class, 'editarsector'])->name('editarsector');
            Route::post('/actualizarsector', [SectorController::class, 'actualizarsector'])->name('actualizarsector');
            Route::post('/eliminarsector/{id}', [SectorController::class, 'eliminarsector'])->name('eliminarsector');
            Route::post('/importar', [SectorController::class, 'csvsectores'])->name('csvsectores');
        });

// Ruta del CRUD de Programas
Route::prefix('programa')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarprogramas', [ProgramaController::class, 'listarprogramas'])->name('listarprogramas');
            Route::post('/guardarprograma', [ProgramaController::class, 'guardarprograma'])->name('guardarprograma');
            Route::get('/verprograma/{id}', [ProgramaController::class, 'verprograma'])->name('verprograma');
            Route::get('/editarprograma/{id}', [ProgramaController::class, 'editarprograma'])->name('editarprograma');
            Route::post('/actualizarprograma', [ProgramaController::class, 'actualizarprograma'])->name('actualizarprograma');
            Route::post('/eliminarprograma/{id}', [ProgramaController::class, 'eliminarprograma'])->name('eliminarprograma');
            Route::post('/importar', [ProgramaController::class, 'csvprogramas'])->name('csvprogramas');
        });

// Ruta del CRUD de Estratégias
Route::prefix('estrategia')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarestrategias', [EstrategiaController::class, 'listarestrategias'])->name('listarestrategias');
            Route::post('/guardarestrategia', [EstrategiaController::class, 'guardarestrategia'])->name('guardarestrategia');
            Route::get('/verestrategia/{id}', [EstrategiaController::class, 'verestrategia'])->name('verestrategia');
            Route::get('/editarestrategia/{id}', [EstrategiaController::class, 'editarestrategia'])->name('editarestrategia');
            Route::post('/actualizarestrategia', [EstrategiaController::class, 'actualizarestrategia'])->name('actualizarestrategia');
            Route::post('/eliminarestrategia/{id}', [EstrategiaController::class, 'eliminarestrategia'])->name('eliminarestrategia');
            Route::post('/importar', [EstrategiaController::class, 'csvestrategias'])->name('csvestrategias');
        });

// Ruta del CRUD de Dimensiones
Route::prefix('dimension')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listardimensiones', [DimensionController::class, 'listardimensiones'])->name('listardimensiones');
            Route::post('/guardardimension', [DimensionController::class, 'guardardimension'])->name('guardardimension');
            Route::get('/verdimension/{id}', [DimensionController::class, 'verdimension'])->name('verdimension');
            Route::get('/editardimension/{id}', [DimensionController::class, 'editardimension'])->name('editardimension');
            Route::post('/actualizardimension', [DimensionController::class, 'actualizardimension'])->name('actualizardimension');
            Route::post('/eliminardimension/{id}', [DimensionController::class, 'eliminardimension'])->name('eliminardimension');
            Route::post('/importar', [DimensionController::class, 'csvdimensiones'])->name('csvdimensiones');
        });

// Ruta del CRUD de Apuestas
Route::prefix('apuesta')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarapuestas', [ApuestaController::class, 'listarapuestas'])->name('listarapuestas');
            Route::post('/guardarapuesta', [ApuestaController::class, 'guardarapuesta'])->name('guardarapuesta');
            Route::get('/verapuesta/{id}', [ApuestaController::class, 'verapuesta'])->name('verapuesta');
            Route::get('/editarapuesta/{id}', [ApuestaController::class, 'editarapuesta'])->name('editarapuesta');
            Route::post('/actualizarapuesta', [ApuestaController::class, 'actualizarapuesta'])->name('actualizarapuesta');
            Route::post('/eliminarapuesta/{id}', [ApuestaController::class, 'eliminarapuesta'])->name('eliminarapuesta');
            Route::post('/importar', [ApuestaController::class, 'csvapuestas'])->name('csvapuestas');
        });

// Ruta del CRUD de ODS
Route::prefix('ods')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarodss', [OdsController::class, 'listarodss'])->name('listarodss');
            Route::post('/guardarods', [OdsController::class, 'guardarods'])->name('guardarods');
            Route::get('/verods/{id}', [OdsController::class, 'verods'])->name('verods');
            Route::get('/editarods/{id}', [OdsController::class, 'editarods'])->name('editarods');
            Route::post('/actualizarods', [OdsController::class, 'actualizarods'])->name('actualizarods');
            Route::post('/eliminarods/{id}', [OdsController::class, 'eliminarods'])->name('eliminarods');
            Route::post('/importar', [OdsController::class, 'csvodss'])->name('csvodss');
        });

// Ruta del CRUD de Metas ODS
Route::prefix('metaods')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarmetasodss', [MetaOdsController::class, 'listarmetasodss'])->name('listarmetasodss');
            Route::post('/guardarmetaods', [MetaOdsController::class, 'guardarmetaods'])->name('guardarmetaods');
            Route::get('/vermetasods/{id}', [MetaOdsController::class, 'vermetaods'])->name('vermetaods');
            Route::get('/editarmetaods/{id}', [MetaOdsController::class, 'editarmetaods'])->name('editarmetaods');
            Route::post('/actualizarmetaods', [MetaOdsController::class, 'actualizarmetaods'])->name('actualizarmetaods');
            Route::post('/eliminarmetaods/{id}', [MetaOdsController::class, 'eliminarmetaods'])->name('eliminarmetaods');
            Route::post('/importar', [MetaOdsController::class, 'csvmetasodss'])->name('csvmetasodss');
        });

// Ruta del CRUD de Estratégias EDPM
Route::prefix('edpm')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listaredpms', [EdpmController::class, 'listaredpms'])->name('listaredpms');
            Route::post('/guardaredpm', [EdpmController::class, 'guardaredpm'])->name('guardaredpm');
            Route::get('/veredpm/{id}', [EdpmController::class, 'veredpm'])->name('veredpm');
            Route::get('/editaredpm/{id}', [EdpmController::class, 'editaredpm'])->name('editaredpm');
            Route::post('/actualizaredpm', [EdpmController::class, 'actualizaredpm'])->name('actualizaredpm');
            Route::post('/eliminaredpm/{id}', [EdpmController::class, 'eliminaredpm'])->name('eliminaredpm');
            Route::post('/importar', [EdpmController::class, 'csvedpms'])->name('csvedpms');
        });

// Ruta del CRUD de Logros Unidos
Route::prefix('logro')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarlogros', [LogroController::class, 'listarlogros'])->name('listarlogros');
            Route::post('/guardarlogro', [LogroController::class, 'guardarlogro'])->name('guardarlogro');
            Route::get('/verlogro/{id}', [LogroController::class, 'verlogro'])->name('verlogro');
            Route::get('/editarlogro/{id}', [LogroController::class, 'editarlogro'])->name('editarlogro');
            Route::post('/actualizarlogro', [LogroController::class, 'actualizarlogro'])->name('actualizarlogro');
            Route::post('/eliminarlogro/{id}', [LogroController::class, 'eliminarlogro'])->name('eliminarlogro');
            Route::post('/importar', [LogroController::class, 'csvlogros'])->name('csvlogros');
        });

// Ruta del CRUD de Dimensiones de Pobreza
Route::prefix('dimpob')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listardimpobs', [DimensionPobrezaController::class, 'listardimpobs'])->name('listardimpobs');
            Route::post('/guardardimpob', [DimensionPobrezaController::class, 'guardardimpob'])->name('guardardimpob');
            Route::get('/verdimpob/{id}', [DimensionPobrezaController::class, 'verdimpob'])->name('verdimpob');
            Route::get('/editardimpob/{id}', [DimensionPobrezaController::class, 'editardimpob'])->name('editardimpob');
            Route::post('/actualizardimpob', [DimensionPobrezaController::class, 'actualizardimpob'])->name('actualizardimpob');
            Route::post('/eliminardimpob/{id}', [DimensionPobrezaController::class, 'eliminardimpob'])->name('eliminardimpob');
            Route::post('/importar', [DimensionPobrezaController::class, 'csvdimpobs'])->name('csvdimpobs');
        });

// Ruta del CRUD de Variables de Pobreza
Route::prefix('varpob')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarvarpobs', [VariablePobrezaController::class, 'listarvarpobs'])->name('listarvarpobs');
            Route::post('/guardarvarpob', [VariablePobrezaController::class, 'guardarvarpob'])->name('guardarvarpob');
            Route::get('/vervarpob/{id}', [VariablePobrezaController::class, 'vervarpob'])->name('vervarpob');
            Route::get('/editarvarpob/{id}', [VariablePobrezaController::class, 'editarvarpob'])->name('editarvarpob');
            Route::post('/actualizarvarpob', [VariablePobrezaController::class, 'actualizarvarpob'])->name('actualizarvarpob');
            Route::post('/eliminarvarpob/{id}', [VariablePobrezaController::class, 'eliminarvarpob'])->name('eliminarvarpob');
            Route::post('/importar', [VariablePobrezaController::class, 'csvvarpobs'])->name('csvvarpobs');
        });

// Ruta del CRUD de Medidas de Resultado
Route::prefix('medres')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarmedress', [MedidaResultadoController::class, 'listarmedress'])->name('listarmedress');
            Route::post('/guardarmedres', [MedidaResultadoController::class, 'guardarmedres'])->name('guardarmedres');
            Route::get('/vermedres/{id}', [MedidaResultadoController::class, 'vermedres'])->name('vermedres');
            Route::get('/editarmedres/{id}', [MedidaResultadoController::class, 'editarmedres'])->name('editarmedres');
            Route::post('/actualizarmedres', [MedidaResultadoController::class, 'actualizarmedres'])->name('actualizarmedres');
            Route::post('/eliminarmedres/{id}', [MedidaResultadoController::class, 'eliminarmedres'])->name('eliminarmedres');
            Route::post('/importar', [MedidaResultadoController::class, 'csvmedress'])->name('csvmedress');
        });

// Ruta del CRUD de Medidas de Producto
Route::prefix('medprod')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarmedprods', [MedidaProductoController::class, 'listarmedprods'])->name('listarmedprods');
            Route::post('/guardarmedprod', [MedidaProductoController::class, 'guardarmedprod'])->name('guardarmedprod');
            Route::get('/vermedprod/{id}', [MedidaProductoController::class, 'vermedprod'])->name('vermedprod');
            Route::get('/editarmedprod/{id}', [MedidaProductoController::class, 'editarmedprod'])->name('editarmedprod');
            Route::post('/actualizarmedprod', [MedidaProductoController::class, 'actualizarmedprod'])->name('actualizarmedprod');
            Route::post('/eliminarmedprod/{id}', [MedidaProductoController::class, 'eliminarmedprod'])->name('eliminarmedprod');
            Route::post('/importar', [MedidaProductoController::class, 'csvmedprods'])->name('csvmedprods');
        });

// Ruta del CRUD de Indicadores MGA
Route::prefix('mga')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarmgas', [IndicadorMgaController::class, 'listarmgas'])->name('listarmgas');
            Route::post('/guardarmga', [IndicadorMgaController::class, 'guardarmga'])->name('guardarmga');
            Route::get('/vermga/{id}', [IndicadorMgaController::class, 'vermga'])->name('vermga');
            Route::get('/editarmga/{id}', [IndicadorMgaController::class, 'editarmga'])->name('editarmga');
            Route::post('/actualizarmga', [IndicadorMgaController::class, 'actualizarmga'])->name('actualizarmga');
            Route::post('/eliminarmga/{id}', [IndicadorMgaController::class, 'eliminarmga'])->name('eliminarmga');
            Route::post('/importar', [IndicadorMgaController::class, 'csvmgas'])->name('csvmgas');
        });

// Ruta del CRUD de Indicadores de Resultado
Route::prefix('ir')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarirs', [IndicadorResultadoController::class, 'listarirs'])->name('listarirs');
            Route::post('/guardarir', [IndicadorResultadoController::class, 'guardarir'])->name('guardarir');
            Route::get('/verir/{id}', [IndicadorResultadoController::class, 'verir'])->name('verir');
            Route::get('/editarir/{id}', [IndicadorResultadoController::class, 'editarir'])->name('editarir');
            Route::post('/actualizarir', [IndicadorResultadoController::class, 'actualizarir'])->name('actualizarir');
            Route::post('/eliminarir/{id}', [IndicadorResultadoController::class, 'eliminarir'])->name('eliminarir');
            Route::post('/importar', [IndicadorResultadoController::class, 'csvirs'])->name('csvirs');
        });

// Ruta del CRUD de Indicadores de Producto
Route::prefix('ip')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarips', [IndicadorProductoController::class, 'listarips'])->name('listarips');
            Route::post('/guardarip', [IndicadorProductoController::class, 'guardarip'])->name('guardarip');
            Route::get('/verip/{id}', [IndicadorProductoController::class, 'verip'])->name('verip');
            Route::get('/veripods/{id}', [IndicadorProductoController::class, 'veripods'])->name('veripods');
            Route::get('/veripmetods/{id}', [IndicadorProductoController::class, 'veripmetods'])->name('veripmetods');
            Route::get('/editarip/{id}', [IndicadorProductoController::class, 'editarip'])->name('editarip');
            Route::post('/actualizarip', [IndicadorProductoController::class, 'actualizarip'])->name('actualizarip');
            Route::post('/eliminarip/{id}', [IndicadorProductoController::class, 'eliminarip'])->name('eliminarip');
            Route::post('/importar', [IndicadorProductoController::class, 'csvips'])->name('csvips');
        });

// Ruta del CRUD de Asignar Metas ODS a Indicadores de Producto
Route::prefix('ipmo')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listaripmos', [IndicadorProductoMetaOdsController::class, 'listaripmos'])->name('listaripmos');
            Route::post('/guardaripmo', [IndicadorProductoMetaOdsController::class, 'guardaripmo'])->name('guardaripmo');
            Route::get('/veripmo/{id}', [IndicadorProductoMetaOdsController::class, 'veripmo'])->name('veripmo');
            Route::get('/editaripmo/{id}', [IndicadorProductoMetaOdsController::class, 'editaripmo'])->name('editaripmo');
            Route::post('/actualizaripmo', [IndicadorProductoMetaOdsController::class, 'actualizaripmo'])->name('actualizaripmo');
            Route::post('/eliminaripmo/{id}', [IndicadorProductoMetaOdsController::class, 'eliminaripmo'])->name('eliminaripmo');
            Route::get('/ods', [IndicadorProductoMetaOdsController::class, 'mostrar_ods'])->name('mostrar_ods');
            Route::post('/importar', [IndicadorProductoMetaOdsController::class, 'csvipmos'])->name('csvipmos');
        });



/************************************************************************
*                      Rutas del Módulo de Programación                 *
************************************************************************/

// Rutas del CRUD de Programación de Actividades por Indicador de Producto
Route::prefix('actividad')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listaracts', [ActividadController::class, 'listaracts'])->name('listaracts');
            Route::get('/indicador_dependencia/{id}', [ActividadController::class, 'dep_ind'])->name('dep_ind');
            Route::post('/guardaract', [ActividadController::class, 'guardaract'])->name('guardaract');
            Route::get('/ver_act_ind/{id}', [ActividadController::class, 'ver_ind'])->name('ver_ind');
            Route::get('/indicador_actividad/anio/{id}', [ActividadController::class, 'veractividades_anio2'])->name('veractividades_anio2');
            Route::get('/veract/{id}', [ActividadController::class, 'veract'])->name('veract');
            Route::get('/editaract/{id}', [ActividadController::class, 'editaract'])->name('editaract');
            Route::post('/actualizaract', [ActividadController::class, 'actualizaract'])->name('actualizaract');
            Route::post('/eliminaract/{id}', [ActividadController::class, 'eliminaract'])->name('eliminaract');
            Route::post('/importar', [ActividadController::class, 'csvacts'])->name('csvacts');
        });

// Rutas del CRUD de Programación Estratégica por Indicador de Producto
Route::prefix('proest')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarproests', [ProgramarEstrategicoController::class, 'listarproests'])->name('listarproests');
            Route::post('/guardarproest', [ProgramarEstrategicoController::class, 'guardarproest'])->name('guardarproest');
            Route::get('/verproest/{id}', [ProgramarEstrategicoController::class, 'verproest'])->name('verproest');
            Route::get('/editarproest/{id}', [ProgramarEstrategicoController::class, 'editarproest'])->name('editarproest');
            Route::post('/actualizarproest', [ProgramarEstrategicoController::class, 'actualizarproest'])->name('actualizarproest');
            Route::post('/eliminarproest/{id}', [ProgramarEstrategicoController::class, 'eliminarproest'])->name('eliminarproest');
            Route::post('/importar', [ProgramarEstrategicoController::class, 'csvproests'])->name('csvproests');
        });

// Rutas del CRUD de Programación Financiera por Indicador de Producto
Route::prefix('profin')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listarprofins', [ProgramarFinancieroController::class, 'listarprofins'])->name('listarprofins');
            Route::post('/guardarprofin', [ProgramarFinancieroController::class, 'guardarprofin'])->name('guardarprofin');
            Route::get('/verprofin/{id}', [ProgramarFinancieroController::class, 'verprofin'])->name('verprofin');
            Route::get('/editarprofin/{id}', [ProgramarFinancieroController::class, 'editarprofin'])->name('editarprofin');
            Route::post('/actualizarprofin', [ProgramarFinancieroController::class, 'actualizarprofin'])->name('actualizarprofin');
            Route::post('/eliminarprofin/{id}', [ProgramarFinancieroController::class, 'eliminarprofin'])->name('eliminarprofin');
            Route::post('/importar', [ProgramarFinancieroController::class, 'csvprofins'])->name('csvprofins');
        });



/************************************************************************
*                      Rutas del Módulo de Avance                       *
************************************************************************/

// Rutas del CRUD de avance de Actividades por Indicador de Producto
Route::prefix('avaact')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listaravaacts', [AvanceActividadController::class, 'listaravaacts'])->name('listaravaacts'); // Listo
            Route::get('/indicador_dependencia/{id}', [AvanceActividadController::class, 'dep_indi'])->name('dep_indi');
            Route::post('/guardaravaact', [AvanceActividadController::class, 'guardaravaact'])->name('guardaravaact');
            Route::get('/veractind/{id}', [AvanceActividadController::class, 'ver_ind1'])->name('ver_ind1');
            Route::get('/indicador/actividad/anio/{id}', [AvanceActividadController::class, 'veractividades_anio1'])->name('veractividades_anio1');
            Route::get('/agregaravaact/{id}', [AvanceActividadController::class, 'agregaravaact'])->name('agregaravaact');
            Route::get('/veravaact/{id}', [AvanceActividadController::class, 'veravaact'])->name('veravaact');
            Route::get('/editaravaact/{id}', [AvanceActividadController::class, 'editaravaact'])->name('editaravaact');
            Route::post('/actualizaravaact', [AvanceActividadController::class, 'actualizaravaact'])->name('actualizaravaact');
            Route::post('/eliminaravaact/{id}', [AvanceActividadController::class, 'eliminaravaact'])->name('eliminaravaact');
            Route::post('/eliminarevidact/{id}', [AvanceActividadController::class, 'eliminarevidact'])->name('eliminarevidact');
            Route::post('/importar', [AvanceActividadController::class, 'csvavaacts'])->name('csvavaacts');
            Route::post('/importar_logro', [AvanceActividadController::class, 'csvlogros'])->name('csvlogros');
            Route::post('/guardarevidenciaip', [AvanceActividadController::class, 'guardarevidenciasip'])->name('guardarevidenciasip');
            Route::get('/editarevidenciaip/{id}', [AvanceActividadController::class, 'editarevidenciasip'])->name('editarevidenciasip');
            Route::post('/actualizarevidenciaip', [AvanceActividadController::class, 'actualizarevidenciasip'])->name('actualizarevidenciasip');
            Route::get('/indicadores_dep/{id}', [AvanceActividadController::class, 'ind_dep1'])->name('ind_dep1');
            Route::get('/indicadores_act/{id}', [AvanceActividadController::class, 'ind_act'])->name('ind_act');
            Route::get('/rezago_ind_act/{id}', [AvanceActividadController::class, 'rezago1'])->name('rezago1');
            Route::get('/rezago_i_d/{id}', [AvanceActividadController::class, 'rezago_ind_dep'])->name('rezago_ind_dep');
            Route::get('/rezago_avance/{id}', [AvanceActividadController::class, 'rezago_avance'])->name('rezago_avance');
            Route::get('/veravaest/{id}', [AvanceActividadController::class, 'veravaest'])->name('veravaest');
            Route::get('/verind_est_dim_apu/{id}', [AvanceActividadController::class, 'ind_est_dim_apu'])->name('ind_est_dim_apu');
            Route::get('/cargar_select_e_d_a_d/{id}', [AvanceActividadController::class, 'cargar_select_e_d_a_d'])->name('cargar_select_e_d_a_d');
            Route::post('/guardarlogroip', [AvanceActividadController::class, 'guardarlogroip'])->name('guardarlogroip');
            Route::get('/editarlogroip/{id}', [AvanceActividadController::class, 'editarlogroip'])->name('editarlogroip');
            Route::post('/actualizarlogroip', [AvanceActividadController::class, 'actualizarlogroip'])->name('actualizarlogroip');
        });

// Rutas del CRUD de Avance Estratégico por Indicador de Producto
Route::prefix('avaest')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listaravaests', [AvanceEstrategicoController::class, 'listaravaests'])->name('listaravaests');
            Route::get('/indicador_dependencia1/{id}', [AvanceEstrategicoController::class, 'dep_indi1'])->name('dep_indi1');
            Route::get('/veractind1/{id}', [AvanceEstrategicoController::class, 'ver_ind2'])->name('ver_ind2');
            Route::post('/guardaravaest', [AvanceEstrategicoController::class, 'guardaravaest'])->name('guardaravaest');
            //Route::get('/veravaest/{id}', [AvanceEstrategicoController::class, 'veravaest'])->name('veravaest');
            Route::get('/editaravaest/{id}', [AvanceEstrategicoController::class, 'editaravaest'])->name('editaravaest');
            Route::post('/actualizaravaest', [AvanceEstrategicoController::class, 'actualizaravaest'])->name('actualizaravaest');
            Route::post('/eliminaravaest/{id}', [AvanceEstrategicoController::class, 'eliminaravaest'])->name('eliminaravaest');
            Route::post('/importar', [AvanceEstrategicoController::class, 'csvavaests'])->name('csvavaests');
            Route::get('/indicadores/{id}', [AvanceEstrategicoController::class, 'ind_dep'])->name('ind_dep');
            Route::get('/rezago/{id}', [AvanceEstrategicoController::class, 'rezago'])->name('rezago');
        });

// Rutas del CRUD de Avance Financiero y de Pobreza por Indicador de Producto
Route::prefix('avafin')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/listaravafins', [AvanceFinancieroController::class, 'listaravafins'])->name('listaravafins');
            Route::post('/guardaravafin', [AvanceFinancieroController::class, 'guardaravafin'])->name('guardaravafin');
            Route::get('/veravaindfin/{id}', [AvanceFinancieroController::class, 'ver_avances'])->name('ver_avances');
            Route::get('/avances_ind/{id}', [AvanceFinancieroController::class, 'ver_avanfin'])->name('ver_avanfin');
            Route::get('/indicador/avances/anio/{id}', [AvanceFinancieroController::class, 'veravances_anio'])->name('veravances_anio');
            Route::get('/veravafin/{id}', [AvanceFinancieroController::class, 'veravafin'])->name('veravafin');
            Route::get('/editaravafin/{id}', [AvanceFinancieroController::class, 'editaravafin'])->name('editaravafin');
            Route::post('/actualizaravafin', [AvanceFinancieroController::class, 'actualizaravafin'])->name('actualizaravafin');
            Route::post('/eliminaravafin/{id}', [AvanceFinancieroController::class, 'eliminaravafin'])->name('eliminaravafin');
            Route::post('/importar', [AvanceFinancieroController::class, 'csvavafins'])->name('csvavafins');
            Route::get('/indicador/avance_financiero/{id}', [AvanceFinancieroController::class, 'verfinanciero_anio'])->name('verfinanciero_anio');
            Route::get('/verfinind/{id}', [AvanceFinancieroController::class, 'ver_ind2'])->name('ver_ind2');
            Route::get('/trae_financiero_anio/{id}', [AvanceFinancieroController::class, 'traer_financiero_anio'])->name('traer_financiero_anio');
        });


/************************************************************************
*                      Rutas del Módulo de Seguimiento                  *
************************************************************************/

// Rutas de la Hoja de Vida del Indicador
Route::prefix('hvi')
    ->middleware(['admin-logueado:1', 'role:Administrador'])
        ->group(function() {
            Route::get('/cargarlistas', [HojaVidaIndicadorController::class, 'cargarlistas'])->name('cargarlistas');
            Route::get('/cargarhvi', [HojaVidaIndicadorController::class, 'cargarhvi'])->name('cargarhvi');
            Route::get('/hvi/indicador/{id}', [HojaVidaIndicadorController::class, 'verindicador'])->name('verindicador');
            Route::get('/hvi/indicador/actividad/{id}', [HojaVidaIndicadorController::class, 'veractividades'])->name('veractividades');
            Route::get('/hvi/indicador/actividad/anio/{id}', [HojaVidaIndicadorController::class, 'veractividades_anio'])->name('veractividades_anio');
            Route::get('/hvi/indicador/cuatrenio1/{id}', [HojaVidaIndicadorController::class, 'cuatrenio1'])->name('cuatrenio1');
            Route::get('/estrategia/{id}', [HojaVidaIndicadorController::class, 'porest'])->name('porest');
            Route::get('/actualizar_est1/{id}', [HojaVidaIndicadorController::class, 'actest1'])->name('actest1');
            Route::get('/actualizar_est2/{id}', [HojaVidaIndicadorController::class, 'actest2'])->name('actest2');
            Route::get('/actualizar_est3/{id}', [HojaVidaIndicadorController::class, 'actest3'])->name('actest3');
            Route::get('/dimension/{id}', [HojaVidaIndicadorController::class, 'pordim'])->name('pordim');
            Route::get('/actualizar_dim1/{id}', [HojaVidaIndicadorController::class, 'actdim1'])->name('actdim1');
            Route::get('/actualizar_dim2/{id}', [HojaVidaIndicadorController::class, 'actdim2'])->name('actdim2');
            Route::get('/actualizar_dim3/{id}', [HojaVidaIndicadorController::class, 'actdim3'])->name('actdim3');
            Route::get('/apuesta/{id}', [HojaVidaIndicadorController::class, 'porapu'])->name('porapu');
            Route::get('/actualizar_apu1/{id}', [HojaVidaIndicadorController::class, 'actapu1'])->name('actapu1');
            Route::get('/actualizar_apu2/{id}', [HojaVidaIndicadorController::class, 'actapu2'])->name('actapu2');
            Route::get('/actualizar_apu3/{id}', [HojaVidaIndicadorController::class, 'actapu3'])->name('actapu3');
            Route::get('/dependencia/{id}', [HojaVidaIndicadorController::class, 'pordep'])->name('pordep');
            Route::get('/actualizar_dp1/{id}', [HojaVidaIndicadorController::class, 'actdp1'])->name('actdp1');
            Route::get('/actualizar_dp2/{id}', [HojaVidaIndicadorController::class, 'actdp2'])->name('actdp2');
            Route::get('/actualizar_dp3/{id}', [HojaVidaIndicadorController::class, 'actdp3'])->name('actdp3');
            Route::get('/borrar_filtros/{id}', [HojaVidaIndicadorController::class, 'borrarFiltros'])->name('borrarFiltros');
        });