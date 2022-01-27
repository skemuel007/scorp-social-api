<?php
namespace App\Repository;

interface IUserRepository
{
    public function getAllUsers();
    public function getUserById($id);
    public function createOrUpdateUser($id = null, $collection = []);
    public function deleteUser($id);
}
