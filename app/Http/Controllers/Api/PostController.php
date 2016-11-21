<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;

class PostController extends Controller
{
	/**
	 * PostRepository.
	 * @var App\Repositories\PostRepository
	 */
	protected $post;

    public function __construct(PostRepository $post)
    {
    	$this->post = $post;
    }

    public function all(Request $request)
    {
    	$posts = $this->post->all($request->input('limit', 8));
    	return response()->json($posts);
    }
}
