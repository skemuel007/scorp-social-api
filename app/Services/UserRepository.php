<?php

namespace App\Services;

use App\Models\User;
use App\Services\IUserRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository
{

    protected $user = null;

    public function getAllUsers(array $requestDetails)
    {
        $limit = 15;
        $page = 1;
        if (array_key_exists("limit", $requestDetails)) {
            $limit = $requestDetails["limit"];
        }

        if (array_key_exists("page", $requestDetails)) {
            $page = $requestDetails["page"];
        }

        return User::paginate(
            $perPage = $limit,
            $columns = ['*'],
            $pageName = 'page',
            $currentPage = $page
        );
    }

    public function getUserById($id)
    {
        return User::where('uuid', $id)->first();
    }

    public function createUser(array $user)
    {

        return User::create($user);
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function getUserByUsername($username)
    {
        return User::where('username', $username)->first();
    }

    public function updateUser($id, array $userDetails)
    {
        return User::where('uuid', $id)->update($userDetails);
    }

    public function deleteUser($id)
    {
        return User::where('uuid', $id)->delete();
    }
}
