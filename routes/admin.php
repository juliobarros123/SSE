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

Route::get('alunos_por_classes/', ['as' => 'admin.alunos_por_classes', 'uses' => 'Ajax\EstatisticaController@alunos_por_classes']);
Route::get('alunos_por_turmas/', ['as' => 'admin.alunos_por_turmas', 'uses' => 'Ajax\EstatisticaController@alunos_por_turmas']);
Route::get('candidatos_por_ano_lectivo/', ['as' => 'admin.candidatos_por_ano_lectivo', 'uses' => 'Ajax\EstatisticaController@candidatos_por_ano_lectivo']);
Route::get('alunos_por_cursos/', ['as' => 'admin.alunos_por_cursos', 'uses' => 'Ajax\EstatisticaController@alunos_por_cursos']);

Route::get('admin/cidadao/{bi}', ['as' => 'admin.cidadao', 'uses' => 'Admin\AlunnoController@cidadao']);
Route::get('/', ['as' => 'raiz', 'uses' => 'Admin\HomeController@raiz']);
Route::get('/home', ['as' => 'home', 'uses' => 'Admin\HomeController@raiz']);
Route::get('/caderneta/{id}', ['as' => 'caderneta', 'uses' => 'Admin\BoletimTurmaController@dados']);

Route::get('/{id}/{trimestre}/gerarBoletimTurma/xlsx', ['as' => 'turmas.boletimTurmwas.xlsx', 'uses' => 'Admin\BoletimTurmaController@ver']);

Route::get('notas-finais/aluno-processos/{processo}/{estudando}', ['as' => 'aluno-processoS', 'uses' => 'Admin\NotaSecaController@alunoProcesso']);
Route::get('notas-finais/vrf_disciplina_terminal/{id_disciplina}/{id_turma}/{estado}/{processo}/{classe}', ['as' => 'vrf_disciplina_terminal', 'uses' => 'Admin\NotaSecaController@vrf_disciplina_terminal']);

