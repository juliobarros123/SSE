@csrf

<div class="col-md-4">
    <div class="form-group">
        <label for="url">{{ __('URL') }}</label>
        <input value="{{ isset($url->url) ? $url->url : '' }}" id="url" type="text"
            class="form-control @error('url') is-invalid @enderror" name="url" placeholder="Digit aqui a ULR  da API" required
            autocomplete="url" autofocus>

        @error('url')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-12">
    <div class="form-group text-center mx-auto col-md-3">
        <label class="text-white"></label>
        <button type="submit" class="btn col-md-12 btn-danger">
            Salvar
        </button>

    </div>

</div>
</form>
