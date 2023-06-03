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


Route::get('/', ['as' => 'raiz', 'uses' => 'Admin\HomeController@raiz']);
Route::get('/home', ['as' => 'home', 'uses' => 'Admin\HomeController@raiz']);
Route::get('/caderneta/{id}',['as' =>'caderneta', 'uses' => 'Admin\BoletimTurmaController@dados']);

Route::get('/{id}/{trimestre}/gerarBoletimTurma/xlsx', ['as' => 'turmas.boletimTurmwas.xlsx', 'uses' => 'Admin\BoletimTurmaController@ver']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('uploadToGPEU',  ['as'=> 'admin.uploadToGPEU', 'uses'=> 'Admin\GPEUController@uploadToGPEU']);
    Route::get('/admitido', ['as' => 'admitido', 'uses' => 'Admin\ConfirmacaoController@confirmar'])->middleware('access.controll.pedagogia');

        Route::group(['prefix' => 'url_estatistica'], function () {
            Route::get('/criar', ['as' => 'api.url_estatistica.url.criar', 'uses' => 'Admin\URLEstatisticaController@criar']);
            Route::post('/cadastrar', ['as' => 'api.url_estatistica.url.cadastrar', 'uses' => 'Admin\URLEstatisticaController@cadastrar']);
            Route::get('/', ['as' => 'api.url_estatistica.url', 'uses' => 'Admin\URLEstatisticaController@index']);
            Route::put('{id}/actualizar', ['as' => 'api.url_estatistica.actualizar', 'uses' => 'Admin\URLEstatisticaController@actualizar']);
            Route::get('{id}/editar/', ['as' => 'api.url_estatistica.editar', 'uses' => 'Admin\URLEstatisticaController@editar']);
            Route::get('{id}/eliminar', ['as' => 'api.url_estatistica.eliminar', 'uses' => 'Admin\URLEstatisticaController@eliminar']);
           
        });
       

    
    //===================== Candidatos ==========================

    Route::group(['prefix' => 'admin/configurar/ano_lectivo'], function () {
        Route::get('{id}/disponibilizar', ['as' => 'admin.configurar.ano_lectivo.disponibilizar', 'uses' => 'Admin\ComposerAnoLectivoController@disponibilizar']);
        Route::get('{id}/ocultar', ['as' => 'admin.configurar.ano_lectivo.ocultar', 'uses' => 'Admin\ComposerAnoLectivoController@ocultar']);
        Route::post('/listar', ['as' => 'admin.pautaFinal.listar.get', 'uses' => 'Admin\PautaFinalController@getListPautaFinal']);
        Route::get('/listar/{anoLectivo}/{Curso}/{classe}', ['as' => 'admin.pautaFinal.Listas.get', 'uses' => 'Admin\PautaFinalController@getListasPautaFinal']);
        Route::get('/visualizar/{turma}', ['as' => 'admin.pautaFinal.visualizar.get', 'uses' => 'Admin\PautaFinalController@getViewPautaFinal']);
    });

    //===================== End Candidatos =====================


    //Routas das notas dos  Diplomados
    Route::get('nota-diplomados/cadastrar/{id}', ['as' => 'admin.nota-diplomados.cadastrar', 'uses' => 'Admin\NotaDiplomadoController@cadastrar'])->middleware('access.controll.administrador');
    Route::post('nota-diplomados/store', ['as' => 'admin.nota-diplomados.store', 'uses' => 'Admin\NotaDiplomadoController@store'])->middleware('access.controll.administrador');
    Route::get('nota-diplomados/editar/{id}', ['as' => 'admin.nota-diplomados.editar', 'uses' => 'Admin\NotaDiplomadoController@editar'])->middleware('access.controll.administrador');
    Route::get('diplomados/visualizar/{id}', ['as' => 'admin.diplomados.visualizar', 'uses' => 'Admin\DiplomadosController@visualizar'])->middleware('access.controll.administrador');

    //Routas dos  Diplomados
    Route::get('diplomados/listar', ['as' => 'admin.diplomados.listar', 'uses' => 'Admin\DiplomadosController@listar'])->middleware('access.controll.administrador');
    Route::get('diplomados/cadastrar', ['as' => 'admin.diplomados.cadastrar', 'uses' => 'Admin\DiplomadosController@cadastrar'])->middleware('access.controll.administrador');
    Route::post('diplomados/store', ['as' => 'admin.diplomados.store', 'uses' => 'Admin\DiplomadosController@store'])->middleware('access.controll.administrador');
    Route::get('diplomados/editar/{id}', ['as' => 'admin.diplomados.editar', 'uses' => 'Admin\DiplomadosController@editar'])->middleware('access.controll.administrador');
    Route::post('diplomados/update/{id}', ['as' => 'admin.diplomados.update', 'uses' => 'Admin\DiplomadosController@update'])->middleware('access.controll.administrador');
    Route::get('diplomados/excluir/{id}', ['as' => 'admin.diplomados.excluir', 'uses' => 'Admin\DiplomadosController@excluir'])->middleware('access.controll.administrador');
    Route::get('admin/diplomados/listas/imprimir', ['as' => 'admin.diplomados.imprimir', 'uses' => 'Admin\DiplomadosController@imprimir'])->middleware('access.controll.administrador');

    //Adnmitido
    Route::group(['prefix' => 'disciplina-terminal'], function () {
        Route::get('/criar', ['as' => 'admin.disciplinaTerminal.criar.get', 'uses' => 'Admin\DisciplinaTerminalController@getViewDisciplinaTerminal']);
        Route::post('/criar', ['as' => 'admin.disciplinaTerminal.criar.post', 'uses' => 'Admin\DisciplinaTerminalController@setDisciplinaTerminal']);
        Route::get('/editar/{id}', ['as' => 'admin.disciplinaTerminal.editar.get', 'uses' => 'Admin\DisciplinaTerminalController@getEditDisciplinaTerminal']);
        Route::post('/editar/{id}', ['as' => 'admin.disciplinaTerminal.editar.post', 'uses' => 'Admin\DisciplinaTerminalController@setEditDisciplinaTerminal']);
        Route::get('/purgar/{id}', ['as' => 'admin.disciplinaTerminal.delete.get', 'uses' => 'Admin\DisciplinaTerminalController@setDeleteDisciplinaTerminal']);
        Route::get('/eliminar/{id}', ['as' => 'admin.disciplinaTerminal.destroy.get', 'uses' => 'Admin\DisciplinaTerminalController@setDestroyDisciplinaTerminal']);
        Route::get('/listar', ['as' => 'admin.disciplinaTerminal.list.get', 'uses' => 'Admin\DisciplinaTerminalController@getListDisciplinaTerminal']);
    });


    Route::group(['prefix' => 'pauta-final'], function () {
        Route::get('/gerar', ['as' => 'admin.pautaFinal.gerar.get', 'uses' => 'Admin\PautaFinalController@getGeneratePautaFinal']);
        Route::post('/listar', ['as' => 'admin.pautaFinal.listar.get', 'uses' => 'Admin\PautaFinalController@getListPautaFinal']);
        Route::get('/listar/{anoLectivo}/{Curso}/{classe}', ['as' => 'admin.pautaFinal.Listas.get', 'uses' => 'Admin\PautaFinalController@getListasPautaFinal']);

        Route::get('/visualizar/{turma}', ['as' => 'admin.pautaFinal.visualizar.get', 'uses' => 'Admin\PautaFinalController@getViewPautaFinal']);
    });


    //Início search Escola
    Route::get('buscar/escolas', ['as' => 'buscar.escolas.searchSchool', 'uses' => 'Admin\DynamicSearch@searchSchool']);
    //FIM search Escola
    //Início search Processo
    Route::get('buscar/processos', ['as' => 'buscar.processo.searchProcess', 'uses' => 'Admin\DynamicSearch@searchProcess']);
    //FIM search Processo

    //Início search Classe
    Route::get('buscar/classes', ['as' => 'buscar.classes.searchGrade', 'uses' => 'Admin\DynamicSearch@searchGrade']);
    //FIM search Classe


    //Início search Turmas
    Route::get('buscar/turmas', ['as' => 'buscar.turmas.searchClass', 'uses' => 'Admin\DynamicSearch@searchClass']);
    //FIM search Turmas
    Route::get('turmas', ['as' => 'turmas', 'uses' => 'Admin\TurmaController@turmas']);
    //Início search Cursos
    Route::get('buscar/cursos', ['as' => 'buscar.cursos.searchCourse', 'uses' => 'Admin\DynamicSearch@searchCourse']);
    //FIM search Cursos

    //Início search Disciplinas
    Route::get('buscar/disciplinas', ['as' => 'buscar.disciplinas.searchSubject', 'uses' => 'Admin\DynamicSearch@searchSubject']);
    //FIM search Disciplina

    //Início search Turma Atrib
    Route::get('buscar/turmas-atrib', ['as' => 'buscar.classAtrib.searchClassAtrib', 'uses' => 'Admin\DynamicSearch@searchClassAtrib']);
    //FIM search Turma Atrib
    //Início search Turma Atrib
    Route::get('buscar/disciplinas-atrib', ['as' => 'buscar.SubjectAtrib.searchSubjectAtrib', 'uses' => 'Admin\DynamicSearch@searchSubjectAtrib']);
    //FIM search Turma Atrib


    //Início search Turmas Matricula
    Route::get('buscar/turmas-matricula', ['as' => 'buscar.turmas-matricula.searchClassRegistration', 'uses' => 'Admin\DynamicSearch@searchClassRegistration']);
    //FIM search Classe

    //Início search Classe
    Route::get('buscar/anoletivo', ['as' => 'buscar.classes.searchYear', 'uses' => 'Admin\DynamicSearch@searchYear']);
    //FIM search Classe

    //Início search Disciplina Atrib
    Route::get('buscar/disciplinas/attrib', ['as' => 'buscar.disciplinas.subjectAtrib', 'uses' => 'Admin\DynamicSearch@searchSubjectAtrib']);
    //FIM search Classe

    //Início search Classe
    //Route::get('/buscar/diasSemana', ['as' => 'buscar.diasSemana.searchDaysOfTheWeek', 'uses' => 'Admin\DynamicSearchController@searchDaysOfTheWeek']);
    //FIM search Classe
    //===================== Candidatos ==========================

    Route::get('admin/candidatos-api', ['as' => 'admin.candidatos-api.create', 'uses' => 'Admin\InscricaoOnlineController@index']);
    Route::get('admin/pre_candidatos-api', ['as' => 'admin.candidatos-api-pre.create', 'uses' => 'Admin\PreCandidatoController@indexAPI']);
    Route::get('admin/alunos-api', ['as' => 'admin.alunos-api.create', 'uses' => 'Admin\ConfirmacaoController@index']);

    //Route::get('admin/candidatos-api/listar', ['as' => 'admin.candidatos-api.listarr', 'uses' => 'Admin\InscricaoOnlineController@listar'])->middleware('access.controll.administrador');



    //====================End Candidatos API =========================



    //=============User-Start=====================//
    Route::get('admin/users/listar', ['as' => 'admin.users', 'uses' => 'Admin\UserController@index'])->middleware('access.controll.administrador');
    Route::get('admin/users/listar/imprimir', ['as' => 'admin.users.listar.imprimir', 'uses' => 'Admin\UserController@imprimir_lista'])->middleware('access.controll.administrador');
    Route::post('admin/users/salvar', ['as' => 'admin.users.salvar', 'uses' => 'Admin\UserController@salvar'])->middleware('access.controll.administrador');
    Route::get('admin/users/cadastrar', ['as' => 'admin.users.cadastrar', 'uses' => 'Admin\UserController@create'])->middleware('access.controll.administrador');
    Route::get('admin/users/excluir/{id}', ['as' => 'admin.users.excluir', 'uses' => 'Admin\UserController@excluir'])->middleware('access.controll.administrador');
    Route::put('admin/users/atualizar/{id}', ['as' => 'admin.users.atualizar', 'uses' => 'Admin\UserController@atualizar'])->middleware('access.controll.administrador');
    Route::get('admin/users/ver/{id}', ['as' => 'users', 'uses' => 'Admin\UserController@ver'])->middleware('access.controll.administrador');
    Route::get('admin/users/editar/{id}', ['as' => 'admin.users.editar', 'uses' => 'Admin\UserController@editar'])->middleware('access.controll.administrador');
    //=============User-End======================//




    //=============Turma-User-Start=====================//

    Route::get('Admin/pesquisarAtribuidos', ['as' => 'admin.pesquisarAtribuidos', 'uses' => 'Admin\TurmaUserController@pesquisar']);
    Route::get('turmas/listar/{id}', ['as' => 'user.turma', 'uses' => 'admin\ProfessorController@listarTurmas']);

    Route::get('admin/atribuicoes/listar', ['as' => 'admin.atribuicoes', 'uses' => 'Admin\TurmaUserController@index']);
    Route::post('admin/atribuicoes/salvar', ['as' => 'admin.atribuicoes.salvar', 'uses' => 'Admin\TurmaUserController@salvar']);
    Route::get('admin/atribuicoes/cadastrar', ['as' => 'admin.atribuicoes.cadastrar', 'uses' => 'Admin\TurmaUserController@cadastrar']);
    Route::get('admin/atribuicoes/excluir/{id}', ['as' => 'admin.atribuicoes.excluir', 'uses' => 'Admin\TurmaUserController@excluir'])->middleware('access.controll.administrador');
    Route::put('admin/atribuicoes/atualizar/{id}', ['as' => 'admin.atribuicoes.atualizar', 'uses' => 'Admin\TurmaUserController@atualizar'])->middleware('access.controll.administrador');
    Route::get('admin/atribuicoes/ver/{id}', ['as' => 'admin.atribuicoes.ver', 'uses' => 'Admin\TurmaUserController@ver']);
    Route::get('admin/atribuicoes/editar/{id}', ['as' => 'admin.atribuicoes.editar', 'uses' => 'Admin\TurmaUserController@editar'])->middleware('access.controll.administrador');
    Route::get('admin/atribuicoes/lecionar/{id}', ['as' => 'admin.atribuicao.lecionar', 'uses' => 'Admin\TurmaUserController@lecionado']);
    //=============Turma-User-End======================//

    //=============Curso-Start=====================//
    Route::get('Admin/cursos/index/index', ['as' => 'cursos', 'uses' => 'Admin\CursoController@index']);
    Route::post('Admin/cursos/store', ['as' => 'cursos.store', 'uses' => 'Admin\CursoController@store']);
    Route::get('Admin/cursos/create/index', ['as' => 'cursos.create', 'uses' => 'Admin\CursoController@create']);
    Route::get('Admin/cursos/destroy/{id}', ['as' => 'cursos.destroy', 'uses' => 'Admin\CursoController@destroy'])->middleware('access.controll.administrador');
    Route::put('Admin/cursos/update/{id}', ['as' => 'cursos.update', 'uses' => 'Admin\CursoController@update'])->middleware('access.controll.administrador');
    Route::get('Admin/cursos/show/index/{id}', ['as' => 'cursos.show', 'uses' => 'Admin\CursoController@show'])->middleware('access.controll.administrador');
    Route::get('Admin/cursos/edit/index/{id}', ['as' => 'cursos.edit', 'uses' => 'Admin\CursoController@edit'])->middleware('access.controll.administrador');
    //=============Curso-End======================//

    //=============Processo-Start=====================//
    Route::get('Admin/processos/index/index', ['as' => 'processos', 'uses' => 'Admin\ProcessoController@index']);
    Route::post('Admin/processos/store', ['as' => 'processos.store', 'uses' => 'Admin\ProcessoController@store']);
    Route::get('Admin/processos/create/index', ['as' => 'processos.create', 'uses' => 'Admin\ProcessoController@create']);
    Route::get('Admin/processos/destroy/index/{id}', ['as' => 'processos.destroy', 'uses' => 'Admin\ProcessoController@destroy'])->middleware('access.controll.administrador');
    Route::put('Admin/processos/update/{id}', ['as' => 'processos.update', 'uses' => 'Admin\ProcessoController@update'])->middleware('access.controll.administrador');
    Route::get('Admin/processos/show/index/{id}', ['as' => 'processos.show', 'uses' => 'Admin\ProcessoController@show'])->middleware('access.controll.administrador');
    Route::get('Admin/processos/edit/index/{id}', ['as' => 'processos.edit', 'uses' => 'Admin\ProcessoController@edit'])->middleware('access.controll.administrador');
    //=============Processo-End======================//


    //=============Matricula-Start=====================//
    Route::get('Admin/pesquisarMatriculados', ['as' => 'admin.matriculas.pesquisar', 'uses' => 'Admin\MatriculaController@pesquisar']);
    Route::post('Admin/matriculados', ['as' => 'admin.matriculados', 'uses' => 'Admin\MatriculaController@matriculados']);

    Route::get('Admin/matriculas/listar/{anoLectivo}/{curso}/{vc_classe}', ['as' => 'admin.matriculas', 'uses' => 'Admin\MatriculaController@index']);
    Route::post('Admin/matriculas/salvar', ['as' => 'admin.matriculas.salvar', 'uses' => 'Admin\MatriculaController@salvar']);
    Route::get('Admin/matriculas/cadastrar', ['as' => 'admin.matriculas.cadastrar', 'uses' => 'Admin\MatriculaController@cadastrar']);
    Route::get('Admin/matriculas/excluir/{id}', ['as' => 'admin.matriculas.excluir', 'uses' => 'Admin\MatriculaController@excluir'])->middleware('access.controll.administrador');
    Route::put('Admin/matriculas/atualizar/{id}', ['as' => 'admin.matriculas.atualizar', 'uses' => 'Admin\MatriculaController@atualizar']);
    Route::get('Admin/matriculas/ver/{id}', ['as' => 'matriculas', 'uses' => 'Admin\MatriculaController@ver']);
    Route::get('Admin/matriculas/editar/{id}', ['as' => 'admin.matriculas.editar', 'uses' => 'Admin\MatriculaController@editar']);
    Route::get('Admin/matriculas/purgar/{id}', ['as' => 'admin.matriculas.purgar', 'uses' => 'Admin\MatriculaController@purgar'])->middleware('access.controll.administrador');
    Route::get('admin/matriculas/pesquisar_pdf', ['as' => 'admin.matriculas.pesquisar_pdf', 'uses' => 'Admin\MatriculaController@pesquisar_pdf']);
    Route::post('Admin/matriculados/lista_pdf', ['as' => 'admin.matriculas.lista_pdf', 'uses' => 'Admin\MatriculaController@lista_pdf']);


    //-------Gerar boletim------//
    Route::get('/admin/matriculas/pesquisar', ['as' => 'admin.matriculas.pesquisar', 'uses' => 'Admin\MatriculaController@pesquisaraluno']);
    Route::post('/admin/matriculas/send/', ['as' => 'admin.matriculas.send', 'uses' => 'Admin\MatriculaController@recebeAluno']);
    Route::get('/admin/matriculas/emitirboletim/{id}', ['as' => 'admin.matriculas.emitirboletim', 'uses' => 'Admin\MatriculaController@emitirboletim']);
    //=============Matricula-End======================//


    // Start Classe
    Route::get('/admin/classes', ['as' => 'admin/classes', 'uses' => 'Admin\ClasseController@index']);
    Route::get('/admin/classes/cadastrar', ['as' => 'admin/classes/cadastrar/post', 'uses' => 'Admin\ClasseController@create']);
    Route::post('/admin/classes/cadastrar', ['as' => 'admin/classes/cadastrar', 'uses' => 'Admin\ClasseController@store']);
    Route::get('/admin/visualizar/{id}', ['as' => 'admin/classes/visualizar', 'uses' => 'Admin\ClasseController@show']);
    Route::get('/admin/aditar/{id}', ['as' => 'admin/classes/editar', 'uses' => 'Admin\ClasseController@edit'])->middleware('access.controll.administrador');
    Route::put('/admin/editar/{id}', ['as' => 'admin/classes/atualizar', 'uses' => 'Admin\ClasseController@update'])->middleware('access.controll.administrador');
    Route::get('/admin/eliminar/{id}', ['as' => 'admin/classes/eliminar', 'uses' => 'Admin\ClasseController@remover'])->middleware('access.controll.administrador');
    // End Classe

    // Start Ano Lectivo
    Route::get('/admin/anolectivo', ['as' => 'admin/anolectivo', 'uses' => 'Admin\AnoLectivoController@index']);
    Route::get('/admin/anolectivo/cadastrar', ['as' => 'admin/anolectivo/cadastrar', 'uses' => 'Admin\AnoLectivoController@create']);
    Route::post('/admin/anolectivo/cadastrar', ['as' => 'admin/anolectivo/cadastrar', 'uses' => 'Admin\AnoLectivoController@store']);
    Route::get('/admin/anolectivo/visualizar/{id}', ['as' => 'admin/anolectivo/visualizar', 'uses' => 'Admin\AnoLectivoController@show']);
    Route::get('/admin/anolectivo/aditar/{id}', ['as' => 'admin/anolectivo/editar', 'uses' => 'Admin\AnoLectivoController@edit'])->middleware('access.controll.administrador');
    Route::put('/admin/anolectivo/editar/{id}', ['as' => 'admin/anolectivo/atualizar', 'uses' => 'Admin\AnoLectivoController@update'])->middleware('access.controll.administrador');
    Route::get('/admin/anolectivo/eliminar/{id}', ['as' => 'admin/anolectivo/eliminar', 'uses' => 'Admin\AnoLectivoController@destroy'])->middleware('access.controll.administrador');
    // End Ano Lectivo

    // Start Activadores de Candidatura
    Route::get('/admin/cadeado_candidatura', ['as' => 'admin/cadeado_candidatura', 'uses' => 'Admin\ActivadordaCandidaturaController@index']);
    Route::get('/admin/cadeado_candidatura/aditar/{id}', ['as' => 'admin/cadeado_candidatura/editar', 'uses' => 'Admin\ActivadordaCandidaturaController@edit'])->middleware('access.controll.administrador');
    Route::put('/admin/cadeado_candidatura/editar/{id}', ['as' => 'admin/cadeado_candidatura/atualizar', 'uses' => 'Admin\ActivadordaCandidaturaController@update'])->middleware('access.controll.administrador');
    // End Activadores de Candidatura

    // Start Cabeçalho da Escola
    Route::get('/admin/escola', ['as' => 'admin/escola', 'uses' => 'Admin\EscolaController@index'])->middleware('access.controll.administrador');
    Route::get('/admin/escola/cadastrar', ['as' => 'admin/escola/cadastrar', 'uses' => 'Admin\EscolaController@create'])->middleware('access.controll.administrador');
    Route::post('/admin/escola/cadastrar', ['as' => 'admin/escola/cadastrar', 'uses' => 'Admin\EscolaController@store'])->middleware('access.controll.administrador');
    Route::get('/admin/escola/visualizar/{id}', ['as' => 'admin/escola/visualizar', 'uses' => 'Admin\EscolaController@show'])->middleware('access.controll.administrador');
    Route::get('/admin/escola/aditar/{id}', ['as' => 'admin/escola/editar', 'uses' => 'Admin\EscolaController@edit'])->middleware('access.controll.administrador');
    Route::put('/admin/escola/editar/{id}', ['as' => 'admin/escola/atualizar', 'uses' => 'Admin\EscolaController@update'])->middleware('access.controll.administrador');
    // End Cabeçalho da Escola



    // Start Idade de Candidatura
    Route::get('/admin/idadedecandidatura', ['as' => 'admin/idadedecandidatura', 'uses' => 'Admin\IdadedeCandidaturaController@index']);
    Route::get('/admin/idadedecandidatura/cadastrar', ['as' => 'admin/idadedecandidatura/cadastrar', 'uses' => 'Admin\IdadedeCandidaturaController@create']);
    Route::post('/admin/idadedecandidatura/cadastrar', ['as' => 'admin/idadedecandidatura/cadastrar', 'uses' => 'Admin\IdadedeCandidaturaController@store']);
    Route::get('/admin/idadedecandidatura/editar/{id}', ['as' => 'admin/idadedecandidatura/editar', 'uses' => 'Admin\IdadedeCandidaturaController@edit'])->middleware('access.controll.administrador');
    Route::put('/admin/idadedecandidatura/editar/{id}', ['as' => 'admin/idadedecandidatura/atualizar', 'uses' => 'Admin\IdadedeCandidaturaController@update'])->middleware('access.controll.administrador');
    Route::get('/admin/idadedecandidatura/eliminar/{id}', ['as' => 'admin/idadedecandidatura/eliminar', 'uses' => 'Admin\IdadedeCandidaturaController@destroy'])->middleware('access.controll.administrador');
    // End Idade de Candidatura


    //alunos


    //alunos

    Route::get('admin/alunos/{id}transferir', ['as' => 'admin.alunos.transferir', 'uses' => 'Admin\AlunnoController@transferir']);
    Route::get('admin/alunos/pesquisar', ['as' => 'admin.alunos.pesquisar', 'uses' => 'Admin\AlunnoController@pesquisar']);
    Route::post('admin/alunos/lista', ['as' => 'admin.alunos.lista', 'uses' => 'Admin\AlunnoController@lista']);
    Route::get('admin/alunos/listar/{anolectivo}/{curso}', ['as' => 'admin.alunos.listar', 'uses' => 'Admin\AlunnoController@listarAlunos']);
    Route::get('admin/aluno/pulgar/{id}', ['as' => 'admin.aluno.pulgar', 'uses' => 'Admin\AlunnoController@pulgar'])->middleware('access.controll.administrador');

    Route::get('admin/alunos/eliminar/{id}', 'Admin\AlunnoController@delete')->name('aluno.delete');
    Route::get('admin/alunos/editar/{id}', 'Admin\AlunnoController@edit')->name('aluno.edit');
    Route::put('admin/alunos/editar/{id}', 'Admin\AlunnoController@update')->name('aluno.update');
    Route::get('admin/aluno/ficha/{id}', ['as' => 'admin.alunno.ficha', 'uses' => 'Admin\AlunnoController@imprimirFicha']);

    Route::post('admin/alunos/recebeBI', ['as' => 'admin.alunos.recebeBI', 'uses' => 'Admin\AlunnoController@recebeBI']);
    Route::get('admin/alunos/trazerCandidato/{BI}', ['as' => 'admin.alunos.trazerCandidato', 'uses' => 'Admin\AlunnoController@trazerCandidato']);

    Route::get('admin/alunos/cadastrar', ['as' => 'admin.alunos.cadastrar', 'uses' => 'Admin\AlunnoController@create']);
    Route::post('admin/alunos/cadastrar', ['as' => 'admin.alunos.cadastrar', 'uses' => 'Admin\AlunnoController@cadastrar']);

    Route::get('admin/selecionados/lista/{anolectivo}/{curso}', ['as' => 'admin.alunos.selecionados', 'uses' => 'Admin\AlunnoController@listas']);
    ///alunos fim
    ///alunos fim

    //Lista PDF dos Selecionados
    Route::get('Admin/candidatos/aceitos/pesquisar/imprimir', ['as' => 'admin.ListadSelecionado.candidatos/aceitos/pesquisar/imprimir', 'uses' => 'Admin\ListadSelecionado@pesquisar']);
    Route::post('Admin/recebeSelecionados', ['as' => 'admin.ListadSelecionado.recebeSelecionados', 'uses' => 'Admin\ListadSelecionado@recebeSelecionados']);

    Route::get('Admin/lista/selecionados/{anoLectivo}/{curso}', ['as' => 'admin.ListadSelecionado.lista', 'uses' => 'Admin\ListadSelecionado@index']);
    //Lista PDF dos Selecionados

    //Lista PDF dos Candidatos
    Route::get('Admin/candidaturas/pesquisar/imprimir', ['as' => 'admin.ListadCandidatura.candidaturas/pesquisar/imprimir', 'uses' => 'Admin\ListadCandidatura@pesquisar']);
    Route::post('Admin/recebeCandidaturas', ['as' => 'admin.ListadCandidatura.recebeCandidaturas', 'uses' => 'Admin\ListadCandidatura@recebeCandidaturas']);

    Route::get('Admin/listas/candidaturas/{anoLectivo}/{curso}', ['as' => 'admin.ListadCandidatura.lista', 'uses' => 'Admin\ListadCandidatura@index']);
    //Lista PDF dos Candidatos

    //Relatórios Início
    /*CANDIDATURA*/

    Route::get('Admin/pesquisarRec', ['as' => 'admin.pesquisarRec', 'uses' => 'Admin\relatorios\RecController@pesquisar']);
    Route::post('Admin/recebeRec', ['as' => 'admin.recebeRec', 'uses' => 'Admin\relatorios\RecController@recebeRec']);
    Route::get('Admin/lista/Rec/{anoLectivo}', ['as' => 'admin.listaRec', 'uses' => 'Admin\relatorios\RecController@lista']);
    Route::get('Admin/relatorio/diario/buscar/{ano_lectivo}/{data_inicio}/', ['as' => 'admin.relatorio_diario_buscar', 'uses' => 'Admin\relatorios\RecController@buscar_diario']);
    Route::post('Admin/relatorio/diario', ['as' => 'admin.relatorio_diario', 'uses' => 'Admin\relatorios\RecController@recebeRec']);
    /* SELEÇÃO */
    Route::get('Admin/pesquisarRes', ['as' => 'admin.pesquisarRes', 'uses' => 'Admin\relatorios\ResController@pesquisar']);
    Route::post('Admin/recebeRes', ['as' => 'admin.recebeRes', 'uses' => 'Admin\relatorios\ResController@recebeRes']);
    Route::get('Admin/lista/Res/{anoLectivo}/{vc_curso}/{data}', ['as' => 'admin.listaRes', 'uses' => 'Admin\relatorios\ResController@lista']);
    /* ALUNOS MATRICULADOS */
    Route::get('Admin/pesquisarRem', ['as' => 'admin.pesquisarRem', 'uses' => 'Admin\relatorios\RemController@pesquisar']);
    Route::post('Admin/recebeRem', ['as' => 'admin.recebeRem', 'uses' => 'Admin\relatorios\RemController@recebeRem']);
    Route::get('Admin/lista/Rem/{anoLectivo}', ['as' => 'admin.listaRem', 'uses' => 'Admin\relatorios\RemController@lista']);

    Route::get('Admin/relatorio/matricula/pesquisar', ['as' => 'admin.relatorio_matricula_pesquisar', 'uses' => 'Admin\relatorios\RemController@relatorio_matricula_pesquisar']);
    Route::post('Admin/relatorio/matricula', ['as' => 'admin.relatorio_matricula', 'uses' => 'Admin\relatorios\RemController@relatorio_matricula']);

    //Relatórios fim




    //candidatura inicio
    Route::get('candidatos/pesquisar', ['as' => 'admin.candidatos.pesquisar', 'uses' => 'Admin\CandidaturaController@pesquisar']);
    Route::get('candidatos/recebecandidaturas', ['as' => 'admin.candidatos.recebecandidaturas', 'uses' => 'Admin\CandidaturaController@recebecandidaturas']);
    Route::post('candidatos/recebecandidaturas', ['as' => 'admin.candidatos.recebecandidaturas', 'uses' => 'Admin\CandidaturaController@recebecandidaturas']);
    Route::get('candidaturas/listar/{anoLectivo}/{curso}', ['as' => 'admin.candidatos.listar', 'uses' => 'Admin\CandidaturaController@index']);
    Route::get('candidatos/{id}/visualizar', ['as' => 'admin.candidatos.visualizar', 'uses' => 'Admin\CandidaturaController@visualizar']);
    Route::get('candidatos/{id}', ['as' => 'admin.candidatos.listar', 'uses' => 'Admin\CandidaturaController@imprimirFicha']);
    Route::get('candidatos/{id}/edit', ['as' => 'admin.candidatos.editar', 'uses' => 'Admin\CandidaturaController@edit']);
    Route::put('candidatos/{id}/update', ['as' => 'admin.candidatos.update', 'uses' => 'Admin\CandidaturaController@update']);
    Route::get('candidatos/{id}/eliminar', ['as' => 'admin.candidatos.eliminar', 'uses' => 'Admin\CandidaturaController@eliminar'])->middleware('access.controll.administrador');
    Route::get('candidatos/{id}/pulgar', ['as' => 'admin.candidatos.pulgar', 'uses' => 'Admin\CandidaturaController@pulgar'])->middleware('access.controll.administrador');
    Route::get('candidatos2/pulgar/{id}', ['as' => 'admin.candidatos2.pulgar', 'uses' => 'Admin\Candidatos2Controller@pulgar'])->middleware('access.controll.administrador');
    Route::get('candidatos/{id}/destroy', ['as' => 'admin.candidatos.destroy', 'uses' => 'Admin\CandidaturaController@destroy'])->middleware('access.controll.administrador');
    Route::get('admin/candidatos/{id}/transferir', ['as' => 'admin.candidatos.transferir', 'uses' => 'Admin\CandidaturaController@transferir']);
    Route::get('admin/candidatos/{id}/admitir', ['as' => 'admin.candidatos.admitir', 'uses' => 'Admin\CandidaturaController@admitir']);
    Route::get('admin/candidatos/filtro', ['as' => 'admin.candidatos.filtro', 'uses' => 'Admin\CandidaturaController@filtro']);
    Route::post('admin/candidatos/filtro_cadidatos', ['as' => 'admin.candidatos.filtro_cadidatos', 'uses' => 'Admin\CandidaturaController@filtro_cadidatos']);

    ///Candidatura Dashboard

    //candidatura inicio
    Route::get('pre_candidatos/pesquisar', ['as' => 'admin.pre_candidatos.pesquisar', 'uses' => 'Admin\PreCandidatoController@pesquisar']);
    Route::get('pre_candidatos/recebecandidaturas', ['as' => 'admin.pre_candidatos.recebecandidaturas', 'uses' => 'Admin\PreCandidatoController@recebecandidaturas']);
    Route::post('pre_candidatos/recebecandidaturas', ['as' => 'admin.pre_candidatos.recebecandidaturas', 'uses' => 'Admin\PreCandidatoController@recebecandidaturas']);
    Route::get('candidaturas/listar/{anoLectivo}/{curso}', ['as' => 'admin.pre_candidatos.listar', 'uses' => 'Admin\PreCandidatoController@index']);
    Route::get('pre_candidatos/{id}/visualizar', ['as' => 'admin.pre_candidatos.visualizar', 'uses' => 'Admin\PreCandidatoController@visualizar']);
    Route::get('pre_candidatos/{id}', ['as' => 'admin.pre_candidatos.listar', 'uses' => 'Admin\PreCandidatoController@imprimirFicha']);
    Route::get('pre_candidatos/{id}/edit', ['as' => 'admin.pre_candidatos.editar', 'uses' => 'Admin\PreCandidatoController@edit'])->middleware('access.controll.administrador');
    Route::put('pre_candidatos/{id}/update', ['as' => 'admin.pre_candidatos.update', 'uses' => 'Admin\PreCandidatoController@update'])->middleware('access.controll.administrador');
    Route::get('pre_candidatos/{id}/eliminar', ['as' => 'admin.pre_candidatos.eliminar', 'uses' => 'Admin\PreCandidatoController@eliminar'])->middleware('access.controll.administrador');
    Route::get('pre_candidatos/{id}/pulgar', ['as' => 'admin.pre_candidatos.pulgar', 'uses' => 'Admin\PreCandidatoController@pulgar'])->middleware('access.controll.administrador');
    Route::get('pre_candidatos/{id}/destroy', ['as' => 'admin.pre_candidatos.destroy', 'uses' => 'Admin\PreCandidatoController@destroy'])->middleware('access.controll.administrador');
    Route::get('admin/pre_candidatos/{id}/transferir', ['as' => 'admin.pre_candidatos.transferir', 'uses' => 'Admin\PreCandidatoController@transferir']);
    Route::get('admin/pre_candidatos/{id}/admitir', ['as' => 'admin.pre_candidatos.admitir', 'uses' => 'Admin\PreCandidatoController@admitir']);
    ///Candidatura Dashboard


    //Turmas
    Route::get('turmas/pesquisar', ['as' => 'admin.turmas.pesquisar', 'uses' => 'Admin\TurmaController@pesquisar']); //->middleware('access.controll.preparador');
    Route::post('turmas/ver', ['as' => 'admin.turmas.ver', 'uses' => 'Admin\TurmaController@ver']); //->middleware('access.controll.preparador');

  //sddd

    Route::group(['prefix' => 'turmas'], function () {

        Route::get('/{id}/professor', ['as' => 'turmas.professor', 'uses' => 'Admin\TurmaController@turmasProfessor']);

        Route::get('/cadastrar', ['as' => 'turmas.cadastrar', 'uses' => 'Admin\TurmaController@cadastrar'])->name('turmas.cadastrar');
        Route::post('/inserir', ['as' => 'turmas.efectuarCadastroDaTurma', 'uses' => 'Admin\TurmaController@efectuarCadastroDaTurma']);
        Route::get('/listarTurmas/{anolectivo}/{curso}', ['as' => 'admin.viewListarTurmas', 'uses' => 'Admin\TurmaController@listarTurmas']);

        Route::get('/{id}/editar', ['as' => 'turmas.editar', 'uses' => 'Admin\TurmaController@editar'])->middleware('access.controll.administrador');
        Route::get('/{id}/eliminar', ['as' => 'turmas.eliminar', 'uses' => 'Admin\TurmaController@eliminar'])->middleware('access.controll.administrador');
        Route::put('/{id}/actualizar', ['as' => 'turmas.actualizar', 'uses' => 'Admin\TurmaController@actualizar'])->middleware('access.controll.administrador');

        Route::get('/{id}/imprimir_alunos', ['as' => 'turmas.imprimir_alunos', 'uses' => 'Admin\TurmaController@gerarlista']);
        Route::get('/{id}/gerarcadernetaTurmas', ['as' => 'turmas.gerarcadernetaTurmas', 'uses' => 'Admin\TurmaController@gerarcaderneta']);

        Route::get('/{id}/gerarcadernetaTurmas/xlsx', ['as' => 'turmas.gerarcadernetaTurmas.xlsx', 'uses' => 'Admin\ExportController@exports']);
        Route::get('/{id}/gerarcadernetaTurmas/xlsx/view', ['as' => 'turmas.gerarcadernetaTurmas.xlsx.view', 'uses' => 'Admin\ExportController@exportsView']);
        Route::get('/{id}/verPauta', ['as' => 'turmas.gerarcadernetaTurmas.xlsx.view', 'uses' => 'Admin\ExportController@exportsView']);

        Route::get('/{id}/{trimestre}/gerarBoletimTurma/xlsx', ['as' => 'turmas.boletimTurmas.xlsx', 'uses' => 'Admin\BoletimTurmaController@exports']);
        Route::get('/{id}/gerarBoletimTurma/xlsx/view', ['as' => 'turmas.boletimTurmas.xlsx.view', 'uses' => 'Admin\BoletimTurmaController@exportsView']);
        Route::get('/{id}/verBoletim', ['as' => 'turmas.boletimTurmas.xlsxview', 'uses' => 'Admin\BoletimTurmaController@exportsView']);

        Route::get('/{id}/gerarListaTurma/xlsx', ['as' => 'turmas.listaTurmas.xlsx', 'uses' => 'Admin\ListaCadastroSiteController@exports']);
        Route::get('/{id}/gerarListaTurma/xlsx/view', ['as' => 'turmas.listaTurmas.xlsx.view', 'uses' => 'Admin\ListaCadastroSiteController@exportsView']);
        Route::get('/{id}/verLista', ['as' => 'turmas.listaTurmas.xlsxview', 'uses' => 'Admin\ListaCadastroSiteController@exportsView']);


    });

    //End Turmas

    //Direitor de Turma
    Route::group(['prefix' => 'direitores-turmas'], function () {

        Route::get('/cadastrar', ['as' => 'turma.cadastrar', 'uses' => 'Admin\DireitorTurmaController@cadastrar'])->name('turmas.cadastrar');
        Route::post('/cadastrar', ['as' => 'turmas.cadastrar', 'uses' => 'Admin\DireitorTurmaController@cadastrar']);
        Route::get('/index', ['as' => 'admin.viewindex', 'uses' => 'Admin\DireitorTurmaController@index']);

        Route::get('/{id}/editarDireitor', ['as' => 'turmas.editarDireitor', 'uses' => 'Admin\DireitorTurmaController@editarDireitor'])->middleware('access.controll.administrador');
        Route::get('/{id}/deletarDireitor', ['as' => 'turmas.deletarDireitor', 'uses' => 'Admin\DireitorTurmaController@deletarDireitor'])->middleware('access.controll.administrador');
        Route::put('/{id}/efectuarEdicaoDireitor', ['as' => 'turmas.efectuarEdicaoDireitor', 'uses' => 'Admin\DireitorTurmaController@efectuarEdicaoDireitor'])->middleware('access.controll.administrador');
        Route::get('consultar_turmas', ['as' => 'direitores-turmas.consultar_turmas', 'uses' => 'Admin\DireitorTurmaController@consultar_turmas']);
        Route::post('turmas', ['as' => 'direitores-turmas.turmas', 'uses' => 'Admin\DireitorTurmaController@turmas']);

    });
    // End Direitor de Turma

    //Start DeclaracaoComNotas
    Route::group(['prefix' => 'declaracaoComNotas'], function () {
        Route::get('/home', ['as' => 'declaracaoComNotas.home', 'uses' => 'Admin\DeclaracaoComNotasController@home']);
        Route::post('/buscarAluno', ['as' => 'declaracaoComNotas.buscarAluno', 'uses' => 'Admin\DeclaracaoComNotasController@buscarAluno']);
        Route::get('/listar', ['as' => 'declaracaoComNotas.listar', 'uses' => 'Admin\DeclaracaoComNotasController@declaracoesEmitidas']);
        Route::get('/gerarDecloaracao', ['as' => 'declaracaoComNotas.gerarDecloaracao', 'uses' => 'Admin\DeclaracaoComNotasController@gerarDecloaracao']);
    });
    //End DeclaracaoComNotas

    //Begin (rota das declaracções sem notas)
    Route::get('/Declaracao', 'DeclaracaoSemNotasController@trabalharDeclaracao');
    Route::get('/DeclaracaoT', 'Admin\DeclaracaoSemNotasController@mostrarLista')->name('mostrarLista');
    Route::get('/teste', 'Admin\DeclaracaoSemNotasController@mostrarLista')->name('teste');
    Route::get('/matricula', ['as' => 'teste1', 'uses' => 'Admin\DeclaracaoSemNotasController@retornando']);
    Route::get('/teste1', 'Admin\DeclaracaoSemNotasController@retornando'); // Paulo por favor não elimina

    Route::group(['prefix' => 'Declaracoes', 'namespace' => 'Admin'], function () {
        //Route::get('/teste',['as'=>'admin','uses'=>'DeclaracaoSemNotasController@roT']);
        // Begin (páginas do projecto)
        Route::get('/paginaCadastrar', ['as' => 'paginaCadastro', 'uses' => 'DeclaracaoSemNotasController@paginaCadastro']);
        Route::get('/paginaListar', ['as' => 'paginaDeclaracao', 'uses' => 'DeclaracaoSemNotasController@paginaVisualizar']);
        Route::post('/listaDeclaracoes', ['as' => 'manipulaVisualizacaoLista', 'uses' => 'DeclaracaoSemNotasController@manipularVisualizacao']);

        Route::get('/paginaEditar/{it_idDeclaracao}', ['as' => 'paginaEditar', 'uses' => 'DeclaracaoSemNotasController@paginaActualizar']);
        Route::get('/paginaDeclaracao/{it_idDeclaracao}', ['as' => 'paginaDeclaracao', 'uses' => 'DeclaracaoSemNotasController@paginaDeclaracao']);
        Route::get('/lista/{aluno?}/{declaracao?}', ['as' => 'lista', 'uses' => 'DeclaracaoSemNotasController@mostrarLista']);
        // End (páginas do projecto)


        // Begin (acções do projecto)
        Route::post('/cadastrar', ['as' => 'cadastrar', 'uses' => 'DeclaracaoSemNotasController@pegarDadosDecla']);
        Route::post('/actualizar', ['as' => 'actualizar', 'uses' => 'DeclaracaoSemNotasController@actualizar']);
        Route::get('/eliminar/{it_idDeclaracao}', ['as' => 'eliminar', 'uses' => 'DeclaracaoSemNotasController@eliminar'])->middleware('access.controll.administrador');
        Route::get('/paginaErros/{id_erro}', ['as' => 'erro', 'uses' => 'DeclaracaoSemNotasController@paginaErros']);

        // End (acções do projecto)
    });
    //End (rota das declaracções sem notas)



    // Start Cartao do Aluno
    Route::get('/admin/cartaoaluno', ['as' => 'admin.cartaoaluno', 'uses' => 'Admin\CartaoAlunosController@index']);
    Route::post('/admin/cartaoaluno/send/', ['as' => 'admin.cartaoaluno', 'uses' => 'Admin\CartaoAlunosController@recebeAluno']);
    Route::get('/admin/cartaoaluno/emitir/{id}', ['as' => 'admin.cartaoaluno', 'uses' => 'Admin\CartaoAlunosController@emitir']);
    // End Cartao Aluno


    // End Cartao Aluno

    // Start Cartão do funcionário
    // Route::get('/admin/funcionarios', ['as' => 'admin/funcionarios', 'uses' => 'Admin\Funcionario@show'])->middleware('access.controll.administrador');
    // Route::get('/admin/funcionario/cadastrar', ['as' => 'admin/funcionario/cadastrar', 'uses' => 'Admin\Funcionario@create'])->middleware('access.controll.administrador');
    // Route::post('/admin/funcionario/cadastrar', ['as' => 'admin/funcionario/cadastrar', 'uses' => 'Admin\Funcionario@store'])->middleware('access.controll.administrador');
    // Route::get('/admin/funcionarios/listar', ['as' => 'admin.funcionarios.listar', 'uses' => 'Admin\Funcionario@listar'])->middleware('access.controll.administrador');

    // Route::get('/admin/funcionario/editar/{id}', ['as' => 'admin/funcionario/editar', 'uses' => 'Admin\Funcionario@edit'])->middleware('access.controll.administrador');
    // Route::put('/admin/funcionario/editar/{id}', ['as' => 'admin/funcionario/atualizar', 'uses' => 'Admin\Funcionario@update'])->middleware('access.controll.administrador');
    // Route::get('/admin/funcionario/eliminar/{id}', ['as' => 'admin/funcionario/eliminar', 'uses' => 'Admin\Funcionario@destroy'])->middleware('access.controll.administrador');
    // Route::get('/admin/funcionario/gerar/cartao/{id}', ['as' => 'admin/funcionario/gerar/cartao', 'uses' => 'Admin\Funcionario@gerar'])->middleware('access.controll.administrador');
    // Route::get(' admin/funcionarios/listas/imprimir', ['as' => ' admin/funcionarios/listas/imprimir', 'uses' => 'Admin\Funcionario@imprimir'])->middleware('access.controll.administrador');


    Route::get('/admin/funcionarios', ['as' => 'admin/funcionarios', 'uses' => 'Admin\Funcionario@show']);
    Route::get('/admin/funcionario/cadastrar', ['as' => 'admin/funcionario/cadastrar', 'uses' => 'Admin\Funcionario@create']);
    Route::post('/admin/funcionario/cadastrar', ['as' => 'admin/funcionario/cadastrar', 'uses' => 'Admin\Funcionario@store']);
    Route::get('/admin/funcionarios/listar', ['as' => 'admin.funcionarios.listar', 'uses' => 'Admin\Funcionario@listar']);

    Route::get('/admin/funcionario/editar/{id}', ['as' => 'admin/funcionario/editar', 'uses' => 'Admin\Funcionario@edit']);
    Route::put('/admin/funcionario/editar/{id}', ['as' => 'admin/funcionario/atualizar', 'uses' => 'Admin\Funcionario@update']);
    Route::get('/admin/funcionario/eliminar/{id}', ['as' => 'admin/funcionario/eliminar', 'uses' => 'Admin\Funcionario@destroy']);
    Route::get('/admin/funcionario/gerar/cartao/{id}', ['as' => 'admin/funcionario/gerar/cartao', 'uses' => 'Admin\Funcionario@gerar']);
    Route::get(' admin/funcionarios/listas/imprimir', ['as' => ' admin/funcionarios/listas/imprimir', 'uses' => 'Admin\Funcionario@imprimir']);



    // End Cartão do funcionário

    //Start Patrimonios
    Route::get('/admin/patrimonios/visualizar', ['as' => 'admin/patrimonios/visualizar', 'uses' => 'Admin\PatrimoniosController@show']);
    Route::get('/admin/patrimonios/cadastrar', ['as' => 'admin/patrimonios/cadastrar', 'uses' => 'Admin\PatrimoniosController@create']);
    Route::post('/admin/patrimonios/cadastrar', ['as' => 'admin/patrimonios/cadastrar', 'uses' => 'Admin\PatrimoniosController@store']);
    Route::get('/admin/patrimonios/editar/{id}', ['as' => 'admin/patrimonios/editar', 'uses' => 'Admin\PatrimoniosController@edit'])->middleware('access.controll.administrador');
    Route::put('/admin/patrimonios/editar/{id}', ['as' => 'admin/patrimonios/atualizar', 'uses' => 'Admin\PatrimoniosController@update'])->middleware('access.controll.administrador');
    Route::get('/admin/patrimonios/eliminar/{id}', ['as' => 'admin/patrimonios/eliminar', 'uses' => 'Admin\PatrimoniosController@destroy'])->middleware('access.controll.administrador');
    //Lista PDF dos Patrimonios
    Route::get('Admin/pesquisarPatrimonios', ['as' => 'admin.ListaPatrimonio.pesquisarPatrimonios', 'uses' => 'Admin\ListaPatrimonio@pesquisar']);
    Route::post('Admin/recebePatrimonios', ['as' => 'admin.ListaPatrimonio.recebePatrimonios', 'uses' => 'Admin\ListaPatrimonio@recebePatrimonios']);

    Route::get('Admin/listas/patrimonios/{anoLectivo}', ['as' => 'admin.ListaPatrimonio.lista', 'uses' => 'Admin\ListaPatrimonio@index']);
    //Lista PDF dos Patrimonios

    // End Patrimonios

    //disciplinas
    Route::get('/disciplina/ver', ['as' => 'admin.disciplinas.index', 'uses' => 'Admin\DisciplinasController@index']);
    Route::get('/disciplina/singular/{id}/{classe}', ['as' => 'admin.disciplinas.singular', 'uses' => 'Admin\DisciplinasController@singular']);
    Route::get('/disciplina', ['as' => 'admin.disciplinas.cadastrar.index', 'uses' => 'Admin\DisciplinasController@create']);
    Route::post('/disciplina', ['as' => 'admin.disciplinas.cadastrar.index', 'uses' => 'Admin\DisciplinasController@store']);
    Route::get('/disciplina/editar/{id}', ['as' => 'admin.disciplinas.editar.index', 'uses' => 'Admin\DisciplinasController@edit'])->middleware('access.controll.administrador');
    Route::put('/disciplina/editar/{id}', ['as' => 'admin.disciplinas.editar.index', 'uses' => 'Admin\DisciplinasController@update'])->middleware('access.controll.administrador');
    Route::get('/disciplina/deletar/{id}', ['as' => 'admin.eliminarDisciplina', 'uses' => 'Admin\DisciplinasController@delete'])->middleware('access.controll.administrador');
    //disciplinas fim

    //disciplinas relacionadas start
    Route::get('admin/disciplina_curso_classe/', ['as' => 'admin.disciplina_curso_classe', 'uses' => 'Admin\DisciplinaCursoClasse@index']);
    /* Route::get('/disciplina_curso_classe/singular/{id}/{classe}', ['as' => 'admin.disciplina_curso_classes.singular', 'uses' => 'Admin\disciplina_curso_classesController@singular']); */
    Route::get('admin/disciplina_curso_classe/create', ['as' => 'admin.disciplina_curso_classe.create', 'uses' => 'Admin\DisciplinaCursoClasse@create']);
    Route::post('admin/disciplina_curso_classe/store', ['as' => 'admin.disciplina_curso_classe.store', 'uses' => 'Admin\DisciplinaCursoClasse@store']);
    Route::get('admin/disciplina_curso_classe/edit/{id}', ['as' => 'admin.disciplina_curso_classe.edit', 'uses' => 'Admin\DisciplinaCursoClasse@edit'])->middleware('access.controll.administrador');
    Route::put('admin/disciplina_curso_classe/update/{id}', ['as' => 'admin.disciplina_curso_classe.update', 'uses' => 'Admin\DisciplinaCursoClasse@update'])->middleware('access.controll.administrador');
    Route::get('admin/disciplina_curso_classe/destroy/{id}', ['as' => 'admin.disciplina_curso_classe.destroy', 'uses' => 'Admin\DisciplinaCursoClasse@destroy'])->middleware('access.controll.administrador');
    //disciplinas relacionadas fim

    //.............nota.............//

    Route::get('nota/pesquisar', ['as' => 'admin.notas.pesquisar.index', 'uses' => 'Admin\NotaController@pesquisar']);
    Route::post('nota/recebePesquisaNotas', ['as' => 'admin.notas.recebePesquisaNotas', 'uses' => 'Admin\NotaController@recebePesquisaNotas']);
    Route::get('nota/ver/{anoLectivo}/{trimestre}/{classe}/{disciplina}/{turma}', ['as' => 'admin.notas.index', 'uses' => 'Admin\NotaController@index']);

    Route::get('/nota/editar/{id}', ['as' => 'admin.notas.editar.index', 'uses' => 'Admin\NotaController@edit']);
    Route::put('/nota/editar/{id}', ['as' => 'admin.notas.editar.index', 'uses' => 'Admin\NotaController@update']);

    Route::get('/nota/deletar/{id}', ['as' => 'admin.eliminarNota', 'uses' => 'Admin\NotaController@delete']);

    Route::post('/admin/nota/send/', ['as' => 'admin.nota', 'uses' => 'Admin\NotaController@recebeAluno']);
    Route::get('/admin/nota/search/{id}/{anoletivo}', ['as' => 'admin.nota', 'uses' => 'Admin\NotaController@search']);

    Route::get('/nota', ['as' => 'admin.notas.cadastrar.index', 'uses' => 'Admin\NotaController@create']);
    Route::post('/nota', ['as' => 'admin.notas.cadastrar.index', 'uses' => 'Admin\NotaController@store']);
    //.............end-nota.............//


    //Pauta
    Route::get('admin/pauta/pesquisar', ['as' => 'admin.pauta.pesquisar', 'uses' => 'Admin\PautaController@index']);
    Route::post('/admin/pauta/recebepautas', ['as' => 'admin.pauta.recebepautas', 'uses' => 'Admin\PautaController@store']);
    Route::get('/admin/pauta/listas/{anolectivo}/{curso}', ['as' => 'admin.pauta.listas', 'uses' => 'Admin\PautaController@show']);
    Route::get('/admin/pauta/gerar/{id}/{trimestre}', ['as' => 'admin.pauta.gerar', 'uses' => 'Admin\PautaController@create1']);
    Route::get('/admin/pauta_final/gerar/{id}/{tipo}', ['as' => 'admin.pauta_final.gerar', 'uses' => 'Admin\PautaController@creatEnd']);
    Route::get('/admin/pautas/mini/disciplina/{id}/{trimestre}/{id_disciplina}', ['as' => 'admin.pauta.mini.disciplina', 'uses' => 'Admin\PautaController@disciplina']);
    Route::get('/admin/pautas/mini/geral/disciplina/{id}/{trimestre}/{id_disciplina}', ['as' => 'admin.pauta.mini.geral.disciplina', 'uses' => 'Admin\PautaController@disciplina_geral']);

    //End Pauta

    //--------------------Melhores_Alunos------------------//
    Route::get('/aluno/melhor', ['as' => 'admin.melhor', 'uses' => 'Admin\Melhores_AlunosController@search']);
    Route::post('/admin/aluno/send/', ['as' => 'admin.melhor', 'uses' => 'Admin\Melhores_AlunosController@recebeAlunoMelhor']);
    Route::get('/ver/melhor/{classe}/{trimestre}/{anolectivo}/{formato}', ['as' => 'admin.melhor.ver', 'uses' => 'Admin\Melhores_AlunosController@index']);

    //---------------end----------------------------------//


    /* Politicas de aprovação */
    Route::get('admin/politica_de_aprovacao', ['as' => 'admin.politica_de_aprovacao.index', 'uses' => 'Admin\Politica_de_aprovacao@index']);
    Route::get('admin/politica_de_aprovacao/cadastrar', ['as' => 'admin.politica_de_aprovacao.cadastrar', 'uses' => 'Admin\Politica_de_aprovacao@create']);
    Route::post('admin/politica_de_aprovacao/salvar', ['as' => 'admin.politica_de_aprovacao.salvar', 'uses' => 'Admin\Politica_de_aprovacao@store']);
    Route::get('admin/politica_de_aprovacao/excluir/{id}', ['as' => 'admin.politica_de_aprovacao.excluir', 'uses' => 'Admin\Politica_de_aprovacao@destroy'])->middleware('access.controll.administrador');
    Route::get('admin/politica_de_aprovacao/editar/{id}', ['as' => 'admin.politica_de_aprovacao.editar', 'uses' => 'Admin\Politica_de_aprovacao@edit'])->middleware('access.controll.administrador');
    Route::put('admin/politica_de_aprovacao/atualizar/{id}', ['as' => 'admin.politica_de_aprovacao.atualizar', 'uses' => 'Admin\Politica_de_aprovacao@update'])->middleware('access.controll.administrador');

    /* ./politicas de aprovação */

    //logs
    Route::get('admin/logs/pesquisar', ['as' => 'admin.logs.pesquisar.index', 'uses' => 'Admin\LogUserController@pesquisar'])->middleware('access.controll.administrador');
    Route::post('admin/logs/recebelogs', ['as' => 'admin.logs.recebelogs', 'uses' => 'Admin\LogUserController@recebelogs'])->middleware('access.controll.administrador');
    Route::get('admin/logs/visualizar/index/{anoLectivo}/{utilizador}', ['as' => 'admin.logs.listar', 'uses' => 'Admin\LogUserController@index'])->middleware('access.controll.administrador');
    //


    /* nota_dinamica */
    Route::group(['prefix' => 'nota_em_carga'], function () {
        Route::get('/buscar_alunos', ['as' => 'nota_em_carga.buscar_alunos', 'uses' => 'Admin\NotaDinamca@buscar_alunos']);
        Route::post('/mostrar_alunos', ['as' => 'nota_em_carga.mostrar_alunos', 'uses' => 'Admin\NotaDinamca@mostrar_alunos']);
        Route::post('/{it_idCurso}/{it_idClasse}/{t_idTurma}/{id_anoLectivo}/{vc_tipodaNota}/{it_disciplina}/inserir', ['as' => 'nota_em_carga.inserir', 'uses' => 'Admin\NotaDinamca@inserir']);
        Route::get('/buscar_notas', ['as' => 'nota_em_carga.buscar_notas', 'uses' => 'Admin\NotaDinamca@buscar_notas']);
        Route::get('/pesquisar', ['as' => 'nota_em_carga.pesquisar', 'uses' => 'Admin\NotaDinamca@pesquisar']);
        Route::post('nota_em_carga/ver/', ['as' => 'nota_em_carga.ver', 'uses' => 'Admin\NotaDinamca@ver']);
    });
    /* nota_dinamica */

    /* permissao */
    Route::group(['prefix' => 'nota/permissao'], function () {
        Route::get('/editar', ['as' => 'permissao.editar', 'uses' => 'Admin\PermissaoNotaController@editar']);
        Route::put('/actualizar', ['as' => 'permissao.actualizar', 'uses' => 'Admin\PermissaoNotaController@actualizar']);
    });

    //-----------------------FolhaSalarioFuncionario-------------------------------------//
    Route::group(['prefix' => 'FolhaSalarioFuncionario', 'namespace' => 'Admin'], function () {
        Route::group(['prefix' => 'pagina'], function () {

            Route::get('/cadastrar', ['as' => 'verCadastrarFolhaSalarioFuncionario', 'uses' => 'FolhaSalarioFuncionarioController@paginaCadastrar']);
            Route::get('/listar', ['as' => 'listarFolhaSalarioFuncionario', 'uses' => 'FolhaSalarioFuncionarioController@paginaListar']);
            Route::get('/ver/{id}', ['as' => 'verFolhaSalarioFuncionario', 'uses' => 'FolhaSalarioFuncionarioController@paginaVerFolhaSalarioFuncionario']);
            Route::get('/editar/{id}', ['as' => 'verEditarFolhaSalarioFuncionario', 'uses' => 'FolhaSalarioFuncionarioController@paginaEditar']);
        });

        Route::post('/cadastrar', ['as' => 'cadastrarFolhaSalarioFuncionario', 'uses' => 'FolhaSalarioFuncionarioController@cadastrar']);
        Route::post('/editar/{id}', ['as' => 'editarFolhaSalarioFuncionario', 'uses' => 'FolhaSalarioFuncionarioController@editar']);
        Route::get('/eliminar/{id}', ['as' => 'eliminarFolhaSalarioFuncionario', 'uses' => 'FolhaSalarioFuncionarioController@eliminar']);
    });

    //-----------------------FolhaSalarioFuncionarioMensal-------------------------------------//
    Route::group(['prefix' => 'FolhaSalarioFuncionarioMensal', 'namespace' => 'Admin'], function () {
        Route::group(['prefix' => 'pagina'], function () {

            Route::get('/cadastrar', ['as' => 'verCadastrarFolhaSalarioFuncionarioMensal', 'uses' => 'FolhaSalarioFuncionarioMensalController@paginaCadastrar']);
            Route::post('/listar', ['as' => 'listarFolhaSalarioFuncionarioMensal', 'uses' => 'FolhaSalarioFuncionarioMensalController@paginaListar']);
            Route::get('/ver', ['as' => 'verFolhaSalarioFuncionarioMensal', 'uses' => 'FolhaSalarioFuncionarioMensalController@paginaVer']);
            Route::get('/editar/{id}', ['as' => 'verEditarFolhaSalarioFuncionarioMensal', 'uses' => 'FolhaSalarioFuncionarioMensalController@paginaEditar']);
            Route::get('/folha/{mes}/{ano}', ['as' => 'ImprimirFolhaSalarioFuncionario', 'uses' => 'FolhaSalarioFuncionarioMensalController@ImprimirFolha']);
        });

        Route::post('/cadastrar', ['as' => 'cadastrarFolhaSalarioFuncionarioMensal', 'uses' => 'FolhaSalarioFuncionarioMensalController@criarFolhaMensal']);
        Route::post('/editar/{id}', ['as' => 'editarFolhaSalarioFuncionarioMensal', 'uses' => 'FolhaSalarioFuncionarioMensalController@editar']);
        Route::get('/eliminar/{id}', ['as' => 'eliminarFolhaSalarioFuncionarioMensal', 'uses' => 'FolhaSalarioFuncionarioMensalController@eliminar']);
    });

    //-----------------------TotalEntradaGastosRemanescente-------------------------------------//

    Route::get('/tt', ['as' => 'vv', 'uses' => 'Admin\TotalEntradaGastosRemanescenteController@tt']);


    Route::group(['prefix' => 'TotalEntradaGastosRemanescente', 'namespace' => 'Admin'], function () {
        Route::group(['prefix' => 'pagina'], function () {

            Route::get('/cadastrar', ['as' => 'verCadastrarTotalEntradaGastosRemanescente', 'uses' => 'TotalEntradaGastosRemanescenteController@paginaCadastrar']);
            Route::get('/listar', ['as' => 'listarTotalEntradaGastosRemanescente', 'uses' => 'TotalEntradaGastosRemanescenteController@paginaListar']);
            Route::get('/ver/{id}', ['as' => 'verTotalEntradaGastosRemanescente', 'uses' => 'TotalEntradaGastosRemanescenteController@paginaVerTotalEntradaGastosRemanescente']);
            Route::get('/editar/{id}', ['as' => 'verEditarTotalEntradaGastosRemanescente', 'uses' => 'TotalEntradaGastosRemanescenteController@paginaEditar']);
        });

        Route::post('/cadastrar', ['as' => 'cadastrarTotalEntradaGastosRemanescente', 'uses' => 'TotalEntradaGastosRemanescenteController@cadastrar']);
        Route::post('/editar/{id}', ['as' => 'editarTotalEntradaGastosRemanescente', 'uses' => 'TotalEntradaGastosRemanescenteController@editar']);
        Route::get('/eliminar/{id}', ['as' => 'eliminarTotalEntradaGastosRemanescente', 'uses' => 'TotalEntradaGastosRemanescenteController@eliminar']);
    });

    //-----------------------Mes-------------------------------------//

    Route::group(['prefix' => 'Mes', 'namespace' => 'Admin'], function () {
        Route::group(['prefix' => 'pagina'], function () {

            Route::get('/cadastrar', ['as' => 'verCadastrarMes', 'uses' => 'MesController@paginaCadastrar']);
            Route::get('/listar', ['as' => 'listarMes', 'uses' => 'MesController@paginaListar']);
            Route::get('/ver/{id}', ['as' => 'verMes', 'uses' => 'MesController@paginaVerMes']);
            Route::get('/editar/{id}', ['as' => 'verEditarMes', 'uses' => 'MesController@paginaEditar']);
        });

        Route::post('/cadastrar', ['as' => 'cadastrarMes', 'uses' => 'MesController@cadastrar']);
        Route::post('/editar/{id}', ['as' => 'editarMes', 'uses' => 'MesController@editar']);
        Route::get('/eliminar/{id}', ['as' => 'eliminarMes', 'uses' => 'MesController@eliminar']);
    });

    //-----------------------Servicos-------------------------------------//

    Route::group(['prefix' => 'Servico', 'namespace' => 'Admin'], function () {

        Route::group(['prefix' => 'pagina'], function () {
            Route::get('/cadastrar', ['as' => 'verCadastrarServico', 'uses' => 'ServicoController@paginaCadastrar']);
            Route::get('/listar', ['as' => 'listarServico', 'uses' => 'ServicoController@paginaListar']);
            Route::get('/ver/{id}', ['as' => 'verServico', 'uses' => 'ServicoController@paginaVer']);
            Route::get('/editar/{id}', ['as' => 'verEditarServico', 'uses' => 'ServicoController@paginaEditar']);
        });
        Route::post('/cadastrar', ['as' => 'cadastrarServico', 'uses' => 'ServicoController@cadastrar']);
        Route::post('/editar/{id}', ['as' => 'editarServico', 'uses' => 'ServicoController@update']);
        Route::get('/eliminar/{id}', ['as' => 'eliminarServico', 'uses' => 'ServicoController@eliminar']);
    });

    //-----------------------Manutecao Servico-------------------------------------//
    Route::group(['prefix' => 'ManutecaoServico', 'namespace' => 'Admin'], function () {


        Route::group(['prefix' => 'pagina'], function () {
            Route::get('/cadastrar', ['as' => 'verCadastrarManutecaoServico', 'uses' => 'ManutecaoDeServicoController@paginaCadastrar']);
            Route::get('/listar', ['as' => 'listarManutecaoServico', 'uses' => 'ManutecaoDeServicoController@paginaListar']);
            Route::get('/ver/{id}', ['as' => 'verManutecaoServico', 'uses' => 'ManutecaoDeServicoController@paginaVer']);
            Route::get('/editar/{id}', ['as' => 'verEditarManutecaoServico', 'uses' => 'ManutecaoDeServicoController@paginaEditar']);
        });
        Route::post('/cadastrar', ['as' => 'cadastrarManutecaoServico', 'uses' => 'ManutecaoDeServicoController@cadastrar']);
        Route::post('/editar/{id}', ['as' => 'editarManutecaoServico', 'uses' => 'ManutecaoDeServicoController@update']);
        Route::get('/eliminar/{id}', ['as' => 'eliminarManutecaoServico', 'uses' => 'ManutecaoDeServicoController@eliminar']);
    });

    //-----------------------Credito-------------------------------------//
    Route::group(['prefix' => 'Credito', 'namespace' => 'Admin'], function () {


        Route::group(['prefix' => 'pagina'], function () {
            Route::get('/cadastrar', ['as' => 'verCadastrarCredito', 'uses' => 'CreditoController@paginaCadastrar']);
            Route::get('/listar', ['as' => 'listarCredito', 'uses' => 'CreditoController@paginaListar']);
            Route::get('/ver/{id}', ['as' => 'verCredito', 'uses' => 'CreditoController@paginaVer']);
            Route::get('/editar/{id}', ['as' => 'verEditarCredito', 'uses' => 'CreditoController@paginaEditar']);
        });
        Route::post('/cadastrar', ['as' => 'cadastrarCredito', 'uses' => 'CreditoController@cadastrar']);
        Route::post('/editar/{id}', ['as' => 'editarCredito', 'uses' => 'CreditoController@update']);
        Route::get('/eliminar/{id}', ['as' => 'eliminarCredito', 'uses' => 'CreditoController@eliminar']);
    });

    //-----------------------Debito-------------------------------------//
    Route::group(['prefix' => 'Debito', 'namespace' => 'Admin'], function () {


        Route::group(['prefix' => 'pagina'], function () {
            Route::get('/cadastrar', ['as' => 'verCadastrarDebito', 'uses' => 'DebitoController@paginaCadastrar']);
            Route::get('/listar', ['as' => 'listarDebito', 'uses' => 'DebitoController@paginaListar']);
            Route::get('/ver/{id}', ['as' => 'verDebito', 'uses' => 'DebitoController@paginaVer']);
            Route::get('/editar/{id}', ['as' => 'verEditarDebito', 'uses' => 'DebitoController@paginaEditar']);
        });
        Route::post('/cadastrar', ['as' => 'cadastrarDebito', 'uses' => 'DebitoController@cadastrar']);
        Route::post('/editar/{id}', ['as' => 'editarDebito', 'uses' => 'DebitoController@update']);
        Route::get('/eliminar/{id}', ['as' => 'eliminarDebito', 'uses' => 'DebitoController@eliminar']);
    });


    /* end permisssao*/

    //=============Permisssao-selecao-Start=====================f//

    Route::group(['prefix' => 'admin/permissao_selecao'], function () {
        Route::post('/cadastrar', ['as' => 'permissao_selecao.cadastrar', 'uses' => 'Admin\PermissaoDeSelecaoController@cadastrar']);
        Route::get('/criar', ['as' => 'permissao_selecao.criar', 'uses' => 'Admin\PermissaoDeSelecaoController@criar']);
        Route::get('/index/index', ['as' => 'permissao_selecao', 'uses' => 'Admin\PermissaoDeSelecaoController@index']);
        Route::get('/destroy/index/{id}', ['as' => 'permissao_selecao.destroy', 'uses' => 'Admin\PermissaoDeSelecaoController@destroy'])->middleware('access.controll.administrador');
        Route::put('/update/{id}', ['as' => 'permissao_selecao.update', 'uses' => 'Admin\PermissaoDeSelecaoController@update'])->middleware('access.controll.administrador');
        Route::get('/show/index/{id}', ['as' => 'permissao_selecao.show', 'uses' => 'Admin\PermissaoDeSelecaoController@show'])->middleware('access.controll.administrador');
        Route::get('/edit/index/{id}', ['as' => 'permissao_selecao.edit', 'uses' => 'Admin\PermissaoDeSelecaoController@edit'])->middleware('access.controll.administrador');
    });

    //=============Permisssao-selecao-End======================//

    //=============Coodernador-Curso-Start=====================f//

    Route::group(['prefix' => 'coordernadores_cursos/'], function () {
        Route::post('/cadastrar', ['as' => 'coordernadores_cursos.cadastrar', 'uses' => 'Admin\CoordenadorCursoController@cadastrar']);
        Route::get('/criar', ['as' => 'coordernadores_cursos.criar', 'uses' => 'Admin\CoordenadorCursoController@criar']);
        Route::get('', ['as' => 'coordernadores_cursos', 'uses' => 'Admin\CoordenadorCursoController@index']);
        Route::get('/eliminar/{id}', ['as' => 'coordernadores_cursos.eliminar', 'uses' => 'Admin\CoordenadorCursoController@eliminar'])->middleware('access.controll.administrador');
        Route::put('/actualizar/{id}', ['as' => 'coordernadores_cursos.actualizar', 'uses' => 'Admin\CoordenadorCursoController@actualizar'])->middleware('access.controll.administrador');
        Route::get('/editar/{id}', ['as' => 'coordernadores_cursos.editar', 'uses' => 'Admin\CoordenadorCursoController@editar'])->middleware('access.controll.administrador');
        Route::get('/pesquisar_turmas', ['as' => 'coordernadores_cursos.pesquisar_turmas', 'uses' => 'Admin\CoordenadorCursoController@pesquisar_turmas']);
        Route::get('/meus_coordenadores', ['as' => 'coordernadores_cursos.meus_coordenadores', 'uses' => 'Admin\CoordenadorCursoController@meus_coordenadores']);

    });

    //=============Coodernador-Curso-End======================//

    //=============Coodernador-Turno-Start=====================f//
    Route::group(['prefix' => 'coordernadores_turno/'], function () {
        Route::post('/cadastrar', ['as' => 'coordernadores_turno.cadastrar', 'uses' => 'Admin\CoordenadorTurnoController@cadastrar']);
        Route::get('/criar', ['as' => 'coordernadores_turno.criar', 'uses' => 'Admin\CoordenadorTurnoController@criar']);
        Route::get('', ['as' => 'coordernadores_turno', 'uses' => 'Admin\CoordenadorTurnoController@index']);
        Route::get('/eliminar/{id}', ['as' => 'coordernadores_turno.eliminar', 'uses' => 'Admin\CoordenadorTurnoController@eliminar'])->middleware('access.controll.administrador');
        Route::put('/actualizar/{id}', ['as' => 'coordernadores_turno.actualizar', 'uses' => 'Admin\CoordenadorTurnoController@actualizar'])->middleware('access.controll.administrador');
        Route::get('/editar/{id}', ['as' => 'coordernadores_turno.editar', 'uses' => 'Admin\CoordenadorTurnoController@editar'])->middleware('access.controll.administrador');
    });
    //=============Coodernador-Turno-End======================//

    //=============Coodernador-Turno-Start=====================f//
    Route::group(['prefix' => 'professores_turno/'], function () {
        Route::get('/consultar', ['as' => 'professores_turno.consultar', 'uses' => 'Admin\TurnoProfessorController@consultar']);
        Route::post('', ['as' => 'professores_turno', 'uses' => 'Admin\TurnoProfessorController@index']);
    });
    //=============Coodernador-Turno-End======================//
    Route::get('admin/admitidos/listar/{anolectivo}/{curso}/', ['as' => 'admin.candidatos.listar_normal', 'uses' => 'Admin\Candidatos2Controller@listar_normal']);
    Route::get('admin/admitidos/listar/{anolectivo}/{curso}/{tipo_filtro}/{nota_unica}/', ['as' => 'admin.candidatos.listar', 'uses' => 'Admin\Candidatos2Controller@listarAdmitidos']);
    Route::get('admin/admitidos/listar/por_nota/{anolectivo}/{curso}/{tipo_filtro}/{idade_unica}/', ['as' => 'admin.candidatos.listar.por_nota', 'uses' => 'Admin\Candidatos2Controller@listarAdmitidos_por_nota']);
    Route::get('admin/admitidos/listar/por_nota_por_idade/{anolectivo}/{curso}/{tipo_filtro}/{idade_unica}/{nota_unica}/', ['as' => 'admin.candidatos.listar.por_nota_por_idade', 'uses' => 'Admin\Candidatos2Controller@listarAdmitidos_por_nota_por_idade']);
    Route::get('admin/admitidos/listar/por_intervalode_idade/{anolectivo}/{curso}/{tipo_filtro}/{idade1}/{idade2}/', ['as' => 'admin.candidatos.listar.por_intervalode_idade', 'uses' => 'Admin\Candidatos2Controller@por_intervalode_idade']);
    Route::get('admin/admitidos/listar/por_intervalode_idade_nota/{anolectivo}/{curso}/{tipo_filtro}/{idade1}/{idade2}/{nota_unica}', ['as' => 'admin.candidatos.listar.por_intervalode_idade_nota', 'uses' => 'Admin\Candidatos2Controller@por_intervalode_idade_nota']);




    // Route::get('admin/admitidos/listar/{anolectivo}/{curso}/', ['as' => 'admin.candidatos.listar_normal', 'uses' => 'Admin\Candidatos2Controller@listar_normal'])->middleware('access.controll.administrador');
    // Route::get('admin/admitidos/listar/{anolectivo}/{curso}/{tipo_filtro}/{nota_unica}/', ['as' => 'admin.candidatos.listar', 'uses' => 'Admin\Candidatos2Controller@listarAdmitidos'])->middleware('access.controll.administrador');
    // Route::get('admin/admitidos/listar/por_nota/{anolectivo}/{curso}/{tipo_filtro}/{idade_unica}/', ['as' => 'admin.candidatos.listar.por_nota', 'uses' => 'Admin\Candidatos2Controller@listarAdmitidos_por_nota'])->middleware('access.controll.administrador');
    // Route::get('admin/admitidos/listar/por_nota_por_idade/{anolectivo}/{curso}/{tipo_filtro}/{idade_unica}/{nota_unica}/', ['as' => 'admin.candidatos.listar.por_nota_por_idade', 'uses' => 'Admin\Candidatos2Controller@listarAdmitidos_por_nota_por_idade'])->middleware('access.controll.administrador');
    // Route::get('admin/admitidos/listar/por_intervalode_idade/{anolectivo}/{curso}/{tipo_filtro}/{idade1}/{idade2}/', ['as' => 'admin.candidatos.listar.por_intervalode_idade', 'uses' => 'Admin\Candidatos2Controller@por_intervalode_idade'])->middleware('access.controll.administrador');
    // Route::get('admin/admitidos/listar/por_intervalode_idade_nota/{anolectivo}/{curso}/{tipo_filtro}/{idade1}/{idade2}/{nota_unica}', ['as' => 'admin.candidatos.listar.por_intervalode_idade_nota', 'uses' => 'Admin\Candidatos2Controller@por_intervalode_idade_nota'])->middleware('access.controll.administrador')->middleware('access.controll.administrador');

    Route::get('admin/selecionados/{id}/transferir', ['as' => 'admin.selecionados.transferir', 'uses' => 'Admin\Candidatos2Controller@transferir']);
    Route::get('Admin/pesquisar_selecionados', ['as' => 'admin.ListadSelecionado.pesquisar_selecionados', 'uses' => 'Admin\Candidatos2Controller@pesquisar_admitidos_pdf']);
    Route::post('admin/selecionados/recebe_selecionados', ['as' => 'admin.selecionados.recebe_selecionados', 'uses' => 'Admin\Candidatos2Controller@recebe_selecionados']);
    Route::get('admin/selecionados/pesquisar', ['as' => 'admin.selecionados.pesquisar', 'uses' => 'Admin\Candidatos2Controller@pesquisar']);
    Route::post('Admin/recebe_selecionados_pdf', ['as' => 'admin.lista_elecionado.recebe_selecionados_pdf', 'uses' => 'Admin\Candidatos2Controller@recebe_selecionados_pdf']);
    Route::get('Admin/lista/selecionados_pdf/{anoLectivo}/{curso}', ['as' => 'admin.lista_elecionado.lista', 'uses' => 'Admin\Candidatos2Controller@index']);
    Route::get('admin/selecionados/eliminar/{id}', 'Admin\Candidatos2Controller@delete')->name('selecionado.delete');
    Route::post('admin/selecionados/recebe_selecionados2', ['as' => 'admin.selecionados.recebe_selecionados2', 'uses' => 'Admin\Candidatos2Controller@recebe_selecionados2']);

    Route::get('admin/selecionados/editar/{id}', 'Admin\Candidatos2Controller@edit')->name('selecionado.edit');
    Route::put('admin/selecionados/editar/{id}', 'Admin\Candidatos2Controller@update')->name('selecionado.update');

    Route::get('admin/candidatos/selecionar', ['as' => 'admin.candidatos.selecionar', 'uses' => 'Admin\Candidatos2Controller@selecionar']);
    Route::post('admin/candidatos_selecionar/cadastrar', ['as' => 'admin.candidatos_selecionar.cadastrar', 'uses' => 'Admin\Candidatos2Controller@cadastrar']);
    Route::post('admin/candidatos/recebeBI', ['as' => 'admin.candidatos.recebeBI', 'uses' => 'Admin\Candidatos2Controller@recebeBI']);
    Route::get('admin/candidatos/trazerCandidato/{BI}', ['as' => 'admin.candidatos.trazerCandidato', 'uses' => 'Admin\Candidatos2Controller@trazerCandidato']);

    Route::get('admin/candidatos/editar_selecao', ['as' => 'admin.candidatos.editar_selecao', 'uses' => 'Admin\Candidatos2Controller@editar_selecao']);

    Route::post('admin/users/editar/nivel/{id}/{nivel}/', ['as' => 'admin.users.editar_nivel', 'uses' => 'Admin\UserController@editar_nivel'])->middleware('access.controll.administrador');

    Route::get('admin/candidatos/trazerCandidato/{BI}', ['as' => 'admin.candidatos.trazerCandidato', 'uses' => 'Admin\Candidatos2Controller@trazerCandidato']);


    Route::get('Admin/pesquisar_alunos', ['as' => 'admin.RelatorioAluno.pesquisar_alunos', 'uses' => 'Admin\relatorios\RelatorioAluno@pesquisar']);
    Route::post('Admin/recebe_alunos', ['as' => 'admin.RelatorioAluno.recebe_alunos', 'uses' => 'Admin\relatorios\RelatorioAluno@recebeRec']);
    Route::get('Admin/lista/alunos/{anoLectivo}/{curso}', ['as' => 'admin.RelatorioAluno.lista', 'uses' => 'Admin\relatorios\RelatorioAluno@index']);
    Route::get('Admin/lista/selecionados/{anoLectivo}/{curso}', ['as' => 'admin.ListadSelecionado.lista', 'uses' => 'Admin\relatorios\RelatorioAluno@index']);
    Route::get('Admin/lista/aluno/Rec/{anoLectivo}', ['as' => 'admin.RelatorioAluno.listaRec', 'uses' => 'Admin\relatorios\RelatorioAluno@lista']);
    Route::get('Admin/relatorio/aluno/diario/buscar/{ano_lectivo}/{data_inicio}/{data_final}/', ['as' => 'admin.relatorio_diario_aluno_buscar', 'uses' => 'Admin\relatorios\RelatorioAluno@buscar_diario']);

    Route::get('admin/admitidos/filtro', ['as' => 'admin.selecionados.filtro', 'uses' => 'Admin\Candidatos2Controller@filtro']);
    Route::post('admin/admitidos/filtro_admitidos', ['as' => 'admin.selecionados.filtro_admitidos', 'uses' => 'Admin\Candidatos2Controller@filtro_admitidos']);

    //Lista PDF dos Selecionados


});
