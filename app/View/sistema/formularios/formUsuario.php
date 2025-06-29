<?php
/* -----------------------------------------------------------
 | Formulário: Usuário – somente Administrador (nível 11)
 |----------------------------------------------------------- */
$formAction = $_POST['formAction'] ?? 'insert';
$isInsert   = ($formAction === 'insert');
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-6">
      <div class="card shadow-sm">
        <!-- Cabeçalho -->
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Usuário – Administrador <?= $isInsert? '- Novo':'- Alteração' ?></h3>
          <a href="<?= baseUrl() ?>usuario" class="btn btn-outline-light btn-sm">Voltar</a>
        </div>

        <div class="card-body px-4 py-5">
          <form method="POST" action="<?= $this->request->formAction() ?>">
            <?php if (!$isInsert): ?>
              <input type="hidden" name="id" value="<?= setValor('id') ?>">
            <?php endif; ?>
            <input type="hidden" name="formAction" value="<?= $formAction ?>">
            <input type="hidden" name="nivel" value="11"><!-- sempre Admin -->

            <h6 class="section-title">Dados do administrador</h6>
            <hr class="section-divider"/>

            <div class="row g-4">
              <!-- Nome -->
              <div class="col-12">
                <label class="form-label">Nome *</label>
                <input name="nome" type="text" maxlength="60" class="form-control" value="<?= setValor('nome') ?>" required autofocus>
                <?= setMsgFilderError('nome') ?>
              </div>

              <!-- E‑mail -->
              <div class="col-12">
                <label class="form-label">E‑mail *</label>
                <input name="email" type="email" maxlength="150" class="form-control" value="<?= setValor('email') ?>" required>
                <?= setMsgFilderError('email') ?>
              </div>

              <!-- Status -->
              <div class="col-12 col-lg-4">
                <label class="form-label">Status *</label>
                <?php $status = setValor('statusRegistro',1); ?>
                <select name="statusRegistro" class="form-select" required>
                  <option value="1" <?= $status==1?'selected':'' ?>>Ativo</option>
                  <option value="2" <?= $status==2?'selected':'' ?>>Inativo</option>
                </select>
              </div>

              <!-- Senhas -->
              <?php if ($isInsert): ?>
                <div class="col-12 col-lg-6">
                  <label class="form-label">Senha *</label>
                  <input name="senha" type="password" class="form-control" required>
                </div>
                <div class="col-12 col-lg-6">
                  <label class="form-label">Confirmar senha *</label>
                  <input name="confSenha" type="password" class="form-control" required>
                </div>
              <?php else: ?>
                <div class="col-12">
                  <label class="form-label">Nova senha (deixe em branco para manter)</label>
                  <input name="senha" type="password" class="form-control">
                </div>
              <?php endif; ?>
            </div><!-- /.row -->

            <div class="text-center pt-5">
              <?= formButton() ?>
            </div>
            <?= exibeAlerta() ?>
          </form>
        </div><!-- /.card-body -->
      </div><!-- /.card -->
    </div>
  </div>
</div>
