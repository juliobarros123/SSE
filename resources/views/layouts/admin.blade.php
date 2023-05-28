@if (Auth::user()->vc_tipoUtilizador == 'Estagiario')
    @include('layouts._includes.adminHeaderEstagiario')
@else
    @include('layouts._includes.adminHeader')
@endif

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        @yield('conteudo')
    </section>

</div>

@include('layouts._includes.adminFooter')
z