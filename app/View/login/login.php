<?php
/*-----------------------------------------------------------------
 | Tela de login
 | – Usa helpers: formTitulo(), exibeAlerta(), setValor()
 | – action → login/signIn   (método já existente)
 *----------------------------------------------------------------*/
?>

<div class="card col-lg-4 mx-auto card-background">
    <div class="card-header text-center">
        <h3 class="m-0">Login</h3>
    </div>

    <div class="card-body">
        <form action="<?= baseUrl()?>login/signIn" method="POST">

            <!-- E-MAIL ------------------------------------------------ -->
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input  type="email"
                        class="form-control border-dark"
                        id="email"
                        name="email"
                        placeholder="informe seu e-mail"
                        value="<?= setValor('email') ?>"
                        required
                        autofocus>
            </div>

            <!-- SENHA ------------------------------------------------- -->
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input  type="password"
                        class="form-control border-dark"
                        id="senha"
                        name="senha"
                        required>
            </div>

            <!-- LINKS + ALERTAS ------------------------------------- -->
            <div class="d-flex justify-content-between mb-2">
                <a href="<?= baseUrl()?>login/esqueciASenha"
                   class="text-decoration-none">Esqueci a senha</a>
            </div>

            <?= exibeAlerta() ?>

            <!-- BOTÕES ----------------------------------------------- -->
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary">Entrar</button>
                <a href="<?= baseUrl()?>" class="btn btn-outline-primary">Voltar</a>
            </div>
        </form>
    </div>
</div>
