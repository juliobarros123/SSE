<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ConexaoDosSistemas;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/get/allSubcribed',['as'=>'admin.get.candidatos','uses'=>'admin\InscricaoOnlineController@getInscritos']);
Route::get('/get/admitidos',['as'=>'admin.get.admitidos','uses'=>'admin\AlunnoController@getAdmitidos']);
Route::post('/confirmacao', ['as' => 'admin/confirmacao/cadastrar', 'uses' => 'admin\ConfirmacaoController@store']);
Route::get('/imagens', ['as' => 'admin.confirmacao.imagens', 'uses' => 'admin\ConfirmacaoController@donwloadImage']);

Route::get('/alunos/post', ['as' => 'admin.alunos.post', 'uses' => 'Admin\ConexaoDosSistemas@postAluno']);
Route::get('/alunos/todos',['as'=> 'admin.alunos.todos', 'uses'=> 'Admin\ConexaoDosSistemas@getAluno']);
Route::post('register', 'TokenController@register');

// Route::post('login', 'TokenController@authenticate');
// Route::get('open', 'DataController@open');

//     Route::group(['middleware' => ['jwt.verify']], function() {

//         Route::get('user', 'Admin\MobileController@getAuthenticatedUser');
//         Route::get('closed', 'Admin\MobileControllerDataController@closed');
//         Route::post('v1/alunos',['as'=> 'api.alunos', 'uses'=> 'Api\AlunoController@alunos']);


//     });

    // Route::post('upload',  ['as'=> 'api.upload', 'uses'=> 'Api\ApiController@upload']);