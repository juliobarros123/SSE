<div class="form-group col-md-6">
    <label>Estudando:</label>
    <select name="estudando" class="form-control " id="estudando" required>
        <option selected disabled>Selecciona o estado actual do aluno</option>
        <option value="1">Sim</option>
        <option value="0">Não</option>
    </select>
    <small> <small class="text-dangr " style="font-size: 150%">Sim-></small> Caso a nota é de exame ou o aluno é
        diplomado</small>
    <small> <small class="text-warning " style="font-size: 150%">Não-> </small> Caso o aluno está estudando e é para as
        notas anterios</small>

</div>

<div class="form-group col-md-6">
    <label>Processo:</label>
    <input type="text" id="processo" class="form-control border-secondary " readonly
        placeholder="Digita o número de processo" name="processo">

</div>
<br>
<h1>Dados actuais do aluno</h1>
<div class="row w-100" >


    <div class="form-group col-md-4">
        <label>Nome completo:</label>
        <input type="text" id="nome-completo" class="form-control border-secondary " readonly>

    </div>
    <div class="form-group col-md-4">
        <label>Curso:</label>
        <input type="text" id="curso" class="form-control border-secondary " name="curso" readonly>
    </div>
    <div class="form-group col-md-4">
        <label>Classe:</label>
        <input type="text" id="classe" class="form-control border-secondary " name="classe" readonly>
    </div>

    <div class="form-group col-md-4">
        <label>Turma:</label>
        <select name="id_turma" id="id_turma" class="form-control " readonly>
        </select>

    </div>
    <div class="form-group col-md-4">
        <label>Ano lectivo:</label>
        <input type="text" id="anoLectivo" class="form-control border-secondary " readonly>
    </div>
    <div class="form-group col-md-4">
        <label>Disciplina:</label>
        <select name="disciplina" class="form-control select2" id="disciplina">

            <option selected disabled>Selecciona a disciplina</option>


        </select>
    </div>
    

    <div id="id-notas" class="row col-md-12  "></div>
</div>
