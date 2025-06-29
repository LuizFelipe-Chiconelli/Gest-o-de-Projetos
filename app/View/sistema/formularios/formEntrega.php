<?php
// Importa a classe de sessão
use Core\Library\Session;

// Captura o nível do usuário logado
$nivel   = (int) Session::get('userNivel');

// Captura o projeto selecionado (via GET ou valor anterior)
$projSel = $_GET['proj'] ?? setValor('projeto_id');

// Se for aluno (nível 31), lista apenas seus projetos
if ($nivel === 31) {
    $projetos = (new \App\Model\ProjetoAlunoModel)
                   ->listarProjetosDoAluno(Session::get('userId'));
} else {
    // Caso contrário (admin ou professor), lista todos os projetos
    $projetos = (new \App\Model\ProjetoModel)->lista('titulo');
}

// Se não houver projetos listados, mas um projeto foi selecionado, busca ele manualmente
if (empty($projetos) && $projSel) {
    $projetos[] = (new \App\Model\ProjetoModel)->getById($projSel);
}
?>

<div class="container py-5 mt-4">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-10 col-xl-8">
      <div class="border rounded bg-white p-5 shadow-sm">

        <!-- Cabeçalho do formulário -->
        <div class="row align-items-center mb-5">
          <div class="col-12 col-lg-6">
            <h4 class="mb-0">Entrega</h4>
          </div>
        </div>

        <!-- Início do formulário -->
        <form method="POST"
              action="<?= $this->request->formAction() ?>"
              enctype="multipart/form-data"> <!-- Necessário para upload de arquivo -->

          <!-- ID da entrega (usado em edição) -->
          <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

          <!-- Caso esteja editando, inclui o nome do arquivo atual -->
          <?php if ($this->request->getAction() !== 'insert'): ?>
            <input type="hidden" name="nomeArquivo" value="<?= setValor('arquivo') ?>">
          <?php endif; ?>

          <div class="row g-4">
            <!-- Campo Projeto -->
            <div class="col-12 col-lg-8">
              <label class="form-label">Projeto *</label>
              <select name="projeto_id"
                      class="form-select border-primary" required>
                <option value="">…</option>
                <?php foreach ($projetos as $p): ?>
                  <option value="<?= $p['id'] ?>"
                          <?= $projSel == $p['id'] ? 'selected' : '' ?>>
                    <?= $p['titulo'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Campo Data -->
            <div class="col-12 col-lg-4">
              <label class="form-label">Data *</label>
              <input type="date" name="data"
                     class="form-control border-primary"
                     value="<?= setValor('data') ?>" required>
            </div>

            <!-- Campo Descrição -->
            <div class="col-12 col-lg-8">
              <label class="form-label">Descrição *</label>
              <input type="text" name="descricao" maxlength="120"
                     class="form-control border-primary"
                     value="<?= setValor('descricao') ?>" required>
            </div>

            <!-- Campo Arquivo (upload) -->
            <div class="col-12 col-lg-4">
              <label class="form-label">Arquivo (opcional)</label>
              <input type="file" name="arquivo"
                     class="form-control border-primary">
              <!-- Exibe o nome do arquivo atual, se existir -->
              <?php if (setValor('arquivo')): ?>
                <small class="text-muted">Atual: <?= setValor('arquivo') ?></small>
              <?php endif; ?>
            </div>

            <!-- Campo Status -->
            <div class="col-12 col-lg-4">
              <label class="form-label">Status *</label>
              <select name="status"
                      class="form-select border-primary" required>
                <?php foreach (['Pendente','Entregue','Atrasado','Finalizado'] as $st): ?>
                  <option <?= setValor('status','Pendente') == $st ? 'selected' : '' ?>>
                    <?= $st ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Botão de salvar/cancelar (gerado por helper) -->
          <div class="text-center mt-5">
            <?= formButton() ?>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
