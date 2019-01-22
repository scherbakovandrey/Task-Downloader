<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use URL;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get('/api/tasks');
        $response->assertStatus(200);
    }

    public function testAddNewTask()
    {
        $response = $this->post('/api/tasks', [
            'url' => 'http://www.google.com/'
        ]);
        $response->assertStatus(201);
        $response->assertExactJson(
            [
                'id' => 1,
                'message' => 'The new task is successfully created!',
                'uri' => '/tasks/1'
            ]
        );

        $response = $this->get('/api/tasks');
        $response->assertStatus(200);
        $response->assertExactJson(
            [
                [
                    'id' => 1,
                    'url' => 'http://www.google.com/',
                    'status' => 2
                ]
            ]
        );
    }

    public function testAddNewTaskErrorEmpty()
    {
        $response = $this->post('/api/tasks', [
            'url' => ''
        ]);
        $response->assertStatus(406);
        $response->assertExactJson(
            [
                'errors' => ['The url field is required.'],
            ]
        );
    }

    public function testAddNewTaskErrorWrong()
    {
        $response = $this->post('/api/tasks', [
            'url' => 'thisisawrongurl'
        ]);
        $response->assertStatus(406);
        $response->assertExactJson(
            [
                'errors' => ['The url format is invalid.'],
            ]
        );
    }

    public function testDownloadTask()
    {
        $downloadUrl = URL::current() . ':8000/test.txt';

        $response = $this->post('/api/tasks', [
            'url' => $downloadUrl
        ]);
        $response->assertStatus(201);
        $contentDecoded = json_decode($response->content());
        $id = $contentDecoded->id;

        $this->refreshApplication();

        $response = $this->get('/api/tasks/' . $id . '/download');
        $response->assertStatus(200);
        $this->assertEquals($response->streamedContent(), 'This is a test file');
    }

    public function testDownloadNotExistingTask()
    {
        $response = $this->get('/api/tasks/1000/download');
        $response->assertStatus(404);
        $response->assertExactJson(
            [
                'errors' => 'This task is not found!',
            ]
        );
    }
}