<?php
use Core\Library\Session;

$nivel   = (int) Session::get('userNivel');
$projSel = $_GET['proj'] ?? setValor('projeto_id');

// projetos conforme perfil
if ($nivel === 31) {
  $projetos = (new \App\Model\ProjetoAlunoModel)->listarProjetosDoAluno(Session::get('userId'));
} else {
  $projetos = (new \App\Model\ProjetoModel)->lista('titulo');
}
if (empty($projetos) && $projSel) {
  $projetos[] = (new \App\Model\ProjetoModel)->getById($projSel);
}
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      <div class="card shadow-sm">
        <!-- Cabeçalho -->
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Entrega <?= formSubTitulo($this->request->getAction()) ?></h3>
          <a href="<?= baseUrl() . $this->request->getController() ?>" class="btn btn-outline-light btn-sm">Voltar</a>
        </div>

        <div class="card-body px-4 py-5">
          <form method="POST" action="<?= $this->request->formAction() ?>" enctype="multipart/form-data">
            <input type="hidden" name="id"          value="<?= setValor('id',0) ?>">
            <?php if ($this->request->getAction() !== 'insert'): ?>
              <input type="hidden" name="nomeArquivo" value="<?= setValor('arquivo') ?>">
            <?php endif; ?>

            <!-- Seção principal -->
            <h6 class="section-title">Dados da entrega</h6>
            <hr class="section-divider"/>

            <div class="row g-4">
              <!-- Projeto -->
              <div class="col-12 col-lg-8">
                <label class="form-label">Projeto *</label>
                <select name="projeto_id" class="form-select" required>
                  <option value="">Selecione…</option>
                  <?php foreach ($projetos as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= $projSel==$p['id']?'selected':'' ?>><?= $p['titulo'] ?></option>
                  <?php endforeach; ?>
                </select>
                <?= setMsgFilderError('projeto_id') ?>
              </div>

              <!-- Data -->
              <div class="col-12 col-lg-4">
                <label class="form-label">Data *</label>
                <input name="data" type="date" class="form-control" value="<?= setValor('data') ?>" required>
                <?= setMsgFilderError('data') ?>
              </div>

              <!-- Descrição -->
              <div class="col-12 col-lg-8">
                <label class="form-label">Descrição *</label>
                <input name="descricao" type="text" maxlength="120" class="form-control" value="<?= setValor('descricao') ?>" required>
                <?= setMsgFilderError('descricao') ?>
              </div>

              <!-- Arquivo -->
              <div class="col-12 col-lg-4">
                <label class="form-label">Arquivo (opcional)</label>
                <input name="arquivo" type="file" class="form-control">
                <?php if (setValor('arquivo')): ?>
                  <small class="text-muted d-block mt-1">Atual: <?= setValor('arquivo') ?></small>
                <?php endif; ?>
              </div>

              <!-- Status -->
              <div class="col-12 col-lg-4">
                <label class="form-label">Status *</label>
                <select name="status" class="form-select" required>
                  <?php foreach (['Pendente','Atrasado','Finalizado'] as $st): ?>
                    <option <?= setValor('status','Pendente')==$st?'selected':'' ?>><?= $st ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div><!-- /.row -->

            <!-- Botões padrão -->
            <div class="text-center pt-5">
              <?= formButton() ?>
            </div>
          </form>
        </div><!-- /.card-body -->
      </div><!-- /.card -->
    </div>
  </div>
</div>
