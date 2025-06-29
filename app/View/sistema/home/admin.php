<div class="container py-5">

  <!-- SAUDAÇÃO -->
  <div class="row mb-5">
    <div class="col-lg-8 mx-auto text-center">
      <h2 class="fw-bold text-primary">Bem-vindo, Administrador!</h2>
      <p class="text-muted mb-0">
        Você possui acesso completo ao GP&nbsp;System.<br>
        Selecione uma opção para começar.
      </p>
    </div>
  </div>

  <!-- CARDS DE AÇÃO -->
  <div class="row g-4">

    <!-- Usuários -->
    <div class="col-sm-6 col-lg-3">
      <a href="<?= baseUrl() ?>usuario" class="card card-action shadow-sm text-center h-100 text-decoration-none">
        <div class="card-body">
          <i class="fas fa-users-cog fa-2x text-primary mb-3"></i>
          <h6 class="card-title mb-2">Gerenciar&nbsp;Usuários</h6>
          <p class="small text-muted mb-0">Professores, Alunos e Admins</p>
        </div>
      </a>
    </div>

    <!-- Projetos -->
    <div class="col-sm-6 col-lg-3">
      <a href="<?= baseUrl() ?>projeto" class="card card-action shadow-sm text-center h-100 text-decoration-none">
        <div class="card-body">
          <i class="fas fa-project-diagram fa-2x text-primary mb-3"></i>
          <h6 class="card-title mb-2">Projetos</h6>
          <p class="small text-muted mb-0">Cadastrar, editar e acompanhar</p>
        </div>
      </a>
    </div>

    <!-- Reuniões -->
    <div class="col-sm-6 col-lg-3">
      <a href="<?= baseUrl() ?>reuniao" class="card card-action shadow-sm text-center h-100 text-decoration-none">
        <div class="card-body">
          <i class="fas fa-handshake fa-2x text-primary mb-3"></i>
          <h6 class="card-title mb-2">Reuniões</h6>
          <p class="small text-muted mb-0">Agendamento e atas</p>
        </div>
      </a>
    </div>

    <!-- Entregas -->
    <div class="col-sm-6 col-lg-3">
      <a href="<?= baseUrl() ?>entrega" class="card card-action shadow-sm text-center h-100 text-decoration-none">
        <div class="card-body">
          <i class="fas fa-file-upload fa-2x text-primary mb-3"></i>
          <h6 class="card-title mb-2">Entregas</h6>
          <p class="small text-muted mb-0">Arquivos e revisões</p>
        </div>
      </a>
    </div>

  </div><!-- /.row -->

  <!-- AVISO RÁPIDO -->
  <div class="alert alert-info mt-5 d-flex align-items-center" role="alert">
    <i class="fas fa-info-circle me-2"></i>
    <div>
      Precisa de ajuda? Consulte a documentação ou entre em contato com o suporte
      <a href="mailto:suporte@fasm.edu.br" class="alert-link">suporte@fasm.edu.br</a>.
    </div>
  </div>

</div>

<!-- Pequeno CSS opcional de “hover” para os cards (coloque em forms.css ou similar) -->
<style>
.card-action:hover{
  transform:translateY(-4px);
  box-shadow:0 6px 22px rgba(0,0,0,.1);
  transition:all .2s;
}
</style>
