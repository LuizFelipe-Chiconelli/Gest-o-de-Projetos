<?php
/*
 |---------------------------------------------------------------
 | Formulário de Usuário – somente Administrador
 |---------------------------------------------------------------
 |  O controller coloca os valores em $_POST.
 |  - insert : cria nível 11 (Administrador)
 |  - update : altera campos básicos; nível não pode ser trocado
*/

$formAction = $_POST['formAction'] ?? 'insert';
$isInsert   = ($formAction === 'insert');
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8 col-xl-6">
      <div class="card border-0 shadow-lg">

        <div class="card-header bg-primary text-white text-center py-3">
          <i class="fas fa-user-shield fa-2x mb-2"></i>
          <h5 class="mb-0">Usuário – Administrador</h5>
        </div>

        <div class="card-body p-4">
          <form method="POST" action="<?= $this->request->formAction() ?>">

            <?php if (!$isInsert): ?>
              <input type="hidden" name="id" value="<?= setValor('id') ?>">
            <?php endif; ?>

            <input type="hidden" name="formAction" value="<?= $formAction ?>">
            <input type="hidden" name="nivel" value="11"><!-- sempre Admin -->

            <div class="row g-4">

              <!-- Nome -->
              <div class="col-12">
                <div class="form-floating">
                  <input type="text" name="nome" maxlength="60"
                         class="form-control border-primary"
                         placeholder="Nome completo"
                         value="<?= setValor('nome') ?>" required>
                  <label>Nome *</label>
                  <?= setMsgFilderError('nome') ?>
                </div>
              </div>

              <!-- E-mail -->
              <div class="col-12">
                <div class="form-floating">
                  <input type="email" name="email" maxlength="150"
                         class="form-control border-primary"
                         placeholder="E-mail"
                         value="<?= setValor('email') ?>" required>
                  <label>E-mail *</label>
                  <?= setMsgFilderError('email') ?>
                </div>
              </div>

              <!-- Status -->
              <div class="col-12">
                <label class="form-label">Status *</label>
                <?php $status = setValor('statusRegistro', 1); ?>
                <select name="statusRegistro" class="form-select border-primary" required>
                  <option value="1" <?= $status==1?'selected':'' ?>>Ativo</option>
                  <option value="2" <?= $status==2?'selected':'' ?>>Inativo</option>
                </select>
              </div>

              <!-- Senha -->
              <?php if ($isInsert): ?>
                <div class="col-12 col-lg-6">
                  <div class="form-floating">
                    <input type="password" name="senha"
                           class="form-control border-primary"
                           placeholder="Senha" required>
                    <label>Senha *</label>
                  </div>
                </div>

                <div class="col-12 col-lg-6">
                  <div class="form-floating">
                    <input type="password" name="confSenha"
                           class="form-control border-primary"
                           placeholder="Confirmar senha" required>
                    <label>Confirmar Senha *</label>
                  </div>
                </div>
              <?php else: ?>
                <div class="col-12">
                  <div class="form-floating">
                    <input type="password" name="senha"
                           class="form-control border-primary"
                           placeholder="Nova senha">
                    <label>Nova senha (deixe em branco para manter)</label>
                  </div>
                </div>
              <?php endif; ?>

            </div><!-- /.row -->

            <div class="d-flex justify-content-between align-items-center mt-4">
              <a href="<?= baseUrl() ?>usuario" class="btn btn-outline-secondary">
                Cancelar
              </a>
              <button type="submit" class="btn btn-primary">
                <?= $isInsert ? 'Criar Administrador' : 'Salvar Alterações' ?>
              </button>
            </div>

            <?= exibeAlerta() ?>
          </form>
        </div><!-- /.card-body -->
      </div>
    </div>
  </div>
</div>
