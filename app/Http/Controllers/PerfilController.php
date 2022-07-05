<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){
        return view('perfil.index');
    }

    public function store(Request $request){
        
    $request->request->add(['username' => Str::slug($request->username)]);

    $this->validate($request, [
        'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20','not_in:editar-perfil,index'],
    ]);

    if($request->imagen){

         // $input = $request->all();
       $image = $request->file('imagen');

       $nombreImagen = Str::uuid(). "." . $image->extension();

       $imagenServidor = Image::make($image);
       $imagenServidor->fit(1000,1000);

       $imagePach = public_path('perfiles').'/'. $nombreImagen;
       $imagenServidor->save($imagePach);
       //return response()->json($nombreImagen);
    }
    //guardar cambios
    $usuario = User::find(auth()->user()->id);
    $usuario->username = $request->username;
    $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
    $usuario->save();
    //redirecionamos
    return redirect()->route('posts.index', $usuario->username);
}


}