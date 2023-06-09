<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\controllerTurma;

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

// ['as' => 'admin.listar', 'uses' => 'Admin\CandidaturaController@index']


// Route::get('/', function () {
//     return view('login');
// });


Route::get('/ex-alunos',['as'=>'site.diplomado','uses'=>'Admin\DiplomadosController@Site']);







Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    return view('dashboard');
})->name('dashboard');

Route::get('monitoramento',['as'=>'post.monitoring','uses'=>'Admin\MonitoramentoController@index']);


//site inicial inicio
Route::get('site', ['as' => 'site.site', 'uses' => 'SiteController@index']);
//site inicial fim
//formulário de candidatura inicio

Route::get('/admitido', ['as' => 'admitido', 'uses' => 'Admin\ConfirmacaoController@confirmar'])->middleware(['auth:sanctum', 'verified']);
Route::post('/admitido/store', ['as' => 'admin.admitidoPost', 'uses' => 'Admin\ConfirmacaoController@confirmarStore'])->middleware(['auth:sanctum', 'verified']);;

//formulário de candidatura fim
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('confirmados/{filename}', function ($filename)
{
    $path = public_path('confirmados/'.$filename);
    //dd($path);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
