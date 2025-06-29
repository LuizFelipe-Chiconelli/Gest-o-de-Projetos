<div class="border rounded shadow-sm mb-4 mt-5">
  <div class="p-3 border-bottom bg-light">
    <?= formTitulo('Entregas', true) ?>
  </div>
  <div class="p-3 table-responsive">
    <table id="tblEntregas" class="table table-striped table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Projeto</th>
          <th>Data</th>
          <th>Descrição</th>
          <th>Status</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($dados as $row): ?>
        <tr>
          <td><?= $row['projeto'] ?></td>
          <td><?= date('d/m/Y',strtotime($row['data'])) ?></td>
          <td><?= $row['descricao'] ?></td>
          <td>
            <span class="badge <?= $row['status']=='Entregue'?'bg-success':'bg-secondary' ?>">
              <?= $row['status'] ?>
            </span>
          </td>
          <td class="text-center">
            <a href="<?= baseUrl() ?>entrega/form/update/<?= $row['id'] ?>"
               class="btn btn-sm btn-warning me-2">Editar</a>
            <a href="<?= baseUrl() ?>entrega/form/delete/<?= $row['id'] ?>"
               class="btn btn-sm btn-danger">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
