<?php
/**  Dashboard do aluno
 *   Garante que sempre tenhamos arrays válidos vinda do controller. */
$dados     = $dados     ?? [];
$projetos  = $projetos  ?? ($dados['projetos']  ?? []);
$reunioes  = $reunioes  ?? ($dados['reunioes']  ?? []);
?>

<div class="container my-4">

  <!-- ╔════════════════════ PROJETOS ════════════════════╗ -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-secondary text-white fw-semibold">
      Meus Projetos
    </div>

    <div class="card-body p-0 table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width:60px">ID</th>
            <th>Título</th>
            <th>Área</th>
            <th>Status</th>
            <th style="width:140px">Previsão</th>
            <th style="width:110px"></th><!-- Botão Entregar -->
          </tr>
        </thead>

        <tbody>
        <?php foreach ($projetos as $p): ?>
          <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['titulo'] ?></td>
            <td><?= $p['area'] ?></td>
            <td><?= $p['status'] ?></td>
            <td>
              <?= $p['previsao_termino']
                     ? date('d/m/Y', strtotime($p['previsao_termino']))
                     : '–' ?>
            </td>
            <td class="text-center">
              <?php
                /* ─── só exibe o botão se NÃO estiver finalizado ─── */
                $status = strtolower(trim($p['status']));
                $jaFinalizado = in_array($status, [
                    'concluído',
                    'finalizado',
                    'entregue'
                ]);

                if (!$jaFinalizado): ?>
                  <a href="<?= baseUrl().'entrega/form/insert/0?proj='.$p['id'] ?>"
                     class="btn btn-sm btn-outline-success">
                     Entregar
                  </a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>

        <?php if (empty($projetos)): ?>
          <tr><td colspan="6" class="text-center py-4">
              Nenhum projeto vinculado.
          </td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div><!-- /.card-body -->
  </div><!-- /.card -->


  <!-- ╔════════════════════ REUNIÕES ════════════════════╗ -->
  <div class="card shadow-sm">
    <div class="card-header bg-secondary text-white fw-semibold">
      Minhas Reuniões
    </div>

    <div class="card-body p-0 table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Projeto</th>
            <th>Data</th>
            <th>Hora</th>
            <th>Local</th>
            <th>Pauta</th>
          </tr>
        </thead>

        <tbody>
        <?php foreach ($reunioes as $r): ?>
          <tr>
            <td><?= $r['titulo'] ?></td>
            <td><?= date('d/m/Y', strtotime($r['data'])) ?></td>
            <td><?= substr($r['hora'], 0, 5) ?></td>
            <td><?= $r['local'] ?></td>
            <td><?= $r['pauta'] ?></td>
          </tr>
        <?php endforeach; ?>

        <?php if (empty($reunioes)): ?>
          <tr><td colspan="5" class="text-center py-4">
              Nenhuma reunião agendada.
          </td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div><!-- /.card-body -->
  </div><!-- /.card -->

</div><!-- /.container -->
