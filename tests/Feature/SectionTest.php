<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SectionTest extends TestCase
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

    public function testIndexSections()
    {
        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        Section::factory()->count(7)->create();
        $response=$this->withHeaders([
            'Authotization'=>'Bearer'.$token['token']
        ])->json('GET','/api/sections');
        $response->assertOk();
        $sections=Section::all();
        $this->assertCount(7,$sections);
    }

    public function testCreateSection(){

        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        $sections=[
            'name'=>'oficina',
            'active'=>true
        ];
        $response = $this->withHeaders([
            'Authorization'=>'Bearer'.$token['token'],
        ])->json('POST','/api/sections',$sections);
        $response->assertStatus(201);
        $this->assertCount(1,Section::all());
        $section=Section::first();
        $this->assertEquals($section->name,'oficina');
    }

    public function testUpdateSection(){
        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        $section=Section::factory()->create([
             'name'=>'oficina',
             'active'=>true
        ]);
        $response=$this->withHeaders([
            'Authorization'=>'Bearer'.$token['token']
        ])->json('PUT',"/api/sections/{$section->id}",[
            'name'=>'escritorio'
        ]);
        $response->assertOk();
        $this->assertCount(1,Section::all());
        $sectionUpdated=Section::first();
        $this->assertEquals($sectionUpdated->name,'escritorio');
    }

    public function testDeleteSection(){
        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        $section=Section::factory()->create();
        $response=$this->withHeaders([
            'Authorization'=>'Bearer'.$token['token']
        ])->json('DELETE',"/api/sections/{$section->id}");
        $response->assertOk();
        $this->assertEquals($section->active,false);
    }
}
