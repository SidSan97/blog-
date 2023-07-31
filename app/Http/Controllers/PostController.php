<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent;

class PostController extends Controller
{

    public function postar(Request $request)
    {
        $post = new Post();

        $post->texto    = $request->input('texto');
        $post->autor    = $request->input('autor');
        $post->id_autor = $request->input('id_autor');

        if($request->hasFile('imagem') and $request->file('imagem')->isValid())
        {
            $requestImg = $request->imagem;
            $extensao   = $requestImg->extension();
            $nomeImg    = md5($requestImg->getClientOriginalName() . strtotime("now")) . "." . $extensao;

            $requestImg->move(public_path('img/posts'), $nomeImg);

            $post->imagem = $nomeImg;

        }

        if($post->save())
        {
            return redirect('/home');
        }
        else
            dd('n foi');
    }

    public function pegarPostagem()
    {
        $post = Post::all();

        return view('home', ['posts'=>$post]);
    }

    public function editarPostagem(Request $request)
    {
        $post = Post::findOrFail($request->id);
        $post->texto = $request->input('texto');

        if($post->save()) {
            return redirect('home');
        }

    }

    public function excluirPostagem($id)
    {
        $post = Post::findOrFail($id);

        if($post->delete()) {
            return redirect('home');
        }

    }
}
