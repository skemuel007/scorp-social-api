<?php
namespace App\Services;


interface IPostRepository {
    public function getAllPosts(array $requestDetails);
    public function getUserPosts(array $requestDetails, $userId);
    public function addPost(array $post);
    public function updatePost($uuid, array $post);
    public function deletePostByUuid($uuid);
}
