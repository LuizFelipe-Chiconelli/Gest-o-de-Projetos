<?php
$isInsert = empty($_POST['id']) || $_POST['id'] == 0;
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      <div class="card shadow-sm">
        <!-- Cabeçalho padrão (gradiente via forms.css) -->
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Professor <?= $isInsert ? '- Novo' : ('- ' . ucfirst($this->request->getAction())) ?></h3>
          <a href="<?= baseUrl() . $this->request->getController() ?>" class="btn btn-outline-light btn-sm">Voltar</a>
        </div>

        <div class="card-body px-4 py-5">
          <form method="POST" action="<?= $this->request->formAction() ?>">
            <input type="hidden" name="id"         value="<?= setValor('id',0) ?>">
            <input type="hidden" name="usuario_id" value="<?= setValor('usuario_id') ?>">

            <!-- Seção Principal -->
            <h6 class="section-title">Dados do professor</h6>
            <hr class="section-divider"/>

            <div class="row g-4">
              <!-- Nome -->
              <div class="col-12 col-lg-6">
                <label class="form-label">Nome *</label>
                <input name="nome" type="text" maxlength="60" class="form-control" value="<?= setValor('nome') ?>" required autofocus>
                <?= setMsgFilderError('nome') ?>
              </div>

              <!-- Email -->
              <div class="col-12 col-lg-6">
                <label class="form-label">Email *</label>
                <input name="email" type="email" maxlength="150" class="form-control" value="<?= setValor('email') ?>" required>
                <?= setMsgFilderError('email') ?>
              </div>

              <!-- Especialidade -->
              <div class="col-12 col-lg-6">
                <label class="form-label">Especialidade *</label>
                <input name="especialidade" type="text" maxlength="50" class="form-control" value="<?= setValor('especialidade') ?>" required>
                <?= setMsgFilderError('especialidade') ?>
              </div>

              <!-- Área opcional -->
              <div class="col-12 col-lg-6">
                <label class="form-label">Área (opcional)</label>
                <input name="area" type="text" maxlength="50" class="form-control" value="<?= setValor('area') ?>">
                <?= setMsgFilderError('area') ?>
              </div>

              <!-- Status -->
              <div class="col-12 col-lg-4">
                <label class="form-label">Status *</label>
                <select name="statusRegistro" class="form-select" required>
                  <option value="1" <?= setValor('statusRegistro','1')=='1' ? 'selected' : '' ?>>Ativo</option>
                  <option value="2" <?= setValor('statusRegistro')=='2' ? 'selected' : '' ?>>Inativo</option>
                </select>
                <?= setMsgFilderError('statusRegistro') ?>
              </div>

              <?php if ($isInsert): ?>
                <!-- Senha / Confirmação (apenas no insert) -->
                <div class="col-12 col-lg-4">
                  <label class="form-label">Senha *</label>
                  <input name="senha" type="password" class="form-control" required>
                </div>
                <div class="col-12 col-lg-4">
                  <label class="form-label">Confirmar senha *</label>
                  <input name="confSenha" type="password" class="form-control" required>
                </div>
              <?php endif; ?>
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
