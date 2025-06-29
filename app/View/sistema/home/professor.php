<div class="container py-5">

  <!-- SAUDAÇÃO -->
  <div class="row mb-5">
    <div class="col-lg-8 mx-auto text-center">
      <h2 class="fw-bold text-primary">Olá, Professor(a)!</h2>
      <p class="text-muted mb-0">
        Gerencie seus projetos, alunos e reuniões de forma prática dentro do GP&nbsp;System.
      </p>
    </div>
  </div>

  <!-- CARDS DE AÇÃO -->
  <div class="row g-4">

    <!-- Meus Projetos -->
    <div class="col-sm-6 col-lg-3">
      <a href="<?= baseUrl() ?>projeto" class="card card-action shadow-sm text-center h-100 text-decoration-none">
        <div class="card-body">
          <i class="fas fa-project-diagram fa-2x text-primary mb-3"></i>
          <h6 class="card-title mb-2">Meus Projetos</h6>
          <p class="small text-muted mb-0">Crie e acompanhe os projetos da turma</p>
        </div>
      </a>
    </div>

    <!-- Entregas dos Alunos -->
    <div class="col-sm-6 col-lg-3">
      <a href="<?= baseUrl() ?>entrega" class="card card-action shadow-sm text-center h-100 text-decoration-none">
        <div class="card-body">
          <i class="fas fa-file-upload fa-2x text-primary mb-3"></i>
          <h6 class="card-title mb-2">Entregas</h6>
          <p class="small text-muted mb-0">Avalie relatórios, códigos e arquivos</p>
        </div>
      </a>
    </div>

    <!-- Reuniões -->
    <div class="col-sm-6 col-lg-3">
      <a href="<?= baseUrl() ?>reuniao" class="card card-action shadow-sm text-center h-100 text-decoration-none">
        <div class="card-body">
          <i class="fas fa-handshake fa-2x text-primary mb-3"></i>
          <h6 class="card-title mb-2">Reuniões</h6>
          <p class="small text-muted mb-0">Agende e registre atas facilmente</p>
        </div>
      </a>
    </div>

    <!-- Alunos -->
    <div class="col-sm-6 col-lg-3">
      <a href="<?= baseUrl() ?>aluno" class="card card-action shadow-sm text-center h-100 text-decoration-none">
        <div class="card-body">
          <i class="fas fa-user-graduate fa-2x text-primary mb-3"></i>
          <h6 class="card-title mb-2">Alunos</h6>
          <p class="small text-muted mb-0">Visualize desempenho e participação</p>
        </div>
      </a>
    </div>

  </div><!-- /.row -->

  <!-- INFO RÁPIDA -->
  <div class="alert alert-info mt-5 d-flex align-items-center" role="alert">
    <i class="fas fa-info-circle me-2"></i>
    Mantenha suas reuniões e entregas sempre atualizadas para que os alunos
    acompanhem o progresso em tempo real.
  </div>

</div>

<!-- Hover suave para cartões (adicione em forms.css ou equivalente) -->
<style>
.card-action:hover{
  transform:translateY(-4px);
  box-shadow:0 6px 22px rgba(0,0,0,.1);
  transition:all .2s;
}
</style>
