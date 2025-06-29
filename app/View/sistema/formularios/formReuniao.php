<?php
use Core\Library\Session;

$nivel = (int) Session::get('userNivel');
$proj  = new \App\Model\ProjetoModel();

if ($nivel >= 12 && $nivel <= 21) {
  $profId = (new \App\Model\ProfessorModel())
              ->db->where('usuario_id', Session::get('userId'))
              ->first()['id'] ?? 0;
  $projetos = $proj->db->where('professor_id', $profId)->orderBy('titulo')->findAll();
} else {
  $projetos = $proj->lista('titulo');
}
$projSel = setValor('projeto_id');
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      <div class="card shadow-sm">
        <!-- Cabeçalho -->
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Reunião <?= formSubTitulo($this->request->getAction()) ?></h3>
          <a href="<?= baseUrl() . $this->request->getController() ?>" class="btn btn-outline-light btn-sm">Voltar</a>
        </div>

        <div class="card-body px-4 py-5">
          <form method="POST" action="<?= $this->request->formAction() ?>">
            <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

            <!-- Seção principal -->
            <h6 class="section-title">Informações da reunião</h6>
            <hr class="section-divider"/>

            <div class="row g-4">
              <!-- Projeto -->
              <div class="col-12 col-lg-6">
                <label class="form-label">Projeto *</label>
                <?php if ($nivel >= 12 && $nivel <= 21 && count($projetos) === 1): ?>
                  <div class="form-control-plaintext"><?= $projetos[0]['titulo'] ?></div>
                  <input type="hidden" name="projeto_id" value="<?= $projetos[0]['id'] ?>">
                <?php else: ?>
                  <select name="projeto_id" class="form-select" required>
                    <option value="">Selecione…</option>
                    <?php foreach ($projetos as $p): ?>
                      <option value="<?= $p['id'] ?>" <?= $projSel==$p['id']?'selected':'' ?>><?= $p['titulo'] ?></option>
                    <?php endforeach; ?>
                  </select>
                <?php endif; ?>
                <?= setMsgFilderError('projeto_id') ?>
              </div>

              <!-- Data -->
              <div class="col-6 col-lg-3">
                <label class="form-label">Data *</label>
                <input id="data" name="data" type="date" class="form-control" value="<?= setValor('data') ?>" required>
                <?= setMsgFilderError('data') ?>
              </div>

              <!-- Hora -->
              <div class="col-6 col-lg-3">
                <label class="form-label">Hora *</label>
                <input id="hora" name="hora" type="time" class="form-control" value="<?= setValor('hora') ?>" required>
                <?= setMsgFilderError('hora') ?>
              </div>

              <!-- Local -->
              <div class="col-12 col-lg-8">
                <label class="form-label">Local *</label>
                <input id="local" name="local" type="text" maxlength="60" class="form-control" value="<?= setValor('local') ?>" required>
                <?= setMsgFilderError('local') ?>
              </div>

              <!-- Pauta -->
              <div class="col-12">
                <label class="form-label">Pauta *</label>
                <input id="pauta" name="pauta" type="text" maxlength="120" class="form-control" value="<?= setValor('pauta') ?>" required>
                <?= setMsgFilderError('pauta') ?>
              </div>

              <!-- Observações -->
              <div class="col-12">
                <label class="form-label">Observações</label>
                <textarea id="observacoes" name="observacoes" rows="3" class="form-control"><?= setValor('observacoes') ?></textarea>
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
