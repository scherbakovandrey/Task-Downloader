<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use URL;

class WebTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testAddNewTask()
    {
        $response = $this->get('/tasks/add');
        $response->assertStatus(200);

        $response = $this->post('/tasks', [
            'url' => 'http://www.google.com/'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/tasks');
    }

    public function testAddNewTaskErrorEmpty()
    {
        $response = $this->post('/tasks', [
            'url' => ''
        ]);
        $response->assertStatus(302); //redirect with error
        $response->assertRedirect('/tasks/add');
    }

    public function testAddNewTaskErrorWrong()
    {
        $response = $this->post('/tasks', [
            'url' => 'this_is_wrong_url'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/tasks/add');
    }

    public function testDownloadTask()
    {
        $downloadUrl = URL::current() . ':8000/test.txt';

        $response = $this->post('/tasks', [
            'url' => $downloadUrl
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/tasks');

        $id = $response->headers->get('task-id');

        $this->refreshApplication();

        $response = $this->get('/tasks/' . $id . '/download');
        $response->assertStatus(200);
        $this->assertEquals($response->streamedContent(), 'This is a test file');
    }

    public function testDownloadNotExistingTask()
    {
        $response = $this->get('/tasks/1000/download');
        $response->assertStatus(404);
    }
}