<!-- PUBLIC HOME – Bem‑vindo -------------------------------------------------->
<div class="container-fluid p-0">

  <!-- HERO (imagem + gradiente) ------------------------------------------ -->
  <section class="hero-gpsystem d-flex align-items-center text-center text-white">
    <div class="container">
      <h1 class="display-5 fw-bold mb-3">Gerencie seus projetos com agilidade</h1>
      <p class="lead mx-auto mb-4" style="max-width:640px;">
        Cadastre equipes, acompanhe entregas e mantenha todas as informações do seu
        TCC em um único lugar — de graça!
      </p>

      <!-- CTAs -->
      <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="<?= baseUrl() ?>login" class="btn btn-primary btn-lg shadow">Entrar / Acessar</a>
        <a href="<?= baseUrl() ?>login/cadastro" class="btn btn-outline-light btn-lg shadow-sm">Criar conta</a>
      </div>
    </div>
  </section>

  <!-- SEÇÃO DE RECURSOS / DESTAQUES -------------------------------------- -->
  <section class="py-5">
    <div class="container">
      <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
          <h2 class="fw-bold">Por que usar o GP System?</h2>
          <p class="text-muted">Recursos focados no universo acadêmico para professores e alunos.</p>
        </div>
      </div>

      <div class="row g-4">
        <!-- Card 1 -->
        <div class="col-md-6 col-lg-3">
          <div class="card border-0 h-100 shadow-sm">
            <div class="card-body text-center">
              <i class="fas fa-project-diagram fa-2x text-primary mb-3"></i>
              <h5 class="card-title">Projetos &amp; Equipes</h5>
              <p class="card-text small text-muted">
                Crie projetos, defina áreas de estudo e acompanhe a evolução da turma sem perder prazos.
              </p>
            </div>
          </div>
        </div>
        <!-- Card 2 -->
        <div class="col-md-6 col-lg-3">
          <div class="card border-0 h-100 shadow-sm">
            <div class="card-body text-center">
              <i class="fas fa-handshake fa-2x text-primary mb-3"></i>
              <h5 class="card-title">Reuniões integradas</h5>
              <p class="card-text small text-muted">
                Agende reuniões, registre pautas e envie atas para todos os participantes automaticamente.
              </p>
            </div>
          </div>
        </div>
        <!-- Card 3 -->
        <div class="col-md-6 col-lg-3">
          <div class="card border-0 h-100 shadow-sm">
            <div class="card-body text-center">
              <i class="fas fa-file-upload fa-2x text-primary mb-3"></i>
              <h5 class="card-title">Entregas online</h5>
              <p class="card-text small text-muted">
                Faça upload de documentos, versões de código ou relatórios; tudo fica salvo com histórico.
              </p>
            </div>
          </div>
        </div>
        <!-- Card 4 -->
        <div class="col-md-6 col-lg-3">
          <div class="card border-0 h-100 shadow-sm">
            <div class="card-body text-center">
              <i class="fas fa-chart-line fa-2x text-primary mb-3"></i>
              <h5 class="card-title">Dashboard de progresso</h5>
              <p class="card-text small text-muted">
                Visualize status, pendências e metas em tempo real com gráficos simples e intuitivos.
              </p>
            </div>
          </div>
        </div>
      </div><!-- /.row -->
    </div>
  </section>

  <!-- CTA FINAL / SOBRE --------------------------------------------------- -->
  <section class="py-5 bg-primary bg-gradient text-white">
    <div class="container text-center">
      <h3 class="mb-3">Pronto para impulsionar seus projetos?</h3>
      <p class="lead opacity-75 mb-4">Professores e alunos da FASM têm acesso gratuito à plataforma.</p>
      <a href="<?= baseUrl() ?>login" class="btn btn-light btn-lg px-4 me-2">Acessar agora</a>
      <a href="<?= baseUrl() ?>site/quemSomos" class="btn btn-outline-light btn-lg px-4">Saiba mais</a>
    </div>
  </section>

</div><!-- /.container-fluid -->
