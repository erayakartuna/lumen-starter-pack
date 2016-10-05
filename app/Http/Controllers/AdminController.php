<?php

namespace App\Http\Controllers;

use App;
use Carbon\Carbon;
use App\User;

class AdminController extends Controller
{
    protected $user;
    public function __construct()
    {
        parent::__construct();

        $this->auth->validateAccessToken();
        $user_id = $this->auth->getResourceOwnerId();
        $this->user = User::find($user_id);

        if($this->user->is_admin === 0){
           echo response()->json([
               'error' => 'access_denied',
               'error_description' => "You don't have permission"
           ], 404)->send();
            exit;
        }
    }

}
