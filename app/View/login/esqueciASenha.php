<?php
/* -------------------------------------------------------------
 | Tela “Esqueci a senha” – mantém a lógica original
 | ------------------------------------------------------------ */
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-5">
      <div class="card shadow-sm">
        <!-- Cabeçalho padrão (gradiente) -->
        <div class="card-header bg-secondary text-white text-center py-4">
          <h3 class="mb-0">Recuperar senha</h3>
        </div>

        <div class="card-body px-4 py-5">
          <form action="<?= baseUrl() ?>login/esqueciASenhaEnvio" method="POST">
            <label class="form-label">E-mail cadastrado *</label>
            <input id="email" name="email" type="email" maxlength="150" class="form-control mb-3" value="<?= setValor('email') ?>" required autofocus>

            <small class="text-muted d-block mb-4">Você receberá um link para criar uma nova senha.</small>

            <?= exibeAlerta() ?>

            <div class="text-center">
              <button class="btn btn-primary btn-padrao">Enviar link</button>
              <a href="<?= baseUrl() ?>login" class="btn btn-outline-secondary btn-padrao">Voltar</a>
            </div>
          </form>
        </div><!-- /.card-body -->
      </div><!-- /.card -->
    </div>
  </div>
</div>
