<?php
// formEntrega.php
use Core\Library\Session;

$nivel   = (int) Session::get('userNivel');
$projSel = $_GET['proj'] ?? setValor('projeto_id');

if ($nivel === 31) {
    $projetos = (new \App\Model\ProjetoAlunoModel)
                   ->listarProjetosDoAluno(Session::get('userId'));
} else {
    $projetos = (new \App\Model\ProjetoModel)->lista('titulo');
}
if (empty($projetos) && $projSel) {
    $projetos[] = (new \App\Model\ProjetoModel)->getById($projSel);
}
?>

<div class="container py-5 mt-4">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-10 col-xl-8">
      <div class="border rounded bg-white p-5 shadow-sm">

        <!-- HEADER -->
        <div class="row align-items-center mb-5">
          <div class="col-12 col-lg-6">
            <h4 class="mb-0">Entrega</h4>
          </div>
        </div>

        <!-- FORMULÁRIO -->
        <form method="POST"
              action="<?= $this->request->formAction() ?>"
              enctype="multipart/form-data">

          <input type="hidden" name="id" value="<?= setValor('id',0) ?>">
          <?php if ($this->request->getAction() !== 'insert'): ?>
            <input type="hidden" name="nomeArquivo" value="<?= setValor('arquivo') ?>">
          <?php endif; ?>

          <div class="row g-4">
            <!-- Projeto (8 col) / Data (4 col) -->
            <div class="col-12 col-lg-8">
              <label class="form-label">Projeto *</label>
              <select name="projeto_id"
                      class="form-select border-primary" required>
                <option value="">…</option>
                <?php foreach ($projetos as $p): ?>
                  <option value="<?= $p['id'] ?>"
                          <?= $projSel == $p['id'] ? 'selected' : '' ?>>
                    <?= $p['titulo'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-12 col-lg-4">
              <label class="form-label">Data *</label>
              <input type="date" name="data"
                     class="form-control border-primary"
                     value="<?= setValor('data') ?>" required>
            </div>

            <!-- Descrição (8 col) / Arquivo (4 col) -->
            <div class="col-12 col-lg-8">
              <label class="form-label">Descrição *</label>
              <input type="text" name="descricao" maxlength="120"
                     class="form-control border-primary"
                     value="<?= setValor('descricao') ?>" required>
            </div>
            <div class="col-12 col-lg-4">
              <label class="form-label">Arquivo (opcional)</label>
              <input type="file" name="arquivo"
                     class="form-control border-primary">
              <?php if (setValor('arquivo')): ?>
                <small class="text-muted">Atual: <?= setValor('arquivo') ?></small>
              <?php endif; ?>
            </div>

            <!-- Status (4 col) -->
            <div class="col-12 col-lg-4">
              <label class="form-label">Status *</label>
              <select name="status"
                      class="form-select border-primary" required>
                <?php foreach (['Pendente','Entregue','Atrasado','Finalizado'] as $st): ?>
                  <option <?= setValor('status','Pendente') == $st ? 'selected' : '' ?>>
                    <?= $st ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="text-center mt-5">
            <?= formButton() ?>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
