<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UnitTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function authenticate(){
        $result = array ();
        Role::factory()->create([
            'name'=>'test',
            'id'=>3
        ]);
        User::create([
            'name' => 'test',
            'email' =>'test@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);
        $response=$this->json('post','/api/login',[
            'email'=> 'test@gmail.com',
            'password'=>'password'
        ]);
        $response->assertOk();
        $response->getOriginalContent();
        $result['token'] = $response['token'];
        $result['user_id'] = $response['role_id'];
        return $result;
    }

    public function testCreateUnit(){

        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        {// $user = User::factory()->make([
            //     'name' => 'Frutas',
            //     'email' => 'frutas@gmail.com',
            //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            //     'role_id' =>3
            // ]);
            // $units=[
            //     'unit_measure'=>'mili'
            // ];
            // /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
            // $response = $this->actingAs($user)->post('/api/units', $units);
        }
        $units=[
            'unit_measure'=>'mili'
        ];
        $response = $this->withHeaders([
            'Authorization'=>'Bearer'.$token['token'],
        ])->json('POST','/api/units',$units);
        $response->assertOk();
        $this->assertCount(1,Unit::all());
        $Unit=Unit::first();
        $this->assertEquals($Unit->unit_measure,'mili');

    }

    public function testIndexUnits(){
        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        Unit::factory()->count(7)->create();
        $response=$this->withHeaders([
            'Authotization'=>'Bearer'.$token['token']
        ])->json('GET','/api/units');
        $response->assertOk();
        $units=Unit::all();
        $this->assertCount(7,$units);
    }

    public function testShowUnit(){
        $this->withExceptionHandling();
        $token=$this->authenticate();
        $unit=Unit::factory()->create();
        $response=$this->withHeaders([
            'Authorization'=>'Bearer'.$token['token']
        ])->json('GET',"/api/units/{$unit->id}");
        $response->assertOk();
        $this->assertCount(1,Unit::all());
    }

    public function testUpdateUnit(){
        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        $un=Unit::factory()->create([
             'unit_measure'=>'mili'
        ]);
        $response=$this->withHeaders([
            'Authorization'=>'Bearer'.$token['token']
        ])->json('PUT',"/api/units/{$un->id}",[
            'unit_measure'=>'kg'
        ]);
        $response->assertOk();
        $this->assertCount(1,Unit::all());
        $unit=Unit::first();
        $this->assertEquals($unit->unit_measure,'kg');
    }

    public function testDeleteUnit(){
        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        $unit=Unit::factory()->create();
        $response=$this->withHeaders([
            'Authorization'=>'Bearer'.$token['token']
        ])->json('DELETE',"/api/units/{$unit->id}");
        $response->assertOk();
        $this->assertCount(0,Unit::all());
    }
}
