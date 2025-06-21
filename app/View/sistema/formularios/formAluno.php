<div class="container py-4 mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="border rounded bg-white p-4 shadow-sm">
        
        <!-- HEADER -->
        <div class="row align-items-center mb-4">
          <!-- título ocupa mesma largura do campo RA (col-lg-4) -->
          <div class="col-12 col-lg-4">
            <h4 class="mb-0">Aluno</h4>
          </div>
          <!-- botão ocupa o restante (col-lg-8) -->
          <div class="col-12 col-lg-8 text-lg-end">
          </div>
        </div>

        <!-- FORM -->
        <form method="POST" action="<?= $this->request->formAction() ?>">
          <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

          <div class="row g-3">
            <div class="col-12 col-lg-4">
              <label class="form-label">RA *</label>
              <input type="text" name="ra" maxlength="20"
                     class="form-control form-control border-primary"
                     value="<?= setValor('ra') ?>" required>
              <?= setMsgFilderError('ra') ?>
            </div>

            <div class="col-12 col-lg-8">
              <label class="form-label">Nome *</label>
              <input type="text" name="nome" maxlength="60"
                     class="form-control form-control border-primary"
                     value="<?= setValor('nome') ?>" required>
              <?= setMsgFilderError('nome') ?>
            </div>

            <div class="col-12 col-lg-6">
              <label class="form-label">Curso *</label>
              <input type="text" name="curso" maxlength="100"
                     class="form-control form-control border-primary"
                     value="<?= setValor('curso') ?>" required>
              <?= setMsgFilderError('curso') ?>
            </div>

            <div class="col-12 col-lg-6">
              <label class="form-label">Email *</label>
              <input type="email" name="email" maxlength="150"
                     class="form-control form-control border-primary"
                     value="<?= setValor('email') ?>" required>
              <?= setMsgFilderError('email') ?>
            </div>

            <div class="col-12 col-lg-4">
              <label class="form-label">Status *</label>
              <select name="statusRegistro"
                      class="form-select form-select border-primary" required>
                <option value="1" <?= setValor('statusRegistro','1')=='1'?'selected':'' ?>>
                  Ativo
                </option>
                <option value="2" <?= setValor('statusRegistro')=='2'?'selected':'' ?>>
                  Inativo
                </option>
              </select>
              <?= setMsgFilderError('statusRegistro') ?>
            </div>
          </div>

          <div class="text-center mt-4">
            <?= formButton() ?>
          </div>
        </form>
      
      </div>
    </div>
  </div>
</div>
