<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol;
use App\Models\Dependencia;
use App\Imports\csvImportUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCredenciales;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class UsuarioController extends Controller
{
    //
    public function listarusuarios() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $roles = Rol::orderBy('nombre_r')->get();
            $dependencia = $usuario->dependencia->nombre_d;
            $usuarios = User::orderBy('name')->get();
            $dependencias = Dependencia::orderBy('nombre_d')->get();
            return view('admin/usuario.index', compact('usuario', 'nombre', 'roles', 'rol', 'dependencia', 'dependencias', 'usuarios'));
        }
        return Redirect::route('login');
    }

    public function guardarusuario(Request $request) {
        $usuario = User::where('email', $request->email)->get();
        if ($usuario->count() > 0)
            return redirect()->route('listarusuarios')->with('error', 'El usuario ya existe en el sistema.');
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'password' => 'required',
            'id_rol' => 'required|exists:rols,id',
            'id_dependencia' => 'required|exists:dependencias,id'
        ]);
        $nombre = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $usuario = new User();
        $usuario->name = $nombre;
        $usuario->email = $email;
        $usuario->password = Hash::make($password);
        $usuario->id_r = $request->input('id_rol');
        $usuario->id_d = $request->input('id_dependencia');
        $usuario->estado_u = 'Activo';
        $usuario->save();
        // Enviar el correo con las credenciales
        Mail::to($email)->send(new EnviarCredenciales($nombre, $email ,$password));
        return redirect()->route('listarusuarios')->with('success', 'Usuario creado correctamente');
    }

    public function verusuario($id) {
        $usuario = User::with(['rol', 'dependencia'])->find($id);
        return response()->json($usuario);
    }

    public function editarusuario($id) {
        $usuario = User::find($id);
        return response()->json($usuario);
    }

    public function actualizarusuario(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'id_rol' => 'required',
            'id_dependencia' => 'required|exists:dependencias,id',
            'estado' => 'required'
        ]);
        $usuario = User::find($request->input('id'));
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->id_r = $request->input('id_rol');
        $usuario->id_d = $request->input('id_dependencia');
        $usuario->estado_u = $request->input('estado');
        $usuario->save();
        return redirect()->route('listarusuarios')->with('success', 'Usuario actualizado correctamente');
    }

    public function eliminarusuario($id) {
        $usuario = User::find($id);
        if ($usuario) {
            $usuario->estado_u = "Inactivo";
            $usuario->save();
            return response()->json(['success' => true, 'message' => 'Usuario Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Usuario no encontrado']);
    }

    public function csvusuarios(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['name', 'email', 'email_verified_at', 'password', 'estado_u', 'id_r', 'id_d', 'remember_token'   ];

        $encabezadosLeidos = array_map('trim', $headings[0][0]);
        sort($encabezadosLeidos);
        sort($encabezadosEsperados);

        //dd($encabezadosLeidos, $encabezadosEsperados);

        // Verificar si los encabezados coinciden
        // Comparamos si los encabezados obtenidos coinciden con los esperados
        if ($encabezadosLeidos !== $encabezadosEsperados) {
            return redirect()->back()->with('error', 'La estructura del archivo no es válida. Verifica los encabezados.');
        }

        // Continuar con la importación si todo está bien
        // Crear la instancia de la clase de importación
        $importar = new csvImportUsuario;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Sectoriales ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Sectoriales importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}