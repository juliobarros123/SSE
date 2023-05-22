<input type="hidden" name="_token" value="{{csrf_token()}}">

<div class="form-group col-md-4">
                    <label for="idAluno" class="form-label">Número de processo</label>
                    <input type="text" class="form-control border-secondary" name="idAluno" placeholder="Número de processo"
                    value="{{isset($dadosActualizar->it_id_processoAluno) ? $dadosActualizar->it_id_processoAluno: '' }}"  id="idAluno" required>
                </div>

                <div class="form-group col-3">
                   <label class="form-label" for="AlClasse">Classe Da declaração</label>
                  <select class="form-control buscarClasse" name="AlClasse"  id="AlClasse" required>

                        <option value="" selected disabled >selecione a classe</option>
                        @foreach($classes as $classe)
                        <option value={{$classe->vc_classe}}>{{$classe->vc_classe}}ª Classe</option>
                        @endforeach
                  </select>
                </div>

                <div class="form-group col-3">
                   <label class="form-label" for="tipoDeclaracao">Tipo de declaração</label>
                  <select class="form-control" name="tipoDeclaracao"  id="tipoDeclaracao" required>
                        <option value="" selected disabled >selecione o tipo de declaração</option>
                        {{-- <option value="DECLARAÇÃO DE APROVEITAMENTO">Declaração de aproveitamento</option> --}}
                        <option value="DECLARAÇÃO DE FREQUÊNCIA">Declaração de frequência</option>
                  </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="efeito" class="form-label">Escreva o efeito da declaração</label>
                    <input type="text" class="form-control border-secondary" name="efeito" placeholder="Para que efeito?"  id="efeito" required
                    value="{{ isset($dadosActualizar->vc_efeito) ? $dadosActualizar->vc_efeito : '' }}">

                </div>



