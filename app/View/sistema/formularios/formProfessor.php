<?php
$isInsert = empty($_POST['id']) || $_POST['id'] == 0;
?>
<div class="container py-4 mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-10 col-xl-8">
      <div class="border rounded bg-white p-5 shadow-sm">

        <div class="row align-items-center mb-5">
          <div class="col-12 col-lg-6">
            <h4 class="mb-0">Professor</h4>
          </div>
        </div>

        <form method="POST" action="<?= $this->request->formAction() ?>">
          <input type="hidden" name="id" value="<?= setValor('id',0) ?>">
          <input type="hidden" name="usuario_id" value="<?= setValor('usuario_id') ?>">

          <div class="row g-4">

            <!-- Nome -->
            <div class="col-12 col-lg-6">
              <label class="form-label">Nome *</label>
              <input type="text" name="nome" maxlength="60"
                     class="form-control border-primary"
                     value="<?= setValor('nome') ?>" required autofocus>
              <?= setMsgFilderError('nome') ?>
            </div>

            <!-- Email -->
            <div class="col-12 col-lg-6">
              <label class="form-label">Email *</label>
              <input type="email" name="email" maxlength="150"
                     class="form-control border-primary"
                     value="<?= setValor('email') ?>" required>
              <?= setMsgFilderError('email') ?>
            </div>

            <!-- Especialidade -->
            <div class="col-12 col-lg-6">
              <label class="form-label">Especialidade *</label>
              <input type="text" name="especialidade" maxlength="50"
                     class="form-control border-primary"
                     value="<?= setValor('especialidade') ?>" required>
              <?= setMsgFilderError('especialidade') ?>
            </div>

            <!-- Área (opcional) -->
            <div class="col-12 col-lg-6">
              <label class="form-label">Área (opcional)</label>
              <input type="text" name="area" maxlength="50"
                     class="form-control border-primary"
                     value="<?= setValor('area') ?>">
              <?= setMsgFilderError('area') ?>
            </div>

            <!-- Status -->
            <div class="col-12 col-lg-4">
              <label class="form-label">Status *</label>
              <select name="statusRegistro"
                      class="form-select border-primary" required>
                <option value="1" <?= setValor('statusRegistro','1')=='1'?'selected':'' ?>>Ativo</option>
                <option value="2" <?= setValor('statusRegistro')=='2'?'selected':'' ?>>Inativo</option>
              </select>
              <?= setMsgFilderError('statusRegistro') ?>
            </div>

            <?php if ($isInsert): ?>
              <!-- Senha no INSERT -->
              <div class="col-12 col-lg-6">
                <label class="form-label">Senha *</label>
                <input type="password" name="senha"
                       class="form-control border-primary" required>
              </div>

              <div class="col-12 col-lg-6">
                <label class="form-label">Confirmar Senha *</label>
                <input type="password" name="confSenha"
                       class="form-control border-primary" required>
              </div>
            <?php endif; ?>

          </div><!-- /.row -->

          <div class="text-center mt-5">
            <?= formButton() ?>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
