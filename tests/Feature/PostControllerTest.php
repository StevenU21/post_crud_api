<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index(): void
    {
        Post::factory(10)->create();

        $response = $this->get('/api/posts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'content', 'created_at', 'updated_at']
                ],
                'links',
                'meta'
            ]);
    }

    public function test_show(): void
    {
        $post = Post::factory()->create();

        $response = $this->get("/api/posts/{$post->id}/show");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'content' => $post->content,
                ]
            ]);
    }

    public function test_store(): void
    {
        $postData = [
            'title' => 'Test Title',
            'content' => 'Test Content',
        ];

        $response = $this->postJson('/api/posts', $postData);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => $postData['title'],
                    'content' => $postData['content'],
                ]
            ]);

        $this->assertDatabaseHas('posts', $postData);
    }

    public function test_update(): void
    {
        $post = Post::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ];

        $response = $this->putJson("/api/posts/{$post->id}/update", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $post->id,
                    'title' => $updateData['title'],
                    'content' => $updateData['content'],
                ]
            ]);

        $this->assertDatabaseHas('posts', $updateData);
    }

    public function test_destroy(): void
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}/destroy");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_validation(): void
    {
        $postData = [
            'title' => '',
            'content' => '',
        ];

        $response = $this->postJson('/api/posts', $postData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'content']);
    }

    public function test_not_found(): void
    {
        $response = $this->get('/api/posts/999/show');

        $response->assertStatus(404);
    }

    public function test_method_not_allowed(): void
    {
        $response = $this->putJson('/api/posts');

        $response->assertStatus(405);
    }
}
