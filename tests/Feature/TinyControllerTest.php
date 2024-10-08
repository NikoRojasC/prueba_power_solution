<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\TinyService;
use App\Services\BracketBalanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TinyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $tinyService;
    // protected $bracketBalanceService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tinyService = $this->createMock(TinyService::class);

        $this->app->instance(TinyService::class, $this->tinyService);
    }

    public function test_index_view()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('shorten');
    }

    public function test_short_url_success()
    {
        $this->tinyService->method('shortUrl')
            ->willReturn(['shorturl' => 'https://tinyurl.ph/iwWEs']);

        $response = $this->postJson('/api/v1/short-urls', [
            'url' => 'https://www.youtube.com/',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'original_url' => 'https://www.youtube.com/',
            'short_url' => 'https://tinyurl.ph/iwWEs',
        ]);
    }

    public function test_short_url_validation_error()
    {
        $response = $this->postJson('/api/v1/short-urls', [
            'url' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['url']);
    }

    public function test_short_url_service_error()
    {
        $this->tinyService->method('shortUrl')
            ->will($this->throwException(new \Exception('Error al acortar la URL')));

        $response = $this->postJson('/api/v1/short-urls', [
            'url' => 'https://www.youtube.com/',
        ]);

        $response->assertStatus(500);
        $response->assertJson(['error' => 'Error al acortar la URL']);
    }
}
