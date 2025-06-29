<?php
$isInsert = empty($_POST['id']) || $_POST['id'] == 0;
?>
<div class="container py-4 mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="border rounded bg-white p-4 shadow-sm">

        <!-- Cabeçalho -->
        <div class="row align-items-center mb-4">
          <div class="col-12 col-lg-4">
            <h4 class="mb-0">Aluno</h4>
          </div>
        </div>

        <form method="POST" action="<?= $this->request->formAction() ?>">
          <input type="hidden" name="id" value="<?= setValor('id',0) ?>">
          <input type="hidden" name="usuario_id" value="<?= setValor('usuario_id') ?>">

          <div class="row g-3">

            <?php if (!$isInsert): ?>
              <!-- RA visível APENAS no update -->
              <div class="col-12 col-lg-4">
                <label class="form-label">RA *</label>
                <input type="text" name="ra" maxlength="20"
                       class="form-control border-primary"
                       value="<?= setValor('ra') ?>" required>
                <?= setMsgFilderError('ra') ?>
              </div>
            <?php endif; ?>

            <!-- Nome -->
            <div class="col-12 <?= $isInsert ? 'col-lg-12' : 'col-lg-8' ?>">
              <label class="form-label">Nome *</label>
              <input type="text" name="nome" maxlength="60"
                     class="form-control border-primary"
                     value="<?= setValor('nome') ?>" required>
              <?= setMsgFilderError('nome') ?>
            </div>

            <!-- Curso -->
            <div class="col-12 col-lg-6">
              <label class="form-label">Curso *</label>
              <select name="curso" class="form-select border-primary" required>
                <option value="">Selecione seu curso</option>
                <?php
                  $cursos = [
                      'Análise e Desenvolvimento de Sistemas','Matemática',
                      'Engenharia de Computação','Administração',
                      'Sistemas de Informação','Ciência da Computação',
                      'Engenharia Elétrica','GTI'
                  ];
                  foreach ($cursos as $c):
                ?>
                <option value="<?= $c ?>" <?= setValor('curso')==$c?'selected':'' ?>><?= $c ?></option>
                <?php endforeach; ?>
              </select>
              <?= setMsgFilderError('curso') ?>
            </div>

            <!-- Email -->
            <div class="col-12 col-lg-6">
              <label class="form-label">Email *</label>
              <input type="email" name="email" maxlength="150"
                     class="form-control border-primary"
                     value="<?= setValor('email') ?>" required>
              <?= setMsgFilderError('email') ?>
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
              <!-- Senha (somente no INSERT) -->
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

          <!-- Botões -->
          <div class="text-center mt-4">
            <?= formButton() ?>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
