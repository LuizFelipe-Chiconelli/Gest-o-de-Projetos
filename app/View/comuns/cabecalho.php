<?php
use Core\Library\Session;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Gerenciador de Projetos</title>

  <!-- Favicon & CSS -->
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="icon" href="<?= baseUrl() ?>assets/img/icone-gp-system.png" type="image/png">
  <link rel="stylesheet" href="<?= baseUrl() ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= baseUrl() ?>assets/css/app.css">
  <link rel="stylesheet" href="<?= baseUrl() ?>assets/css/forms.css">
  <link rel="stylesheet" href="<?= baseUrl() ?>assets/css/navbar.css">
  <link rel="stylesheet" href="<?= baseUrl() ?>assets/css/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?= baseUrl() ?>assets/css/home.css">


<!-- NOVO -->

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="<?= baseUrl() ?>assets/bootstrap/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-light">

<!-- ===== NAVBAR ==================================================== -->
<header class="sticky-top navbar-main">
  <nav class="navbar navbar-expand-lg">
    <div class="container">

      <!-- LOGO -->
      <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="<?= baseUrl() ?>">
        <img src="<?= baseUrl() ?>assets/img/logo-gp-system.png" alt="GP System" width="68" height="68">
      </a>

      <!-- TOGGLER -->
      <button class="navbar-toggler" type="button"
              data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- LINKS -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-item"><a class="nav-link active"    href="<?= baseUrl() ?>">HOME</a></li>
          <li class="nav-item"><a class="nav-link"           href="<?= baseUrl() ?>site/quemSomos">SOBRE NÓS</a></li>
          <li class="nav-item"><a class="nav-link"           href="<?= baseUrl() ?>site/produtosServicos">PRODUTOS/SERVIÇOS</a></li>

          <?php if (Session::get('userId')): ?>
            <?php $nivel = (int) Session::get('userNivel'); ?>

            <?php if ($nivel === 31): ?>
              <li class="nav-item"><a class="nav-link" href="<?= baseUrl() ?>sistema/listaAlunoProjReuniao">MEUS PROJETOS</a></li>
            <?php endif; ?>

            <?php if ($nivel <= 21): ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">PROJETOS</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="<?= baseUrl() ?>projeto">Lista</a></li>
                  <?php if ($nivel <= 11): ?>
                    <li><a class="dropdown-item" href="<?= baseUrl() ?>projeto/form/insert/0">Novo</a></li>
                  <?php endif; ?>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="<?= baseUrl() ?>reuniao">Reuniões</a></li>
                  <li><a class="dropdown-item" href="<?= baseUrl() ?>entrega">Entregas</a></li>
                </ul>
              </li>
            <?php endif; ?>

            <?php if ($nivel <= 11): ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">PESSOAS</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="<?= baseUrl() ?>professor">Professores</a></li>
                  <li><a class="dropdown-item" href="<?= baseUrl() ?>aluno">Alunos</a></li>
                </ul>
              </li>
            <?php endif; ?>
          <?php endif; ?>
        </ul>

        <!-- LOGIN / PERFIL -->
        <ul class="navbar-nav align-items-lg-center">
          <?php if (Session::get('userId')): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                <?= Session::get('userNome') ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php if ($nivel <= 11): ?>
                  <li><a class="dropdown-item" href="<?= baseUrl() ?>usuario">Usuários</a></li>
                  <li><hr class="dropdown-divider"></li>
                <?php endif; ?>
                <li><a class="dropdown-item" href="<?= baseUrl() ?>usuario/formTrocarSenha">Trocar senha</a></li>
                <li><a class="dropdown-item" href="<?= baseUrl() ?>login/signOut">Sair</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="btn btn-auth" href="<?= baseUrl() ?>login">Área restrita</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div><!-- /.container -->
  </nav>
</header>

<main class="container py-4">
