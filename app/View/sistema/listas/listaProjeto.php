<div class="border rounded shadow-sm mb-4">
  <div class="p-3 border-bottom bg-light">
    <?= formTitulo('Projetos', true) ?>
  </div>

  <div class="p-3 table-responsive">
    <table id="tblProjetos" class="table table-striped table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Título</th>
          <th>Professor</th>
          <th>Área</th>
          <th>Status</th>
          <th>Início</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach($dados as $row): ?>
          <tr>
            <td><?= $row['id'] ?? '-' ?></td>
            <td><?= $row['titulo'] ?? '-' ?></td>
            <td><?= $row['professor'] ?? 'Não cadastrado' ?></td>
            <td><?= $row['area'] ?? '-' ?></td>
            <td>
              <span class="badge <?= ($row['status'] ?? '') === 'Ativo' ? 'bg-success' : 'bg-secondary' ?>">
                <?= $row['status'] ?? '-' ?>
              </span>
            </td>
            <td>
              <?php
                // Formata a data de início
                $inicio = $row['inicio'] ?? null;
                echo $inicio ? date('d/m/Y', strtotime($inicio)) : '-';
              ?>
            </td>
            <td class="text-center">
              <!-- Botão de edição (vai para o formulário) -->
              <a href="<?= baseUrl() ?>projeto/form/update/<?= $row['id'] ?? 0 ?>" 
                 class="btn btn-sm btn-warning me-2">Editar</a>

              <!-- Botão de exclusão (usa formulário POST para evitar erro) -->
              <form method="POST" action="<?= baseUrl() ?>projeto/delete" style="display:inline;">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Tem certeza que deseja excluir este projeto?');">
                  Excluir
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
