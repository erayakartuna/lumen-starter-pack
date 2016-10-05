# Lumen Starter Pack
Lumen + Oauth2 resource owner password credentials grant + Users Module

You can derive an oauth2 rest api from this package.I wrote a users module with permission control.You are able to create,update,delete,list users.


##Installation

**How To**

- Insert project into empty folder / git clone https://github.com/erayakartuna/lumen-starter-pack.git
- Create an empty database table
- Copy the .env.example to .env and insert the Database config
- Run the following commands
```
    composer install
    php artisan migrate
    php artisan db:seed
```
Thats it!

##Usage

**Routes**

```
-------------------------------------------------------------------------------------
POST      => /login   Required Params:email,password
POST      => /refresh-token
-------------------------------------------------------------------------------------
Required Params : access_token

GET       => /admin/users             AdminUserController@index
POST      => /admin/users             AdminUserController@store
GET       => /admin/users/{user_id}   AdminUserController@show
PATCH     => /admin/users/{user_id}   AdminUserController@update
DELETE    => /admin/users/{user_id}   AdminUserController@destroy

-------------------------------------------------------------------------------------
GET       => /users   Required params: access_token   |  UserController@index
-------------------------------------------------------------------------------------
```

**Users Table Schema**
```
Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->boolean('is_admin',0);
			$table->rememberToken();
			$table->timestamps();
		});
```
#### Resources

[LUMEN](https://lumen.laravel.com/)

[LUMEN API OAUTH](https://github.com/esbenp/lumen-api-oauth)



