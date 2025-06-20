<div class="container py-4 mt-5">
 
  <div class="border rounded shadow-sm mb-4">
    <div class="p-3 border-bottom bg-light">
      <?= formTitulo('Alunos', true) ?>
    </div>

    <div class="p-3 table-responsive">
      <table id="tblAlunos"
             class="table table-striped table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>RA</th>
            <th>Nome</th>
            <th>Curso</th>
            <th>Email</th>
            <th>Status</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($dados as $row): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['ra'] ?></td>
            <td><?= $row['nome'] ?></td>
            <td><?= $row['curso'] ?></td>
            <td><?= $row['email'] ?></td>
            <td>
              <span class="badge <?= $row['statusRegistro']==1?'bg-success':'bg-secondary' ?>">
                <?= $row['statusRegistro']==1?'Ativo':'Inativo' ?>
              </span>
            </td>
            <td class="text-nowrap text-center">
              <a href="<?= baseUrl() ?>aluno/form/update/<?= $row['id'] ?>"
                 class="btn btn-sm btn-warning me-2">Editar</a>
              <a href="<?= baseUrl() ?>aluno/form/delete/<?= $row['id'] ?>"
                 class="btn btn-sm btn-danger">Excluir</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
