<?php
/* Lista de Projetos
 * Usa formTitulo() para cabeçalho + botão “Novo”.
 * A tabela é ativada pelo DataTables (CDN simples).
 */
?>

<?= formTitulo('Projetos', true) ?>

<table id="tblProjetos" class="table table-striped table-hover align-middle">
  <thead class="table-primary">
    <tr>
      <th>#</th>
      <th>Título</th>
      <th>Id do professor:</th>
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
      <td><?= $row['professor_id'] ?></td><!--Lembrar de trocar depois, estamos mostrando o id-->
      <td><?= $row['area'] ?></td>
      <td><?= $row['status'] ?></td>
      <td class="text-nowrap text-center">
        <a href="<?= baseUrl().'Projeto/form/update/'.$row['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
        <a href="<?= baseUrl().'Projeto/form/delete/'.$row['id'] ?>" class="btn btn-sm btn-danger">Excluir</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<!-- DataTables (CDN rápido) -->
<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  $(function(){
    $('#tblProjetos').DataTable({
      language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'},
      responsive:true
    });
  });
</script>
