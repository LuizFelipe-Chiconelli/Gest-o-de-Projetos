<?= formTitulo('Entregas', true) ?>

<table id="tblEntrega" class="table table-striped table-hover">
  <thead class="table-primary">
    <tr>
      <th>#</th>
      <th>Projeto</th>
      <th>Data</th>
      <th>Descrição</th>
      <th>Arquivo</th>
      <th>Status</th>
      <th class="text-center">Ações</th>
    </tr>
  </thead>

  <tbody>
  <?php foreach ($dados as $e): ?>
    <tr>
      <td><?= $e['id'] ?></td>
      <td><?= $e['projeto_id'] ?></td>
      <td><?= date('d/m/Y', strtotime($e['data'])) ?></td>
      <td><?= $e['descricao'] ?></td>
      <td>
        <?php if ($e['arquivo']): ?>
          <a href="<?= baseUrl().'uploads/entrega/'.$e['arquivo']?>" target="_blank">Ver</a>
        <?php endif; ?>
      </td>
      <td><?= $e['status'] ?></td>
      <td class="text-nowrap text-center">
        <a href="<?= baseUrl().'Entrega/form/update/'.$e['id']?>" class="btn btn-sm btn-warning">Editar</a>
        <a href="<?= baseUrl().'Entrega/form/delete/'.$e['id']?>" class="btn btn-sm btn-danger">Excluir</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<script>
  $(function(){
    $('#tblEntrega').DataTable({
      language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'}
    });
  });
</script>
