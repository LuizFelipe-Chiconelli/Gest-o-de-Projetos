<div class="container py-5">

  <!-- SAUDAÇÃO -->
  <div class="row mb-5">
    <div class="col-lg-8 mx-auto text-center">
      <h2 class="fw-bold text-primary">Bem‑vindo(a) ao seu painel, Aluno!</h2>
      <p class="text-muted mb-0">
        Acompanhe seus projetos, entregue atividades e fique em dia com as próximas reuniões.
      </p>
    </div>
  </div>

  <!-- CARDS DE AÇÃO -->
  <div class="row g-4">

    <!-- Projetos Ativos -->
    <div class="col-sm-6 col-lg-4">
      <a href="<?= baseUrl() ?>sistema/listaAlunoProjReuniao" class="card card-action shadow-sm text-center h-100 text-decoration-none">
        <div class="card-body">
          <i class="fas fa-project-diagram fa-2x text-primary mb-3"></i>
          <h6 class="card-title mb-2">Meus Projetos</h6>
          <p class="small text-muted mb-0">Veja prazos, professores e status</p>
        </div>
      </a>
    </div>

    <!-- Entregas -->
    <div class="col-sm-6 col-lg-4">
      <a href="<?= baseUrl() ?>entrega" class="card card-action shadow-sm text-center h-100 text-decoration-none">
        <div class="card-body">
          <i class="fas fa-file-upload fa-2x text-primary mb-3"></i>
          <h6 class="card-title mb-2">Entregar arquivos</h6>
          <p class="small text-muted mb-0">Envie relatórios e versões atualizadas</p>
        </div>
      </a>
    </div>

    <!-- Reuniões -->
    <div class="col-sm-6 col-lg-4">
      <a href="<?= baseUrl() ?>reuniao" class="card card-action shadow-sm text-center h-100 text-decoration-none">
        <div class="card-body">
          <i class="fas fa-handshake fa-2x text-primary mb-3"></i>
          <h6 class="card-title mb-2">Minhas Reuniões</h6>
          <p class="small text-muted mb-0">Datas, pautas e atas disponíveis</p>
        </div>
      </a>
    </div>

  </div><!-- /.row -->

  <!-- AVISO RÁPIDO -->
  <div class="alert alert-info mt-5 d-flex align-items-center" role="alert">
    <i class="fas fa-info-circle me-2"></i>
    Lembre‑se de verificar as atualizações de prazo e comparecer às reuniões agendadas.
  </div>

</div>

<!-- Hover suave (já usado nos outros painéis) -->
<style>
.card-action:hover{
  transform:translateY(-4px);
  box-shadow:0 6px 22px rgba(0,0,0,.1);
  transition:all .2s;
}
</style>
