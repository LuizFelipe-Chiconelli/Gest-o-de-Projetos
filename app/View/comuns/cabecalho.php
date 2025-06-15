<?php
/*--------------------------------------------------------------------
| CABEÇALHO PADRÃO – Projeto de Gestão
| • baseUrl()     helper global para montar links/arquivos
| • Session::get  usado para exibir menus quando logado
| • Níveis        1  = super-admin   (acesso total)
|                 11 = admin         (acesso total)
|                 21 = usuário comum (só vê/usa o que liberarmos)
*-------------------------------------------------------------------*/
use Core\Library\Session;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Gerenciador de Projetos</title>

    <!-- favicon -->
    <link rel="icon" href="<?= baseUrl()?>assets/img/AtomPHP-icone.png" type="image/png">

    <!-- Bootstrap local -->
    <link rel="stylesheet" href="<?= baseUrl()?>assets/bootstrap/css/bootstrap.min.css">

    <!-- DataTables CDN + skin Bootstrap -->
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="<?= baseUrl()?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Seu CSS extra -->
    <link rel="stylesheet" href="<?= baseUrl()?>assets/css/app.css">
</head>

<body>
<header class="container-fluid">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">

            <!-- LOGO -->
            <a class="navbar-brand" href="<?= baseUrl()?>">
                <img src="<?= baseUrl()?>assets/img/AtomPHP-logo.png" alt="Logo" width="90" height="90">
            </a>

            <!-- Botão hambúrguer (celular) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navbarNav" class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <!-- links públicos -->
                    <li class="nav-item"><a class="nav-link" href="<?= baseUrl()?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Quem Somos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Produtos/Serviços</a></li>

                    <?php if (Session::get('userId')): ?>
                        <!-- ===== áreas protegidas – somente pessoas logadas ===== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#"
                               id="menuProjetos" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                Projetos
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= baseUrl()?>projeto">Lista de Projetos</a></li>
                                <li><a class="dropdown-item" href="<?= baseUrl()?>projeto/form/insert/0">Novo Projeto</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= baseUrl()?>reuniao">Reuniões</a></li>
                                <li><a class="dropdown-item" href="<?= baseUrl()?>entrega">Entregas</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#"
                               id="menuPessoas" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                Pessoas
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= baseUrl()?>professor">Professores</a></li>
                                <li><a class="dropdown-item" href="<?= baseUrl()?>aluno">Alunos</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Bloco à direita (login / usuário) -->
                <ul class="navbar-nav">
                    <?php if (Session::get('userId')): ?>
                        <?php $nivel = (int)Session::get('userNivel'); ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#"
                               role="button" data-bs-toggle="dropdown">
                               <?= Session::get('userNome') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <!-- Administrador vê mais coisas -->
                                <?php if ($nivel <= 20): ?>
                                    <a class="dropdown-item" href="<?= baseUrl()?>usuario">Gerenciar usuários</a>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>

                                <li><a class="dropdown-item" href="<?= baseUrl()?>usuario/formTrocarSenha">Trocar senha</a></li>
                                <li><a class="dropdown-item" href="<?= baseUrl()?>login/signOut">Sair</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= baseUrl()?>login">Área restrita</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>

<main class="container">
