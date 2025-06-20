<?php
/*-----------------------------------------------------------------
 | Tela de recuperação (recuperarSenha.php)
 *----------------------------------------------------------------*/
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
      <div class="card border-0 shadow-lg">
        
        <!-- CABEÇALHO -->
        <div class="card-header bg-info text-white text-center py-4">
          <i class="fas fa-unlock-alt fa-2x mb-2"></i>
          <h5 class="mb-0">Nova Senha</h5>
        </div>
        
        <!-- CORPO -->
        <div class="card-body p-4">
          <p>Olá <strong><?= $dados['nome'] ?></strong>, escolha sua nova senha:</p>
          
          <form action="<?= baseUrl() ?>login/atualizaRecuperaSenha" method="POST">
            <input type="hidden" name="id"  value="<?= $dados['id'] ?>">
            <input type="hidden" name="usuariorecuperasenha_id"
                   value="<?= $dados['usuariorecuperasenha_id'] ?>">
            
            <div class="form-floating mb-3">
              <input type="password"
                     class="form-control border-info"
                     id="NovaSenha" name="NovaSenha"
                     placeholder="Nova senha"
                     required
                     onkeyup="checa_segur_senha('NovaSenha','msg1','btnOk')">
              <label for="NovaSenha">Nova Senha</label>
            </div>
            <div id="msg1" class="small text-muted mb-3"></div>
            
            <div class="form-floating mb-4">
              <input type="password"
                     class="form-control border-info"
                     id="NovaSenha2" name="NovaSenha2"
                     placeholder="Repita a senha"
                     required
                     onkeyup="checa_segur_senha('NovaSenha2','msg2','btnOk')">
              <label for="NovaSenha2">Confirmar Senha</label>
            </div>
            <div id="msg2" class="small text-muted mb-3"></div>
            
            <?= exibeAlerta() ?>
            
            <div class="d-grid gap-2">
              <button id="btnOk" class="btn btn-info btn-lg" disabled>
                Atualizar Senha
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
