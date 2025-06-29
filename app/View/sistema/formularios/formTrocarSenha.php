<?php
use Core\Library\Session;
$idUsuario = Session::get('userId');
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-6">
      <div class="card shadow-sm">
        <!-- Cabeçalho -->
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Trocar senha</h3>
          <a href="<?= baseUrl() ?>sistema" class="btn btn-outline-light btn-sm">Cancelar</a>
        </div>

        <div class="card-body px-4 py-5">
          <form method="POST" action="<?= baseUrl() ?>usuario/updateNovaSenha">
            <input type="hidden" name="id" value="<?= $idUsuario ?>">

            <!-- Seção -->
            <h6 class="section-title">Defina a nova senha</h6>
            <hr class="section-divider"/>

            <div class="row g-4">
              <div class="col-12">
                <label class="form-label">Senha atual *</label>
                <input id="senhaAtual" name="senhaAtual" type="password" class="form-control" required>
              </div>

              <div class="col-12 col-lg-6">
                <label class="form-label">Nova senha *</label>
                <input id="novaSenha" name="novaSenha" type="password" class="form-control" required>
              </div>
              <div class="col-12 col-lg-6">
                <label class="form-label">Confirmar nova senha *</label>
                <input id="novaSenha2" name="novaSenha2" type="password" class="form-control" required>
              </div>
            </div>

            <div class="text-center pt-5">
              <button type="submit" class="btn btn-primary">Atualizar senha</button>
            </div>
            <?= exibeAlerta() ?>
          </form>
        </div><!-- /.card-body -->
      </div><!-- /.card -->
    </div>
  </div>
</div>
