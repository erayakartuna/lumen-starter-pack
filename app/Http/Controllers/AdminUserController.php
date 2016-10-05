<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use Validator;

class AdminUserController extends AdminController
{
    protected $rules;
    protected $validation_messages;

    public function __construct(){
        parent::__construct();

        $this->validation_messages = [
            'password.required' => 'Password is required.',
            'email.unique' => 'Email must be unique.'
        ];

    }

    public function index()
    {
        $Users = User::all();
        return $this->createSuccessResponse($Users,200);
    }

    public function store(Request $request)
    {
        $validate = $this->validatRequest($request);

        if(!$validate['validate'])
        {
            return $this->createErrorMessage($validate['message'],404);
        }

        $user = User::create($request->all());

        return $this->createSuccessResponse("User created successfully",200);

    }

    public function show($id)
    {
        $user = User::find($id);

        if($user)
        {
            return $this->createSuccessResponse($user,200);
        }

        return $this->createErrorMessage("User has not found",404);
    }

    public function update(Request $request,$user_id)
    {
        $user = User::find($user_id);

        if($user)
        {
            $validate = $this->validatRequest($request,$user_id);
            if(!$validate['validate'])
            {
                $this->createErrorMessage($validate['message'],404);
            }

            $user->email = $request->get('email') ? $request->get('email') : $user->email;
            $user->password = $request->get('password') ? app()->make('hash')->make($request->get('password')) : $user->password;
            $user->name = $request->get('name') ? $request->get('name') : $user->name;
            $user->is_admin = $request->get('is_admin') ? $request->get('is_admin') : $user->is_admin;
            $user->save();

            return $this->createSuccessResponse($user,200);
        }

        return $this->createErrorMessage("User has not found",404);

    }

    public function destroy($user_id)
    {
        if($user_id == $this->auth->getResourceOwnerId()){
            return $this->createErrorMessage("You cannot remove yourself.",403);
        }

        $user = User::find($user_id);

        if($user)
        {
            $user->delete();

            return $this->createSuccessResponse("User deleted successfully",200);
        }

        return $this->createErrorMessage("User has not found",404);
    }


    private function validatRequest($request,$id = 0)
    {
        $rules =
            [
                'email'         => 'required|email|unique:users,email,'.$id.'|max:255',
                'name'          => 'max:255',
                'password'      => $id == 0 ? 'required|max:60' : 'max:60'
            ];

        $validator = Validator::make($request->all(),$rules,$this->validation_messages);

        if($validator->fails()){
            return ['validate' => false,'message' => $validator->errors()->all()];
        }

        return ['validate' => true];
    }

   
}