<div class="container py-4 mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-10 col-xl-8">
      <div class="border rounded bg-white p-5 shadow-sm">

        <!-- HEADER -->
        <div class="row align-items-center mb-5">
          <div class="col-12 col-lg-6">
            <h4 class="mb-0">Professor</h4>
          </div>
        </div>

        <!-- FORMULÁRIO -->
        <form method="POST" action="<?= $this->request->formAction() ?>">
          <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

          <div class="row g-4">
            <div class="col-12 col-lg-6">
              <label class="form-label">Nome *</label>
              <input type="text" name="nome" maxlength="60"
                     class="form-control border-primary"
                     value="<?= setValor('nome') ?>" required autofocus>
              <?= setMsgFilderError('nome') ?>
            </div>

            <div class="col-12 col-lg-6">
              <label class="form-label">Email *</label>
              <input type="email" name="email" maxlength="150"
                     class="form-control border-primary"
                     value="<?= setValor('email') ?>" required>
              <?= setMsgFilderError('email') ?>
            </div>

            <div class="col-12 col-lg-6">
              <label class="form-label">Especialidade *</label>
              <input type="text" name="especialidade" maxlength="50"
                     class="form-control border-primary"
                     value="<?= setValor('especialidade') ?>" required>
              <?= setMsgFilderError('especialidade') ?>
            </div>

            <div class="col-12 col-lg-6">
              <label class="form-label">Área (opcional)</label>
              <input type="text" name="area" maxlength="50"
                     class="form-control border-primary"
                     value="<?= setValor('area') ?>">
              <?= setMsgFilderError('area') ?>
            </div>

            <div class="col-12 col-lg-4">
              <label class="form-label">Status *</label>
              <select name="statusRegistro"
                      class="form-select border-primary" required>
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

          <div class="text-center mt-5">
            <?= formButton() ?>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
