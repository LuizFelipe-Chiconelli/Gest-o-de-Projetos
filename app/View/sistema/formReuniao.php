<?= formTitulo('Reunião') ?>

<form method="POST" action="<?= $this->request->formAction() ?>">

  <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

  <div class="row m-2">

    <!-- PROJETO ---------------------------------------------------- -->
    <?php
    $proj = new \App\Model\ProjetoModel();
    $projetos = $proj->lista('titulo');
    ?>
    <div class="mb-3 col-6">
      <label class="form-label">Projeto *</label>
      <select name="projeto_id" class="form-select" required>
          <option value="">…</option>
          <?php foreach($projetos as $p): ?>
            <option value="<?=$p['id']?>"
                    <?= setValor('projeto_id')==$p['id']?'selected':'' ?>>
                <?=$p['titulo']?>
            </option>
          <?php endforeach; ?>
      </select>
      <?= setMsgFilderError('projeto_id') ?>
    </div>

    <div class="mb-3 col-4 col-lg-2">
      <label class="form-label" for="data">Data *</label>
      <input type="date" id="data" name="data"
             class="form-control" value="<?= setValor('data') ?>" required>
      <?= setMsgFilderError('data') ?>
    </div>

    <div class="mb-3 col-4 col-lg-2">
      <label class="form-label" for="hora">Hora *</label>
      <input type="time" id="hora" name="hora"
             class="form-control" value="<?= setValor('hora') ?>" required>
      <?= setMsgFilderError('hora') ?>
    </div>

    <div class="mb-3 col-4 col-lg-4">
      <label class="form-label" for="local">Local *</label>
      <input type="text" id="local" name="local"
             class="form-control" maxlength="60"
             value="<?= setValor('local') ?>" required>
      <?= setMsgFilderError('local') ?>
    </div>

    <div class="mb-3 col-12">
      <label class="form-label" for="pauta">Pauta *</label>
      <input type="text" id="pauta" name="pauta"
             class="form-control" maxlength="120"
             value="<?= setValor('pauta') ?>" required>
      <?= setMsgFilderError('pauta') ?>
    </div>

    <div class="mb-3 col-12">
      <label class="form-label" for="observacoes">Observações</label>
      <textarea id="observacoes" name="observacoes" rows="3"
                class="form-control"><?= setValor('observacoes') ?></textarea>
    </div>

  </div>

  <div class="m-3">
    <?= formButton() ?>
  </div>
</form>
