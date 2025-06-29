<?php
// formUsuario.php

// Pega a ação atual da página (insert, update, etc.)
$action = $this->request->getAction();

// Verifica se a ação atual é de inserir ou atualizar (mostra campos de senha)
$isInsert = in_array($action, ['insert', 'update']);

?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8 col-xl-6">
      <div class="card border-0 shadow-lg">

        <!-- Cabeçalho do card com ícone e título -->
        <div class="card-header bg-primary text-white text-center py-3">
          <i class="fas fa-user fa-2x mb-2"></i>
          <h5 class="mb-0">Usuário</h5>
        </div>

        <!-- Corpo do card com o formulário -->
        <div class="card-body p-4">
          <form method="POST" action="<?= $this->request->formAction() ?>">

            <!-- Campo oculto com ID do usuário -->
            <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

            <!-- Campo oculto com a ação atual -->
            <input type="hidden" name="action" value="<?= $action ?>">

            <div class="row g-4">

              <!-- Campo: Nome do usuário -->
              <div class="col-12">
                <div class="form-floating">
                  <input type="text" name="nome" maxlength="60"
                         class="form-control border-primary"
                         id="nome" placeholder="Nome completo"
                         value="<?= setValor('nome') ?>" required>
                  <label for="nome">Nome *</label>
                  <?= setMsgFilderError('nome') ?>
                </div>
              </div>

              <!-- Campo: Nível de acesso (Administrador, Professor, Aluno) -->
              <div class="col-12 col-lg-6">
                <label class="form-label">Nível *</label>
                <select name="nivel" class="form-select border-primary" required>
                  <option value="">Selecione...</option>
                  <option value="11" <?= setValor('nivel')=='11' ? 'selected' : '' ?>>Administrador</option>
                  <option value="21" <?= setValor('nivel')=='21' ? 'selected' : '' ?>>Professor</option>
                  <option value="31" <?= setValor('nivel')=='31' ? 'selected' : '' ?>>Aluno</option>
                </select>
                <?= setMsgFilderError('nivel') ?>
              </div>

              <!-- Campo: E-mail -->
              <div class="col-12 col-lg-6">
                <div class="form-floating">
                  <input type="email" name="email" maxlength="150"
                         class="form-control border-primary"
                         id="email" placeholder="seu@email.com"
                         value="<?= setValor('email') ?>" required>
                  <label for="email">E-mail *</label>
                  <?= setMsgFilderError('email') ?>
                </div>
              </div>

              <!-- Campo: Status do usuário -->
              <div class="col-12 col-lg-6">
                <label class="form-label">Status *</label>
                <select name="statusRegistro"
                        class="form-select border-primary" required>
                  <option value="1" <?= setValor('statusRegistro','1')=='1'?'selected':'' ?>>Ativo</option>
                  <option value="2" <?= setValor('statusRegistro')=='2'?'selected':'' ?>>Inativo</option>
                </select>
                <?= setMsgFilderError('statusRegistro') ?>
              </div>

              <!-- Campos de senha (apenas quando for inserir ou atualizar) -->
              <?php if ($isInsert): ?>
                <!-- Senha -->
                <div class="col-12 col-lg-6">
                  <div class="form-floating">
                    <input type="password" name="senha" 
                           class="form-control border-primary" 
                           id="senha" placeholder="Senha" required>
                    <label for="senha">Senha *</label>
                  </div>
                </div>

                <!-- Confirmar senha -->
                <div class="col-12 col-lg-6">
                  <div class="form-floating">
                    <input type="password" name="confSenha" 
                           class="form-control border-primary" 
                           id="confSenha" placeholder="Confirme a senha" required>
                    <label for="confSenha">Confirmar Senha *</label>
                  </div>
                </div>
              <?php endif; ?>
            </div>

            <!-- Botões de ação: Cancelar e Salvar -->
            <div class="d-flex justify-content-between align-items-center mt-4">
              <a href="<?= baseUrl() ?>usuario" class="btn btn-outline-secondary">
                Cancelar
              </a>
              <button type="submit" class="btn btn-primary">
                <?= $isInsert ? 'Criar Usuário' : 'Salvar Alterações' ?>
              </button>
            </div>

            <!-- Mostra alertas de erro ou sucesso -->
            <?= exibeAlerta() ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

