<?php
/* -------------------------------------------------------------
 | Tela de Login
 | ------------------------------------------------------------ */
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-5">
      <div class="card shadow-sm">
        <!-- Cabeçalho -->
        <div class="card-header bg-secondary text-white text-center py-4">
          <h3 class="mb-0">Entrar</h3>
        </div>

        <div class="card-body px-4 py-5">
          <form action="<?= baseUrl() ?>login/signIn" method="POST">
            <div class="row g-4">
              <!-- E-mail -->
              <div class="col-12">
                <label class="form-label">E-mail *</label>
                <input id="email" name="email" type="email" maxlength="150" class="form-control" value="<?= setValor('email') ?>" required autofocus>
              </div>

              <!-- Senha -->
              <div class="col-12">
                <label class="form-label">Senha *</label>
                <input id="senha" name="senha" type="password" class="form-control" required>
              </div>
            </div>

            <?= exibeAlerta() ?>

            <div class="d-flex justify-content-between align-items-center my-4">
              <a href="<?= baseUrl() ?>login/esqueciASenha" class="small link-primary">Esqueci minha senha</a>
              <a href="<?= baseUrl() ?>login/cadastro" class="btn btn-outline-primary btn-sm">Cadastre‑se</a>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary btn-padrao">Entrar</button>
              <a href="<?= baseUrl() ?>" class="btn btn-outline-secondary btn-padrao">Voltar</a>
            </div>
          </form>
        </div><!-- /.card-body -->
      </div><!-- /.card -->
    </div>
  </div>
</div>
