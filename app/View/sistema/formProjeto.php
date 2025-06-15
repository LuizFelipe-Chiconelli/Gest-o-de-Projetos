<?php
/*  Formulário de Projeto
 *  Carrega professores ordenados por nome
*/
  $profModel = new \App\Model\ProfessorModel();
  $listaProf = $profModel->lista('nome');

  $alunoModel = new \App\Model\AlunoModel();
  $todosAlunos = $alunoModel->lista('nome');
  /* alunos já vinculados */
  $alVinc = [];               // default vazio
  if ($this->request->getAction()!='insert') {
      $pivot = new \App\Model\ProjetoAlunoModel();
      $alVinc = $pivot->db
                ->where('projeto_id', setValor('id'))
                ->select('aluno_id')
                ->findAll();   // array de arrays
      $alVinc = array_column($alVinc,'aluno_id');
  }
?>

<?= formTitulo('Projeto') ?>
<form method="POST" action="<?= $this->request->formAction() ?>">

    <!-- id = 0 quando for novo registro -->
    <input type="hidden" name="id" id="id" value="<?= setValor('id',0) ?>">

    <div class="row m-2">

        <!-- TÍTULO -------------------------------------------------------- -->
        <div class="mb-3 col-8">
            <label for="titulo" class="form-label">Título *</label>
            <input type="text"
                   class="form-control"
                   id="titulo"
                   name="titulo"
                   maxlength="100"
                   placeholder="Nome do projeto"
                   value="<?= setValor('titulo') ?>"
                   required
                   autofocus>
            <?= setMsgFilderError('titulo') ?>
        </div>
        
        <!--CAIXA ROLAVEL DE ALUNOS VINCULADOS-->
        <div class="mb-3 col-6">
            <label class="form-label">Alunos vinculados</label>

            <div class="lista-alunos p-2 border rounded">
                <?php foreach ($todosAlunos as $a): ?>
                    <div class="form-check">
                        <input  class="form-check-input"    
                                type="checkbox"
                                name="alunos_id[]"
                                value="<?= $a['id'] ?>"
                                <?= in_array($a['id'],$alVinc)?'checked':'' ?>>
                        <label class="form-check-label"><?= $a['nome'] ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>



        <!-- COMBOBOX DOS PROFESSORES--> 
        <div class="mb-3 col-6">
            <label class="form-label">Professor *</label>
            <select name="professor_id" class="form-select" required>
                <option value="">...</option>
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
        <div class="mb-3 col-4">
            <label for="area" class="form-label">Área *</label>
            <input type="text"
                   class="form-control"
                   id="area"
                   name="area"
                   maxlength="50"
                   placeholder="Área de conhecimento"
                   value="<?= setValor('area') ?>"
                   required>
            <?= setMsgFilderError('area') ?>
        </div>

        <!-- STATUS -------------------------------------------------------- -->
        <div class="mb-3 col-4">
            <label for="status" class="form-label">Status *</label>
            <select class="form-select" id="status" name="status" required>
                <?php
                    $sel = setValor('status','Ativo');        // valor padrão
                    foreach (['Ativo','Concluído','Pausado'] as $opt){
                        $s = $sel == $opt ? 'selected' : '';
                        echo "<option $s>$opt</option>";
                    }
                ?>
            </select>
            <?= setMsgFilderError('status') ?>
        </div>

        <!-- DATA DE INÍCIO ------------------------------------------------ -->
        <div class="mb-3 col-4">
            <label for="inicio" class="form-label">Data de início *</label>
            <input type="date"
                   class="form-control"
                   id="inicio"
                   name="inicio"
                   value="<?= setValor('inicio') ?>"
                   required>
        </div>

        <!-- PREVISÃO DE TÉRMINO ------------------------------------------ -->
        <div class="mb-3 col-4">
            <label for="previsao_termino" class="form-label">Previsão de término</label>
            <input type="date"
                   class="form-control"
                   id="previsao_termino"
                   name="previsao_termino"
                   value="<?= setValor('previsao_termino') ?>">
        </div>

        <!-- RESUMO -------------------------------------------------------- -->
        <div class="mb-3 col-12">
            <label for="resumo" class="form-label">Resumo</label>
            <textarea class="form-control"
                      id="resumo"
                      name="resumo"
                      rows="4"
                      maxlength="1000"
                      placeholder="Breve descrição do projeto"><?= setValor('resumo') ?></textarea>
        </div>

    </div>

    <!-- BOTÕES -->
    <div class="m-3">
        <?= formButton() ?>
    </div>
</form>