<div class="container py-4 mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="border rounded bg-white p-4 shadow-sm">
        
        <!-- Cabeçalho com título "Aluno" -->
        <div class="row align-items-center mb-4">
          <!-- Título ocupa parte da largura (col-lg-4) -->
          <div class="col-12 col-lg-4">
            <h4 class="mb-0">Aluno</h4>
          </div>
          <!-- Espaço para possíveis botões no futuro -->
          <div class="col-12 col-lg-8 text-lg-end">
          </div>
        </div>

        <!-- Início do formulário -->
        <form method="POST" action="<?= $this->request->formAction() ?>">
          <!-- Campo oculto que guarda o ID do aluno (0 para novo) -->
          <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

          <div class="row g-3">
            <!-- Campo RA -->
            <div class="col-12 col-lg-4">
              <label class="form-label">RA *</label>
              <input type="text" name="ra" maxlength="20"
                     class="form-control form-control border-primary"
                     value="<?= setValor('ra') ?>" required>
              <?= setMsgFilderError('ra') ?> <!-- Exibe erro se houver -->
            </div>

            <!-- Campo Nome -->
            <div class="col-12 col-lg-8">
              <label class="form-label">Nome *</label>
              <input type="text" name="nome" maxlength="60"
                     class="form-control form-control border-primary"
                     value="<?= setValor('nome') ?>" required>
              <?= setMsgFilderError('nome') ?>
            </div>

            <!-- Campo Curso -->
            <div class="col-12 col-lg-6">
              <label class="form-label">Curso *</label>
              <select name="curso" class="form-select border-primary" required>
                <option value="">Selecione seu curso</option>
                <option value="Análise e Desenvolvimento de Sistemas" <?= setValor('curso') == 'Análise e Desenvolvimento de Sistemas' ? 'selected' : '' ?>>Análise e Desenvolvimento de Sistemas</option>
                <option value="Matemática" <?= setValor('curso') == 'Matemática' ? 'selected' : '' ?>>Matemática</option>
                <option value="Engenharia de Computação" <?= setValor('curso') == 'Engenharia de Computação' ? 'selected' : '' ?>>Engenharia de Computação</option>
                <option value="Administração" <?= setValor('curso') == 'Administração' ? 'selected' : '' ?>>Administração</option>
                <option value="Sistemas de Informação" <?= setValor('curso') == 'Sistemas de Informação' ? 'selected' : '' ?>>Sistemas de Informação</option>
                <option value="Ciência da Computação" <?= setValor('curso') == 'Ciência da Computação' ? 'selected' : '' ?>>Ciência da Computação</option>
                <option value="Engenharia Elétrica" <?= setValor('curso') == 'Engenharia Elétrica' ? 'selected' : '' ?>>Engenharia Elétrica</option>
                <option value="GTI" <?= setValor('curso') == 'GTI' ? 'selected' : '' ?>>GTI</option>
              </select>
              <?= setMsgFilderError('curso') ?>
            </div>


            <!-- Campo Email -->
            <div class="col-12 col-lg-6">
              <label class="form-label">Email *</label>
              <input type="email" name="email" maxlength="150"
                     class="form-control form-control border-primary"
                     value="<?= setValor('email') ?>" required>
              <?= setMsgFilderError('email') ?>
            </div>

            <!-- Campo Status (Ativo ou Inativo) -->
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

          <!-- Botão de salvar/cancelar (gerado por helper) -->
          <div class="text-center mt-4">
            <?= formButton() ?>
          </div>
        </form>
      
      </div>
    </div>
  </div>
</div>
