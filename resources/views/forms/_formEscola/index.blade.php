
<div class="form-group col-sm-4">
    <label for="" class="form-label">Logo</label>
    <input type="file" class="form-control" placeholder="Escola" name="vc_logo"
        value="{{ isset($cabecalho->vc_logo) ? $cabecalho->vc_logo : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Assinatura do Director</label>
    <input type="file" class="form-control" placeholder="Escola" name="assinatura_director"
        value="{{ isset($cabecalho->assinatura_director) ? $cabecalho->assinatura_director : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Escola</label>
    <input type="text" class="form-control" placeholder="Escola" name="vc_escola"
        value="{{ isset($cabecalho->vc_escola) ? $cabecalho->vc_escola : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Acronimo da Escola <small>Se não tiver tire as primeiras letras da Escola</small></label>
    <input type="text" class="form-control" placeholder="Acronimo da Escola " name="vc_acronimo"
        value="{{ isset($cabecalho->vc_acronimo) ? $cabecalho->vc_acronimo : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Numero de Identificação Fiscal(NIF)</label>
    <input type="text" class="form-control" placeholder="NIF" name="vc_nif"
        value="{{ isset($cabecalho->vc_nif) ? $cabecalho->vc_nif : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">República</label>
    <input type="text" class="form-control" placeholder="República" name="vc_republica"
        value="{{ isset($cabecalho->vc_republica) ? $cabecalho->vc_republica : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Ministério de tutela da Escola<small> Mais de um Ministério coleque um "< br>"</small></label>
    <input type="text" class="form-control" placeholder="Ministério" name="vc_ministerio"
        value="{{ isset($cabecalho->vc_ministerio) ? $cabecalho->vc_ministerio : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Telefone</label>
    <input type="number" class="form-control" placeholder="Telefone" name="it_telefone"
        value="{{ isset($cabecalho->it_telefone) ? $cabecalho->it_telefone : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Tipo de escola</label>
    <select name="vc_tipo_escola" class="form-control" >

        <option value="{{ isset($cabecalho->vc_tipo_escola) ? $cabecalho->vc_tipo_escola : '0' }}" select>
            {{ isset($cabecalho->vc_tipo_escola) ? $cabecalho->vc_tipo_escola : 'Seleciona o tipo de escola' }}
        </option>
        <option value="Liceu">Liceu</option>
        <option value="Magistério">Magistério</option>
        <option value="Instituto">Instituto</option>
        <option value="Técnico">Técnico</option>
        <option value="Geral">Geral</option>


    </select>
 
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Nome completo do Director(a)</label>
    <input type="text" class="form-control" placeholder="Director(a)" name="vc_nomeDirector"
        value="{{ isset($cabecalho->vc_nomeDirector) ? $cabecalho->vc_nomeDirector : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Endereço da Escola</label>
    <input type="text" class="form-control" placeholder="Endereço" name="vc_endereco"
        value="{{ isset($cabecalho->vc_endereco) ? $cabecalho->vc_endereco : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Email Institucional</label>
    <input type="email" class="form-control" placeholder="Email" name="vc_email"
        value="{{ isset($cabecalho->vc_email) ? $cabecalho->vc_email : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Subdirector(a) Pedagógico(a)</label>
    <input type="text" class="form-control" placeholder="Subdirector(a) Pedagógico(a)" name="vc_nomeSubdirectorPedagogico"
        value="{{ isset($cabecalho->vc_nomeSubdirectorPedagogico) ? $cabecalho->vc_nomeSubdirectorPedagogico : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Subdirector(a) Administrativo(a) e Financeiro(a)</label>
    <input type="text" class="form-control" placeholder="Subdirector(a) Administrativo(a) e Financeiro(a)" name="vc_nomeSubdirectorAdminFinanceiro"
        value="{{ isset($cabecalho->vc_nomeSubdirectorAdminFinanceiro) ? $cabecalho->vc_nomeSubdirectorAdminFinanceiro : '' }}">
</div>


<div class="form-group col-sm-4">
    <label for="" class="form-label">Provincia</label>
        <select class="form-control buscarProvincia " name="it_id_provincia" id="it_id_provincia">
            <option value="{{ isset($cabecalho) ? $cabecalho->it_id_provincia : '' }}" selected>
                {{ isset($cabecalho) ? $cabecalho->vc_nomeProvincia : 'Selecione o Provincia:' }}</option>
            
                @foreach ($provincias as $provincia)
                <option value="{{ $provincia->id }}">{{ $provincia->vc_nome }} </option>
          
            @endforeach
        </select>
</div>

<div class="form-group col-sm-4">
    <label for="" class="form-label">Municipio</label>
        <select class="form-control buscarMunicipio " name="it_id_municipio" id="it_id_municipio" >
            <option value="{{ isset($cabecalho) ? $cabecalho->it_id_municipio : '' }}" selected>
                {{ isset($cabecalho) ? $cabecalho->vc_nomeMunicipio : 'Selecione o Municipio:' }}</option>
            @foreach ($municipios as $municipio)
                <option value="{{ $municipio->id }}">{{ $municipio->vc_nome }} </option>
          
            @endforeach
        </select>
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Nº da escola</label>
    <input type="text" class="form-control" placeholder="Número da escola" name="vc_numero_escola"
        value="{{ isset($cabecalho->vc_numero_escola) ? $cabecalho->vc_numero_escola : '' }}">
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Director(a) Municipal</label>
    <input type="text" class="form-control" placeholder="Nome do(a) Director(a) Municipal" name="director_municipal"
        value="{{ isset($cabecalho->director_municipal) ? $cabecalho->director_municipal : '' }}">
</div>
