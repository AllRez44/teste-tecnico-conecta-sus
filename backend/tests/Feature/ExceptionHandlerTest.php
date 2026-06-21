<?php

namespace Tests\Feature;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use Exception;

class ExceptionHandlerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/api/test-validation', function () {
            throw ValidationException::withMessages(['field' => ['The field is invalid.']]);
        });

        Route::get('/api/test-model-not-found', function () {
            throw new ModelNotFoundException();
        });

        Route::get('/api/test-authentication', function () {
            throw new AuthenticationException();
        });

        Route::get('/api/test-http-exception', function () {
            throw new HttpException(403, 'Acesso proibido.');
        });

        Route::get('/api/test-generic-exception', function () {
            throw new Exception('Algum erro fatal aconteceu.');
        });
    }

    public function test_returns_422_for_validation_exception()
    {
        $response = $this->getJson('/api/test-validation');

        $response->assertStatus(422)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Os dados fornecidos são inválidos.',
                     'errors' => [
                         'field' => ['The field is invalid.']
                     ]
                 ]);
    }

    public function test_returns_404_for_model_not_found_exception()
    {
        $response = $this->getJson('/api/test-model-not-found');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Registro não encontrado.',
                 ]);
    }

    public function test_returns_404_for_not_found_http_exception()
    {
        $response = $this->getJson('/api/rota-inexistente-12345');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Rota não encontrada.',
                 ]);
    }

    public function test_returns_401_for_authentication_exception()
    {
        $response = $this->getJson('/api/test-authentication');

        $response->assertStatus(401)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Não autenticado.',
                 ]);
    }

    public function test_returns_custom_status_for_generic_http_exception()
    {
        $response = $this->getJson('/api/test-http-exception');

        $response->assertStatus(403)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Acesso proibido.',
                 ]);
    }

    public function test_returns_500_for_generic_exception()
    {
        $response = $this->getJson('/api/test-generic-exception');

        $response->assertStatus(500)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Erro interno no servidor.',
                 ]);
    }
}
