<!-- ============================================================
     PÁGINA: QUEM SOMOS
     ============================================================ -->
<div class="container-fluid p-0">

  <!-- HERO ----------------------------------------------------- -->
  <section class="bg-primary bg-gradient text-white py-5 mb-5">
    <div class="container text-center">
      <h1 class="display-5 fw-bold mb-3">Quem somos</h1>
      <p class="lead opacity-75 mx-auto" style="max-width: 680px;">
        Uma equipe apaixonada por educação e tecnologia formando pontes entre conhecimento e prática.
      </p>
    </div>
  </section>

  <!-- MISSÃO / VISÃO / VALORES --------------------------------- -->
  <section class="container mb-5">
    <div class="row text-center mb-5">
      <div class="col-lg-8 mx-auto">
        <h2 class="fw-bold text-primary">Nossa essência</h2>
        <p class="text-muted">O propósito que guia cada linha de código do GP System.</p>
      </div>
    </div>

    <div class="row g-4 text-center">
      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body">
            <i class="fas fa-bullseye fa-2x text-primary mb-3"></i>
            <h5 class="fw-semibold">Missão</h5>
            <p class="small text-muted">
              Facilitar a gestão de projetos acadêmicos, promovendo organização,
              transparência e colaboração entre alunos e docentes.
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body">
            <i class="fas fa-eye fa-2x text-primary mb-3"></i>
            <h5 class="fw-semibold">Visão</h5>
            <p class="small text-muted">
              Ser referência nacional em plataformas educacionais que unem teoria
              e prática de forma simples e intuitiva.
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body">
            <i class="fas fa-heart fa-2x text-primary mb-3"></i>
            <h5 class="fw-semibold">Valores</h5>
            <p class="small text-muted">
              Inovação, colaboração, acessibilidade e melhoria contínua em cada
              entrega de projeto.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- HISTÓRIA -------------------------------------------------- -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row align-items-center gy-4">
        <!-- IMAGEM -->
        <div class="col-md-6 order-md-1">
          <!-- SE TIVER ARQUIVO LOCAL, USE-O AQUI -->
          <!-- <img src="<?= baseUrl() ?>assets/img/about-journey.svg" class="img-fluid rounded shadow-sm" alt="Painel GP System"> -->

          <!-- PLACEHOLDER UNSPLASH (pode manter se não quiser subir imagem agora) -->
          <img src="https://images.unsplash.com/photo-1528372444006-1bfc81acab02?auto=format&fit=crop&w=900&q=60"
              class="img-fluid rounded shadow-sm" alt="Equipe trabalhando em projeto">
        </div>

        <!-- TEXTO -->
        <div class="col-md-6 order-md-2">
          <h3 class="fw-bold text-primary mb-3">Nossa jornada</h3>
          <p>
            Tudo começou como um projeto de <strong>TCC</strong> dentro da Faculdade Santa Marcelina —
            hoje evoluiu para uma plataforma completa, capaz de acompanhar centenas de projetos por semestre.
          </p>
          <p>
            A cada ciclo letivo incorporamos feedback de alunos e professores,
            garantindo que o sistema continue <em>feito por acadêmicos, para acadêmicos</em>.
          </p>
        </div>
      </div>
    </div>
  </section>


  <!-- EQUIPE ---------------------------------------------------- -->
  <section class="container py-5">
    <div class="row text-center mb-5">
      <div class="col-lg-8 mx-auto">
        <h2 class="fw-bold text-primary">Nosso time</h2>
        <p class="text-muted">Docentes, alunos e desenvolvedores unidos na mesma missão.</p>
      </div>
    </div>

    <div class="row g-4 justify-content-center">

      <!-- exemplo de membro -->
      <div class="col-6 col-sm-4 col-lg-3">
        <div class="card border-0 shadow-sm">
          <img src="<?= baseUrl() ?>assets/img/team-placeholder.jpg" class="card-img-top" alt="">
          <div class="card-body text-center p-3">
            <h6 class="fw-semibold mb-0">Prof. Audecir</h6>
            <small class="text-muted">Coordenador</small>
          </div>
        </div>
      </div>

      <!-- repita ou gere dinamicamente -->
      <!-- ... -->

    </div>
  </section>

  <!-- CALL TO ACTION FINAL ------------------------------------- -->
  <section class="py-5 bg-primary bg-gradient text-white text-center">
    <div class="container">
      <h3 class="fw-bold mb-3">Pronto para fazer parte dessa história?</h3>
      <p class="lead opacity-75 mb-4">Junte-se ao GP System e transforme ideias em projetos de sucesso.</p>
      <a href="<?= baseUrl() ?>login/cadastro"
         class="btn btn-light btn-lg px-4">Criar conta grátis</a>
    </div>
  </section>

</div>
