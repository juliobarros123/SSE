<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="form-group col-7">
                    <label for="idAluno" class="form-label">Número de processo:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="idAluno" placeholder="Número de processo"
                    value=""  id="idAluno" required>
                </div>

                <div class=" col-4 ">
                   <label class="form-label " for="AlClasse">Classe:</label>
                  <select class="form-control buscarClasse" name="AlClasse"  id="AlClasse" required>

                        <option value="" disabled selected >selecione a classe</option>
                        @foreach($classes as $classe)
                        <option value={{$classe->id}}>{{$classe->vc_classe}}ª Classe</option>
                        @endforeach
                  </select>
                </div>