Route::get('classes_por_curso/{curso}', ['as' => 'classes_por_curso', 'uses' => 'Admin\CandidaturaController@classes_por_curso']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('candidatura', ['as' => 'site.candidatura', 'uses' => 'Admin\CandidaturaController@create']);
    Route::post('candidatura/', ['as' => 'site.candidatura', 'uses' => 'Admin\CandidaturaController@store']);

});
Route::middleware(['auth:sanctum', 'restrictCandidatoAccess'])->group(function () {
    Route::post('uploadToGPEU', ['as' => 'admin.uploadToGPEU', 'uses' => 'Admin\GPEUController@uploadToGPEU']);
    // Route::get('/admitido', ['as' => 'admitido', 'uses' => 'Admin\ConfirmacaoController@confirmar'])->middleware('access.controll.pedagogia');

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
    /* start nota seca */
    Route::group(['prefix' => 'notas-finais'], function () {

        Route::get('/inserir/{id_turma}', ['as' => 'notas-finais.inserir', 'uses' => 'Admin\NotaSecaController@inserir']);
        Route::post('/cadastrar/{slug_turma}', ['as' => 'notas-finais.cadastrar', 'uses' => 'Admin\NotaSecaController@cadastrar']);
        Route::post('/{it_idCurso}/{it_idClasse}/{t_idTurma}/{id_anoLectivo}/{vc_tipodaNota}/{it_disciplina}/inserir', ['as' => 'nota_em_carga_diplomado.inserir', 'uses' => 'Admin\NotaDinamicaDiplomadoController@inserir']);
        Route::get('/buscar_notas', ['as' => 'nota_em_carga_diplomado.buscar_notas', 'uses' => 'Admin\NotaDinamicaDiplomadoController@buscar_notas']);
        Route::get('/pesquisar', ['as' => 'nota_em_carga_diplomado.pesquisar', 'uses' => 'Admin\NotaDinamicaDiplomadoController@pesquisar']);
        Route::post('nota_em_carga_diplomado/ver/', ['as' => 'nota_em_carga_diplomado.ver', 'uses' => 'Admin\NotaDinamicaDiplomadoController@ver']);
    });
    /* end nota seca */

    Route::get('notas-recurso/aluno-processos/{processo}', ['as' => 'aluno-processoS', 'uses' => 'Admin\NotaRecursoController@alunoProcesso']);
    Route::group(['prefix' => 'notas-recurso'], function () {
        Route::get('inserir', ['as' => 'admin.notas-recurso.inserir', 'uses' => 'Admin\NotaRecursoController@inserir']);
        Route::post('/cadastrar', ['as' => 'admin.notas-recurso.cadastrar', 'uses' => 'Admin\NotaRecursoController@cadastrar']);
        Route::get('{slug}/eliminar', ['as' => 'admin.notas-recurso.eliminar', 'uses' => 'Admin\NotaRecursoController@eliminar']);
        Route::get('', ['as' => 'admin.notas-recurso.index', 'uses' => 'Admin\NotaRecursoController@index']);
    });

    /* start nota seca */
    Route::group(['prefix' => 'permissoes/nota/professor'], function () {
        Route::get('/', ['as' => 'permissoes.nota.professor.index', 'uses' => 'Admin\PermissaoProfessorNotaController@index']);
        Route::get('/permitir', ['as' => 'permissoes.nota.professor.permitir', 'uses' => 'Admin\PermissaoProfessorNotaController@permitir']);
        Route::get('/eliminar/{id}', ['as' => 'permissoes.nota.professor.eliminar', 'uses' => 'Admin\PermissaoProfessorNotaController@eliminar']);
        Route::post('/cadastrar', ['as' => 'permissoes.nota.professor.cadastrar', 'uses' => 'Admin\PermissaoProfessorNotaController@cadastrar']);
        Route::post('/{it_idCurso}/{it_idClasse}/{t_idTurma}/{id_anoLectivo}/{vc_tipodaNota}/{it_disciplina}/inserir', ['as' => 'nota_em_carga_diplomado.inserir', 'uses' => 'Admin\NotaDinamicaDiplomadoController@inserir']);
        Route::get('/buscar_notas', ['as' => 'nota_em_carga_diplomado.buscar_notas', 'uses' => 'Admin\NotaDinamicaDiplomadoController@buscar_notas']);
        Route::get('/pesquisar', ['as' => 'nota_em_carga_diplomado.pesquisar', 'uses' => 'Admin\NotaDinamicaDiplomadoController@pesquisar']);
        Route::post('nota_em_carga_diplomado/ver/', ['as' => 'nota_em_carga_diplomado.ver', 'uses' => 'Admin\NotaDinamicaDiplomadoController@ver']);
    });
    /* end nota seca */
    /* start ano validade cartão */
    Route::group(['prefix' => 'anos-validade-cartao'], function () {
        Route::get('criar', ['as' => 'anos-validade-cartao.criar', 'uses' => 'Admin\AnoValidadeCartaoController@criar']);
        Route::get('', ['as' => 'anos-validade-cartao', 'uses' => 'Admin\AnoValidadeCartaoController@index']);
        Route::post('cadastrar', ['as' => 'anos-validade-cartao.cadastrar', 'uses' => 'Admin\AnoValidadeCartaoController@cadastrar']);
        // Route::get('/{id}/editar', ['as' => 'anos-validade-cartao', 'uses' => 'Admin\AnoValidadeCartaoController@index']);
        Route::get('/{id}/eliminar', ['as' => 'anos-validade-cartao.eliminar', 'uses' => 'Admin\AnoValidadeCartaoController@eliminar']);
    });
    /* end ano validade cartão */



    //Routas das notas dos  Diplomados
    Route::get('nota-diplomados/cadastrar/{id}', ['as' => 'admin.nota-diplomados.cadastrar', 'uses' => 'Admin\NotaDiplomadoController@cadastrar'])->middleware('access.controll.administrador');


    Route::post('nota-diplomados/store', ['as' => 'admin.nota-diplomados.store', 'uses' => 'Admin\NotaDiplomadoController@store'])->middleware('access.controll.administrador');
    Route::get('nota-diplomados/editar/{id}', ['as' => 'admin.nota-diplomados.editar', 'uses' => 'Admin\NotaDiplomadoController@editar'])->middleware('access.controll.administrador');
    Route::get('diplomados/visualizar/{id}', ['as' => 'admin.diplomados.visualizar', 'uses' => 'Admin\DiplomadosController@visualizar'])->middleware('access.controll.administrador');

    //Routas dos  Diplomados

    Route::get('transferir-diplomado-aluno/{processo}', ['as' => 'admin.transferirDiplomadoAluno', 'uses' => 'Admin\DiplomadosController@transferirDiplomadoAluno'])->middleware('access.controll.administrador');

    Route::get('diplomado-aluno', ['as' => 'admin.diplomadoParaAluno', 'uses' => 'Admin\DiplomadosController@diplomadoParaAluno'])->middleware('access.controll.administrador');
    Route::get('diplomados/listar', ['as' => 'admin.diplomados.listar', 'uses' => 'Admin\DiplomadosController@listar'])->middleware('access.controll.administrador');
    Route::get('diplomados/cadastrar', ['as' => 'admin.diplomados.cadastrar', 'uses' => 'Admin\DiplomadosController@cadastrar'])->middleware('access.controll.administrador');
    Route::post('diplomados/store', ['as' => 'admin.diplomados.store', 'uses' => 'Admin\DiplomadosController@store'])->middleware('access.controll.administrador');
    Route::get('diplomados/editar/{id}', ['as' => 'admin.diplomados.editar', 'uses' => 'Admin\DiplomadosController@editar'])->middleware('access.controll.administrador');
    Route::post('diplomados/update/{id}', ['as' => 'admin.diplomados.update', 'uses' => 'Admin\DiplomadosController@update'])->middleware('access.controll.administrador');
    Route::get('diplomados/excluir/{id}', ['as' => 'admin.diplomados.excluir', 'uses' => 'Admin\DiplomadosController@excluir'])->middleware('access.controll.administrador');
    Route::get('admin/diplomados/listas/imprimir', ['as' => 'admin.diplomados.imprimir', 'uses' => 'Admin\DiplomadosController@imprimir'])->middleware('access.controll.administrador');

    //Adnmitido
    Route::get('diplomados/actualizar', ['as' => 'admin.diplomados.actualizar', 'uses' => 'Admin\DiplomadosController@actualizar'])->middleware('access.controll.administrador');

    Route::group(['prefix' => 'disciplina-terminal'], function () {
        Route::get('/criar', ['as' => 'admin.disciplinaTerminal.criar.get', 'uses' => 'Admin\DisciplinaTerminalController@getViewDisciplinaTerminal']);
        Route::post('/criar', ['as' => 'admin.disciplinaTerminal.criar.post', 'uses' => 'Admin\DisciplinaTerminalController@setDisciplinaTerminal']);
        Route::get('/editar/{id}', ['as' => 'admin.disciplinaTerminal.editar.get', 'uses' => 'Admin\DisciplinaTerminalController@getEditDisciplinaTerminal']);
        Route::put('/editar/{id}', ['as' => 'admin.disciplinaTerminal.editar.put', 'uses' => 'Admin\DisciplinaTerminalController@setEditDisciplinaTerminal']);
        Route::get('/purgar/{id}', ['as' => 'admin.disciplinaTerminal.delete.get', 'uses' => 'Admin\DisciplinaTerminalController@setDeleteDisciplinaTerminal']);
        Route::get('/eliminar/{id}', ['as' => 'admin.disciplinaTerminal.destroy.get', 'uses' => 'Admin\DisciplinaTerminalController@setDestroyDisciplinaTerminal']);
        Route::get('/listar', ['as' => 'admin.disciplinaTerminal.list.get', 'uses' => 'Admin\DisciplinaTerminalController@getListDisciplinaTerminal']);
    });

    //novas rotas pautas finais
    Route::group(['prefix' => 'pauta-final'], function () {
        Route::get('/turma/{slug_turma}/{formato}', ['as' => 'admin.pautaFinal.gerar', 'uses' => 'Admin\PautaFinalController@gerar']);

        //     Route::post('/listar', ['as' => 'admin.pautaFinal.listar.get', 'uses' => 'Admin\PautaFinalController@getListPautaFinal']);
        //     Route::get('/listar/{anoLectivo}/{Curso}/{classe}', ['as' => 'admin.pautaFinal.Listas.get', 'uses' => 'Admin\PautaFinalController@getListasPautaFinal']);

        //     Route::get('/visualizar/{turma}', ['as' => 'admin.pautaFinal.visualizar.get', 'uses' => 'Admin\PautaFinalController@getViewPautaFinal']);
    });
    // Route::group(['prefix' => 'pauta-final'], function () {
    //     Route::get('/gerar', ['as' => 'admin.pautaFinal.gerar.get', 'uses' => 'Admin\PautaFinalController@getGeneratePautaFinal']);
    //     Route::post('/listar', ['as' => 'admin.pautaFinal.listar.get', 'uses' => 'Admin\PautaFinalController@getListPautaFinal']);
    //     Route::get('/listar/{anoLectivo}/{Curso}/{classe}', ['as' => 'admin.pautaFinal.Listas.get', 'uses' => 'Admin\PautaFinalController@getListasPautaFinal']);

    //     Route::get('/visualizar/{turma}', ['as' => 'admin.pautaFinal.visualizar.get', 'uses' => 'Admin\PautaFinalController@getViewPautaFinal']);
    // });
    //end novas rotas pautas finais

    //Início search Escola
    Route::get('buscar/escolas', ['as' => 'buscar.escolas.searchSchool', 'uses' => 'Admin\DynamicSearch@searchSchool']);
    //FIM search Escola
    //Início search Processo
    Route::get('buscar/processos', ['as' => 'buscar.processo.searchProcess', 'uses' => 'Admin\DynamicSearch@searchProcess']);
    //FIM search Processo

    //Início search Classe
    Route::get('buscar/classes', ['as' => 'buscar.classes.searchGrade', 'uses' => 'Admin\DynamicSearch@searchGrade']);
    //FIM search Classe

    //Início search provincias
    Route::get('buscar/provincias', ['as' => 'buscar.provincias.searchProvince', 'uses' => 'Admin\DynamicSearch@searchProvince']);
    //FIM search provincias



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
    Route::get('admin/actualizar_municipio', ['as' => 'admin.actualizar_municipio', 'uses' => 'Admin\ConfirmacaoController@actualizar_municipio']);

    //Route::get('admin/candidatos-api/listar', ['as' => 'admin.candidatos-api.listarr', 'uses' => 'Admin\InscricaoOnlineController@listar'])->middleware('access.controll.administrador');



    //====================End Candidatos API =========================



    //=============User-Start=====================//
    Route::get('admin/users/listar', ['as' => 'admin.users', 'uses' => 'Admin\UserController@index'])->middleware('access.controll.administrador');
    Route::get('admin/users/listar/imprimir', ['as' => 'admin.users.listar.imprimir', 'uses' => 'Admin\UserController@imprimir_lista'])->middleware('access.controll.administrador');
    Route::post('admin/users/salvar', ['as' => 'admin.users.salvar', 'uses' => 'Admin\UserController@salvar'])->middleware('access.controll.administrador');
    Route::get('admin/users/cadastrar', ['as' => 'admin.users.cadastrar', 'uses' => 'Admin\UserController@create'])->middleware('access.controll.administrador');
    Route::get('admin/users/excluir/{slug}', ['as' => 'admin.users.excluir', 'uses' => 'Admin\UserController@excluir'])->middleware('access.controll.administrador');
    Route::put('admin/users/atualizar/{slug}', ['as' => 'admin.users.atualizar', 'uses' => 'Admin\UserController@atualizar']);
    Route::get('admin/users/ver/{slug}', ['as' => 'users', 'uses' => 'Admin\UserController@ver'])->middleware('access.controll.administrador');
    Route::get('admin/users/editar/{slug}', ['as' => 'admin.users.editar', 'uses' => 'Admin\UserController@editar']);

    Route::get('admin/user/editar/{id}', ['as' => 'admin.user.editar', 'uses' => 'Admin\UserController@editarPessoal']);
    Route::put('admin/user/atualizar/{id}', ['as' => 'admin.user.atualizar', 'uses' => 'Admin\UserController@atualizarPessoal']);


    Route::get('admin/users/eliminadas', ['as' => 'admin.users.eliminadas', 'uses' => 'Admin\UserController@eliminadas'])->middleware('access.controll.administrador');
    Route::get('admin/users/purgar/{id}', ['as' => 'admin.users.purgar', 'uses' => 'Admin\UserController@purgar'])->middleware('access.controll.administrador');
    Route::get('admin/users/recuperar/{id}', ['as' => 'admin.users.recuperar', 'uses' => 'Admin\UserController@recuperar'])->middleware('access.controll.administrador');

    //=============User-End======================//




    //=============Turma-User-Start=====================//

    Route::get('Admin/pesquisarAtribuidos', ['as' => 'admin.pesquisarAtribuidos', 'uses' => 'Admin\TurmaUserController@pesquisar']);
    Route::get('turmas/listar/{id}', ['as' => 'user.turma', 'uses' => 'admin\ProfessorController@listarTurmas']);

    Route::any('admin/atribuicoes/listar', ['as' => 'admin.atribuicoes', 'uses' => 'Admin\TurmaUserController@index']);
    Route::post('admin/atribuicoes/salvar', ['as' => 'admin.atribuicoes.salvar', 'uses' => 'Admin\TurmaUserController@salvar']);
    Route::get('admin/atribuicoes/cadastrar', ['as' => 'admin.atribuicoes.cadastrar', 'uses' => 'Admin\TurmaUserController@cadastrar']);
    Route::get('admin/atribuicoes/excluir/{id}', ['as' => 'admin.atribuicoes.excluir', 'uses' => 'Admin\TurmaUserController@excluir'])->middleware('access.controll.administrador');
    Route::put('admin/atribuicoes/atualizar/{slug}', ['as' => 'admin.atribuicoes.atualizar', 'uses' => 'Admin\TurmaUserController@atualizar'])->middleware('access.controll.administrador');
    Route::get('admin/atribuicoes/ver/{slug}', ['as' => 'admin.atribuicoes.ver', 'uses' => 'Admin\TurmaUserController@ver']);
    Route::get('admin/atribuicoes/editar/{slug}', ['as' => 'admin.atribuicoes.editar', 'uses' => 'Admin\TurmaUserController@editar'])->middleware('access.controll.administrador');

    Route::get('admin/atribuicoes/professores/{slug}', ['as' => 'admin.atribuicao.professores', 'uses' => 'Admin\TurmaUserController@professores']);
    Route::get('admin/atribuicoes/pesquisar', ['as' => 'admin.atribuicoes.pesquisar', 'uses' => 'Admin\TurmaUserController@pesquisar']);

    //=============Turma-User-End======================//

    //=============Curso-Start=====================//
    Route::get('Admin/cursos/index/index', ['as' => 'cursos', 'uses' => 'Admin\CursoController@index']);
    Route::post('Admin/cursos/store', ['as' => 'cursos.store', 'uses' => 'Admin\CursoController@store']);
    Route::get('Admin/cursos/create/index', ['as' => 'cursos.create', 'uses' => 'Admin\CursoController@create']);
    Route::get('Admin/cursos/destroy/{slug}', ['as' => 'cursos.destroy', 'uses' => 'Admin\CursoController@destroy'])->middleware('access.controll.administrador');
    Route::put('Admin/cursos/update/{slug}', ['as' => 'cursos.update', 'uses' => 'Admin\CursoController@update'])->middleware('access.controll.administrador');
    Route::get('Admin/cursos/show/index/{slug}', ['as' => 'cursos.show', 'uses' => 'Admin\CursoController@show'])->middleware('access.controll.administrador');
    Route::get('Admin/cursos/edit/index/{slug}', ['as' => 'cursos.edit', 'uses' => 'Admin\CursoController@edit'])->middleware('access.controll.administrador');

    //=============Curso-End======================//

    //=============Processo-Start=====================//
    Route::get('Admin/processos/index/index', ['as' => 'processos', 'uses' => 'Admin\ProcessoController@index']);
    Route::post('Admin/processos/store', ['as' => 'processos.store', 'uses' => 'Admin\ProcessoController@store']);
    Route::get('Admin/processos/create/index', ['as' => 'processos.create', 'uses' => 'Admin\ProcessoController@create']);

    Route::put('Admin/processos/update/{slug}', ['as' => 'processos.update', 'uses' => 'Admin\ProcessoController@update'])->middleware('access.controll.administrador');

    Route::get('Admin/processos/edit/index/{slug}', ['as' => 'processos.edit', 'uses' => 'Admin\ProcessoController@edit'])->middleware('access.controll.administrador');
    //=============Processo-End======================//


    //=============Matricula-Start=====================//
    Route::get('Admin/matriculas/pesquisar', ['as' => 'admin.matriculas.pesquisar', 'uses' => 'Admin\MatriculaController@pesquisar']);
    Route::any('Admin/matriculados', ['as' => 'admin.matriculados', 'uses' => 'Admin\MatriculaController@matriculados']);

    Route::get('Admin/matriculas/listar/{anoLectivo}/{curso}/{vc_classe}', ['as' => 'admin.matriculas', 'uses' => 'Admin\MatriculaController@index']);
    Route::post('Admin/matriculas/salvar', ['as' => 'admin.matriculas.salvar', 'uses' => 'Admin\MatriculaController@salvar']);
    Route::get('Admin/matriculas/cadastrar', ['as' => 'admin.matriculas.cadastrar', 'uses' => 'Admin\MatriculaController@cadastrar']);
    Route::get('Admin/matriculas/excluir/{slug}', ['as' => 'admin.matriculas.excluir', 'uses' => 'Admin\MatriculaController@excluir'])->middleware('access.controll.administrador');
    Route::put('Admin/matriculas/atualizar/{slug}', ['as' => 'admin.matriculas.atualizar', 'uses' => 'Admin\MatriculaController@atualizar']);
    Route::get('Admin/matriculas/ver/{id}', ['as' => 'matriculas', 'uses' => 'Admin\MatriculaController@ver']);
    Route::get('Admin/matriculas/editar/{slug}', ['as' => 'admin.matriculas.editar', 'uses' => 'Admin\MatriculaController@editar']);

    Route::get('admin/matriculas/pesquisar_pdf', ['as' => 'admin.matriculas.pesquisar_pdf', 'uses' => 'Admin\MatriculaController@pesquisar_pdf']);
    Route::any('Admin/matriculados/lista_pdf', ['as' => 'admin.matriculas.lista_pdf', 'uses' => 'Admin\MatriculaController@lista_pdf']);
    //-------Gerar boletim------//
    Route::get('/admin/matriculas/pesquisar', ['as' => 'admin.matriculas.pesquisar', 'uses' => 'Admin\MatriculaController@pesquisaraluno']);
    Route::post('/admin/matriculas/send/', ['as' => 'admin.matriculas.send', 'uses' => 'Admin\MatriculaController@recebeAluno']);
    Route::get('/admin/matriculas/emitirboletim/{id}', ['as' => 'admin.matriculas.emitirboletim', 'uses' => 'Admin\MatriculaController@emitirboletim']);
    Route::get('admin/matriculas/ficha/{slug}', ['as' => 'admin.matriculas.ficha', 'uses' => 'Admin\MatriculaController@imprimirFicha']);

    //=============Matricula-End======================//


    // Start Classe
    Route::get('/admin/classes', ['as' => 'admin/classes', 'uses' => 'Admin\ClasseController@index']);
    Route::get('/admin/classes/cadastrar', ['as' => 'admin/classes/cadastrar/post', 'uses' => 'Admin\ClasseController@create']);
    Route::post('/admin/classes/cadastrar', ['as' => 'admin/classes/cadastrar', 'uses' => 'Admin\ClasseController@store']);
    Route::get('/admin/aditar/{slug}', ['as' => 'admin/classes/editar', 'uses' => 'Admin\ClasseController@edit'])->middleware('access.controll.administrador');
    Route::put('/admin/editar/{slug}', ['as' => 'admin/classes/atualizar', 'uses' => 'Admin\ClasseController@update'])->middleware('access.controll.administrador');
    Route::get('/admin/eliminar/{slug}', ['as' => 'admin/classes/eliminar', 'uses' => 'Admin\ClasseController@eliminar'])->middleware('access.controll.administrador');


    // End Classe

    // Start Ano Lectivo
    Route::get('/admin/anolectivo', ['as' => 'admin/anolectivo', 'uses' => 'Admin\AnoLectivoController@index']);
    Route::get('/admin/anolectivo/cadastrar', ['as' => 'admin/anolectivo/cadastrar', 'uses' => 'Admin\AnoLectivoController@create']);
    Route::post('/admin/anolectivo/cadastrar', ['as' => 'admin/anolectivo/cadastrar', 'uses' => 'Admin\AnoLectivoController@store']);

    Route::get('/admin/anolectivo/aditar/{slug}', ['as' => 'admin/anolectivo/editar', 'uses' => 'Admin\AnoLectivoController@edit'])->middleware('access.controll.administrador');
    Route::put('/admin/anolectivo/editar/{slug}', ['as' => 'admin/anolectivo/atualizar', 'uses' => 'Admin\AnoLectivoController@update'])->middleware('access.controll.administrador');
    Route::get('/admin/anolectivo/eliminar/{slug}', ['as' => 'admin/anolectivo/eliminar', 'uses' => 'Admin\AnoLectivoController@destroy'])->middleware('access.controll.administrador');


    // Route::get('admin/anolectivo/purgar/{slug}', ['as' => 'admin.anolectivo.purgar', 'uses' => 'Admin\AnoLectivoController@purgar'])->middleware('access.controll.administrador');

    // End Ano Lectivo


    // Start Província
    Route::get('/admin/provincia', ['as' => 'admin.provincia', 'uses' => 'Admin\ProvinciaController@index']);
    Route::get('/admin/provincia/cadastrar', ['as' => 'admin.provincia.cadastrar', 'uses' => 'Admin\ProvinciaController@create']);
    Route::post('/admin/provincia/cadastrar', ['as' => 'admin.provincia.cadastrar', 'uses' => 'Admin\ProvinciaController@store']);
    Route::get('/admin/provincia/visualizar/{id}', ['as' => 'admin.provincia.visualizar', 'uses' => 'Admin\ProvinciaController@show']);
    Route::get('/admin/provincia/aditar/{id}', ['as' => 'admin.provincia.editar', 'uses' => 'Admin\ProvinciaController@edit'])->middleware('access.controll.administrador');
    Route::put('/admin/provincia/editar/{id}', ['as' => 'admin.provincia.atualizar', 'uses' => 'Admin\ProvinciaController@update'])->middleware('access.controll.administrador');
    Route::get('/admin/provincia/eliminar/{id}', ['as' => 'admin.provincia.eliminar', 'uses' => 'Admin\ProvinciaController@destroy'])->middleware('access.controll.administrador');

    Route::get('admin/provincia/eliminadas', ['as' => 'admin.provincia.eliminadas', 'uses' => 'Admin\ProvinciaController@eliminadas'])->middleware('access.controll.administrador');
    Route::get('admin/provincia/purgar/{id}', ['as' => 'admin.provincia.purgar', 'uses' => 'Admin\ProvinciaController@purgar'])->middleware('access.controll.administrador');
    Route::get('admin/provincia/recuperar/{id}', ['as' => 'admin.provincia.recuperar', 'uses' => 'Admin\ProvinciaController@recuperar'])->middleware('access.controll.administrador');
    // End Província

    // Start Município
    Route::get('/admin/municipio', ['as' => 'admin.municipio', 'uses' => 'Admin\MunicipioController@index']);
    Route::get('/admin/municipio/cadastrar', ['as' => 'admin.municipio.cadastrar', 'uses' => 'Admin\MunicipioController@create']);
    Route::post('/admin/municipio/cadastrar', ['as' => 'admin.municipio.cadastrar', 'uses' => 'Admin\MunicipioController@store']);
    Route::get('/admin/municipio/visualizar/{id}', ['as' => 'admin.municipio.visualizar', 'uses' => 'Admin\MunicipioController@show']);
    Route::get('/admin/municipio/aditar/{id}', ['as' => 'admin.municipio.editar', 'uses' => 'Admin\MunicipioController@edit'])->middleware('access.controll.administrador');
    Route::put('/admin/municipio/editar/{id}', ['as' => 'admin.municipio.atualizar', 'uses' => 'Admin\MunicipioController@update'])->middleware('access.controll.administrador');
    Route::get('/admin/municipio/eliminar/{id}', ['as' => 'admin.municipio.eliminar', 'uses' => 'Admin\MunicipioController@destroy'])->middleware('access.controll.administrador');

    Route::get('admin/municipio/eliminadas', ['as' => 'admin.municipio.eliminadas', 'uses' => 'Admin\MunicipioController@eliminadas'])->middleware('access.controll.administrador');
    Route::get('admin/municipio/purgar/{id}', ['as' => 'admin.municipio.purgar', 'uses' => 'Admin\MunicipioController@purgar'])->middleware('access.controll.administrador');
    Route::get('admin/municipio/recuperar/{id}', ['as' => 'admin.municipio.recuperar', 'uses' => 'Admin\MunicipioController@recuperar'])->middleware('access.controll.administrador');
    // End Município

    // Start Activadores de Candidatura
    Route::get('/admin/cadeado_candidatura', ['as' => 'admin/cadeado_candidatura', 'uses' => 'Admin\ActivadordaCandidaturaController@index']);
    Route::get('/admin/cadeado_candidatura/mudar_estado/{slug}/{estado}', ['as' => 'admin.cadeado_candidatura.mudar_estado', 'uses' => 'Admin\ActivadordaCandidaturaController@mudar_estado'])->middleware('access.controll.administrador');
    // Route::put('/admin/cadeado_candidatura/editar/{id}', ['as' => 'admin/cadeado_candidatura/atualizar', 'uses' => 'Admin\ActivadordaCandidaturaController@update'])->middleware('access.controll.administrador');
    // End Activadores de Candidatura

    // Start Cabeçalho da Escola
    Route::get('/admin/escola', ['as' => 'admin/escola', 'uses' => 'Admin\EscolaController@index'])->middleware('access.controll.administrador');
    Route::get('/admin/escola/cadastrar', ['as' => 'admin/escola/cadastrar', 'uses' => 'Admin\EscolaController@create'])->middleware('access.controll.administrador');
    Route::post('/admin/escola/cadastrar', ['as' => 'admin/escola/cadastrar', 'uses' => 'Admin\EscolaController@store'])->middleware('access.controll.administrador');
    Route::get('/admin/escola/visualizar/{id}', ['as' => 'admin/escola/visualizar', 'uses' => 'Admin\EscolaController@show'])->middleware('access.controll.administrador');
    Route::get('/admin/escola/aditar/{id}', ['as' => 'admin/escola/editar', 'uses' => 'Admin\EscolaController@edit'])->middleware('access.controll.administrador');
    Route::put('/admin/escola/editar/{id}', ['as' => 'admin/escola/atualizar', 'uses' => 'Admin\EscolaController@update'])->middleware('access.controll.administrador');
    Route::get('{slug}/{estado}/mudar_estado', ['as' => 'admin.cabecalhos.mudar_estado', 'uses' => 'Admin\EscolaController@mudar_estado']);
    // End Cabeçalho da Escola



    // Start Idade de Candidatura
    Route::get('/admin/idadedecandidatura', ['as' => 'admin/idadedecandidatura', 'uses' => 'Admin\IdadedeCandidaturaController@index']);
    Route::get('/admin/idadedecandidatura/cadastrar', ['as' => 'admin/idadedecandidatura/cadastrar', 'uses' => 'Admin\IdadedeCandidaturaController@create']);
    Route::post('/admin/idadedecandidatura/cadastrar', ['as' => 'admin/idadedecandidatura/cadastrar', 'uses' => 'Admin\IdadedeCandidaturaController@store']);
    Route::get('/admin/idadedecandidatura/editar/{slug}', ['as' => 'admin/idadedecandidatura/editar', 'uses' => 'Admin\IdadedeCandidaturaController@edit'])->middleware('access.controll.administrador');
    Route::put('/admin/idadedecandidatura/editar/{slug}', ['as' => 'admin/idadedecandidatura/atualizar', 'uses' => 'Admin\IdadedeCandidaturaController@update'])->middleware('access.controll.administrador');
    Route::get('/admin/idadedecandidatura/eliminar/{slug}', ['as' => 'admin/idadedecandidatura/eliminar', 'uses' => 'Admin\IdadedeCandidaturaController@destroy'])->middleware('access.controll.administrador');
    // End Idade de Candidatura


    //alunos


    //alunos

    Route::get('admin/alunos/actualizar_classe', ['as' => 'admin.alunos.actualizar_classe', 'uses' => 'Admin\AlunnoController@actualizar_classe']);
    Route::get('admin/alunos/{id}/transferir', ['as' => 'admin.alunos.transferir', 'uses' => 'Admin\AlunnoController@transferir']);
    Route::get('admin/alunos/pesquisar', ['as' => 'admin.alunos.pesquisar', 'uses' => 'Admin\AlunnoController@pesquisar']);
    Route::any('admin/alunos/ver', ['as' => 'admin.alunos.ver', 'uses' => 'Admin\AlunnoController@ver']);
    // Route::get('admin/alunos/listar/{anolectivo}/{curso}', ['as' => 'admin.alunos.listar', 'uses' => 'Admin\AlunnoController@listarAlunos']);
    Route::get('admin/aluno/pulgar/{id}', ['as' => 'admin.aluno.pulgar', 'uses' => 'Admin\AlunnoController@pulgar'])->middleware('access.controll.administrador');

    Route::get('admin/alunos/eliminar/{slug}', 'Admin\AlunnoController@delete')->name('aluno.delete');
    Route::get('admin/alunos/editar/{id}', 'Admin\AlunnoController@edit')->name('aluno.edit');
    Route::put('admin/alunos/editar/{id}', 'Admin\AlunnoController@update')->name('aluno.update');

    Route::post('admin/alunos/recebeBI', ['as' => 'admin.alunos.recebeBI', 'uses' => 'Admin\AlunnoController@recebeBI']);
    Route::get('admin/alunos/trazerCandidato/{BI}', ['as' => 'admin.alunos.trazerCandidato', 'uses' => 'Admin\AlunnoController@trazerCandidato']);

    Route::get('admin/alunos/cadastrar', ['as' => 'admin.alunos.cadastrar', 'uses' => 'Admin\AlunnoController@create']);
    Route::post('admin/alunos/cadastrar', ['as' => 'admin.alunos.cadastrar', 'uses' => 'Admin\AlunnoController@cadastrar']);

    Route::get('admin/selecionados/lista/{anolectivo}/{curso}', ['as' => 'admin.alunos.selecionados', 'uses' => 'Admin\AlunnoController@listas']);

    Route::get('admin/aluno/{processo}', ['as' => 'admin.aluno.por_processo', 'uses' => 'Admin\AlunnoController@aluno']);
    Route::get('admin/alunos/importar', ['as' => 'admin.alunos.importar', 'uses' => 'Admin\AlunnoController@importar']);
    Route::get('admin/alunos/cadastrar', ['as' => 'admin.alunos.cadastrar', 'uses' => 'Admin\AlunnoController@cadastrar']);




    ///alunos fim
    ///alunos fim

    //Lista PDF dos Selecionados
    Route::get('Admin/candidatos/aceitos/pesquisar/imprimir', ['as' => 'admin.ListadSelecionado.candidatos/aceitos/pesquisar/imprimir', 'uses' => 'Admin\ListadSelecionado@pesquisar']);
    Route::post('Admin/recebeSelecionados', ['as' => 'admin.ListadSelecionado.recebeSelecionados', 'uses' => 'Admin\ListadSelecionado@recebeSelecionados']);

    Route::get('Admin/lista/selecionados/{anoLectivo}/{curso}', ['as' => 'admin.ListadSelecionado.lista', 'uses' => 'Admin\ListadSelecionado@index']);
    //Lista PDF dos Selecionados

    //Lista PDF dos Candidatos
    Route::get('Admin/candidaturas/pesquisar/imprimir', ['as' => 'admin.ListadCandidatura.candidaturas/pesquisar/imprimir', 'uses' => 'Admin\ListadCandidatura@pesquisar']);
    Route::any('Admin/candidaturas/lista_pdf', ['as' => 'admin.ListadCandidatura.lista_pdf', 'uses' => 'Admin\ListadCandidatura@lista_pdf']);

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
    Route::get('candidatos/novo_candidato', ['as' => 'admin.candidatos.novo_candidato', 'uses' => 'Admin\CandidaturaController@novo_candidato']);

    Route::get('candidatos/pesquisar', ['as' => 'admin.candidatos.pesquisar', 'uses' => 'Admin\CandidaturaController@pesquisar']);
    // Route::get('candidatos/recebecandidaturas', ['as' => 'admin.candidatos.recebecandidaturas', 'uses' => 'Admin\CandidaturaController@recebecandidaturas']);
    Route::any('candidatos/recebecandidaturas', ['as' => 'admin.candidatos.recebecandidaturas', 'uses' => 'Admin\CandidaturaController@recebecandidaturas']);
    Route::get('candidaturas/listar/{anoLectivo}/{curso}', ['as' => 'admin.candidatos.listar', 'uses' => 'Admin\CandidaturaController@index']);
    // Route::get('candidatos/{slug}/extender', ['as' => 'admin.candidatos.extender', 'uses' => 'Admin\CandidaturaController@extender']);
    Route::get('candidatos/{slug}/imprimir_ficha', ['as' => 'admin.candidatos.imprimirFicha', 'uses' => 'Admin\CandidaturaController@imprimirFicha']);
    Route::get('candidatos/{slug}/edit', ['as' => 'admin.candidatos.editar', 'uses' => 'Admin\CandidaturaController@edit']);
    Route::put('candidatos/{slug}/update', ['as' => 'admin.candidatos.update', 'uses' => 'Admin\CandidaturaController@update']);
    Route::get('candidatos/{slug}/eliminar', ['as' => 'admin.candidatos.eliminar', 'uses' => 'Admin\CandidaturaController@eliminar'])->middleware('access.controll.administrador');
    Route::get('admin/candidatos/{id}/transferir', ['as' => 'admin.candidatos.transferir', 'uses' => 'Admin\CandidaturaController@transferir']);

    Route::get('admin/candidatos/filtro', ['as' => 'admin.candidatos.filtro', 'uses' => 'Admin\CandidaturaController@filtro']);
    Route::post('admin/candidatos/filtro_cadidatos', ['as' => 'admin.candidatos.filtro_cadidatos', 'uses' => 'Admin\CandidaturaController@filtro_cadidatos']);


    Route::get('admin/candidaturas/eliminadas', ['as' => 'admin.candidatos.eliminadas', 'uses' => 'Admin\CandidaturaController@eliminadas'])->middleware('access.controll.administrador');
    Route::get('admin/candidaturas/purgar/{id}', ['as' => 'admin.candidatos.purgar', 'uses' => 'Admin\CandidaturaController@purgar'])->middleware('access.controll.administrador');
    Route::get('admin/candidaturas/recuperar/{id}', ['as' => 'admin.candidatos.recuperar', 'uses' => 'Admin\CandidaturaController@recuperar'])->middleware('access.controll.administrador');

    ///Candidatura Dashboard


    //Turmas
    Route::get('turmas/pesquisar', ['as' => 'admin.turmas.pesquisar', 'uses' => 'Admin\TurmaController@pesquisar']); //->middleware('access.controll.preparador');
    Route::any('turmas/ver', ['as' => 'admin.turmas.ver', 'uses' => 'Admin\TurmaController@ver']); //->middleware('access.controll.preparador');

    //sddd

    Route::group(['prefix' => 'pautas_online'], function () {
        Route::get('/', ['as' => 'admin.pautas_online', 'uses' => 'Admin\CadeadoPautaController@index']);
        Route::get('/mudar_estado/{estado}', ['as' => 'admin.pautas_online.mudar_estado', 'uses' => 'Admin\CadeadoPautaController@mudar_estado']);
       
    }
    );
    Route::group(['prefix' => 'turmas'], function () {

        Route::get('/{id}/professor', ['as' => 'turmas.professor', 'uses' => 'Admin\TurmaController@turmasProfessor']);

        Route::get('/cadastrar', ['as' => 'turmas.cadastrar', 'uses' => 'Admin\TurmaController@cadastrar'])->name('turmas.cadastrar');
        Route::post('/inserir', ['as' => 'turmas.inserir', 'uses' => 'Admin\TurmaController@inserir']);
        Route::get('/listarTurmas/{anolectivo}/{curso}', ['as' => 'admin.viewListarTurmas', 'uses' => 'Admin\TurmaController@listarTurmas']);

        Route::get('/{id}/editar', ['as' => 'turmas.editar', 'uses' => 'Admin\TurmaController@editar'])->middleware('access.controll.administrador');
        Route::get('/{slug}/eliminar', ['as' => 'turmas.eliminar', 'uses' => 'Admin\TurmaController@eliminar'])->middleware('access.controll.administrador');
        Route::put('/{slug}/actualizar', ['as' => 'turmas.actualizar', 'uses' => 'Admin\TurmaController@actualizar'])->middleware('access.controll.administrador');

        Route::get('/{id}/imprimir_alunos', ['as' => 'turmas.imprimir_alunos', 'uses' => 'Admin\TurmaController@imprimir_alunos']);
        Route::get('/{slug}/imprimir_crendencias', ['as' => 'turmas.imprimir_crendencias', 'uses' => 'Admin\TurmaController@imprimir_crendencias']);
       

        Route::get('eliminadas/', ['as' => 'turmas.eliminadas', 'uses' => 'Admin\TurmaController@eliminadas'])->middleware('access.controll.administrador');
        Route::get('recuperar/{id}', ['as' => 'turmas.recuperar', 'uses' => 'Admin\TurmaController@recuperar'])->middleware('access.controll.administrador');
        Route::get('purgar/{id}', ['as' => 'turmas.purgar', 'uses' => 'Admin\TurmaController@purgar'])->middleware('access.controll.administrador');
    });

    //End Turmas

    //Direitor de Turma
    Route::group(['prefix' => 'direitores-turmas'], function () {

        Route::get('/criar', ['as' => 'direitores-turmas.criar', 'uses' => 'Admin\DireitorTurmaController@criar']);
        Route::post('/cadastrar', ['as' => 'direitores-turmas.cadastrar', 'uses' => 'Admin\DireitorTurmaController@cadastrar']);
        Route::get('/index', ['as' => 'direitores-turmas.index', 'uses' => 'Admin\DireitorTurmaController@index']);
        Route::get('/{slug}/editar', ['as' => 'direitores-turmas.editar', 'uses' => 'Admin\DireitorTurmaController@editar'])->middleware('access.controll.administrador');
        Route::get('/{slug}/eliminar', ['as' => 'direitores-turmas.eliminar', 'uses' => 'Admin\DireitorTurmaController@eliminar'])->middleware('access.controll.administrador');
        Route::put('/{slug}/actualizar', ['as' => 'direitores-turmas.actualizar', 'uses' => 'Admin\DireitorTurmaController@actualizar'])->middleware('access.controll.administrador');
        Route::post('turmas', ['as' => 'direitores-turmas.turmas', 'uses' => 'Admin\DireitorTurmaController@turmas']);
        Route::get('/meus', ['as' => 'direitores-turmas.meus', 'uses' => 'Admin\DireitorTurmaController@meus']);

    });
    // End Direitor de Turma

    //Start Tipo pagamento
    Route::group(['prefix' => 'tipos-pagamento'], function () {

        Route::get('/criar', ['as' => 'tipos-pagamento.criar', 'uses' => 'Admin\TipoPagamentoController@criar']);
        Route::post('/cadastrar', ['as' => 'tipos-pagamento.cadastrar', 'uses' => 'Admin\TipoPagamentoController@cadastrar']);
        Route::get('/', ['as' => 'tipos-pagamento', 'uses' => 'Admin\TipoPagamentoController@index']);
        Route::get('/{slug}/editar', ['as' => 'tipos-pagamento.editar', 'uses' => 'Admin\TipoPagamentoController@editar'])->middleware('access.controll.administrador');
        Route::get('/{slug}/eliminar', ['as' => 'tipos-pagamento.eliminar', 'uses' => 'Admin\TipoPagamentoController@eliminar'])->middleware('access.controll.administrador');
        Route::put('/{slug}/actualizar', ['as' => 'tipos-pagamento.actualizar', 'uses' => 'Admin\TipoPagamentoController@actualizar'])->middleware('access.controll.administrador');


    });
    //End Tipo pagamento
    //Start Tipo pagamento
    Route::group(['prefix' => 'inicio-termino-ano-lectivo'], function () {
        Route::get('/criar', ['as' => 'inicio-termino-ano-lectivo.criar', 'uses' => 'Admin\InicioTerminoAnoLectivoController@criar']);
        Route::post('/cadastrar', ['as' => 'inicio-termino-ano-lectivo.cadastrar', 'uses' => 'Admin\InicioTerminoAnoLectivoController@cadastrar']);
        Route::get('/', ['as' => 'inicio-termino-ano-lectivo', 'uses' => 'Admin\InicioTerminoAnoLectivoController@index']);
        Route::get('/{slug}/editar', ['as' => 'inicio-termino-ano-lectivo.editar', 'uses' => 'Admin\InicioTerminoAnoLectivoController@editar'])->middleware('access.controll.administrador');
        Route::get('/{slug}/eliminar', ['as' => 'inicio-termino-ano-lectivo.eliminar', 'uses' => 'Admin\InicioTerminoAnoLectivoController@eliminar'])->middleware('access.controll.administrador');
        Route::put('/{slug}/actualizar', ['as' => 'inicio-termino-ano-lectivo.actualizar', 'uses' => 'Admin\InicioTerminoAnoLectivoController@actualizar'])->middleware('access.controll.administrador');

    });
    //End Tipo pagamento
    Route::group(['prefix' => 'configuracoes'], function () {
        Route::group(['prefix' => 'pautas'], function () {
            Route::group(['prefix' => 'n_negativas'], function () {
                Route::get('/criar', ['as' => 'configuracoes.pautas.n_negativas.criar', 'uses' => 'Admin\NNegativaController@criar']);
                Route::post('/cadastrar', ['as' => 'configuracoes.pautas.n_negativas.cadastrar', 'uses' => 'Admin\NNegativaController@cadastrar']);
                Route::get('/', ['as' => 'configuracoes.pautas.n_negativas', 'uses' => 'Admin\NNegativaController@index']);
                Route::get('/{slug}/editar', ['as' => 'configuracoes.pautas.n_negativas.editar', 'uses' => 'Admin\NNegativaController@editar'])->middleware('access.controll.administrador');
                Route::get('/{slug}/eliminar', ['as' => 'configuracoes.pautas.n_negativas.eliminar', 'uses' => 'Admin\NNegativaController@eliminar'])->middleware('access.controll.administrador');
                Route::put('/{slug}/actualizar', ['as' => 'configuracoes.pautas.n_negativas.actualizar', 'uses' => 'Admin\NNegativaController@actualizar'])->middleware('access.controll.administrador');

            });
            Route::group(['prefix' => 'disciplinas_exames'], function () {
                Route::get('/criar', ['as' => 'configuracoes.pautas.disciplinas_exames.criar', 'uses' => 'Admin\DisciplinaExameController@criar']);
                Route::post('/cadastrar', ['as' => 'configuracoes.pautas.disciplinas_exames.cadastrar', 'uses' => 'Admin\DisciplinaExameController@cadastrar']);
                Route::get('/', ['as' => 'configuracoes.pautas.disciplinas_exames', 'uses' => 'Admin\DisciplinaExameController@index']);
                Route::get('/{slug}/editar', ['as' => 'configuracoes.pautas.disciplinas_exames.editar', 'uses' => 'Admin\DisciplinaExameController@editar'])->middleware('access.controll.administrador');
                Route::get('/{slug}/eliminar', ['as' => 'configuracoes.pautas.disciplinas_exames.eliminar', 'uses' => 'Admin\DisciplinaExameController@eliminar'])->middleware('access.controll.administrador');
                Route::put('/{slug}/actualizar', ['as' => 'configuracoes.pautas.disciplinas_exames.actualizar', 'uses' => 'Admin\DisciplinaExameController@actualizar'])->middleware('access.controll.administrador');

            });
            Route::group(['prefix' => 'pesos_notas_exames'], function () {
                Route::get('/criar', ['as' => 'configuracoes.pautas.pesos_notas_exames.criar', 'uses' => 'Admin\PesoNotaExameController@criar']);
                Route::post('/cadastrar', ['as' => 'configuracoes.pautas.pesos_notas_exames.cadastrar', 'uses' => 'Admin\PesoNotaExameController@cadastrar']);
                Route::get('/', ['as' => 'configuracoes.pautas.pesos_notas_exames', 'uses' => 'Admin\PesoNotaExameController@index']);
                Route::get('/{slug}/editar', ['as' => 'configuracoes.pautas.pesos_notas_exames.editar', 'uses' => 'Admin\PesoNotaExameController@editar'])->middleware('access.controll.administrador');
                Route::get('/{slug}/eliminar', ['as' => 'configuracoes.pautas.pesos_notas_exames.eliminar', 'uses' => 'Admin\PesoNotaExameController@eliminar'])->middleware('access.controll.administrador');
                Route::put('/{slug}/actualizar', ['as' => 'configuracoes.pautas.pesos_notas_exames.actualizar', 'uses' => 'Admin\PesoNotaExameController@actualizar'])->middleware('access.controll.administrador');

            });
            Route::group(['prefix' => 'criterio_disciplinas'], function () {
                Route::get('/criar', ['as' => 'configuracoes.pautas.criterio_disciplinas.criar', 'uses' => 'Admin\CriterioDisciplinaController@criar']);
                Route::post('/cadastrar', ['as' => 'configuracoes.pautas.criterio_disciplinas.cadastrar', 'uses' => 'Admin\CriterioDisciplinaController@cadastrar']);
                Route::get('/', ['as' => 'configuracoes.pautas.criterio_disciplinas', 'uses' => 'Admin\CriterioDisciplinaController@index']);
                Route::get('/{slug}/editar', ['as' => 'configuracoes.pautas.criterio_disciplinas.editar', 'uses' => 'Admin\CriterioDisciplinaController@editar'])->middleware('access.controll.administrador');
                Route::get('/{slug}/eliminar', ['as' => 'configuracoes.pautas.criterio_disciplinas.eliminar', 'uses' => 'Admin\CriterioDisciplinaController@eliminar'])->middleware('access.controll.administrador');
                Route::put('/{slug}/actualizar', ['as' => 'configuracoes.pautas.criterio_disciplinas.actualizar', 'uses' => 'Admin\CriterioDisciplinaController@actualizar'])->middleware('access.controll.administrador');

            });

        });

    });
    //Start Nº de Negativas

    //End Nº de Negativas
    //Start  pagamento
    Route::group(['prefix' => 'pagamentos'], function () {
        Route::get('/pesquisar', ['as' => 'pagamentos.pesquisar', 'uses' => 'Admin\PagamentoController@pesquisar']);
        Route::any('/estado', ['as' => 'pagamentos.estado', 'uses' => 'Admin\PagamentoController@estado']);
        Route::get('{slug_tipo_pagamento}/{processo}/{slug_ano_lectivo}/{mes}/{valor_final}/pagar_mensalidade', ['as' => 'pagamentos.pagar_mensalidade', 'uses' => 'Admin\PagamentoController@pagar_mensalidade']);
        Route::get('{slug_pagamento}/anular_pagamento', ['as' => 'pagamentos.anular_pagamento', 'uses' => 'Admin\PagamentoController@anular_pagamento']);
        Route::get('{slug_pagamento}/fatura', ['as' => 'pagamentos.fatura', 'uses' => 'Admin\PagamentoController@fatura']);
        Route::get('filtrar', ['as' => 'pagamentos.filtrar', 'uses' => 'Admin\PagamentoController@filtrar']);
        Route::any('lista', ['as' => 'pagamentos.lista', 'uses' => 'Admin\PagamentoController@lista']);

        // Route::post('/pesquisar', ['as' => 'pagamentos.pesquisar', 'uses' => 'Admin\PagamentoController@pesquisar']);
        Route::get('/', ['as' => 'pagamentos', 'uses' => 'Admin\PagamentoController@index']);
        Route::get('/{slug}/editar', ['as' => 'pagamentos.editar', 'uses' => 'Admin\PagamentoController@editar'])->middleware('access.controll.administrador');
        Route::get('/{slug}/eliminar', ['as' => 'pagamentos.eliminar', 'uses' => 'Admin\PagamentoController@eliminar'])->middleware('access.controll.administrador');
        Route::put('/{slug}/actualizar', ['as' => 'pagamentos.actualizar', 'uses' => 'Admin\PagamentoController@actualizar'])->middleware('access.controll.administrador');


    });
    //End  pagamento
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

    Route::get('/admin/funcionarios', ['as' => 'admin/funcionarios', 'uses' => 'Admin\Funcionario@show']);
    Route::get('/admin/funcionario/cadastrar', ['as' => 'admin/funcionario/cadastrar', 'uses' => 'Admin\Funcionario@create']);
    Route::post('/admin/funcionario/cadastrar', ['as' => 'admin/funcionario/cadastrar', 'uses' => 'Admin\Funcionario@store']);
    Route::get('/admin/funcionarios/listar', ['as' => 'admin.funcionarios.listar', 'uses' => 'Admin\Funcionario@listar']);

    Route::get('/admin/funcionario/editar/{slug}', ['as' => 'admin/funcionario/editar', 'uses' => 'Admin\Funcionario@edit']);
    Route::put('/admin/funcionario/editar/{slug}', ['as' => 'admin/funcionario/atualizar', 'uses' => 'Admin\Funcionario@update']);
    Route::get('/admin/funcionario/eliminar/{slug}', ['as' => 'admin/funcionario/eliminar', 'uses' => 'Admin\Funcionario@destroy']);
    Route::get('/admin/funcionario/gerar/cartao/{slug}', ['as' => 'admin/funcionario/gerar/cartao', 'uses' => 'Admin\Funcionario@gerar']);
    Route::get('admin/funcionarios/listas/imprimir', ['as' => ' admin/funcionarios/listas/imprimir', 'uses' => 'Admin\Funcionario@imprimir']);
    Route::get('admin/funcionarios/cartao_imprimir/{slug}', ['as' => 'admin.funcionarios.listas.cartao_imprimir', 'uses' => 'Admin\Funcionario@cartao_imprimir']);
   
    



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
    Route::get('/disciplina', ['as' => 'admin.disciplinas.cadastrar.index', 'uses' => 'Admin\DisciplinasController@create']);
    Route::post('/disciplina', ['as' => 'admin.disciplinas.cadastrar.index', 'uses' => 'Admin\DisciplinasController@store']);
    Route::get('/disciplina/editar/{slug}', ['as' => 'admin.disciplinas.editar.index', 'uses' => 'Admin\DisciplinasController@edit'])->middleware('access.controll.administrador');
    Route::put('/disciplina/editar/{slug}', ['as' => 'admin.disciplinas.editar.index', 'uses' => 'Admin\DisciplinasController@update'])->middleware('access.controll.administrador');
    Route::get('/disciplina/deletar/{slug}', ['as' => 'admin.eliminarDisciplina', 'uses' => 'Admin\DisciplinasController@delete'])->middleware('access.controll.administrador');



    //disciplinas fim

    //disciplinas relacionadas start
    Route::get('admin/disciplina_curso_classe/', ['as' => 'admin.disciplina_curso_classe', 'uses' => 'Admin\DisciplinaCursoClasse@index']);
    /* Route::get('/disciplina_curso_classe/singular/{id}/{classe}', ['as' => 'admin.disciplina_curso_classes.singular', 'uses' => 'Admin\disciplina_curso_classesController@singular']); */
    Route::get('admin/disciplina_curso_classe/create', ['as' => 'admin.disciplina_curso_classe.create', 'uses' => 'Admin\DisciplinaCursoClasse@create']);
    Route::post('admin/disciplina_curso_classe/store', ['as' => 'admin.disciplina_curso_classe.store', 'uses' => 'Admin\DisciplinaCursoClasse@store']);
    Route::get('admin/disciplina_curso_classe/edit/{id}', ['as' => 'admin.disciplina_curso_classe.edit', 'uses' => 'Admin\DisciplinaCursoClasse@edit'])->middleware('access.controll.administrador');
    Route::put('admin/disciplina_curso_classe/update/{id}', ['as' => 'admin.disciplina_curso_classe.update', 'uses' => 'Admin\DisciplinaCursoClasse@update'])->middleware('access.controll.administrador');
    Route::get('admin/disciplina_curso_classe/destroy/{id}', ['as' => 'admin.disciplina_curso_classe.destroy', 'uses' => 'Admin\DisciplinaCursoClasse@destroy'])->middleware('access.controll.administrador');

    Route::get('admin/disciplina_curso_classe/eliminadas', ['as' => 'admin.disciplina_curso_classe.eliminadas', 'uses' => 'Admin\DisciplinaCursoClasse@eliminadas'])->middleware('access.controll.administrador');
    Route::get('admin/disciplina_curso_classe/purgar/{id}', ['as' => 'admin.disciplina_curso_classe.purgar', 'uses' => 'Admin\DisciplinaCursoClasse@purgar'])->middleware('access.controll.administrador');
    Route::get('admin/disciplina_curso_classe/recuperar/{id}', ['as' => 'admin.disciplina_curso_classe.recuperar', 'uses' => 'Admin\DisciplinaCursoClasse@recuperar'])->middleware('access.controll.administrador');
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
    Route::get('/admin/pauta/trimestral/{slug_turma}/{trimestre}', ['as' => 'admin.pauta.trimestral', 'uses' => 'Admin\PautaController@trimestral']);
    // Route::get('/admin/pauta_final/gerar/{id}/{tipo}', ['as' => 'admin.pauta_final.gerar', 'uses' => 'Admin\PautaController@creatEnd']);
    Route::get('/admin/pautas/mini/disciplina/{slug_turma_user}/{trimestre}/{slug_disciplina_curso_classe}', ['as' => 'admin.pauta.mini.disciplina', 'uses' => 'Admin\PautaController@disciplina']);
    // Route::get('/admin/pautas/mini/geral/disciplina/{id}/{trimestre}/{id_disciplina}', ['as' => 'admin.pauta.mini.geral.disciplina', 'uses' => 'Admin\PautaController@disciplina_geral']);

    //End Pauta

    //--------------------Melhores_Alunos------------------//
    Route::get('quadros-honra', ['as' => 'admin.quadros.honra', 'uses' => 'Admin\Melhores_AlunosController@search']);
    Route::post('/admin/aluno/send/', ['as' => 'admin.melhor1', 'uses' => 'Admin\Melhores_AlunosController@recebeAlunoMelhor']);
    Route::get('/ver/melhor/{classe}/{trimestre}/{anolectivo}/{formato}/{nota}/{nota2}', ['as' => 'admin.melhor.ver', 'uses' => 'Admin\Melhores_AlunosController@index']);

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
    Route::any('admin/logs/recebelogs', ['as' => 'admin.logs.recebelogs', 'uses' => 'Admin\LogUserController@recebelogs'])->middleware('access.controll.administrador');
    Route::get('admin/logs/visualizar/index/{anoLectivo}/{utilizador}', ['as' => 'admin.logs.listar', 'uses' => 'Admin\LogUserController@index'])->middleware('access.controll.administrador');
    //


    /* nota_dinamica */
    Route::group(['prefix' => 'nota_em_carga'], function () {
        Route::get('/buscar_alunos', ['as' => 'nota_em_carga.buscar_alunos', 'uses' => 'Admin\NotaDinamca@buscar_alunos']);
        Route::post('/mostrar_alunos', ['as' => 'nota_em_carga.mostrar_alunos', 'uses' => 'Admin\NotaDinamca@mostrar_alunos']);
        Route::post('inserir', ['as' => 'nota_em_carga.inserir', 'uses' => 'Admin\NotaDinamca@inserir']);
        Route::get('/buscar_notas', ['as' => 'nota_em_carga.buscar_notas', 'uses' => 'Admin\NotaDinamca@buscar_notas']);
        Route::get('/pesquisar', ['as' => 'nota_em_carga.pesquisar', 'uses' => 'Admin\NotaDinamca@pesquisar']);
        Route::post('nota_em_carga/ver/', ['as' => 'nota_em_carga.ver', 'uses' => 'Admin\NotaDinamca@ver']);
        Route::get('alunos/{slug_turma_user}/{trimestre}', ['as' => 'nota_em_carga.alunos', 'uses' => 'Admin\NotaDinamca@alunos']);

        // alunos($slug_turma_user,$trimistre)
    });
    /* nota_dinamica */

    /* nota_em_carga_diplomado */
    Route::group(['prefix' => 'nota_em_carga_diplomado'], function () {
        Route::get('/buscar_alunos', ['as' => 'nota_em_carga_diplomado.buscar_alunos', 'uses' => 'Admin\NotaDinamicaDiplomadoController@buscar_alunos']);
        Route::post('/mostrar_alunos', ['as' => 'nota_em_carga_diplomado.mostrar_alunos', 'uses' => 'Admin\NotaDinamicaDiplomadoController@mostrar_alunos']);
        Route::post('/{it_idCurso}/{it_idClasse}/{t_idTurma}/{id_anoLectivo}/{vc_tipodaNota}/{it_disciplina}/inserir', ['as' => 'nota_em_carga_diplomado.inserir', 'uses' => 'Admin\NotaDinamicaDiplomadoController@inserir']);
        Route::get('/buscar_notas', ['as' => 'nota_em_carga_diplomado.buscar_notas', 'uses' => 'Admin\NotaDinamicaDiplomadoController@buscar_notas']);
        Route::get('/pesquisar', ['as' => 'nota_em_carga_diplomado.pesquisar', 'uses' => 'Admin\NotaDinamicaDiplomadoController@pesquisar']);
        Route::post('nota_em_carga_diplomado/ver/', ['as' => 'nota_em_carga_diplomado.ver', 'uses' => 'Admin\NotaDinamicaDiplomadoController@ver']);
    });
    /* nota_em_carga_diplomado */


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


    //=============Start caminho=====================f//
    Route::group(['prefix' => 'caminho-files/'], function () {
        Route::post('/cadastrar', ['as' => 'caminho-files.cadastrar', 'uses' => 'Admin\CaminhoFicheiroController@cadastrar']);
        Route::get('/criar', ['as' => 'caminho-files.criar', 'uses' => 'Admin\CaminhoFicheiroController@criar']);
        Route::get('', ['as' => 'caminho-files', 'uses' => 'Admin\CaminhoFicheiroController@index']);
        Route::get('/eliminar/{id}', ['as' => 'caminho-files.eliminar', 'uses' => 'Admin\CaminhoFicheiroController@eliminar'])->middleware('access.controll.administrador');
        Route::put('/actualizar/{id}', ['as' => 'caminho-files.actualizar', 'uses' => 'Admin\CaminhoFicheiroController@actualizar'])->middleware('access.controll.administrador');
        Route::get('/editar/{id}', ['as' => 'caminho-files.editar', 'uses' => 'Admin\CaminhoFicheiroController@editar'])->middleware('access.controll.administrador');
    });
    //=============End-caminho======================//

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

    Route::get('admin/admitidos/eliminadas', ['as' => 'admin.admitidos.eliminadas', 'uses' => 'Admin\Candidatos2Controller@eliminadas'])->middleware('access.controll.administrador');
    Route::get('admin/admitidos/purgar/{id}', ['as' => 'admin.admitidos.purgar', 'uses' => 'Admin\Candidatos2Controller@purgar'])->middleware('access.controll.administrador');
    Route::get('admin/admitidos/recuperar/{id}', ['as' => 'admin.admitidos.recuperar', 'uses' => 'Admin\Candidatos2Controller@recuperar'])->middleware('access.controll.administrador');




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

    Route::group(['prefix' => 'documentos/'], function () {

        Route::group(['prefix' => 'certificados/'], function () {
            Route::get('/emitir', ['as' => 'documentos.certificados.emitir', 'uses' => 'Admin\CertificadoDocumentoController@emitir']);
            Route::post('/imprimir', ['as' => 'documentos.certificados.imprimir', 'uses' => 'Admin\CertificadoDocumentoController@imprimir']);
            // Route::post('/gerar', ['as' => 'relatorio.estatistico.alunos.resultados-finais.gerar', 'uses' => 'Admin\ResultadoFinalAlunoController@gerar']);

        });

        Route::group(['prefix' => 'declaracoes/'], function () {
            Route::get('/emitir', ['as' => 'documentos.declaracoes.emitir', 'uses' => 'Admin\DeclaracaoDocumentoController@emitir']);
            Route::post('/imprimir', ['as' => 'documentos.declaracoes.imprimir', 'uses' => 'Admin\DeclaracaoDocumentoController@imprimir']);
            // Route::post('/gerar', ['as' => 'relatorio.estatistico.alunos.resultados-finais.gerar', 'uses' => 'Admin\ResultadoFinalAlunoController@gerar']);

        });
        
        Route::group(['prefix' => 'anulacao_matricula/'], function () {
            Route::get('/emitir', ['as' => 'documentos.anulacao_matricula.emitir', 'uses' => 'Admin\AnulacaoMatriculaDocumentoController@emitir']);
            Route::post('/imprimir', ['as' => 'documentos.anulacao_matricula.imprimir', 'uses' => 'Admin\AnulacaoMatriculaDocumentoController@imprimir']);

        });

        Route::group(['prefix' => 'boletim_justificativo_falta/'], function () {
            Route::get('/emitir', ['as' => 'documentos.boletim_justificativo_falta.emitir', 'uses' => 'Admin\BoletimJustificativoFaltaDocumentoController@emitir']);
            Route::post('/imprimir', ['as' => 'documentos.boletim_justificativo_falta.imprimir', 'uses' => 'Admin\BoletimJustificativoFaltaDocumentoController@imprimir']);

        });

        Route::group(['prefix' => 'dispensa_administrativa/'], function () {
            Route::get('/emitir', ['as' => 'documentos.dispensa_administrativa.emitir', 'uses' => 'Admin\DispensaAdministrativaDocumentoController@emitir']);
            Route::post('/imprimir', ['as' => 'documentos.dispensa_administrativa.imprimir', 'uses' => 'Admin\DispensaAdministrativaDocumentoController@imprimir']);

        });

        Route::group(['prefix' => 'dispensa_professor/'], function () {
            Route::get('/emitir', ['as' => 'documentos.dispensa_professor.emitir', 'uses' => 'Admin\DispensaProfessorDocumentoController@emitir']);
            Route::post('/imprimir', ['as' => 'documentos.dispensa_professor.imprimir', 'uses' => 'Admin\DispensaProfessorDocumentoController@imprimir']);

        });

        Route::group(['prefix' => 'declaracao_frequencia/'], function () {
            Route::get('/emitir', ['as' => 'documentos.declaracao_frequencia.emitir', 'uses' => 'Admin\DeclaracaoFrequenciaDocumentoController@emitir']);
            Route::post('/imprimir', ['as' => 'documentos.declaracao_frequencia.imprimir', 'uses' => 'Admin\DeclaracaoFrequenciaDocumentoController@imprimir']);

        });

        Route::group(['prefix' => 'componentes/'], function () {
            Route::post('/cadastrar', ['as' => 'admin.documentos.componentes.cadastrar', 'uses' => 'Admin\ComponenteController@cadastrar']);
            Route::get('/criar', ['as' => 'admin.documentos.componentes.criar', 'uses' => 'Admin\ComponenteController@criar']);
            Route::get('', ['as' => 'admin.documentos.componentes', 'uses' => 'Admin\ComponenteController@index']);
            Route::get('/eliminar/{slug}', ['as' => 'admin.documentos.componentes.eliminar', 'uses' => 'Admin\ComponenteController@eliminar'])->middleware('access.controll.administrador');
            Route::put('/actualizar/{slug}', ['as' => 'admin.documentos.componentes.actualizar', 'uses' => 'Admin\ComponenteController@actualizar'])->middleware('access.controll.administrador');
            Route::get('/editar/{slug}', ['as' => 'admin.documentos.componentes.editar', 'uses' => 'Admin\ComponenteController@editar'])->middleware('access.controll.administrador');
        });
        Route::group(['prefix' => 'componentes-disciplinas/'], function () {
            Route::post('/cadastrar', ['as' => 'admin.documentos.componentes-disciplinas.cadastrar', 'uses' => 'Admin\ComponenteDisciplinaController@cadastrar']);
            Route::get('/criar', ['as' => 'admin.documentos.componentes-disciplinas.criar', 'uses' => 'Admin\ComponenteDisciplinaController@criar']);
            Route::get('', ['as' => 'admin.documentos.componentes-disciplinas', 'uses' => 'Admin\ComponenteDisciplinaController@index']);
            Route::get('/eliminar/{slug}', ['as' => 'admin.documentos.componentes-disciplinas.eliminar', 'uses' => 'Admin\ComponenteDisciplinaController@eliminar'])->middleware('access.controll.administrador');
            Route::put('/actualizar/{slug}', ['as' => 'admin.documentos.componentes-disciplinas.actualizar', 'uses' => 'Admin\ComponenteDisciplinaController@actualizar'])->middleware('access.controll.administrador');
            Route::get('/editar/{slug}', ['as' => 'admin.documentos.componentes-disciplinas.editar', 'uses' => 'Admin\ComponenteDisciplinaController@editar'])->middleware('access.controll.administrador');
        });
        Route::group(['prefix' => 'fundos_cartoes/'], function () {
            Route::post('/cadastrar', ['as' => 'admin.fundos_cartoes.cadastrar', 'uses' => 'Admin\FundoCartaoController@cadastrar']);
            Route::get('/criar', ['as' => 'admin.fundos_cartoes.criar', 'uses' => 'Admin\FundoCartaoController@criar']);
            Route::get('', ['as' => 'admin.fundos_cartoes', 'uses' => 'Admin\FundoCartaoController@index']);
            Route::get('/eliminar/{slug}', ['as' => 'admin.fundos_cartoes.eliminar', 'uses' => 'Admin\FundoCartaoController@eliminar'])->middleware('access.controll.administrador');
            Route::put('/actualizar/{slug}', ['as' => 'admin.fundos_cartoes.actualizar', 'uses' => 'Admin\FundoCartaoController@actualizar'])->middleware('access.controll.administrador');
            Route::get('/editar/{slug}', ['as' => 'admin.fundos_cartoes.editar', 'uses' => 'Admin\FundoCartaoController@editar'])->middleware('access.controll.administrador');
        });
        Route::group(['prefix' => 'infos_certificado'], function () {
            Route::get('/criar', ['as' => 'admin.documentos.infos_certificado.criar', 'uses' => 'Admin\InfoCerficadoController@criar']);
            Route::post('/cadastrar', ['as' => 'admin.documentos.infos_certificado.cadastrar', 'uses' => 'Admin\InfoCerficadoController@cadastrar']);
            Route::get('/', ['as' => 'admin.documentos.infos_certificado', 'uses' => 'Admin\InfoCerficadoController@index']);
            Route::get('/{slug}/editar', ['as' => 'admin.documentos.infos_certificado.editar', 'uses' => 'Admin\InfoCerficadoController@editar']);
            Route::get('/{slug}/eliminar', ['as' => 'admin.documentos.infos_certificado.eliminar', 'uses' => 'Admin\InfoCerficadoController@eliminar']);
            Route::put('/{slug}/actualizar', ['as' => 'admin.documentos.infos_certificado.actualizar', 'uses' => 'Admin\InfoCerficadoController@actualizar']);

        });
        //=============relatorios-Start=====================f//
        Route::group(['prefix' => 'relatorios/'], function () {
            //=============relatorios-Start=====================f//
            Route::group(['prefix' => 'candidaturas/'], function () {
                Route::get('/pesquisar', ['as' => 'relatorios.candidaturas.pesquisar', 'uses' => 'Admin\RelatorioController@candidaturas_pesquisar']);
                Route::post('/imprimir', ['as' => 'relatorios.candidaturas.imprimir', 'uses' => 'Admin\RelatorioController@candidaturas_imprimir']);

            });
            Route::group(['prefix' => 'candidatos_aceitos/'], function () {
                Route::get('/pesquisar', ['as' => 'relatorios.candidatos_aceitos.pesquisar', 'uses' => 'Admin\RelatorioController@candidatos_aceitos_pesquisar']);
                Route::post('/imprimir', ['as' => 'relatorios.candidatos_aceitos.imprimir', 'uses' => 'Admin\RelatorioController@candidatos_aceitos_imprimir']);

            });
            Route::group(['prefix' => 'matriculados/'], function () {
                Route::get('/pesquisar', ['as' => 'relatorios.matriculados.pesquisar', 'uses' => 'Admin\RelatorioController@matriculados_pesquisar']);
                Route::post('/imprimir', ['as' => 'relatorios.matriculados.imprimir', 'uses' => 'Admin\RelatorioController@matriculados_imprimir']);

            });
            Route::group(['prefix' => 'propinas/'], function () {
                Route::group(['prefix' => 'alunos/'], function () {
                    Route::get('/pesquisar', ['as' => 'relatorios.propinas.alunos.pesquisar', 'uses' => 'Admin\RelatorioController@propinas_aluno_pesquisar']);
                    Route::any('/imprimir', ['as' => 'relatorios.propinas.alunos.imprimir', 'uses' => 'Admin\RelatorioController@propinas_aluno_imprimir']);

                });

            });
            //=============relatorios-End======================//

        });

        //=============relatorios-Lista=====================f//
        Route::group(['prefix' => 'listas/'], function () {

            Route::group(['prefix' => 'propinas/turmas'], function () {
                Route::get('/pesquisar', ['as' => 'listas.propinas_turmas.pesquisar', 'uses' => 'Admin\ListaController@propinas_turmas_pesquisar']);
                Route::post('/imprimir', ['as' => 'listas.propinas_turmas.imprimir', 'uses' => 'Admin\ListaController@propinas_turmas_imprimir']);

            });
        });

        //=============relatorios-Lista=====================f//


    });
});