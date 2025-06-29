    </main>

    <footer class="footer-main">
  <div class="container">

    <!-- ===== TOP GRID ================================================= -->
    <div class="row gy-4">

      <!-- COL 1 -->
      <div class="col-6 col-md-3">
        <h6 class="footer-title">Aplicação</h6>
        <ul class="list-unstyled footer-list">
          <li><a href="<?= baseUrl() ?>projeto">Projetos</a></li>
          <li><a href="<?= baseUrl() ?>reuniao">Reuniões</a></li>
          <li><a href="<?= baseUrl() ?>entrega">Entregas</a></li>
          <li><a href="<?= baseUrl() ?>site/quemSomos">Sobre nós</a></li>
        </ul>
      </div>

      <!-- COL 2 -->
      <div class="col-6 col-md-3">
        <h6 class="footer-title">Suporte</h6>
        <ul class="list-unstyled footer-list">
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Documentação</a></li>
          <li><a href="#">Tutoriais</a></li>
          <li><a href="#">Feedback</a></li>
        </ul>
      </div>

      <!-- COL 3 (social) -->
      <div class="col-6 col-md-3">
        <h6 class="footer-title">Siga-nos</h6>
        <div class="d-flex mb-3">
          <a class="social-icon" href="#"><i class="fab fa-facebook-f"></i></a>
          <a class="social-icon" href="#"><i class="fab fa-twitter"></i></a>
          <a class="social-icon" href="#"><i class="fab fa-instagram"></i></a>
          <a class="social-icon" href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>

      <!-- COL 4 (newsletter) -->
      <div class="col-6 col-md-3">
        <h6 class="footer-title">Newsletter</h6>
        <form class="news-form d-flex">
          <input type="email" class="form-control form-control-sm me-2" placeholder="Seu e-mail" required>
          <button class="btn btn-subs btn-sm">OK</button>
        </form>
      </div>

    </div><!-- /.row -->

    <!-- ===== COPYRIGHT BAR =========================================== -->
    <div class="copy-bar d-flex flex-column flex-md-row
                justify-content-between align-items-center mt-4">

      <div class="d-flex align-items-center mb-2 mb-md-0">
        <img src="<?= baseUrl() ?>assets/img/logo-gp-system.png" alt="" style="width:30px;height:30px;filter:invert(1);" class="me-2">
        GP System © 2025&nbsp;•&nbsp;FASM – Disciplina de Frameworks
      </div>

      <ul class="list-inline mb-0">
        <li class="list-inline-item"><a href="#">Termos</a></li>
        <li class="list-inline-item"><a href="#">Privacidade</a></li>
        <li class="list-inline-item"><a href="#">Contato</a></li>
      </ul>
    </div>
  </div><!-- /.container -->
</footer>

  </body>
</html>
