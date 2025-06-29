<!-- PUBLIC – Produtos & Serviços
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->
<div class="container-fluid p-0">

  <!-- HERO / INTRODUÇÃO ----------------------------------- -->
  <section class="py-5 text-center bg-primary bg-gradient position-relative overflow-hidden">
    <div class="container position-relative" style="z-index:2">
      <h1 class="display-5 fw-bold text-white mb-3">Produtos &amp; Serviços</h1>
      <p class="lead text-white-50 mx-auto" style="max-width:740px">
        Uma suíte completa para gerenciar <strong>projetos acadêmicos</strong>
        do início ao fim — pensado para alunos, professores e coordenação.
      </p>
      <a href="<?= baseUrl() ?>login/cadastro" class="btn btn-light btn-lg shadow-sm mt-3">
        Experimente grátis
      </a>
    </div>

    </section>

  <!-- RECURSOS PRINCIPAIS ---------------------------------- -->
  <section class="py-5">
    <div class="container">
      <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
          <h2 class="fw-bold mb-3">O que a plataforma oferece?</h2>
          <p class="text-muted">Funcionalidades que poupam tempo e elevam a qualidade do acompanhamento acadêmico.</p>
        </div>
      </div>

      <div class="row g-4">

        <!-- Cards de serviço -->
        <?php
          $servicos = [
            ['Gerenciamento de Projetos', 'Crie, atualize e acompanhe projetos em tempo real', 'project-diagram'],
            ['Controle de Entregas', 'Envio de arquivos e registro automático de prazos', 'file-upload'],
            ['Reuniões Agendadas', 'Planeje encontros e gere atas num clique', 'handshake'],
            ['Gestão de Usuários', 'Permissões específicas para admins, docentes e discentes', 'user-cog'],
            ['Relatórios &amp; Métricas', 'Dashboards e exportações de progresso', 'chart-bar'],
          ];
          foreach ($servicos as $s):
        ?>
        <div class="col-md-6 col-lg-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
              <i class="fas fa-<?= $s[2] ?> fa-2x text-primary mb-3"></i>
              <h5 class="card-title"><?= $s[0] ?></h5>
              <p class="card-text small text-muted"><?= $s[1] ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>

      </div><!-- /.row -->
    </div>
  </section>

  <!-- CTA FINAL ------------------------------------------- -->
  <section class="py-5 bg-light">
    <div class="container text-center">
      <h3 class="fw-bold mb-3">Pronto para agilizar seus projetos?</h3>
      <p class="text-muted mb-4">
        Professores e alunos da FASM têm acesso gratuito. Cadastre-se e comece hoje mesmo!
      </p>
      <a href="<?= baseUrl() ?>login" class="btn btn-primary btn-lg px-4 me-2 shadow">Entrar</a>
      <a href="<?= baseUrl() ?>login/cadastro" class="btn btn-outline-primary btn-lg px-4">Criar conta</a>
    </div>
  </section>

</div><!-- /.container-fluid -->
