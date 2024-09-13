<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Messages;
use App\Repositaries\auth\RegisterRepositary;
class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    private $repo;
    public function __construct(RegisterRepositary $repo)
    {
        $this->repo=$repo;
    }
    public function __invoke(UserFormRequest $request)
    {
        return $this->repo->create_user($request->validated());

    }
}
