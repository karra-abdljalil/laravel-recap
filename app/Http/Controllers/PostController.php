<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use GrokPHP\Laravel\Facades\GrokAI;

use function Laravel\Ai\agent;

class PostController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:posts,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Find the post by ID
        $post = Post::findOrFail($request->id);

        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();


        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post
        ]);
    }


    public function create(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'title' => 'required|string|max:255'
            ]);


            // generate post content based on the title, 
            $content = agent()->prompt(
                'Generate a detailed blog post about: ' . $request->title,
                provider: 'gemini',
                model: 'gemini-3.5-flash-lite'
            );

            $post = Post::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'description' =>  (string)$content
            ]);

            $post->save();

            return response()->json([
                'message' => 'Post created successfully',
                'post' => $post->description
            ]);
        } catch (Exception $error) {
            return response()->json([
                'message' => $error,
            ])->status();
        }
    }
}
