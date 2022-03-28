<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'jwtauthapi'], function () {
    Route::get('/conteudos', [App\Http\Controllers\Api\Conteudos::class, 'get']);
    Route::get('/faq1', [App\Http\Controllers\Api\Faq1s::class, 'get']);
    Route::get('/faq2', [App\Http\Controllers\Api\Faq2s::class, 'get']);
    Route::get('/pagina', [App\Http\Controllers\Api\Paginas::class, 'get']);
    Route::get('/categoria', [App\Http\Controllers\Api\Categorias::class, 'get']);
    Route::get('/ciclo', [App\Http\Controllers\Api\Ciclos::class, 'get']);
    Route::get('/disciplina', [App\Http\Controllers\Api\Disciplinas::class, 'get']);
    Route::get('/link-preview', [App\Http\Controllers\Api\LinkPreview::class, 'get']);
});
