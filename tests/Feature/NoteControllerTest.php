<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Predis\Client;
use Tests\TestCase;
use App\Models\Note;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class NoteControllerTest extends TestCase
{
    public string $jwtToken;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->jwtToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VySWQiOjIsInVzZXJuYW1lIjoieWFzc2VyIiwiZXhwaXJlZEF0IjoiMjAyNC0wNy0wMyAxOToyNDoyMiJ9.CB6VYKcmFDT8Mdj41ECYC3kMop4sbcRUsyt4QIj17aM';
    }

    /**
     * A basic feature test example.
     */
    public function testUserCanCreateNote()
    {
        $noteTitle = "note".time();

        $response = $this->post('api/note/create', [
            'title' => $noteTitle,
            "content" => "content for note".time(),
        ], [
            'authorization' => 'bearer '.$this->jwtToken,
        ]);
          var_dump($response->getContent());

        $returnedArr = json_decode($response->getContent());
        $returnedArr = $returnedArr->data;

        $response->assertStatus(201);
        $this->assertEquals($returnedArr->title, $noteTitle);
    }

    public function testUserCanCreateNoteValidation()
    {
        $response = $this->post('api/note/create', [
            'title' => "",
            "content" => "",
        ], [
            'authorization' => 'bearer '.$this->jwtToken,
        ]);
        $returnedArr = json_decode($response->getContent());

        $response->assertStatus(400);
    }

    public function testUserCanUpdateNote(): void
    {
        $noteTitle = "note".time();
        $data = JWT::decode($this->jwtToken, new Key('foobar', 'HS256'));
        $note = Note::create(['user_id' => $data->userId, "title" => "foobar", "content" => "foooobarrr"]);

        $response = $this->post('api/note/update/'.$note->id, [
            'title' => $noteTitle,
            "content" => "content for note".time(),
        ], [
            'authorization' => 'bearer '.$this->jwtToken,
        ]);

        var_dump($response->getContent());

        $returnedArr = json_decode($response->getContent());
        $returnedArr = $returnedArr->data;


        $response->assertStatus(200);
        $this->assertEquals($returnedArr->title, $noteTitle);
    }

    public function testUserCanDeleteNote(): void
    {
        $noteTitle = "note".time();
        $data = JWT::decode($this->jwtToken, new Key('foobar', 'HS256'));
        $note = Note::create([
            'user_id' => $data->userId,
            "title" => "foobar",
            "content" => "foooobarrr",
        ]);

        $response = $this->post('api/note/destroy/'.$note->id, [], [
            'authorization' => 'bearer '.$this->jwtToken,
        ]);
        $response->assertStatus(200);
    }

    public function testRedisPubSub(): void
    {
        $redisPrefix = env('REDIS_PREFIX');

        $publisher = new Client([
            "host" => env('REDIS_HOST'),
            "password" => env('REDIS_PASSWORD'),
            "port" => env("REDIS_PORT"),
        ]);

        $publisher->publish(
            $redisPrefix.'user_added_note',
            json_encode([
                'type' => 'user_added_note',
                'user_id' => 10,
                'note_id' => 50,
            ])
        );
    }

}
