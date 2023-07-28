<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Routing\Route;

class PostController extends Controller
{

    public function postar(Request $request)
    {
        $post = new Post();

        $post->texto  = $request->input('texto');
        $post->autor  = "Sidnei Santiago";

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
            die('n foi');
    }
}
