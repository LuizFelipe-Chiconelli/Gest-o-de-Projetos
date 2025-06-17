<?= formTitulo('Projetos', true) ?>

<table id="tblProjetos" class="table table-striped table-hover align-middle">
  <thead class="table-primary">
    <tr>
      <th>#</th>
      <th>Título</th>
      <th>Professor</th>
      <th>Área</th>
      <th>Status</th>
      <th class="text-center">Ações</th>
    </tr>
  </thead>

  <tbody>
  <?php foreach ($dados as $row): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['titulo'] ?></td>
      <td><?= $row['professor'] ?></td>  <!-- nome via JOIN -->
      <td><?= $row['area'] ?></td>
      <td><?= $row['status'] ?></td>
      <td class="text-nowrap text-center">
        <a href="<?= baseUrl().'projeto/form/update/'.$row['id'] ?>"
           class="btn btn-sm btn-warning">Editar</a>
        <a href="<?= baseUrl().'projeto/form/delete/'.$row['id'] ?>"
           class="btn btn-sm btn-danger">Excluir</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<script>
$(function(){
  $('#tblProjetos').DataTable({
    language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'}
  });
});
</script>
