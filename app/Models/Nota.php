<?php
/* Este sistema esta protegido pelos direitos autoriais do Instituto de Telecomunicações criado ao
abrigo do decreto executivo conjunto nº29/85 de 29 de Abril,
dos Ministérios da Educação e dos Transportes e Comunicações,
publicado no Diário da República, 1ª série nº 35/85, nos termos
do artigo 62º da Lei Constitucional.

contactos:
site:www.itel.gov.ao
Telefone I: +244 931 313 333
Telefone II: +244 997 788 768
Telefone III: +244 222 381 640
Email I: secretariaitel@hotmail.com
Email II: geral@itel.gov.ao*/

namespace App\Models;

use App\Models\Turma;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use App\Models\Disciplinas;
use Illuminate\Support\Arr;

class Nota extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $hash_bcrypt = '';
            $hash_bcrypt = Hash::make(slug_gerar());
            $stringSemBarras = str_replace('/', '', $hash_bcrypt);
            $model->slug = $stringSemBarras;
        });
    }

    protected $fillable = ['id_cabecalho','slug', 
        'it_disciplina',
        'id_classe',
        'fl_nota1',
        'fl_nota2',
        'id_aluno',
        'it_idDeclaracao',
        'id_turma',
        'vc_tipodaNota',
        'fl_media',
        'id_ano_lectivo',
        'it_estado_nota',
        'fl_mac',
    ];

    public function alunno()
    {
        return $this->belongsTo(Alunno::class);
    }
    public function pautas()
    {
        return $this->belongsToMany(pauta::class);
    }
    public function declaracaocomNotas()
    {
        return $this->belongsToMany(DeclaracaoComNotas::class);
    }
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplinas::class);
    }
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    public function anos()
    {
        return $this->belongsTo('App\Models\AnoLectivo', 'anoslectivos');
    }

    public function RDisciplinasJoins()
    {
        $disciplina = DB::table('disciplinas_cursos_classes')

            ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
            ->join('cursos', 'disciplinas_cursos_classes.it_curso', '=', 'cursos.id')
            ->join('classes', 'disciplinas_cursos_classes.it_classe', '=', 'classes.id')

            ->orderby('disciplinas.vc_nome', 'asc')
            ->select(
                'disciplinas.vc_nome',
                'disciplinas_cursos_classes.id',
                'cursos.vc_nomeCurso',
                'classes.vc_classe'
            );
        return $disciplina->get();
    }

    public function NotaForSearch($anoLectivo, $disciplina, $classe, $turma, $trimestre)
    {

        $notas = DB::table('notas')
            ->join('alunnos', 'alunnos.id', '=', 'notas.it_idAluno')

            ->join('disciplinas_cursos_classes', 'disciplinas_cursos_classes.id', '=', 'notas.it_disciplina')
            ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
            ->select('notas.*', 'alunnos.vc_ultimoaNome', 'alunnos.vc_nomedoMeio', 'alunnos.vc_primeiroNome', 'disciplinas.vc_nome')
            ->distinct()
            ->where([['notas.it_estado_nota', 1]])
            ->where([['notas.vc_anolectivo', '=', $anoLectivo]])
            ->where([['notas.vc_tipodaNota', '=', $trimestre]])
            ->where([['notas.it_classe', '=', $classe]])
            ->where([['notas.vc_nomedaTurma', '=', $turma]])
            ->where([['notas.it_disciplina', '=', $disciplina]]);

        return $notas->get();
    }
    public function object_notas2($id, $trimestre)
    {
        $turma = Turma::find($id);
        $notas = collect($this->notas($id, $trimestre)->get());


        $notas_linhas = array();
        $alunos = $this->alunos($turma);
        foreach ($alunos as $aluno) {
            array_push(
                $notas_linhas,
                array(
                    'id_aluno' => $aluno->id,
                    'nome' => $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_ultimoaNome,
                    'notas' => $notas->where('id_aluno', $aluno->id)->toArray(),
                )
            );
        }
        $notas_linhas =  $this->orgNotasTri3($notas_linhas, $turma->vc_classeTurma, $trimestre, $turma->id);

        return $notas_linhas;
    }
    public function orgNotasTri3($notas, $classe, $trimestre, $id_turma)
    {

        $notasOrgs = array();
        $alunosNotas = array();

        $turma = new Turma;
        $disciplinas =  $turma->turmasDisciplinas($id_turma)->get();

        foreach ($notas as $nota) {
            foreach ($nota["notas"] as $t) {
                if ($disciplinas->where('vc_acronimo',  $t->vc_acronimo)->count()) {



                    if ($classe == 12 && $trimestre == "III") {
                        array_push(
                            $notasOrgs,
                            [
                                "it_idAluno" => $t->it_idAluno,
                                "vc_nome" => $t->vc_nome,
                                "vc_acronimo" => $t->vc_acronimo,
                                "fl_media" =>  ($t->fl_nota1 + $t->fl_mac) / 2,
                                "fl_nota1" => $t->fl_nota1,
                                "fl_nota2" => $t->fl_nota2,
                                "fl_mac" => $t->fl_mac,
                            ]
                        );
                    } else {
                        array_push(
                            $notasOrgs,
                            [
                                "it_idAluno" => $t->it_idAluno,
                                "vc_nome" => $t->vc_nome,
                                "vc_acronimo" => $t->vc_acronimo,
                                "fl_media" => $t->fl_media,
                                "fl_nota1" => $t->fl_nota1,
                                "fl_nota2" => $t->fl_nota2,
                                "fl_mac" => $t->fl_mac,
                            ]
                        );
                    }
                }
            }
            array_push(
                $alunosNotas,
                [
                    "processo" => $nota["processo"],
                    "nome" => $nota["nome"],
                    "notas" =>  $notasOrgs
                ]
            );
            $notasOrgs = [];
        }
        return $alunosNotas;
    }
    public function object_notas($id, $trimestre)
    {
        $turma = Turma::find($id);
        $notas = collect($this->notas($id, $trimestre)->get());

        $notas_linhas = array();
        $alunos = $this->alunos($turma);
        foreach ($alunos as $aluno) {
            array_push(
                $notas_linhas,
                array(
                    'id_aluno' => $aluno->id,
                    'nome' => $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_ultimoaNome,
                    'notas' => $notas->where('id_aluno', $aluno->id)->toArray(),
                )
            );
        }
        return $notas_linhas;
    }

    public function object_notas_disciplina($id, $trimestre, $id_disciplina)
    {
        $notas = [];
        $turma = Turma::find($id);
        if ($id_disciplina == 'Todas') {
            $notas = $this->notas($id, $trimestre)
                ->join('alunnos', 'alunnos.id', '=', 'notas.it_idAluno')
                ->select(
                    'notas.it_idAluno',
                    'disciplinas.vc_nome',
                    'disciplinas.vc_acronimo',
                    'notas.fl_media',
                    'notas.fl_nota1',
                    'notas.fl_nota2',
                    'notas.fl_mac',
                    'alunnos.id',
                    'alunnos.vc_primeiroNome',
                    'alunnos.vc_nomedoMeio',
                    'alunnos.vc_ultimoaNome'
                )
                ->distinct()
                ->get();
        } else {
            $notas = $this->notas($id, $trimestre)
                ->join('alunnos', 'alunnos.id', '=', 'notas.it_idAluno')
                ->select(
                    'notas.it_idAluno',
                    'disciplinas.vc_nome',
                    'disciplinas.vc_acronimo',
                    'notas.fl_media',
                    'notas.fl_nota1',
                    'notas.fl_nota2',
                    'notas.fl_mac',
                    'alunnos.id',
                    'alunnos.vc_primeiroNome',
                    'alunnos.vc_nomedoMeio',
                    'alunnos.vc_ultimoaNome'
                )
                ->distinct()
                ->where('disciplinas.id', $id_disciplina)->get();
        }
        //    dd($notas);
        return $notas;
    }

    public function object_notas_disc_todos_trimestre($id, $trimestre, $id_disciplina)
    {
        $notas = collect($this->object_notas_disciplina($id, $trimestre, $id_disciplina));

        $turma = Turma::find($id);
        $disciplina = Disciplinas::find($id_disciplina);
        $alunos = $this->alunos($turma);

        $notas_linhas = array();
        foreach ($alunos as $aluno) {
            if (isset($notas->groupBy('id_aluno')['' . $aluno->id])) {
                array_push(
                    $notas_linhas,
                    array(
                        'id_aluno' => $aluno->id,
                        'vc_nome' => $disciplina->vc_nome,
                        'vc_acronimo' => $disciplina->vc_acronimo,
                        'nome_aluno' => $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_ultimoaNome,
                        'media_geral' => $notas->groupBy('id_aluno')['' . $aluno->id]->avg('fl_media')
                    )
                );
            }
        }
        return $notas_linhas;
    }

    public function object_notas_anual($id, $trimestre, $id_disciplina)
    {
        $notas = collect($this->object_notas_disciplina($id, $trimestre, $id_disciplina));

        $turma = Turma::find($id);
        $disciplina = Disciplinas::find($id_disciplina);
        $alunos = $this->alunos($turma);

        $notas_linhas = array();
        foreach ($alunos as $aluno) {
            if (isset($notas->groupBy('id_aluno')['' . $aluno->id])) {
                array_push(
                    $notas_linhas,
                    array(
                        'id_aluno' => $aluno->id,
                        'vc_nome' => $disciplina->vc_nome,
                        'vc_acronimo' => $disciplina->vc_acronimo,
                        'nome_aluno' => $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_ultimoaNome,
                        'media_geral' => $notas->groupBy('id_aluno')['' . $aluno->id]->avg('fl_media')
                    )
                );
            }
        }
        return $notas_linhas;
    }



    public function notas($id, $trimestre)
    {
        $turma = Turma::find($id);
// dd($turma);
        if ($trimestre != "Geral") {

            $notas = DB::table('notas')
                ->leftJoin('turmas', 'turmas.id', '=', 'notas.id_turma')
                ->leftJoin('anoslectivos', 'notas.id_ano_lectivo', '=', 'anoslectivos.id')
                ->leftJoin('disciplinas_cursos_classes', 'disciplinas_cursos_classes.id', '=', 'notas.it_disciplina')
                ->leftJoin('disciplinas', 'disciplinas.id', '=', 'disciplinas_cursos_classes.it_disciplina')
                // ->orderBy('notas.id', 'desc')
                // ->distinct()
                ->where([['notas.id_turma', $turma->id]])
                ->where([['notas.id_ano_lectivo', $turma->it_idAnoLectivo]])
                ->where([['notas.vc_tipodaNota', $trimestre]])
                ->where([['notas.it_estado_nota', 1]])

                ->select('notas.id', 'notas.it_idAluno', 'disciplinas.vc_nome', 'disciplinas.vc_acronimo', 'notas.fl_media', 'notas.fl_nota1', 'notas.fl_nota2', 'notas.fl_mac')
                // ->orderBy('notas.id', 'desc')
                ->distinct();
            return $notas;
        } else {

            $notas = DB::table('notas')
                ->leftJoin('turmas', 'turmas.id', '=', 'notas.id_turma')
                ->leftJoin('anoslectivos', 'notas.id_ano_lectivo', '=', 'anoslectivos.id')
                ->leftJoin('disciplinas_cursos_classes', 'disciplinas_cursos_classes.id', '=', 'notas.it_disciplina')
                ->leftJoin('disciplinas', 'disciplinas.id', '=', 'disciplinas_cursos_classes.it_disciplina')
                ->where([['notas.id_turma', $turma->id]])
                ->where([['notas.id_ano_lectivo', $turma->it_idAnoLectivo]])
                ->where([['notas.it_estado_nota', 1]])
                ->select('notas.id', 'notas.it_idAluno', 'disciplinas.vc_nome', 'disciplinas.vc_acronimo', 'notas.fl_media', 'notas.fl_nota1', 'notas.fl_nota2', 'notas.fl_mac')
                // ->orderBy('notas.id', 'desc')
                ->distinct();
            return $notas;
        }
    }

    public function geral()
    {


        $notas = DB::table('notas')
            ->leftJoin('turmas', 'turmas.id', '=', 'notas.id_turma')
            ->leftJoin('anoslectivos', 'notas.id_ano_lectivo', '=', 'anoslectivos.id')
            ->leftJoin('disciplinas_cursos_classes', 'disciplinas_cursos_classes.id', '=', 'notas.it_disciplina')
            ->leftJoin('disciplinas', 'disciplinas.id', '=', 'disciplinas_cursos_classes.it_disciplina')
            ->distinct()
            ->where([['notas.it_estado_nota', 1]])
            ->select(
                'notas.*',
                'notas.it_idAluno',
                'disciplinas.vc_nome',
                'disciplinas.vc_acronimo',
                'notas.vc_tipodaNota',
                'notas.id_classe',

                'disciplinas.id as id_disciplina',
                'notas.fl_media',
                'notas.fl_nota1',
                'notas.fl_nota2',
                'notas.fl_mac',
                // 'alunnos.id',
                // 'alunnos.vc_primeiroNome',
                // 'alunnos.vc_nomedoMeio',
                // 'alunnos.vc_ultimoaNome',
                'anoslectivos.ya_inicio',
                'anoslectivos.ya_fim',
                'anoslectivos.id as id_anolectivo'
            );



        return $notas;
    }

    public function notasGeral($id_turma)
    {
        $notas = DB::table('notas')
            ->leftJoin('turmas', 'turmas.id', '=', 'notas.id_turma')
            ->leftJoin('anoslectivos', 'notas.id_ano_lectivo', '=', 'anoslectivos.id')
            ->leftJoin('disciplinas_cursos_classes', 'disciplinas_cursos_classes.id', '=', 'notas.it_disciplina')
            ->leftJoin('disciplinas', 'disciplinas.id', '=', 'disciplinas_cursos_classes.it_disciplina')
            ->join('alunnos', 'alunnos.id', '=', 'notas.it_idAluno')
            ->distinct();
        $turma = Turma::find($id_turma);


        if ($id_turma != "''") {

            $notas = $notas->where([['notas.id_turma', $turma->id]]);
        }
        if (isset($turma->it_idAnoLectivo)) {
            $notas = $notas->where([['notas.id_ano_lectivo', $turma->it_idAnoLectivo]]);
        }
        $notas =   $notas->where([['notas.it_estado_nota', 1]])

            ->select(
                'notas.it_idAluno',
                'disciplinas.vc_nome',
                'disciplinas.vc_acronimo',
                'notas.vc_tipodaNota',
                'disciplinas.id as id_disciplina',
                'notas.fl_media',
                'notas.fl_nota1',
                'notas.fl_nota2',
                'notas.fl_mac',
                'alunnos.id',
                'alunnos.vc_primeiroNome',
                'alunnos.vc_nomedoMeio',
                'alunnos.vc_ultimoaNome'
            );
        return $notas;
    }
    //     if ($disciplina->id_disciplina_terminal){
    //         $ac=   notasDeOutrosAnos($aluno->id,$disciplina->id, "''",$detalhes_turma->it_idClasse);
    //         array_push($disciplinasPositivas, $disciplina->id );

    // }else{
    //     $ac=array_push($disciplinasNegativas,$disciplina->id );

    // }

    public function notasNoutrosAnos($n_processo, $id_disciplina, $id_anoLectivo, $id_classe)
    {

        $notas = DB::table('notas')
            ->leftJoin('turmas', 'turmas.id', '=', 'notas.id_turma')
            ->leftJoin('anoslectivos', 'notas.id_ano_lectivo', '=', 'anoslectivos.id')
            ->leftJoin('disciplinas_cursos_classes', 'disciplinas_cursos_classes.id', '=', 'notas.it_disciplina')
            ->leftJoin('disciplinas', 'disciplinas.id', '=', 'disciplinas_cursos_classes.it_disciplina')
            ->join('alunnos', 'alunnos.id', '=', 'notas.it_idAluno')
            ->distinct()
            ->join('classes', 'disciplinas_cursos_classes.it_classe', '=', 'classes.id');
        // $turma = Turma::find($id_turma);


        if ($id_disciplina != "''") {
            $notas = $notas->where([['disciplinas.id', $id_disciplina]]);
        }
        if ($id_anoLectivo != "''") {
            $notas = $notas->where([['notas.id_ano_lectivo', $id_anoLectivo]]);
        }
        if ($n_processo != "''") {
            // dd( $n_processo);
            $notas = $notas->where([['alunnos.id', $n_processo]]);
        }

        if ($id_classe != "''") {
            // dd( $n_processo);
            $notas = $notas->where([['notas.id_classe', $id_classe]]);
        }
        $notas =   $notas->where([['notas.it_estado_nota', 1]])

            ->select(
                'notas.it_idAluno',
                'disciplinas.vc_nome',
                'disciplinas.vc_acronimo',
                'notas.vc_tipodaNota',
                'notas.id_classe',
                'classes.vc_classe',
                'disciplinas.id as id_disciplina',
                'notas.fl_media',
                'notas.fl_nota1',
                'notas.fl_nota2',
                'notas.fl_mac',
                'alunnos.id',
                'alunnos.vc_primeiroNome',
                'alunnos.vc_nomedoMeio',
                'alunnos.vc_ultimoaNome',
                'anoslectivos.ya_inicio',
                'anoslectivos.ya_fim',
                'anoslectivos.id as id_anolectivo',
                'disciplinas_cursos_classes.it_curso'
            );

        return $notas;
    }


    public function alunos($turma)
    {

        $alunos = DB::table('matriculas')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->leftJoin('turmas', 'turmas.id', '=', 'matriculas.it_idTurma')
            ->orderby('alunnos.vc_primeiroNome', 'asc')
            ->orderby('alunnos.vc_nomedoMeio', 'asc')
            ->orderby('alunnos.vc_ultimoaNome', 'asc')
            ->where([['turmas.it_idAnoLectivo', $turma->it_idAnoLectivo]])
            ->where([['turmas.id', $turma->id]])
            ->distinct()
            ->select('alunnos.id', 'alunnos.vc_primeiroNome', 'alunnos.vc_nomedoMeio', 'alunnos.vc_ultimoaNome')
            ->get();
        // dd(  $alunos);
        return $alunos;
    }
}
