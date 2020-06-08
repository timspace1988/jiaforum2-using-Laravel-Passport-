<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\ActingJWTUser;

class TopicApiTest extends TestCase
{
    use ActingJWTUser;

    use RefreshDatabase;

    protected $user;

    protected function setUp(): void{
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    protected function makeTopic(){
        return factory(Topic::class)->create([
            'user_id' => $this->user->id,
            'category_id' => 1,
        ]);
    }

    //Test create topic function
    public function testStoreTopic(){
        $data = ['category_id' => 1, 'body' => 'first test content', 'title' => 'first test title'];

        $response = $this->JWTActingAs($this->user)->json('POST', '/api/v1/topics', $data);

        // $token = auth('api')->fromUser($this->user);//This code has been putin ActingJWTUser trait
        // $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->json('POST', '/api/v1/topics', $data);
        //$response = $this->json('POST', '/api/v1/topics', $data, ['Authorization' => 'Bearer ' . $token]); //same with above

        $assertData = [
            'category_id' => 1,
            'user_id' => $this->user->id,
            'title' => 'first test title',
            'body' => clean('first test content', 'user_topic_body'),
        ];

        $response->assertStatus(201)->assertJsonFragment($assertData);
        //Check the result, 断言response状态为201，断言response结果包含$assertData中的数据
    }

    //Test update topic function
    public function testUpdateTopic(){
        $topic = $this->makeTopic();

        $editData = ['category_id' => 2, 'body' => 'edit body', 'title' => 'edit title'];

        $response = $this->JWTActingAs($this->user)->json('PATCH', '/api/v1/topics/' . $topic->id, $editData);

        $assertData = [
            'category_id' => 2,
            'user_id' => $this->user->id,
            'title' => 'edit title',
            'body' => clean('edit body', 'user_topic_body'),
        ];

        $response->assertStatus(200)->assertJsonFragment($assertData);
    }


    //Test show topic function
    public function testShowTopic(){
        $topic = $this->makeTopic();
        $response = $this->json('GET', '/api/v1/topics/' . $topic->id);

        $assertData = [
            'category_id' => $topic->category_id,
            'user_id' => $topic->user_id,
            'title' => $topic->title,
            'body' => $topic->body,
        ];

        $response->assertStatus(200)->assertJsonFragment($assertData);
    }

    //Test show topic list function
    public function testIndexTopic(){
        $response = $this->json('GET', '/api/v1/topics');

        $response->assertStatus(200)->assertJsonStructure(['data', 'meta']);
        //check if the response result's structure contains 'data' and 'meta'
    }

    //Test delete topic function
    public function testDeleteTopic(){
        $topic = $this->makeTopic();
        $response = $this->JWTActingAs($this->user)
            ->json('DELETE', '/api/v1/topics/' . $topic->id);

        $response->assertStatus(204);
        //After we delete the topic, we should get 204 status code

        $response = $this->json('GET', '/api/v1/topics/' . $topic->id);
        $response->assertStatus(404);
        //when we show the topic we deleted again, we should get 404 status code
    }


    // /**
    //  * A basic feature test example.
    //  *
    //  * @return void
    //  */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
}
