<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/faq', function () {
    return view('faq');
});

Route::get('/busca-curadoria', function () {
    return view('busca-curadoria');
});

Route::get('/conteudo', function () {
    return view('conteudo');
});

Route::get('/seguranca', function () {
    return view('conteudo', ['pagina' => 'seguranca']);
});

Route::get('/quem-somos', function () {
    return view('conteudo', ['pagina' => 'quem-somos']);
});

Route::get('/jwt-check', [App\Http\Controllers\JwtManager::class, 'valid'])->middleware('jwtauthapi');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
