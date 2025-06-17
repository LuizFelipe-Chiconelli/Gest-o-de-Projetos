<?= formTitulo('Usuários', true) ?>

<table id="tbl" class="table table-striped align-middle">
  <thead class="table-primary">
    <tr>
      <th>#</th><th>Nome</th><th>E-mail</th><th>Nível</th><th>Status</th><th class="text-center">Ações</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($dados as $u): ?>
    <tr>
      <td><?= $u['id'] ?></td>
      <td><?= $u['nome'] ?></td>
      <td><?= $u['email'] ?></td>
      <td><?= $u['nivel'] ?></td>
      <td><?= $u['statusRegistro']==1?'Ativo':'Inativo' ?></td>
      <td class="text-center">
        <a href="<?= baseUrl().'usuario/form/update/'.$u['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
        <a href="<?= baseUrl().'usuario/form/delete/'.$u['id'] ?>" class="btn btn-sm btn-danger">Excluir</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<script>
$(function(){
  $('#tbl').DataTable({
    language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'}
  });
});
</script>
