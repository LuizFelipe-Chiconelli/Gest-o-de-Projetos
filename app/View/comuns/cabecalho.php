<?php
use Core\Library\Session;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Gerenciador de Projetos</title>

  <!-- FAVICON / BOOTSTRAP -->
  <link rel="icon" href="<?= baseUrl() ?>assets/img/icone-gp-system.png" type="image/png">
  <link rel="stylesheet" href="<?= baseUrl() ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= baseUrl() ?>assets/css/app.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="<?= baseUrl() ?>assets/bootstrap/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-light">
 <header class="sticky-top bg-white border-bottom shadow-sm">
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">

      <!-- LOGO + NOME -->
      <a class="navbar-brand d-flex align-items-center gap-2 text-primary fw-bold"
         href="<?= baseUrl() ?>">
        <img src="<?= baseUrl() ?>assets/img/logo-gp-system.png"
             alt="GP System" width="80" height="80" class="rounded-circle">
      </a>

      <!-- TOGGLER (Mobile) -->
      <button class="navbar-toggler border-0" type="button"
              data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false"
              aria-label="Alternar navegação">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- LINKS -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <!-- Itens do menu -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-3">
          <li class="nav-item">
            <a class="nav-link text-primary fw-semibold" href="<?= baseUrl() ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary fw-semibold" href="<?= baseUrl() ?>site/quemSomos">Quem Somos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary fw-semibold" href="<?= baseUrl() ?>site/produtosServicos">Produtos/Serviços</a>
          </li>

          <?php if (Session::get('userId')): ?>
            <?php $nivel = (int) Session::get('userNivel'); ?>

            <?php if ($nivel === 31): ?>
              <li class="nav-item">
                <a class="nav-link text-primary fw-semibold" href="<?= baseUrl() ?>sistema/listaAlunoProjReuniao">
                  Meus Projetos
                </a>
              </li>
            <?php endif; ?>

            <?php if ($nivel <= 21): ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-primary fw-semibold"
                   href="#" role="button" data-bs-toggle="dropdown">
                  Projetos
                </a>
                <ul class="dropdown-menu border-0 rounded shadow-sm">
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
                <a class="nav-link dropdown-toggle text-primary fw-semibold"
                   href="#" role="button" data-bs-toggle="dropdown">
                  Pessoas
                </a>
                <ul class="dropdown-menu border-0 rounded shadow-sm">
                  <li><a class="dropdown-item" href="<?= baseUrl() ?>professor">Professores</a></li>
                  <li><a class="dropdown-item" href="<?= baseUrl() ?>aluno">Alunos</a></li>
                </ul>
              </li>
            <?php endif; ?>
          <?php endif; ?>
        </ul>

        <!-- Login / Perfil -->
        <ul class="navbar-nav align-items-lg-center gap-lg-3">
          <?php if (Session::get('userId')): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-primary fw-semibold"
                 href="#" role="button" data-bs-toggle="dropdown">
                <?= Session::get('userNome') ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end border-0 rounded shadow-sm">
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
              <a class="btn btn-outline-primary fw-semibold" href="<?= baseUrl() ?>login">Área restrita</a>
            </li>
          <?php endif; ?>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav>
</header>



  <main class="container py-4">
