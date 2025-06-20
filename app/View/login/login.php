<?php
/*-----------------------------------------------------------------
 | Tela de login (login.php)
 *----------------------------------------------------------------*/
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
      <div class="card border-0 shadow-lg">
        
        <!-- CABEÇALHO -->
        <div class="card-header bg-primary text-white text-center py-4">
          <i class="fas fa-sign-in-alt fa-2x mb-2"></i>
          <h5 class="mb-0">Entrar</h5>
        </div>
        
        <!-- CORPO -->
        <div class="card-body p-4">
          <form action="<?= baseUrl() ?>login/signIn" method="POST">
            
            <div class="form-floating mb-3">
              <input type="email"
                     class="form-control border-primary"
                     id="email" name="email"
                     placeholder="E-mail"
                     value="<?= setValor('email') ?>"
                     required autofocus>
              <label for="email">E-mail</label>
            </div>
            
            <div class="form-floating mb-3">
              <input type="password"
                     class="form-control border-primary"
                     id="senha" name="senha"
                     placeholder="Senha"
                     required>
              <label for="senha">Senha</label>
            </div>
            
            <?= exibeAlerta() ?>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
              <a href="<?= baseUrl() ?>login/esqueciASenha"
                 class="link-primary small">
                Esqueci minha senha
              </a>
              <a href="<?= baseUrl() ?>login/cadastro"
                 class="btn btn-sm btn-outline-primary">
                Cadastre-se
              </a>
            </div>
            
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary btn-lg">
                Entrar
              </button>
              <a href="<?= baseUrl() ?>" class="btn btn-outline-secondary btn-lg">
                Voltar
              </a>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
