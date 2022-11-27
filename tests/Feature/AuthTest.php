<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegister()
    {
        $this->withoutExceptionHandling();
        Role::factory()->count(4)->create();
        $user=[
            'name'=> 'prueba2',
            'email'=>'almacen@gmail.com',
            'password'=>'12345678s'
        ];
        $response = $this->post('/api/register',$user);
        $response->assertStatus(201);
    }

    public function testLogin(){
        Role::factory()->count(3)->create();
        User::create([
            'name'=>'test',
            'email'=>$email='test1@gmail.com',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);
        $response=$this->json('post','/api/login',[
            'email'=> $email,
            'password'=>'password'
        ]);
       
        $response->assertOk();
        $this->assertArrayHasKey('token',$response->json());
    }
}
