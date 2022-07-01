@extends('layout.app')

@section('titulo')
{{$post->titulo}}
@endsection

@section('contenido')

  <div class="container mx-auto md:flex">
         <div class="md:w-1/2">
            <img src="{{ asset('uploads') .'/'. $post->imagen}}" alt="Imagendel Post {{$post->titulo}}">
            <div class=" p-3">
                0 likes
            </div>

            <div>
                <p class=" font-bold">{{ $post->user->username}}</p>
                <p class=" text-sm text-gray-500">  
                {{ $post->created_at->diffForHumans()}}
                </p>   

                <p class="mt-5">
                    {{$post->description}}
                </p>
            </div>
          @auth
            
        
                @if ($post->user_id === auth()->user()->id)
                   <form method="POST" action="{{ route('posts.destroy' , $post)}}">
                    @method('DELETE')
                    @csrf
                   <input 
                   type="submit"
                   value="Eliminar Publicacion"
                   class=" bg-red-400 hover:bg-red-600 p-2 rounded text-white font-bold mt-4
                  cursor pointer">
                  </form>
              @endif
      @endauth
        </div>

        <div class="md:w-1/2 p-5">
        
          <div class=" shadow bg-white p-5 mb-4">

               @auth
                   
               
              <p class=" text-xl font-bold text-center mb-4"> 
                Agrega un nuevo comentario </p>
                @if (session('mensaje'))
                <div class=" bg bg-green-500 p-2 rounded-lg text-white text-center mb-4">
                  {{session('mensaje')}}
                </div>
            
                  
                @endif

         <form action="{{ route('comentarios.store' , ['post'=>$post , 'user'=>$user ])}}" method="POST">
            @csrf
      <div class="mb-5">
        <label for="comentario" class="mb-2   block uppercase text-gray-400 font-bold">
            Comentario
        </label>
          <textarea 
          id="comentario" name="comentario" 
          type="text" 
          placeholder="comentario de la publicacion"
          class="border p-3 w-full rounded-lg"></textarea>
          @error('comentario')
        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
       {{ $message }}
        </p>
         @enderror
  </div>


  
  <input type="submit" value="Agrega comentario"
  class="bg-sky-600 hover:bg-sky-
  transition-colors cursor-pointer uppercase  
  font-bold w-full p-3 text-white rounded-lg text-center" />

         </form>
      @endauth

      <div class=" bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
              @if ($post->comentarios->count())
                @foreach ($post->comentarios as $comentario)
                <div class=" p-5 border-gray-300 border-b"> 
                      <a class=" font-bold" href="{{ route('posts.index', $comentario->user)}}">
                        {{$comentario->user->username}}
                      </a>
                  <p>{{$comentario->comentario}} </p>
                  <p class=" text-sm text-gray-500">{{$comentario->created_at->diffForHumans() }} </p>
                  </div>

                

                @endforeach
              @else
                 <p class=" p-10 text-center"> No hay comentarios </p> 
              @endif
      </div>

          </div>


            </div>
  </div>

@endsection