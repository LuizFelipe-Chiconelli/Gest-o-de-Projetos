<?= formTitulo('Professor') ?>

<form method="POST" action="<?= $this->request->formAction() ?>">

  <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

  <div class="row m-2">

    <!-- NOME --------------------------------------------------------- -->
    <div class="mb-3 col-lg-6">
      <label class="form-label">Nome *</label>
      <input type="text" name="nome" maxlength="60"
             class="form-control"
             value="<?= setValor('nome') ?>" required autofocus>
      <?= setMsgFilderError('nome') ?>
    </div>

    <!-- EMAIL -------------------------------------------------------- -->
    <div class="mb-3 col-lg-6">
      <label class="form-label">Email *</label>
      <input type="email" name="email" maxlength="150"
             class="form-control"
             value="<?= setValor('email') ?>" required>
      <?= setMsgFilderError('email') ?>
    </div>

    <!-- ESPECIALIDADE ----------------------------------------------- -->
    <div class="mb-3 col-lg-6">
      <label class="form-label">Especialidade *</label>
      <input type="text" name="especialidade" maxlength="50"
             class="form-control"
             value="<?= setValor('especialidade') ?>" required>
      <?= setMsgFilderError('especialidade') ?>
    </div>

    <!-- ÁREA (opcional) --------------------------------------------- -->
    <div class="mb-3 col-lg-6">
      <label class="form-label">Área (opcional)</label>
      <input type="text" name="area" maxlength="50"
             class="form-control"
             value="<?= setValor('area') ?>">
      <?= setMsgFilderError('area') ?>
    </div>

    <!-- STATUS ------------------------------------------------------- -->
    <div class="mb-3 col-lg-4">
      <label class="form-label">Status *</label>
      <select name="statusRegistro" class="form-select" required>
        <option value="1" <?= setValor('statusRegistro','1')=='1'?'selected':'' ?>>Ativo</option>
        <option value="2" <?= setValor('statusRegistro')=='2'?'selected':'' ?>>Inativo</option>
      </select>
      <?= setMsgFilderError('statusRegistro') ?>
    </div>

  </div>

  <div class="m-3">
    <?= formButton() ?>
  </div>
</form>
