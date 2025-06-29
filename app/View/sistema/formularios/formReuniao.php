<?php
use Core\Library\Session;

// Captura o nível do usuário logado (ex: professor ou admin)
$nivel = (int) Session::get('userNivel');

// Carrega os projetos disponíveis conforme o perfil do usuário
$proj = new \App\Model\ProjetoModel();

if ($nivel >= 12 && $nivel <= 21) {
    // Se for professor, busca o ID do professor e seus projetos
    $profId = (new \App\Model\ProfessorModel())
                 ->db->where('usuario_id', Session::get('userId'))
                 ->first()['id'] ?? 0;

    $projetos = $proj->db
                     ->where('professor_id', $profId)
                     ->orderBy('titulo')
                     ->findAll();
} else {
    // Se for admin, carrega todos os projetos
    $projetos = $proj->lista('titulo');
}

// Captura o projeto selecionado (para edição)
$projSel = setValor('projeto_id');

?>

<div class="container py-5 mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-10 col-xl-8">
      <div class="border rounded bg-white p-5 shadow-sm">

        <!-- Título -->
        <div class="row align-items-center mb-5">
          <div class="col-12 col-lg-6">
            <h4 class="mb-0">Reunião</h4>
          </div>
        </div>

        <!-- Início do formulário -->
        <form method="POST" action="<?= $this->request->formAction() ?>">
          <!-- ID oculto (usado na edição) -->
          <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

          <div class="row g-4">

            <!-- Campo: Projeto vinculado -->
            <div class="col-12 col-lg-6">
              <label class="form-label">Projeto *</label>
              <?php if ($nivel >= 12 && $nivel <= 21 && count($projetos) === 1): ?>
                <!-- Se for professor com um único projeto, campo fixo -->
                <div class="form-control-plaintext">
                  <?= $projetos[0]['titulo'] ?>
                </div>
                <input type="hidden" name="projeto_id" value="<?= $projetos[0]['id'] ?>">
              <?php else: ?>
                <!-- Admin ou professor com vários projetos -->
                <select name="projeto_id" class="form-select border-primary" required>
                  <option value="">Selecione...</option>
                  <?php foreach ($projetos as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= $projSel == $p['id'] ? 'selected' : '' ?>>
                      <?= $p['titulo'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              <?php endif; ?>
              <?= setMsgFilderError('projeto_id') ?>
            </div>

            <!-- Campo: Data da reunião -->
            <div class="col-12 col-md-6 col-lg-4">
              <label for="data" class="form-label">Data *</label>
              <input type="date" id="data" name="data"
                     class="form-control border-primary"
                     value="<?= setValor('data') ?>" required>
              <?= setMsgFilderError('data') ?>
            </div>

            <!-- Campo: Hora da reunião -->
            <div class="col-12 col-md-6 col-lg-4">
              <label for="hora" class="form-label">Hora *</label>
              <input type="time" id="hora" name="hora"
                     class="form-control border-primary"
                     value="<?= setValor('hora') ?>" required>
              <?= setMsgFilderError('hora') ?>
            </div>

            <!-- Campo: Local da reunião -->
            <div class="col-12 col-lg-8">
              <label for="local" class="form-label">Local *</label>
              <input type="text" id="local" name="local" maxlength="60"
                     class="form-control border-primary"
                     value="<?= setValor('local') ?>" required>
              <?= setMsgFilderError('local') ?>
            </div>

            <!-- Campo: Pauta (assunto da reunião) -->
            <div class="col-12">
              <label for="pauta" class="form-label">Pauta *</label>
              <input type="text" id="pauta" name="pauta" maxlength="120"
                     class="form-control border-primary"
                     value="<?= setValor('pauta') ?>" required>
              <?= setMsgFilderError('pauta') ?>
            </div>

            <!-- Campo: Observações (opcional) -->
            <div class="col-12">
              <label for="observacoes" class="form-label">Observações</label>
              <textarea id="observacoes" name="observacoes" rows="3"
                        class="form-control border-primary"><?= setValor('observacoes') ?></textarea>
            </div>
          </div>

          <!-- Botão de envio -->
          <div class="text-center mt-5">
            <?= formButton() ?>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

