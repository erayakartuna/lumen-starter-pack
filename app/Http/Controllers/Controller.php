<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App;
use Cache;
use Carbon\Carbon;

class Controller extends BaseController
{
    protected $auth;

    public function __construct()
    {
        $this->middleware('oauth');

        $this->auth = App()->make('LucaDegasperi\OAuth2Server\Authorizer');
    }

    public function createSuccessResponse($data, $code)
    {
        return response()->json(['data' => $data], $code);
    }

    public function createErrorMessage($message, $code)
    {
        return response()->json(['error' => $message, 'error_description' => ''], $code);
    }


}
