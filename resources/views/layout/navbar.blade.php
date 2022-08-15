<nav class="navbar navbar-expand-sm navbar-light bg-light" style="height: 120px; border-bottom: solid 5px var(--p-color)">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">
          <img class="img-fluid logo" src="/storage/img/inclusao-digital.png" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse fw-bold bg-light" id="navbarSupportedContent" style="z-index: 999;">
        <div class="navbar-nav p-4" style="width: 100%;display: flex;justify-content: space-around;">
            <a class="p-color nav-link @yield('home-ativo')" aria-current="page" href="/">O Projeto</a>
            <a class="p-color nav-link @yield('faq-ativo')" href="/faq">FAQS</a>
            <a class="p-color nav-link @yield('sec-ativo')" href="/seguranca">Segurança</a>
            <a class="p-color nav-link @yield('bucus-ativo')" href="/busca-curadoria">Busca/Curadoria</a>
            <a class="p-color nav-link @yield('qs-ativo')" href="/quem-somos">Quem somos</a>
        </div>
      </div>
    </div>
</nav>
