<?php
/* -------------------------------------------------------------
 | Tela de definição de nova senha (link de recuperação)
 | ------------------------------------------------------------ */
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-5">
      <div class="card shadow-sm">
        <!-- Cabeçalho padrão -->
        <div class="card-header bg-secondary text-white text-center py-4">
          <h3 class="mb-0">Nova senha</h3>
        </div>

        <div class="card-body px-4 py-5">
          <p class="mb-4">Olá <strong><?= $dados['nome'] ?></strong>, escolha sua nova senha:</p>

          <form action="<?= baseUrl() ?>login/atualizaRecuperaSenha" method="POST">
            <input type="hidden" name="id"  value="<?= $dados['id'] ?>">
            <input type="hidden" name="usuariorecuperasenha_id" value="<?= $dados['usuariorecuperasenha_id'] ?>">

            <div class="row g-4">
              <div class="col-12 col-lg-6">
                <label class="form-label">Nova senha *</label>
                <input id="NovaSenha" name="NovaSenha" type="password" class="form-control" required>
                <small id="msg1" class="text-muted"></small>
              </div>
              <div class="col-12 col-lg-6">
                <label class="form-label">Confirmar senha *</label>
                <input id="NovaSenha2" name="NovaSenha2" type="password" class="form-control" required>
                <small id="msg2" class="text-muted"></small>
              </div>
            </div>

            <?= exibeAlerta() ?>

            <div class="text-center pt-4">
              <button id="btnOk" class="btn btn-primary btn-padrao" disabled>Atualizar senha</button>
            </div>
          </form>
        </div><!-- /.card-body -->
      </div><!-- /.card -->
    </div>
  </div>
</div>

<script>
const senha1 = document.getElementById('NovaSenha');
const senha2 = document.getElementById('NovaSenha2');
const btn    = document.getElementById('btnOk');
const msg1   = document.getElementById('msg1');
const msg2   = document.getElementById('msg2');

function validar() {
  const s1 = senha1.value.trim();
  const s2 = senha2.value.trim();
  msg1.textContent = s1.length < 6 && s1 ? 'Mín. 6 caracteres.' : '';
  msg2.textContent = (s1 && s2 && s1 !== s2) ? 'As senhas não coincidem.' : '';
  btn.disabled = !(s1.length >= 6 && s1 === s2);
}
['input','keyup'].forEach(evt => {
  senha1.addEventListener(evt, validar);
  senha2.addEventListener(evt, validar);
});
</script>
