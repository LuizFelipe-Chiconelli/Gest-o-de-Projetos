<?php
/* carrega listas */
$profModel   = new \App\Model\ProfessorModel();
$listaProf   = $profModel->lista('nome');

$alunoModel  = new \App\Model\AlunoModel();
$todosAlunos = $alunoModel->lista('nome');

/* alunos já vinculados (para edição) */
$alVinc = [];
if ($this->request->getAction() !== 'insert') {
    $pivot   = new \App\Model\ProjetoAlunoModel();
    $alVinc  = $pivot->db->where('projeto_id', setValor('id'))
                         ->select('aluno_id')->findAll();
    $alVinc  = array_column($alVinc,'aluno_id');
}
?>

<?= formTitulo('Projeto') ?>
<form method="POST" action="<?= $this->request->formAction() ?>">

  <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

  <div class="row m-2">

    <!-- TÍTULO -------------------------------------------------------- -->
    <div class="mb-3 col-lg-8">
      <label class="form-label" for="titulo">Título *</label>
      <input type="text" id="titulo" name="titulo" maxlength="100"
             class="form-control"
             value="<?= setValor('titulo') ?>" required autofocus>
      <?= setMsgFilderError('titulo') ?>
    </div>

    <!-- PROFESSOR ----------------------------------------------------- -->
    <div class="mb-3 col-lg-4">
      <label class="form-label">Professor *</label>
      <select name="professor_id" class="form-select" required>
        <option value="">…</option>
        <?php foreach ($listaProf as $p): ?>
          <option value="<?= $p['id'] ?>"
                  <?= setValor('professor_id')==$p['id']?'selected':'' ?>>
            <?= $p['nome'] ?>
          </option>
        <?php endforeach; ?>
      </select>
      <?= setMsgFilderError('professor_id') ?>
    </div>

    <!-- ÁREA ---------------------------------------------------------- -->
    <div class="mb-3 col-lg-4">
      <label class="form-label" for="area">Área *</label>
      <input type="text" id="area" name="area" maxlength="50"
             class="form-control"
             value="<?= setValor('area') ?>" required>
      <?= setMsgFilderError('area') ?>
    </div>

    <!-- STATUS -------------------------------------------------------- -->
    <div class="mb-3 col-lg-4">
      <label class="form-label">Status *</label>
      <select id="status" name="status" class="form-select" required>
        <?php
          $sel = setValor('status','Ativo');
          foreach(['Ativo','Concluído','Pausado'] as $opt){
              echo '<option '.($sel==$opt?'selected':'').'>'.$opt.'</option>';
          }
        ?>
      </select>
      <?= setMsgFilderError('status') ?>
    </div>

    <!-- DATA INÍCIO / PREVISÃO --------------------------------------- -->
    <div class="mb-3 col-lg-4">
      <label class="form-label" for="inicio">Data início *</label>
      <input type="date" id="inicio" name="inicio"
             class="form-control" value="<?= setValor('inicio') ?>" required>
    </div>

    <div class="mb-3 col-lg-4">
      <label class="form-label" for="previsao_termino">Previsão término</label>
      <input type="date" id="previsao_termino" name="previsao_termino"
             class="form-control" value="<?= setValor('previsao_termino') ?>">
    </div>

    <!-- ALUNOS (caixa rolável) --------------------------------------- -->
    <div class="mb-3 col-lg-6">
      <label class="form-label">Alunos vinculados</label>
      <div class="lista-alunos p-2 border rounded">
        <?php foreach ($todosAlunos as $a): ?>
          <div class="form-check">
            <input  type="checkbox" class="form-check-input"
                    name="alunos_id[]"
                    value="<?= $a['id'] ?>"
                    <?= in_array($a['id'],$alVinc)?'checked':'' ?>>
            <label class="form-check-label"><?= $a['nome'] ?></label>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- RESUMO -------------------------------------------------------- -->
    <div class="mb-3 col-12">
      <label class="form-label" for="resumo">Resumo</label>
      <textarea id="resumo" name="resumo" rows="4" maxlength="1000"
                class="form-control"
                placeholder="Breve descrição do projeto"><?= setValor('resumo') ?></textarea>
    </div>

  </div>

  <div class="m-3">
    <?= formButton() ?>
  </div>
</form>
