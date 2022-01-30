<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\IPostRepository;
use App\Services\IUserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    private IPostRepository $postRepository;
    private IUserRepository $userRepository;

    public function __construct(
        IPostRepository $postRepository,
        IUserRepository $userRepository
    ) {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requestDetails = $request->all();

        $posts = $this->postRepository->getAllPosts($requestDetails);
        return response()->json([
            'result' => $posts
        ]);
    }

    public function getUserPosts(Request $request, $userId)
    {
        $requestDetails = $request->all();

        // check user exists
        if (!$this->userRepository->getUserById($userId)) {
            return response()->json([
                'error' => 'Invalid user id'
            ], 404);
        }

        $posts = $this->postRepository->getUserPosts($requestDetails, $userId);

        return response()->json([
            'result' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        // check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        // check user exists
        if (!$this->userRepository->getUserById($request->input('user_id'))) {
            return response()->json([
                'error' => 'No such user'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $saved = $this->postRepository->addPost($request->all());

        return response()->json([
            'result' => $saved
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
