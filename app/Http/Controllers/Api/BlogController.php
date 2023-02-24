<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function createBlog(Request $request){
        $request->validate([
            "title" => "required",
            "content" => "required"
        ]);


        $user_id = auth()->user()->id;

        $blog = new Blog();
        $blog ->user_id = $user_id;
        $blog ->title = $request->title;
        $blog ->content = $request->content;
        $blog->save();

        return response([
            "status" => 1,
            "msg" => "Blog creado exitosamente",
        ]);


    }

    public function listBlog(){
        $user_id = auth()->user()->id;
        $blogs = Blog::where("user_id",$user_id)->get();
        return response([
            "status" => 1,
            "msg" => "Listado de blogs",
            "data" => $blogs
        ]);

    }

    public function showBlog($id){

    }

    public function updateBlog(Request $request,$id){
        $user_id = auth()->user()->id;
        if (Blog::where(["user_id"=>$user_id, "id"=>$id])->exists()){
            $blog = Blog::find($id);

          $blog->title = isset($request->title) ? $request->title : $blog->title;
          $blog->content = isset($request->content) ? $request->content: $request->content;
          $blog->save();

          return response([
            "status" => 1,
            "msg" => "Blog actualizado corectamente ",
            "data" => $blog
        ]);

        }else {
            return response([
                "status" => 1,
                "msg" => "Blog no encontrado",
            ], 404);

        }


    }
    public function deleteBlog($id){
        $user_id = auth()->user()->id;
        if(Blog::where( ["id"=>$id, "user_id"=>$user_id])->exists() ){

           $blog = Blog::where( ["id"=>$id, "user_id"=>$user_id])->first();
           $blog -> delete();
           return response([
            "status" => 1,
            "msg" => "Blog eliminado corectamente",
        ], 404);


        }else{
            return response([
                "status" => 1,
                "msg" => "Blog no encontrado",
            ], 404);

        }

    }

}

