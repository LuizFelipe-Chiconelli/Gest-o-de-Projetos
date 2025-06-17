<?= formTitulo('Professores', true) ?>

<table id="tblProfessores" class="table table-striped table-hover align-middle">
  <thead class="table-primary">
    <tr>
      <th>#</th>
      <th>Nome</th>
      <th>Email</th>
      <th>Especialidade</th>
      <th>Área</th>
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
      <td><?= $row['especialidade'] ?></td>
      <td><?= $row['area'] ?? '—' ?></td>
      <td><?= $row['statusRegistro']==1 ? 'Ativo' : 'Inativo' ?></td>
      <td class="text-nowrap text-center">
        <a href="<?= baseUrl().'professor/form/update/'.$row['id'] ?>"
           class="btn btn-sm btn-warning">Editar</a>
        <a href="<?= baseUrl().'professor/form/delete/'.$row['id'] ?>"
           class="btn btn-sm btn-danger">Excluir</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<script>
$(function(){
  $('#tblProfessores').DataTable({
    language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'}
  });
});
</script>
