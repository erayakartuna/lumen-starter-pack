<?php

use App\User;

class AdminTest extends TestCase {

    protected $email = 'admin@admin.com';
    protected $password = 'user1234';

    /**
     * Admin Login Test.
     *
     * @return string
     */
    public function testLogin()
    {
        $response = $this->call('POST', '/login',['email' => $this->email,'password' => $this->password]);
        $this->assertResponseOk();

        $content = $response->getContent();
        $content = json_decode($content);
        return $content->accessToken;
    }

    /**
     * Test Get Users
     *
     * @depends testLogin
     * @param string $access_token
     * @return void
     */
    public function testGetUsers(string $access_token)
    {
        $response = $this->call('GET', '/admin/users',['access_token' => $access_token]);
        $this->assertResponseOk();
    }

    /**
     * Test Create User
     *
     * @depends testLogin
     * @param string $access_token
     * @return void
     */
    public function testCreateUser(string $access_token)
    {
        $response = $this->call('POST', '/admin/users',[
            'access_token' => $access_token,
            'email' => md5(time()).'@test.com',
            'password' => '12345678',
            'name' => 'Test Person',
            'is_admin' => 0
        ]);

        $this->assertResponseOk();
    }

    /**
     * Test Update Last User
     *
     * @depends testLogin
     * @param string $access_token
     * @return void
     */

    public function testUpdateUser(string $access_token)
    {
        $user_id = User::max('id');

        $response = $this->call('PATCH', '/admin/users/'.$user_id,[
            'access_token' => $access_token,
            'password' => '32323232',
            'name' => 'Test Person',
            'is_admin' => 0
        ]);

        $this->assertResponseOk();
    }

    /**
     * Test Get Added User
     *
     * @depends testLogin
     * @param string $access_token
     * @return void
     */

    public function testGetAddedUser(string $access_token)
    {
        $user_id = User::max('id');

        $response = $this->call('GET', '/admin/users/'.$user_id,[
            'access_token' => $access_token
        ]);

        $content = json_decode($response->getContent());
        $this->assertEquals($user_id,$content->data->id);
    }

    /**
     * Test Delete User
     *
     * @depends testLogin
     * @param string $access_token
     * @return void
     */

    public function testDeleteUser(string $access_token)
    {
        $user_id = User::max('id');
        $response = $this->call('DELETE', '/admin/users/'.$user_id,[
            'access_token' => $access_token
        ]);
        $this->assertResponseOk();
    }

}
