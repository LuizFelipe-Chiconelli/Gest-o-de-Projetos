<div class="border rounded shadow-sm mb-4 mt-5">

  <div class="p-3 border-bottom bg-light">
    <?= formTitulo('Reuniões', true) ?>
  </div>

  <div class="p-3 table-responsive">
    <table id="tblReunioes"            
           class="table table-striped table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Projeto</th>
          <th>Data</th>
          <th>Hora</th>
          <th>Local</th>
          <th style="width:140px;" class="text-center">Ações</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($dados as $row): ?>
        <tr>
          <td><?= $row['projeto'] ?></td>
          <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
          <td><?= date('H:i',   strtotime($row['hora'])) ?></td>
          <td><?= $row['local'] ?></td>


          <td class="text-center text-nowrap">
            <a href="<?= baseUrl() ?>reuniao/form/update/<?= $row['id'] ?>"
               class="btn btn-sm btn-warning me-2">Editar</a>

            <a href="<?= baseUrl() ?>reuniao/form/delete/<?= $row['id'] ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('Excluir esta reunião?');">Excluir</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

    <?= datatables('tblReunioes') ?>

    <script>
      $(function () {
        $('#tblReunioes')
          .DataTable()
          .order([[1,'desc'], [2,'asc']])
          .draw();
      });
    </script>
  </div>
</div>

<style>
  table.dataTable { margin-top: .75rem !important; }
</style>
