<?php
/* Formulário de Professor
 * – Mesma estrutura/estilo do form de Projeto
 */
?>

<?= formTitulo('Professor') ?>

<form method="POST" action="<?= $this->request->formAction() ?>">

    <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

    <div class="row m-2">

        <!-- NOME -->
        <div class="mb-3 col-6">
            <label class="form-label">Nome *</label>
            <input type="text" name="nome" class="form-control"
                   maxlength="60" placeholder="Nome completo"
                   value="<?= setValor('nome') ?>" required autofocus>
            <?= setMsgFilderError('nome') ?>
        </div>

        <!-- EMAIL -->
        <div class="mb-3 col-6">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control"
                   maxlength="150" placeholder="Email institucional"
                   value="<?= setValor('email') ?>" required>
            <?= setMsgFilderError('email') ?>
        </div>

        <!-- ESPECIALIDADE -->
        <div class="mb-3 col-6">
            <label class="form-label">Especialidade *</label>
            <input type="text" name="especialidade" class="form-control"
                   maxlength="50" placeholder="Ex.: Engenharia de Software"
                   value="<?= setValor('especialidade') ?>" required>
            <?= setMsgFilderError('especialidade') ?>
        </div>

        <!-- STATUS -->
        <div class="mb-3 col-3">
            <label class="form-label">Status *</label>
            <select name="statusRegistro" class="form-select" required>
                <option value="1" <?= setValor('statusRegistro','1')=='1'?'selected':'' ?>>Ativo</option>
                <option value="2" <?= setValor('statusRegistro')=='2'?'selected':'' ?>>Inativo</option>
            </select>
            <?= setMsgFilderError('statusRegistro') ?>
        </div>

    </div>

    <div class="m-3 text-end">
        <?= formButton() ?>
    </div>

</form>
