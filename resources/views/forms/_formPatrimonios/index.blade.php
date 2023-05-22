@isset($patrimonios->vc_foto)

    <div class="col-sm-12 m-2">

        <div class="card card-outline-info h-100">
            <div class="card-img-top">
                <img src="{{ asset($patrimonios->vc_foto) }}" class="grayscale img-fluid mx-auto d-block"
                   width="200">
            </div>
        </div>

    </div>
@endisset

<div class="col-md-4">
    <label for="vc_primeiroNome" class="form-label">Nome</label>
    <input type="text" class="form-control border-secondary"
        value="{{ isset($patrimonios->vc_nome) ? $patrimonios->vc_nome : '' }}" name="vc_nome" placeholder="Nome">
</div>
<div class="col-md-2">
    <label for="" class="form-label">Estado</label>
    <select type="text" class="form-control border-secondary" value="" name="vc_estado">
        @isset($patrimonios)
            <option value="{{ $patrimonios->vc_estado }}">{{ $patrimonios->vc_estado }}</option>
        @else
            <option disabled selected>Selecione a opção</option>
        @endisset
        <option value="Degradado">Degradado</option>
        <option value="Conservado">Conservado</option>
        <option value="Bom">Bom</option>
    </select>
</div>
<div class="col-md-6">
    <label for="vc_bi" class="form-label">Descrição</label>
    <input type="text" class="form-control border-secondary"
        value="{{ isset($patrimonios->vc_descricao) ? $patrimonios->vc_descricao : '' }}" name="vc_descricao"
        placeholder="Discrição">
</div>

<div class="col-md-4 mt-2">
    <label for="" class="form-label">Quantidade</label>
    <input type="number" class="form-control border-secondary"
        value="{{ isset($patrimonios->it_quantidade) ? $patrimonios->it_quantidade : '' }}" name="it_quantidade"
        placeholder="Quantidade">
</div>
<div class="col-md-4 mt-2">
    <label for="" class="form-label">Valor líquido</label>
    <input type="number" class="form-control border-secondary"
        value="{{ isset($patrimonios->it_valor) ? $patrimonios->it_valor : '' }}" name="it_valor"
        placeholder="Valor do patrimonial liquido">
</div>
<div class="col-md-4 mt-2">
    <label for="" class="form-label">Nº da Factura</label>
    <input type="number" class="form-control border-secondary"
        value="{{ isset($patrimonios->it_numfactura) ? $patrimonios->it_numfactura : '' }}" name="it_numfactura"
        placeholder="Número da fatura de compra">
</div>
<div class="col-md-4 mt-2">
    <label for="" class="form-label">Vida Útil</label>
    <input type="number" class="form-control border-secondary"
        value="{{ isset($patrimonios->it_vidaUtil) ? $patrimonios->it_vidaUtil : '' }}" name="it_vidaUtil"
        placeholder="Vida útil">
</div>
<div class="col-md-2">
    <label for="" class="form-label">Em utilização:</label>
    <select type="text" class="form-control border-secondary" value="" name="vc_utilidade">
        @isset($patrimonios)
            <option value="{{ $patrimonios->vc_utilidade }}">{{ $patrimonios->vc_utilidade }}</option>
        @else
            <option disabled selected>Selecione a opção</option>
        @endisset
        <option value="Sim">Sim</option>
        <option value="Não">Não</option>
    </select>
</div>
<div class="col-md-6">
    <label for="vc_bi" class="form-label">Marca</label>
    <input type="text" class="form-control border-secondary"
        value="{{ isset($patrimonios->vc_marca) ? $patrimonios->vc_marca : '' }}" name="vc_marca"
        placeholder="Marca">
</div>
<div class="col-md-6">
    <label for="vc_bi" class="form-label">Modelo</label>
    <input type="text" class="form-control border-secondary"
        value="{{ isset($patrimonios->vc_modelo) ? $patrimonios->vc_modelo : '' }}" name="vc_modelo"
        placeholder="Modelo">
</div>
<div class="col-md-6">
    <label for="vc_bi" class="form-label">Localização</label>
    <input type="text" class="form-control border-secondary"
        value="{{ isset($patrimonios->vc_localizacao) ? $patrimonios->vc_localizacao : '' }}" name="vc_localizacao"
        placeholder="Localização">
</div>

<style>
    .file {
        opacity: 0;
        width: 0.1px;
        height: 0.1px;
        position: absolute;
    }

    .file-input label {
        display: block;
        position: relative;
        height: 50px;
        border-radius: 6px;
        background: linear-gradient(40deg, #343a41, #343a41);
        box-shadow: 0 4px 7px rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: transform .2s ease-out;
        top: 3px;
        width: auto;
    }

</style>
<div class="file-field input-field col-12 mt-4">
    <div class="form-group">
        <div class="file-input">
            <input name="vc_foto" type="file" id="file" class="file"
                value="{{ isset($patrimonios->vc_foto) ? $patrimonios->vc_foto : '' }}">
            <label for="file"><i class="fas fa-camera mr-2"></i> Carregar foto</label>
        </div>
    </div>
</div>
