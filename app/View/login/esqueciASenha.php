<?php /* tela “Esqueci a senha” */ ?>

<?= formTitulo('Recuperar senha', 'col-lg-4') ?>

<div class="card col-lg-4 mx-auto card-background">
    <div class="card-header text-center">
        <h3>Esqueceu sua senha</h3>
    </div>

    <div class="card-body">
        <form action="<?= baseUrl()?>login/esqueciASenhaEnvio" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">E-mail</label>
                <input  type="email"
                        class="form-control border-dark mt-2"
                        id="email"
                        name="email"
                        placeholder="informe seu e-mail"
                        value="<?= setValor('email') ?>"
                        required
                        autofocus>
                <small class="text-muted">Você receberá um link para criar
                    uma nova senha.</small>
            </div>

            <?= exibeAlerta() ?>

            <div class="d-flex justify-content-between mt-3">
                <button class="btn btn-primary">Enviar</button>
                <a href="<?= baseUrl()?>login" class="btn btn-outline-primary">Voltar</a>
            </div>
        </form>
    </div>
</div>
