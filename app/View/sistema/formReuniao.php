<?php
/*
 | Formulário de Reunião
 | – Campos alinhados com Bootstrap Grid (row/col)
 | – Helpers setValor() e setMsgFilderError() para repovoar e exibir erros
*/
?>

<?= formTitulo('Reunião') ?>

<form method="POST" action="<?= $this->request->formAction(); ?>">

  <!-- id oculto (0 = novo) -->
  <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

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

    <div class="mb-3 col-3">
      <label class="form-label">Hora *</label>
      <input type="time" name="hora" class="form-control"
             value="<?= setValor('hora') ?>" required>
      <?= setMsgFilderError('hora') ?>
    </div>

    <div class="mb-3 col-3">
      <label class="form-label">Local *</label>
      <input type="text" name="local" class="form-control"
             maxlength="60" value="<?= setValor('local') ?>" required>
      <?= setMsgFilderError('local') ?>
    </div>

    <div class="mb-3 col-12">
      <label class="form-label">Pauta *</label>
      <input type="text" name="pauta" class="form-control"
             maxlength="120" value="<?= setValor('pauta') ?>" required>
      <?= setMsgFilderError('pauta') ?>
    </div>

    <div class="mb-3 col-12">
      <label class="form-label">Observações</label>
      <textarea name="observacoes" class="form-control" rows="3">
        <?= setValor('observacoes') ?>
      </textarea>
    </div>

  </div>

  <div class="m-3 text-end">
    <?= formButton() ?>
  </div>
</form>
