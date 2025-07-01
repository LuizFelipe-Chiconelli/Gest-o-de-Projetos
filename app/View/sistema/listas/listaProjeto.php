<div class="border rounded shadow-sm mb-4">


  <div class="p-3 border-bottom bg-light">
    <?= formTitulo('Projetos', true) ?>
  </div>


  <div class="p-3 table-responsive">
    <table id="tblProjetos"                
           class="table table-striped table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Título</th>
          <th>Professor</th>
          <th>Área</th>
          <th>Status</th>
          <th>Início</th>
          <th style="width:140px;" class="text-center">Ações</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($dados as $row): ?>
        <tr>
          <td><?= $row['titulo']             ?? '-' ?></td>
          <td><?= $row['professor']          ?? 'Não cadastrado' ?></td>
          <td><?= $row['area']               ?? '-' ?></td>
          <td>
            <span class="badge <?= ($row['status'] ?? '') === 'Ativo'
                                   ? 'bg-success'
                                   : 'bg-secondary' ?>">
              <?= $row['status'] ?? '-' ?>
            </span>
          </td>
          <td>
            <?php
              $inicio = $row['inicio'] ?? null;
              echo $inicio ? date('d/m/Y', strtotime($inicio)) : '-';
            ?>
          </td>

          <td class="text-center text-nowrap">
            <a href="<?= baseUrl() ?>projeto/form/update/<?= $row['id'] ?>"
               class="btn btn-sm btn-warning me-2">Editar</a>

            <form method="POST" action="<?= baseUrl() ?>projeto/delete"
                  class="d-inline"
                  onsubmit="return confirm('Excluir este projeto?');">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <button class="btn btn-sm btn-danger">Excluir</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

    <?= datatables('tblProjetos') ?>

    <script>
      $(function () {
        $('#tblProjetos').DataTable().order([4, 'desc']).draw();
      });
    </script>
  </div>
</div>


<style>
  table.dataTable { margin-top: .75rem !important; }
</style>
