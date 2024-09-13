<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Messages;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $creditial=['phone'=>request('phone'),
            'password'=>request('password')];
        if(auth()->attempt($creditial)){
            $data=auth()->user();
            $data['token']=auth()->user()->createToken($data['phone'])->plainTextToken;
            return Messages::success(UserResource::make($data),'Login successfully');

        }
        else{
            return Messages::error('Login failed');
        }
    }
}
