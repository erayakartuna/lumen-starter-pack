<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;


class UserController extends Controller
{

    public function index()
    {
        $user = User::find($this->auth->getResourceOwnerID());

        return $this->createSuccessResponse($user,200);
    }

}