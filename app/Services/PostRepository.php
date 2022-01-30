<?php

namespace App\Services;

use App\Models\Post;

class PostRepository implements IPostRepository
{
    public function getAllPosts(array $requestDetails)
    {
        $limit = 15;
        $page = 1;
        if (array_key_exists("limit", $requestDetails)) {
            $limit = $requestDetails["limit"];
        }

        if (array_key_exists("page", $requestDetails)) {
            $page = $requestDetails["page"];
        }

        return Post::with('user')->paginate(
            $perPage = $limit,
            $columns = ['*'],
            $pageName = 'page',
            $currentPage = $page
        );
    }

    public function getUserPosts(array $requestDetails, $userId)
    {
        $limit = 15;
        $page = 1;
        if (array_key_exists("limit", $requestDetails)) {
            $limit = $requestDetails["limit"];
        }

        if (array_key_exists("page", $requestDetails)) {
            $page = $requestDetails["page"];
        }

        return Post::where('user_id', $userId)->paginate(
            $perPage = $limit,
            $columns = ['*'],
            $pageName = 'page',
            $currentPage = $page
        );
    }

    public function addPost(array $post)
    {
        return Post::create($post);
    }

    public function updatePost($uuid, array $post)
    {
    }

    public function deletePostByUuid($uuid)
    {
    }
}
