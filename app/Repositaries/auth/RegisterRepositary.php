<?php

namespace App\Repositaries\auth;
use App\Models\User;
use App\Services\Messages;
class RegisterRepositary
{
public function create_user($data)
{
    if(!(isset($data['password']))){
        $data['password']=rand(0,99999);
    }
    User::query()->create($data);
    return Messages::success([],'user created successfully');
}
}
