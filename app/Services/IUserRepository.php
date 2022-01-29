<?php

namespace App\Services;

interface IUserRepository
{
    public function getAllUsers(array $requestDetails);
    public function getUserById($id);
    public function createUser(array $userDetails);
    public function getUserByUsername($username);
    public function getUserByEmail($email);
    public function updateUser($id, array $userDetails);
    public function deleteUser($id);
}
