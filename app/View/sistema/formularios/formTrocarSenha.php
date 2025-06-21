<?php
// formTrocarSenha.php

use Core\Library\Session;
$idUsuario = Session::get('userId');
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card border-0 shadow-lg">
        <!-- HEADER -->
        <div class="card-header bg-primary text-white text-center py-4">
          <i class="fas fa-lock fa-2x mb-2"></i>
          <h5 class="mb-0">Trocar Senha</h5>
        </div>
        <div class="card-body p-4">
          <form method="POST" action="<?= baseUrl() ?>usuario/updateNovaSenha">
            <input type="hidden" name="id" value="<?= $idUsuario ?>">

            <div class="form-floating mb-3">
              <input type="password" 
                     class="form-control border-primary" 
                     id="senhaAtual" name="senhaAtual" 
                     placeholder="Senha Atual" required>
              <label for="senhaAtual">Senha Atual</label>
            </div>

            <div class="form-floating mb-3">
              <input type="password" 
                     class="form-control border-primary" 
                     id="novaSenha" name="novaSenha" 
                     placeholder="Nova Senha" required>
              <label for="novaSenha">Nova Senha</label>
            </div>

            <div class="form-floating mb-4">
              <input type="password" 
                     class="form-control border-primary" 
                     id="novaSenha2" name="novaSenha2" 
                     placeholder="Confirme a Nova Senha" required>
              <label for="novaSenha2">Confirme a Nova Senha</label>
            </div>

            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary btn-lg">
                Atualizar Senha
              </button>
              <a href="<?= baseUrl() ?>sistema" 
                 class="btn btn-outline-secondary btn-lg">
                Cancelar
              </a>
            </div>

            <?= exibeAlerta() ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
