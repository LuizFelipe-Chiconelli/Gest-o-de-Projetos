<div class="border rounded shadow-sm mb-4 mt-5">

  <div class="p-3 border-bottom bg-light">
    <?= formTitulo('Professores', true) ?>
  </div>

  <div class="p-3 table-responsive">
    <table id="tblProfessores"                     
           class="table table-striped table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Especialidade</th>
          <th style="width:90px;">Status</th>
          <th style="width:130px;" class="text-center">Ações</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($dados as $row): ?>
        <tr>
          <td><?= $row['nome'] ?></td>
          <td><?= $row['email'] ?></td>
          <td><?= $row['especialidade'] ?></td>
          <td>
            <span class="badge <?= $row['statusRegistro']==1 ? 'bg-success' : 'bg-secondary' ?>">
              <?= $row['statusRegistro']==1 ? 'Ativo' : 'Inativo' ?>
            </span>
          </td>
          <td class="text-center text-nowrap">
            <a href="<?= baseUrl() ?>professor/form/update/<?= $row['id'] ?>"
               class="btn btn-sm btn-warning me-2">Editar</a>

            <form action="<?= baseUrl() ?>professor/delete"
                  method="post" class="d-inline"
                  onsubmit="return confirm('Excluir professor e usuário vinculado?');">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <button class="btn btn-sm btn-danger">Excluir</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

    <?= datatables('tblProfessores') ?>

    <script>
      $(function () {
        $('#tblProfessores').DataTable().order([1,'asc']).draw();
      });
    </script>
  </div>
</div>

<style>
  table.dataTable { margin-top: .75rem !important; }
</style>
