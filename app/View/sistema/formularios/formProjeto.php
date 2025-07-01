<?php

$data = $data ?? [];

// auxiliares
$profModel  = new \App\Model\ProfessorModel();
$listaProf  = $profModel->lista('nome');

$alunoModel = new \App\Model\AlunoModel();
$todosAlunos= $alunoModel->listaComCurso();


$alVinc = [];
if ($this->request->getAction() !== 'insert') {
    $pivot = new \App\Model\ProjetoAlunoModel();
    $rows  = $pivot->db
                   ->where('projeto_id', $data['id'] ?? 0)
                   ->select('aluno_id')
                   ->findAll();
    // extrai só os IDs
    $alVinc = array_column($rows, 'aluno_id');
}

$profFix = $profLogado ?? null;
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
          <h3 class="mb-0">
            Projeto <?= formSubTitulo($this->request->getAction()) ?>
          </h3>
          <a href="<?= baseUrl().$this->request->getController() ?>"
             class="btn btn-outline-light">
            Voltar
          </a>
        </div>

        <div class="card-body px-4 py-5">
          <form method="POST" action="<?= $this->request->formAction() ?>">
            <!-- 3) hidden id: defaultiza para $data['id'] -->
            <input type="hidden" name="id"
                   value="<?= setValor('id', $data['id'] ?? 0) ?>">

            <!-- ─── Informações básicas ────────────────────────── -->
            <h6 class="section-title">Informações básicas</h6>
            <hr class="section-divider">

            <div class="row g-4">
              <!-- Título -->
              <div class="col-12 col-lg-8">
                <label class="form-label">Título *</label>
                <input name="titulo" type="text" maxlength="100"
                  class="form-control"
                  value="<?= setValor('titulo', $data['titulo'] ?? '') ?>"
                  required>
                <?= setMsgFilderError('titulo') ?>
              </div>

              <!-- Professor -->
              <div class="col-12 col-lg-4">
                <label class="form-label">Professor *</label>
                <?php if ($profFix): ?>
                  <div class="form-control-plaintext">
                    <?= ($profModel->getById($profFix))['nome'] ?>
                  </div>
                  <input type="hidden" name="professor_id" value="<?= $profFix ?>">
                <?php else: ?>
                  <select name="professor_id" class="form-select" required>
                    <option value="">Selecione…</option>
                    <?php foreach ($listaProf as $p): ?>
                      <option value="<?= $p['id'] ?>"
                        <?= (setValor('professor_id', $data['professor_id'] ?? '') == $p['id'])
                           ? 'selected' : '' ?>>
                        <?= $p['nome'] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <?= setMsgFilderError('professor_id') ?>
                <?php endif; ?>
              </div>

              <!-- Área -->
              <div class="col-12 col-lg-4">
                <label class="form-label">Área *</label>
                <input name="area" type="text" maxlength="50"
                  class="form-control"
                  value="<?= setValor('area', $data['area'] ?? '') ?>"
                  required>
                <?= setMsgFilderError('area') ?>
              </div>

              <!-- Status -->
              <div class="col-12 col-lg-4">
                <label class="form-label">Status *</label>
                <?php $sel = setValor('status', $data['status'] ?? 'Ativo'); ?>
                <select name="status" class="form-select">
                  <?php foreach (['Ativo','Concluído','Pausado'] as $opt): ?>
                    <option <?= $sel == $opt ? 'selected' : '' ?>>
                      <?= $opt ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Datas -->
              <div class="col-6 col-lg-4">
                <label class="form-label">Data início *</label>
                <input id="inicio" name="inicio" type="date"
                  class="form-control"
                  value="<?= setValor('inicio', $data['inicio'] ?? '') ?>"
                  min="<?= date('Y-m-d') ?>" required>
              </div>
              <div class="col-6 col-lg-4">
                <label class="form-label">Previsão término</label>
                <input id="previsao_termino" name="previsao_termino" type="date"
                  class="form-control"
                  value="<?= setValor('previsao_termino', $data['previsao_termino'] ?? '') ?>">
              </div>

              <!-- Resumo -->
              <div class="col-12">
                <label class="form-label">Resumo</label>
                <textarea name="resumo" rows="3" maxlength="1000"
                  class="form-control"
                  placeholder="Breve descrição do projeto"><?= 
                    setValor('resumo', $data['resumo'] ?? '') 
                  ?></textarea>
              </div>
            </div>

            <!-- ─── Alunos vinculados ───────────────────────────── -->
            <h6 class="section-title mt-4">Alunos vinculados</h6>
            <hr class="section-divider">

            <input id="buscaAlunos" type="search"
                   class="form-control form-control-sm mb-3"
                   placeholder="Buscar por nome ou curso…">

            <div id="listaAlunos" class="border rounded">
              <div id="listaAlunos-header"
                   class="d-flex fw-semibold px-3 py-2 small bg-light border-bottom">
                <div style="width:28px"></div>
                <div class="flex-grow-1">Nome</div>
                <div style="width:35%">Curso</div>
              </div>

              <?php foreach ($todosAlunos as $a):
                $busca = mb_strtolower(trim($a['nome'].' '.$a['curso']));
                $checked = in_array($a['id'], $alVinc) ? 'checked' : '';
              ?>
                <label class="d-flex align-items-center px-3 py-2 border-bottom aluno-item"
                       data-busca="<?= $busca ?>"
                       style="cursor:pointer">
                  <input type="checkbox"
                         class="form-check-input me-2"
                         name="alunos_id[]"
                         value="<?= $a['id'] ?>"
                         <?= $checked ?>>

                  <span class="flex-grow-1"><?= $a['nome'] ?></span>
                  <span style="width:35%" class="text-muted small">
                    <?= $a['curso'] ?>
                  </span>
                </label>
              <?php endforeach; ?>
            </div>

            <div class="text-center pt-4">
              <?= formButton() ?>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // filtro e clique continuam iguais
  const busca = document.getElementById('buscaAlunos');
  const itens = document.querySelectorAll('#listaAlunos .aluno-item');

  const filtra = () => {
    const termo = busca.value.trim().toLowerCase();
    itens.forEach(i => i.classList.toggle('d-none',
      !i.dataset.busca.includes(termo)
    ));
  };
  busca.addEventListener('input',  filtra);
  busca.addEventListener('keyup',  filtra);
  filtra();

  itens.forEach(i => i.addEventListener('click', e => {
    if (e.target.tagName==='INPUT') return;
    const ck = i.querySelector('input');
    ck.checked = !ck.checked;
    i.classList.toggle('bg-light', ck.checked);
  }));
});
</script>
