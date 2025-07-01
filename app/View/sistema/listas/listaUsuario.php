<div class="border rounded shadow-sm mb-4 mt-5">
  <div class="p-3 border-bottom bg-light">
    <?= formTitulo('Usuários', true) ?>
  </div>

  <div class="p-3 table-responsive">
    <table id="tblUsuarios"              
           class="table table-striped table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Nível</th>
          <th>Status</th>
          <th style="width:140px;" class="text-center">Ações</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($dados as $row): ?>
        <tr>
          <td><?= $row['nome'] ?></td>
          <td><?= $row['email'] ?></td>

          <!-- Nível (11 = Adm, 21 = Prof, 31 = Aluno) -->
          <td>
            <?php
              switch ((int)($row['nivel'] ?? 0)) {
                case 11:  echo 'Administrador'; break;
                case 21:  echo 'Professor';     break;
                case 31:  echo 'Aluno';         break;
                default:  echo '—';
              }
            ?>
          </td>

          <td>
            <span class="badge <?= $row['statusRegistro']==1 ? 'bg-success' : 'bg-secondary' ?>">
              <?= $row['statusRegistro']==1 ? 'Ativo' : 'Inativo' ?>
            </span>
          </td>

          <td class="text-center text-nowrap">
            <?php if ($row['nivel'] == 11): ?>
              <a href="<?= baseUrl() ?>usuario/form/update/<?= $row['id'] ?>"
                 class="btn btn-sm btn-warning me-2">Editar</a>
            <?php endif; ?>

            <form action="<?= baseUrl() ?>usuario/delete"
                  method="post" class="d-inline"
                  onsubmit="return confirm('Excluir usuário?');">
              <input type="hidden" name="userId" value="<?= $row['id'] ?>">
              <button class="btn btn-sm btn-danger">Excluir</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>


    <?= datatables('tblUsuarios') ?>

    <script>
      $(function () {
        $('#tblUsuarios').DataTable().order([1,'asc']).draw();
      });
    </script>
  </div>
</div>

<style>
  table.dataTable { margin-top: .75rem !important; }
</style>
