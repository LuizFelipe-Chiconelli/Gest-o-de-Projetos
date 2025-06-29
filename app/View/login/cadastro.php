<?php
/* -------------------------------------------------------------
 | Tela de Cadastro (public) – mantém a mesma lógica
 |------------------------------------------------------------- */
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-6 col-xl-5">
      <div class="card shadow-sm">
        <!-- Cabeçalho padrão (gradiente via forms.css) -->
        <div class="card-header bg-secondary text-white text-center py-4">
          <h3 class="mb-0">Cadastro</h3>
        </div>

        <div class="card-body px-4 py-5">
          <form action="<?= baseUrl() ?>Usuario/registraUsuario" method="post">
            <h6 class="section-title">Dados pessoais</h6>
            <hr class="section-divider"/>

            <div class="row g-4">
              <!-- Nome -->
              <div class="col-12">
                <label class="form-label">Nome completo *</label>
                <input id="register-name" name="register-name" type="text" maxlength="60" class="form-control" required autofocus>
              </div>

              <!-- Email -->
              <div class="col-12">
                <label class="form-label">E‑mail *</label>
                <input id="register-email" name="register-email" type="email" maxlength="150" class="form-control" required>
              </div>

              <!-- Tipo de usuário -->
              <div class="col-12">
                <label class="form-label fw-semibold">Tipo de usuário *</label>
                <select id="nivel" name="nivel" class="form-select" required onchange="mostrarCamposExtras()">
                  <option value="">Selecione…</option>
                  <option value="11">Administrador</option>
                  <option value="21">Professor</option>
                  <option value="31">Aluno</option>
                </select>
              </div>

              <div id="camposExtras" class="col-12"></div>

              <!-- Senhas -->
              <div class="col-12 col-lg-6">
                <label class="form-label">Senha *</label>
                <input id="register-password" name="register-password" type="password" class="form-control" required>
              </div>
              <div class="col-12 col-lg-6">
                <label class="form-label">Confirmar senha *</label>
                <input id="confirm-register-password" name="confirm-register-password" type="password" class="form-control" required>
              </div>

              <div class="col-12 small text-danger" id="mensagemSenha"></div>
            </div><!-- /.row -->

            <div class="text-center pt-4">
              <button id="btnRegistrar" class="btn btn-primary btn-padrao" disabled>Registrar</button>
              <a href="<?= baseUrl() ?>login" class="btn btn-outline-secondary btn-padrao">Entrar</a>
            </div>
          </form>
        </div><!-- /.card-body -->
      </div><!-- /.card -->
    </div>
  </div>
</div>

<script>
function mostrarCamposExtras() {
  const n   = document.getElementById('nivel').value;
  const div = document.getElementById('camposExtras');
  div.innerHTML = '';
  if (n === '31') {
    div.innerHTML = `
      <label class="form-label">Curso *</label>
      <select name="curso" class="form-select" required>
        <option value="">Selecione o curso</option>
        <option>Análise e Desenvolvimento de Sistemas</option>
        <option>Matemática</option>
        <option>Engenharia de Computação</option>
        <option>Administração</option>
        <option>Sistemas de Informação</option>
        <option>Ciência da Computação</option>
        <option>Engenharia Elétrica</option>
        <option>GTI</option>
      </select>`;
  } else if (n === '21') {
    div.innerHTML = `
      <label class="form-label">Especialidade *</label>
      <input name="especialidade" type="text" class="form-control mb-3" required>
      <label class="form-label">Área *</label>
      <input name="area" type="text" class="form-control" required>`;
  }
}

function validarSenha() {
  const s1   = document.getElementById('register-password').value;
  const s2   = document.getElementById('confirm-register-password').value;
  const out  = document.getElementById('mensagemSenha');
  const btn  = document.getElementById('btnRegistrar');
  let msg = '';
  if (s1.length < 6) msg += 'A senha deve ter ao menos 6 caracteres.<br>';
  if (s1 !== s2)    msg += 'As senhas não coincidem.<br>';
  out.innerHTML = msg;
  btn.disabled  = msg !== '';
}

['DOMContentLoaded','input'].forEach(evt => {
  if (evt==='DOMContentLoaded') document.addEventListener(evt, () => {
    document.getElementById('register-password').addEventListener('keyup', validarSenha);
    document.getElementById('confirm-register-password').addEventListener('keyup', validarSenha);
  });
});
</script>
