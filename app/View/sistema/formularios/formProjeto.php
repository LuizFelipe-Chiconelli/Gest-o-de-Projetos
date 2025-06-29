<?php
// Carrega lista de professores e alunos para usar nos selects e checkboxes
$profModel   = new \App\Model\ProfessorModel();
$listaProf   = $profModel->lista('nome');
$alunoModel  = new \App\Model\AlunoModel();
$todosAlunos = $alunoModel->lista('nome');

// Se for edição (e não inserção), busca os alunos já vinculados ao projeto
$alVinc = [];
if ($this->request->getAction() !== 'insert') {
    $pivot  = new \App\Model\ProjetoAlunoModel();
    $alVinc = $pivot->db
                   ->where('projeto_id', setValor('id'))
                   ->select('aluno_id')
                   ->findAll();
    $alVinc = array_column($alVinc,'aluno_id'); // Pega só os IDs dos alunos
}

// Se o professor estiver logado, fixa o ID dele (admin deixa em branco para selecionar)
$profFix = $profLogado ?? null;
?>

<!-- Layout principal do formulário -->
<div class="container py-5 mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-10 col-xl-8">
      <div class="border rounded bg-white p-5 shadow-sm">

        <!-- Cabeçalho do formulário -->
        <div class="row align-items-center mb-5">
          <div class="col-12 col-lg-6">
            <h4 class="mb-0">Projeto</h4>
          </div>
        </div>

        <!-- Início do formulário -->
        <form method="POST" action="<?= $this->request->formAction() ?>">
          <!-- Campo oculto para armazenar o ID do projeto -->
          <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

          <div class="row g-4">
            <!-- Campo Título -->
            <div class="col-12 col-lg-8">
              <label for="titulo" class="form-label">Título *</label>
              <input type="text" id="titulo" name="titulo" maxlength="100"
                     class="form-control border-primary"
                     value="<?= setValor('titulo') ?>" required autofocus>
              <?= setMsgFilderError('titulo') ?>
            </div>

            <!-- Campo Professor -->
            <div class="col-12 col-lg-4">
              <label class="form-label">Professor *</label>
              <?php if ($profFix): ?>
                <!-- Se for professor logado, exibe nome fixo e ID oculto -->
                <div class="form-control-plaintext">
                  <?= ($profModel->getById($profFix))['nome'] ?>
                </div>
                <input type="hidden" name="professor_id" value="<?= $profFix ?>">
              <?php else: ?>
                <!-- Se for admin, permite escolher o professor -->
                <select name="professor_id" class="form-select border-primary" required>
                  <option value="">…</option>
                  <?php foreach ($listaProf as $p): ?>
                    <option value="<?= $p['id'] ?>"
                      <?= setValor('professor_id',$profFix)==$p['id']?'selected':'' ?>>
                      <?= $p['nome'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              <?php endif; ?>
              <?= setMsgFilderError('professor_id') ?>
            </div>

            <!-- Campo Área -->
            <div class="col-12 col-lg-4">
              <label for="area" class="form-label">Área *</label>
              <input type="text" id="area" name="area" maxlength="50"
                     class="form-control border-primary"
                     value="<?= setValor('area') ?>" required>
              <?= setMsgFilderError('area') ?>
            </div>

            <!-- Campo Status -->
            <div class="col-12 col-lg-4">
              <label class="form-label">Status *</label>
              <select id="status" name="status" class="form-select border-primary" required>
                <?php 
                  $sel = setValor('status','Ativo'); // Valor padrão: Ativo
                  foreach (['Ativo','Concluído','Pausado'] as $opt): ?>
                  <option <?= $sel==$opt?'selected':'' ?>><?= $opt ?></option>
                <?php endforeach; ?>
              </select>
              <?= setMsgFilderError('status') ?>
            </div>

            <!-- Campo Data de Início -->
            <div class="col-12 col-lg-4">
              <label for="inicio" class="form-label">Data início *</label>
              <input type="date" id="inicio" name="inicio"
                     class="form-control border-primary"
                     value="<?= setValor('inicio') ?>" required>
              <?= setMsgFilderError('inicio') ?>
            </div>

            <!-- Campo Previsão de Término -->
            <div class="col-12 col-lg-4">
              <label for="previsao_termino" class="form-label">Previsão término</label>
              <input type="date" id="previsao_termino"
                     name="previsao_termino"
                     class="form-control border-primary"
                     value="<?= setValor('previsao_termino') ?>">
            </div>

            <!-- Checkboxes de alunos vinculados -->
            <div class="col-12 col-lg-6">
              <label class="form-label">Alunos vinculados</label>
              <div class="border rounded p-3" style="max-height:200px; overflow-y:auto;">
                <?php foreach ($todosAlunos as $a): ?>
                  <div class="form-check">
                    <input type="checkbox"
                           class="form-check-input"
                           name="alunos_id[]"
                           value="<?= $a['id'] ?>"
                           <?= in_array($a['id'],$alVinc)?'checked':'' ?>>
                    <label class="form-check-label"><?= $a['nome'] ?></label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Campo Resumo -->
            <div class="col-12">
              <label for="resumo" class="form-label">Resumo</label>
              <textarea id="resumo" name="resumo" rows="4" maxlength="1000"
                        class="form-control border-primary"
                        placeholder="Breve descrição do projeto"><?= setValor('resumo') ?></textarea>
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
