<div class="border rounded shadow-sm mb-4 mt-5">
  <div class="p-3 border-bottom bg-light">
    <?= formTitulo('Professores', true) ?>
  </div>
  <div class="p-3 table-responsive">
    <table id="tblProfessores" class="table table-striped table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Especialidade</th>
          <th>Status</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($dados as $row): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['nome'] ?></td>
          <td><?= $row['email'] ?></td>
          <td><?= $row['especialidade'] ?></td>
          <td>
            <span class="badge <?= $row['statusRegistro']==1?'bg-success':'bg-secondary' ?>">
              <?= $row['statusRegistro']==1?'Ativo':'Inativo' ?>
            </span>
          </td>
          <td class="text-center">
            <a href="<?= baseUrl() ?>professor/form/update/<?= $row['id'] ?>"
               class="btn btn-sm btn-warning me-2">Editar</a>
            <a href="<?= baseUrl() ?>professor/form/delete/<?= $row['id'] ?>"
               class="btn btn-sm btn-danger">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
