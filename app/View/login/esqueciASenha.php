<?php
/*-----------------------------------------------------------------
 | Tela “Esqueci a senha” (esqueciASenha.php)
 *----------------------------------------------------------------*/
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
      <div class="card border-0 shadow-lg">
        
        <!-- CABEÇALHO -->
        <div class="card-header bg-warning text-white text-center py-4">
          <i class="fas fa-key fa-2x mb-2"></i>
          <h5 class="mb-0">Recuperar Senha</h5>
        </div>
        
        <!-- CORPO -->
        <div class="card-body p-4">
          <form action="<?= baseUrl() ?>login/esqueciASenhaEnvio" method="POST">
            
            <div class="form-floating mb-3">
              <input type="email" class="form-control border-warning"
                     id="email" name="email"
                     placeholder="E-mail" value="<?= setValor('email') ?>" required>
              <label for="email">E-mail</label>
            </div>
            <small class="text-muted mb-3 d-block">
              Você receberá um link para criar uma nova senha.
            </small>
            
            <?= exibeAlerta() ?>
            
            <div class="d-grid gap-2">
              <button class="btn btn-warning btn-lg">Enviar Link</button>
              <a href="<?= baseUrl() ?>login"
                 class="btn btn-outline-secondary btn-lg">
                Voltar
              </a>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
