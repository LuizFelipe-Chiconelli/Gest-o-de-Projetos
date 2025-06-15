<?= formTitulo('Entrega') ?>

<form method="POST" action="<?= $this->request->formAction(); ?>">
  <!-- id e nome do arquivo atual -->
  <input type="hidden" name="id" value="<?= setValor('id',0) ?>">
  <input type="hidden" name="nomeArquivo" value="<?= setValor('arquivo') ?>">

  <div class="row m-2">
    <div class="mb-3 col-3">
      <label class="form-label">Projeto ID *</label>
      <input type="number" name="projeto_id" class="form-control"
             value="<?= setValor('projeto_id') ?>" required>
      <?= setMsgFilderError('projeto_id') ?>
    </div>

    <div class="mb-3 col-3">
      <label class="form-label">Data *</label>
      <input type="date" name="data" class="form-control"
             value="<?= setValor('data') ?>" required>
      <?= setMsgFilderError('data') ?>
    </div>

    <div class="mb-3 col-6">
      <label class="form-label">Descrição *</label>
      <input type="text" name="descricao" class="form-control"
             maxlength="120" value="<?= setValor('descricao') ?>" required>
      <?= setMsgFilderError('descricao') ?>
    </div>

    <div class="mb-3 col-6">
      <label class="form-label">Arquivo (PDF / ZIP)</label>
      <input type="file" name="arquivo" class="form-control">
      <?php if (setValor('arquivo')): ?>
        <small class="text-muted">Atual: <?= setValor('arquivo') ?></small>
      <?php endif; ?>
    </div>

    <div class="mb-3 col-3">
      <label class="form-label">Status *</label>
      <select name="status" class="form-select" required>
        <?php foreach(['Pendente','Entregue','Atrasado'] as $st): ?>
          <option <?= setValor('status','Pendente')==$st?'selected':'' ?>><?= $st ?></option>
        <?php endforeach; ?>
      </select>
      <?= setMsgFilderError('status') ?>
    </div>
  </div>

  <div class="m-3 text-end">
    <?= formButton() ?>
  </div>
</form>
