<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Crear comentario y asignarlo a un post usando el post_id en el cuerpo de la solicitud
    public function createComment(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'post_id' => 'required|exists:posts,id',
                'author' => 'required|string|max:255',
                'text' => 'required|string',
            ]);

            $comment = Comment::create([
                'post_id' => $validatedData['post_id'],
                'author' => $validatedData['author'],
                'text' => $validatedData['text'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comment created successfully',
                'data' => $comment,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    // Retornar un post junto con sus comentarios usando el id del post en los parámetros de la URL
    public function getPostById($id)
    {
        try {
            $post = Post::with('comments')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Post retrieved successfully',
                'data' => $post,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }
}
