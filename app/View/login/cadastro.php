<?php
/*-----------------------------------------------------------------
 | Tela de cadastro (cadastro.php)
 *----------------------------------------------------------------*/
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
      <div class="card border-0 shadow-lg">
        
        <!-- CABEÇALHO -->
        <div class="card-header bg-success text-white text-center py-4">
          <i class="fas fa-user-plus fa-2x mb-2"></i>
          <h5 class="mb-0">Cadastro</h5>
        </div>
        
        <!-- CORPO -->
        <div class="card-body p-4">
          <form action="<?= baseUrl() ?>Usuario/registraUsuario" method="post">
            
            <div class="form-floating mb-3">
              <input type="text" class="form-control border-success"
                     id="register-name" name="register-name"
                     placeholder="Nome completo" required>
              <label for="register-name">Nome completo</label>
            </div>
            
            <div class="form-floating mb-3">
              <input type="email" class="form-control border-success"
                     id="register-email" name="register-email"
                     placeholder="E-mail" required>
              <label for="register-email">E-mail</label>
            </div>
            
            <div class="mb-3">
              <label for="nivel" class="form-label fw-semibold">Tipo de usuário</label>
              <select id="nivel" name="nivel"
                      class="form-select border-success"
                      required onchange="mostrarCamposExtras()">
                <option value="">Selecione…</option>
                <option value="11">Administrador</option>
                <option value="21">Professor</option>
                <option value="31">Aluno</option>
              </select>
            </div>
            
            <div id="camposExtras" class="mb-3"></div>
            
            <div class="form-floating mb-3">
              <input type="password" class="form-control border-success"
                     id="register-password" name="register-password"
                     placeholder="Senha" required>
              <label for="register-password">Senha</label>
            </div>
            
            <div class="form-floating mb-4">
              <input type="password" class="form-control border-success"
                     id="confirm-register-password"
                     name="confirm-register-password"
                     placeholder="Confirmar senha" required>
              <label for="confirm-register-password">Confirmar senha</label>
            </div>
            
            <div class="d-grid gap-2">
              <div id="mensagemSenha" class="text-danger small mb-2"></div>
              <button id="btnRegistrar" class="btn btn-success btn-lg" disabled>Registrar</button>
              <a href="<?= baseUrl() ?>login"
                 class="btn btn-outline-secondary btn-lg">
                Já tem conta? Entrar
              </a>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function mostrarCamposExtras() {
    const nivel = document.getElementById("nivel").value;
    const container = document.getElementById("camposExtras");
    container.innerHTML = "";
    if (nivel === "31") {
      container.innerHTML = `
        <div class="form-floating mb-3">
          <select name="curso" class="form-select border-success" required>
            <option value="">Selecione seu curso</option>
            <option>Análise e Desenvolvimento de Sistemas</option>
            <option>Matemática</option>
            <option>Engenharia de Computação</option>
            <option>Administração</option>
            <option>Sistemas de Informação</option>
            <option>Ciência da Computação</option>
            <option>Engenharia Elétrica</option>
            <option>GTI</option>
          </select>
          <label>Curso</label>
        </div>`;
    } else if (nivel === "21") {
      container.innerHTML = `
        <div class="form-floating mb-3">
          <input type="text" name="especialidade"
                 class="form-control border-success"
                 placeholder="Especialidade" required>
          <label>Especialidade</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" name="area"
                 class="form-control border-success"
                 placeholder="Área" required>
          <label>Área de atuação</label>
        </div>`;
    }
  }

  // Validação de senha com mínimo de 6 caracteres e confirmação
  function validarSenhaSimples() {
    const senha = document.getElementById("register-password").value;
    const confirmar = document.getElementById("confirm-register-password").value;
    const mensagem = document.getElementById("mensagemSenha");
    const botao = document.getElementById("btnRegistrar");

    let texto = "";

    if (senha.length < 6) {
      texto += "A senha deve ter pelo menos 6 caracteres.<br>";
    }

    if (senha !== confirmar) {
      texto += "As senhas não coincidem.<br>";
    }

    mensagem.innerHTML = texto;
    botao.disabled = texto !== "";
  }

  document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("register-password").addEventListener("keyup", validarSenhaSimples);
    document.getElementById("confirm-register-password").addEventListener("keyup", validarSenhaSimples);
  });
</script>

