<?= formTitulo('Alunos', true) ?>

<table id="tblAlunos" class="table table-striped table-hover align-middle">
  <thead class="table-primary">
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
    <?php foreach($dados as $row): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['ra'] ?></td>
        <td><?= $row['nome'] ?></td>
        <td><?= $row['curso'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['statusRegistro']==1?'Ativo':'Inativo' ?></td>
        <td class="text-nowrap text-center">
          <a href="<?= baseUrl().'Aluno/form/update/'.$row['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
          <a href="<?= baseUrl().'Aluno/form/delete/'.$row['id'] ?>" class="btn btn-sm btn-danger">Excluir</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script>
  $(function(){
    $('#tblAlunos').DataTable({
      language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'},
      responsive:true
    });
  });
</script>
