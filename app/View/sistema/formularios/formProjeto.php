<?php
/* ============================================================
 *  FORMULÁRIO – PROJETO  (mantém formHelper, apenas estilo melhorado)
 * ============================================================ */

/* ---------- Listas auxiliares ---------- */
$profModel   = new \App\Model\ProfessorModel();
$listaProf   = $profModel->lista('nome');

$alunoModel  = new \App\Model\AlunoModel();
$todosAlunos = $alunoModel->listaComCurso();          // id, nome, curso

/* ---------- Alunos já vinculados (em edição) ---------- */
$alVinc = [];
if ($this->request->getAction() !== 'insert') {
    $pivot  = new \App\Model\ProjetoAlunoModel();
    $vinc   = $pivot->db
                    ->where('projeto_id', setValor('id'))
                    ->select('aluno_id')
                    ->findAll();
    $alVinc = array_column($vinc, 'aluno_id');
}

/* ---------- Professor fixo quando não‑admin ---------- */
$profFix = $profLogado ?? null;
?>

<!-- ============================================================
     LAYOUT (usa forms.css)            
     ============================================================ -->
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white rounded-top d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Projeto <?= formSubTitulo($this->request->getAction()) ?></h3>
          <a href="<?= baseUrl() . $this->request->getController() ?>"
             class="btn btn-outline-light">
             Voltar
          </a>
        </div>

        <div class="card-body px-4 py-5">
          <form method="POST" action="<?= $this->request->formAction() ?>">
            <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

            <!------------- Seção: Informações básicas ------------->
            <h6 class="section-title">Informações básicas</h6>
            <hr class="section-divider">

            <div class="row g-4">
              <!-- Título -->
              <div class="col-12 col-lg-8">
                <label class="form-label">Título *</label>
                <input name="titulo" type="text" maxlength="100" class="form-control" value="<?= setValor('titulo') ?>" required>
                <?= setMsgFilderError('titulo') ?>
              </div>

              <!-- Professor -->
              <div class="col-12 col-lg-4">
                <label class="form-label">Professor *</label>
                <?php if ($profFix): ?>
                  <div class="form-control-plaintext"><?= ($profModel->getById($profFix))['nome'] ?></div>
                  <input type="hidden" name="professor_id" value="<?= $profFix ?>">
                <?php else: ?>
                  <select name="professor_id" class="form-select" required>
                    <option value="">Selecione…</option>
                    <?php foreach ($listaProf as $p): ?>
                      <option value="<?= $p['id'] ?>" <?= setValor('professor_id')==$p['id']?'selected':'' ?>><?= $p['nome'] ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= setMsgFilderError('professor_id') ?>
                <?php endif; ?>
              </div>

              <!-- Área -->
              <div class="col-12 col-lg-4">
                <label class="form-label">Área *</label>
                <input name="area" type="text" maxlength="50" class="form-control" value="<?= setValor('area') ?>" required>
                <?= setMsgFilderError('area') ?>
              </div>

              <!-- Status -->
              <div class="col-12 col-lg-4">
                <label class="form-label">Status *</label>
                <?php $sel = setValor('status','Ativo'); ?>
                <select name="status" class="form-select">
                  <?php foreach ([ 'Ativo','Concluído','Pausado'] as $opt): ?>
                    <option <?= $sel==$opt?'selected':'' ?>><?= $opt ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Datas -->
              <div class="col-6 col-lg-4">
                <label class="form-label">Data início *</label>
                <input id="inicio" name="inicio" type="date" class="form-control" value="<?= setValor('inicio') ?>" min="<?= date('Y-m-d') ?>" required>
              </div>

              <div class="col-6 col-lg-4">
                <label class="form-label">Previsão término</label>
                <input id="previsao_termino" name="previsao_termino" type="date" class="form-control" value="<?= setValor('previsao_termino') ?>">
              </div>

              <!-- Resumo -->
              <div class="col-12">
                <label class="form-label">Resumo</label>
                <textarea name="resumo" rows="3" maxlength="1000" class="form-control" placeholder="Breve descrição do projeto"><?= setValor('resumo') ?></textarea>
              </div>
            </div>

            <!------------- Seção: Alunos vinculados ------------->
            <h6 class="section-title">Alunos vinculados</h6>
            <hr class="section-divider">

            <input id="buscaAlunos" type="search" class="form-control form-control-sm mb-3" placeholder="Buscar por nome ou curso…">

            <div id="listaAlunos" class="border rounded">
              <div id="listaAlunos-header" class="d-flex fw-semibold px-3 py-2 small bg-light border-bottom">
                <div style="width:28px"></div>
                <div class="flex-grow-1">Nome</div>
                <div style="width:35%">Curso</div>
              </div>

              <?php foreach ($todosAlunos as $a): $busca = mb_strtolower(trim($a['nome'].' '.$a['curso'])); ?>
                <label class="d-flex align-items-center px-3 py-2 border-bottom aluno-item <?= in_array($a['id'],$alVinc)?'bg-light':'' ?>" data-busca="<?= $busca ?>" style="cursor:pointer">
                  <input type="checkbox" class="form-check-input me-2" name="alunos_id[]" value="<?= $a['id'] ?>" <?= in_array($a['id'],$alVinc)?'checked':'' ?>>
                  <span class="flex-grow-1"><?= $a['nome'] ?></span>
                  <span style="width:35%" class="text-muted small"><?= $a['curso'] ?></span>
                </label>
              <?php endforeach; ?>
            </div>

            <!-- Botões padrão do formHelper -->
            <div class="text-center pt-5">
              <?= formButton() ?>
            </div>
          </form>
        </div><!-- /card-body -->
      </div><!-- /card -->
    </div>
  </div>
</div>

<!-- ============================================================
     SCRIPTS  (apenas JS relacionado ao formulário)
     ============================================================ -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    /* ----- Limites de data ----- */
    const inicio = document.getElementById('inicio');
    const fim    = document.getElementById('previsao_termino');
    function fixDate() {
      if (!inicio.value) return;
      fim.min = inicio.value;
      const d = new Date(inicio.value); d.setFullYear(d.getFullYear()+1);
      fim.max = d.toISOString().slice(0,10);
    }
    inicio.addEventListener('change', fixDate); fixDate();

    /* ----- Filtro de alunos ----- */
    const busca = document.getElementById('buscaAlunos');
    const itens = document.querySelectorAll('#listaAlunos .aluno-item');
    const filtra = () => {
      const t = busca.value.trim().toLowerCase();
      itens.forEach(i => i.classList.toggle('d-none', !i.dataset.busca.includes(t)));
    };
    busca.addEventListener('input', filtra); busca.addEventListener('keyup', filtra); filtra();

    /* ----- Linha clicável ----- */
    itens.forEach(i => i.addEventListener('click', e => {
      if (e.target.tagName==='INPUT') return;
      const ck = i.querySelector('input[type=checkbox]'); ck.checked=!ck.checked;
      i.classList.toggle('bg-light', ck.checked);
    }));
  });
</script>
