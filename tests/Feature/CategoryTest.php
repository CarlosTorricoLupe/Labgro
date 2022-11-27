<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
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

    public function testIndexCategories()
    {
        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        Category::factory()->count(7)->create();
        $response=$this->withHeaders([
            'Authotization'=>'Bearer'.$token['token']
        ])->json('GET','/api/categories');
        $response->assertOk();
        $categories=Category::all();
        $this->assertCount(7,$categories);
    }

    public function testCreateCategory(){

        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        $categories=[
            'name'=>'oficina',
            'active'=>true
        ];
        $response = $this->withHeaders([
            'Authorization'=>'Bearer'.$token['token'],
        ])->json('POST','/api/categories',$categories);
        $response->assertStatus(201);
        $this->assertCount(1,Category::all());
        $Category=Category::first();
        $this->assertEquals($Category->name,'oficina');
    }

    public function testUpdateCategory(){
        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        $category=Category::factory()->create([
             'name'=>'oficina',
             'active'=>true
        ]);
        $response=$this->withHeaders([
            'Authorization'=>'Bearer'.$token['token']
        ])->json('PUT',"/api/categories/{$category->id}",[
            'name'=>'escritorio'
        ]);
        $response->assertOk();
        $this->assertCount(1,Category::all());
        $categoryUpdated=Category::first();
        $this->assertEquals($categoryUpdated->name,'escritorio');
    }

    public function testDeleteCategory(){
        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        $category=Category::factory()->create();
        $response=$this->withHeaders([
            'Authorization'=>'Bearer'.$token['token']
        ])->json('DELETE',"/api/categories/{$category->id}");
        $response->assertOk();
        $this->assertCount(0,Category::all());
    }
}
