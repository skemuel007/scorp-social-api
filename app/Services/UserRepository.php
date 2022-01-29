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
        $limit = $requestDetails["limit"] ? $requestDetails["limit"] : 15;
        $page = $requestDetails["page"] ? $requestDetails["page"] : 1;

        return User::paginate(
            $perPage = $limit,
            $columns = ['*'],
            $pageName = 'users',
            $currentPage = $page
        );
    }

    public function getUserById($id)
    {
        return User::find($id);
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
        return User::where($id)->update($userDetails);
    }

    public function deleteUser($id)
    {
        return User::find($id)->delete();
    }
}
