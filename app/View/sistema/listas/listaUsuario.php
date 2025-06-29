<div class="border rounded shadow-sm mb-4 mt-5">
  <div class="p-3 border-bottom bg-light">
    <?= formTitulo('Usuários', true) ?>
  </div>

  <div class="p-3 table-responsive">
    <table id="tblUsuarios" class="table table-striped table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Nível</th>
          <th>Status</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($dados as $row): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['nome'] ?></td>
          <td><?= $row['email'] ?></td>

          <!-- Nível -->
          <td>
            <?= isset($row['nivel'])
              ? ($row['nivel'] == 11 ? 'Administrador'
                : ($row['nivel'] == 21 ? 'Professor' : 'Aluno'))
              : '—'; ?>
          </td>

          <!-- Status -->
          <td>
            <span class="badge <?= $row['statusRegistro'] == 1 ? 'bg-success' : 'bg-secondary' ?>">
              <?= $row['statusRegistro'] == 1 ? 'Ativo' : 'Inativo' ?>
            </span>
          </td>

          <!-- Ações -->
          <td class="text-center">

        <?php if ($row['nivel'] == 11): ?>
          <a href="<?= baseUrl() ?>usuario/form/update/<?= $row['id'] ?>"
            class="btn btn-sm btn-warning me-2">
            Editar
          </a>
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
  </div>
</div>
