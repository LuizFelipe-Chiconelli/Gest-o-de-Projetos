<?= formTitulo('Entrega') ?>

<form method="POST" action="<?= $this->request->formAction() ?>" enctype="multipart/form-data">
  <!-- id + arquivo atual (hidden) -->
  <input type="hidden" name="id"          value="<?= setValor('id',0) ?>">
  <?php if ($this->request->getAction() !== 'insert'): ?>
    <!-- nome do arquivo antigo (só no update) -->
    <input type="hidden" name="nomeArquivo" value="<?= setValor('arquivo') ?>">
  <?php endif; ?> 

    <div class="row m-2">
  <?php
  $proj = new \App\Model\ProjetoModel();
  $projetos = $proj->lista('titulo');
  ?>
    <div class="mb-3 col-6">
      <label class="form-label">Projeto *</label>
      <select name="projeto_id" class="form-select" required>
          <option value="">…</option>
          <?php foreach($projetos as $p): ?>
            <option value="<?=$p['id']?>"
                    <?= setValor('projeto_id')==$p['id']?'selected':'' ?>>
                <?=$p['titulo']?>
            </option>
          <?php endforeach; ?>
      </select>
      <?= setMsgFilderError('projeto_id') ?>
    </div>

    <div class="mb-3 col-lg-3">
      <label class="form-label">Data *</label>
      <input type="date" name="data" class="form-control"
             value="<?= setValor('data') ?>" required>
      <?= setMsgFilderError('data') ?>
    </div>

    <div class="mb-3 col-lg-6">
      <label class="form-label">Descrição *</label>
      <input type="text" name="descricao" maxlength="120"
             class="form-control"
             value="<?= setValor('descricao') ?>" required>
      <?= setMsgFilderError('descricao') ?>
    </div>

    <div class="mb-3 col-lg-6">
      <label class="form-label">Arquivo (opcional)</label>
      <input type="file" name="arquivo" class="form-control">
      <?php if (setValor('arquivo')): ?>
        <small class="text-muted">Atual: <?= setValor('arquivo') ?></small>
      <?php endif; ?>
    </div>

    <div class="mb-3 col-lg-3">
      <label class="form-label">Status *</label>
      <select name="status" class="form-select" required>
        <?php foreach (['Pendente','Entregue','Atrasado'] as $st): ?>
          <option <?= setValor('status','Pendente')==$st?'selected':'' ?>>
            <?= $st ?>
          </option>
        <?php endforeach; ?>
      </select>
      <?= setMsgFilderError('status') ?>
    </div>

  </div>

  <div class="m-3">
    <?= formButton() ?>
  </div>
</form>
