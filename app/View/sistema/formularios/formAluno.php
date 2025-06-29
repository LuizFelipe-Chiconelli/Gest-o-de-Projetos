<?php
$isInsert = empty($_POST['id']) || $_POST['id'] == 0;
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-6">
      <div class="card shadow-sm">
        <!-- Cabeçalho (usa bg-secondary para herdar degradê do forms.css) -->
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Aluno <?= $isInsert? '- Novo':('- '.ucfirst($this->request->getAction())) ?></h3>
          <a href="<?= baseUrl() . $this->request->getController() ?>" class="btn btn-outline-light btn-sm">Voltar</a>
        </div>

        <div class="card-body px-4 py-5">
          <form method="POST" action="<?= $this->request->formAction() ?>">
            <input type="hidden" name="id"         value="<?= setValor('id',0) ?>">
            <input type="hidden" name="usuario_id" value="<?= setValor('usuario_id') ?>">

            <!-- Seção dados principais -->
            <h6 class="section-title">Dados do aluno</h6>
            <hr class="section-divider">

            <div class="row g-4">
              <?php if (!$isInsert): ?>
                <!-- RA visível APENAS no update -->
                <div class="col-12 col-lg-4">
                  <label class="form-label">RA *</label>
                  <input type="text" name="ra" maxlength="20" class="form-control" value="<?= setValor('ra') ?>" required>
                  <?= setMsgFilderError('ra') ?>
                </div>
              <?php endif; ?>

              <!-- Nome -->
              <div class="col-12 <?= $isInsert ? 'col-lg-12' : 'col-lg-8' ?>">
                <label class="form-label">Nome *</label>
                <input type="text" name="nome" maxlength="60" class="form-control" value="<?= setValor('nome') ?>" required>
                <?= setMsgFilderError('nome') ?>
              </div>

              <!-- Curso -->
              <div class="col-12 col-lg-6">
                <label class="form-label">Curso *</label>
                <select name="curso" class="form-select" required>
                  <option value="">Selecione…</option>
                  <?php
                    $cursos = [
                      'Análise e Desenvolvimento de Sistemas','Matemática',
                      'Engenharia de Computação','Administração',
                      'Sistemas de Informação','Ciência da Computação',
                      'Engenharia Elétrica','GTI'
                    ];
                    foreach ($cursos as $c): ?>
                      <option value="<?= $c ?>" <?= setValor('curso')==$c?'selected':'' ?>><?= $c ?></option>
                  <?php endforeach; ?>
                </select>
                <?= setMsgFilderError('curso') ?>
              </div>

              <!-- Email -->
              <div class="col-12 col-lg-6">
                <label class="form-label">Email *</label>
                <input type="email" name="email" maxlength="150" class="form-control" value="<?= setValor('email') ?>" required>
                <?= setMsgFilderError('email') ?>
              </div>

              <!-- Status -->
              <div class="col-12 col-lg-4">
                <label class="form-label">Status *</label>
                <select name="statusRegistro" class="form-select" required>
                  <option value="1" <?= setValor('statusRegistro','1')=='1'?'selected':'' ?>>Ativo</option>
                  <option value="2" <?= setValor('statusRegistro')=='2'?'selected':'' ?>>Inativo</option>
                </select>
                <?= setMsgFilderError('statusRegistro') ?>
              </div>

              <?php if ($isInsert): ?>
                <!-- Senha / Confirmação -->
                <div class="col-12 col-lg-4">
                  <label class="form-label">Senha *</label>
                  <input type="password" name="senha" class="form-control" required>
                </div>
                <div class="col-12 col-lg-4">
                  <label class="form-label">Confirmar senha *</label>
                  <input type="password" name="confSenha" class="form-control" required>
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
