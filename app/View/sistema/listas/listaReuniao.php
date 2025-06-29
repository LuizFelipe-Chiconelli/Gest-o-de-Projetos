<div class="border rounded shadow-sm mb-4 mt-5">
  <div class="p-3 border-bottom bg-light">
    <?= formTitulo('Reuniões', true) ?>
  </div>
  <div class="p-3 table-responsive">
    <table id="tblReunioes" class="table table-striped table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Projeto</th>
          <th>Data</th>
          <th>Hora</th>
          <th>Local</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($dados as $row): ?>
        <tr>
          <td><?= $row['projeto'] ?></td>
          <td><?= date('d/m/Y',strtotime($row['data'])) ?></td>
          <td><?= date('H:i',strtotime($row['hora'])) ?></td>
          <td><?= $row['local'] ?></td>
          <td class="text-center">
            <a href="<?= baseUrl() ?>reuniao/form/update/<?= $row['id'] ?>"
               class="btn btn-sm btn-warning me-2">Editar</a>
            <a href="<?= baseUrl() ?>reuniao/form/delete/<?= $row['id'] ?>"
               class="btn btn-sm btn-danger">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
