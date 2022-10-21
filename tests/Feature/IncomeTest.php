<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\Income;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeTest extends TestCase
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

    public function testIndexIncomes(){
        $this->withExceptionHandling();
        $token=$this->authenticate();
        Income::factory()->count(7)->create();
        $response=$this->withHeaders([
            'Authotization'=>'Bearer'.$token['token']
        ])->json('GET','/api/incomes');
        $response->assertOk();
        $categories=Income::all();
        $this->assertCount(7,$categories);
     }

     public function testCreateIncome(){
        $this->withoutExceptionHandling();
        $token=$this->authenticate();
        Article::factory()->create([
            'id'=> 1,
            'stock'=>3,
            'unit_price'=>34,
        ]);
        $incomes=[
            'receipt' => 12367 ,
            'provider' => 'pedro',
            'order_number' => 7643,
            'total' => 1234,
            'invoice_number' => 567,
            'created_at' => "2021-08-01",
            'articles'=>
                [[
                'article_id'=> 1,
                'quantity'=>3,
                'unit_price'=>34,
                'total_price'=>150.00
                ]]
        ];
        $response = $this->withHeaders([
            'Authorization'=>'Bearer'.$token['token'],
        ])->json('POST','/api/incomes',$incomes);
        $response->assertStatus(201);
        $this->assertCount(1,Income::all());
        $Article=Article::first();
        $this->assertEquals($Article->stock_total,6);
    }

    public function testGetDetailIncome(){
        $this->withExceptionHandling();
        $token=$this->authenticate();
        Article::factory()->create([
            'id'=> 1,
            'stock'=>3,
            'unit_price'=>34,
        ]);
        Income::factory()->create($incomes=[
            'receipt' => 12367 ,
            'provider' => 'pedro',
            'order_number' => 7643,
            'total' => 1234,
            'invoice_number' => 567,
            'created_at' => "2021-08-01",
            'articles'=>
                [[
                'article_id'=> 1,
                'quantity'=>3,
                'unit_price'=>34,
                'total_price'=>150.00
                ]]
        ]);
        $response=$this->withHeaders([
            'Authotization'=>'Bearer'.$token['token']
        ])->json('GET','/api/incomes/getDetailsIncome');
        
    }
}
