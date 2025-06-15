    <?php
/*  Tela que chega pelo link enviado no e-mail
 *  Recebe $dados[id] e $dados[usuariorecuperasenha_id] do controller
 */
?>

<?= formTitulo('Recuperação de senha', 'col-lg-4') ?>

<div class="card col-lg-4 mx-auto card-background">
    <div class="card-header text-center">
        <h3 class="m-0">Nova senha</h3>
    </div>

    <div class="card-body">
        <form action="<?= baseUrl()?>login/atualizaRecuperaSenha" method="POST">

            <!-- campos ocultos obrigatórios -->
            <input type="hidden" name="id"  value="<?= $dados['id'] ?>">
            <input type="hidden" name="usuariorecuperasenha_id"
                   value="<?= $dados['usuariorecuperasenha_id'] ?>">

            <p>Olá <b><?= $dados['nome'] ?></b>, digite a nova senha:</p>

            <!-- senha nova ---------------------------------------- -->
            <div class="mb-3">
                <label class="form-label">Senha nova</label>
                <input  type="password"
                        class="form-control"
                        name="NovaSenha"
                        id="NovaSenha"
                        placeholder="nova senha"
                        required
                        onkeyup="checa_segur_senha('NovaSenha','msg1','btnOk')">
                <div id="msg1" class="mt-2 small"></div>
            </div>

            <!-- confirmação --------------------------------------- -->
            <div class="mb-3">
                <label class="form-label">Confirme a senha</label>
                <input  type="password"
                        class="form-control"
                        name="NovaSenha2"
                        id="NovaSenha2"
                        placeholder="repita a senha"
                        required
                        onkeyup="checa_segur_senha('NovaSenha2','msg2','btnOk')">
                <div id="msg2" class="mt-2 small"></div>
            </div>

            <?= exibeAlerta() ?>

            <button id="btnOk" class="btn btn-primary" disabled>Atualizar</button>
        </form>
    </div>
</div>
