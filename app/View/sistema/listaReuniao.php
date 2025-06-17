<?= formTitulo('Reuniões', true) ?>

<table id="tblReuniao" class="table table-striped table-hover">
  <thead class="table-primary">
    <tr>
      <th>#</th>
      <th>Projeto</th>
      <th>Data</th>
      <th>Hora</th>
      <th>Local</th>
      <th>Pauta</th>
      <th class="text-center">Ações</th>
    </tr>
  </thead>

  <tbody>
  <?php foreach ($dados as $r): ?>
    <tr>
      <td><?= $r['id'] ?></td>
      <td><?= $r['projeto'] ?></td>
      <td><?= date('d/m/Y', strtotime($r['data'])) ?></td>
      <td><?= $r['hora'] ?></td>
      <td><?= $r['local'] ?></td>
      <td><?= $r['pauta'] ?></td>

      <td class="text-nowrap text-center">
        <a href="<?= baseUrl()?>reuniao/form/update/<?= $r['id'] ?>"
           class="btn btn-sm btn-warning">Editar</a>
        <a href="<?= baseUrl()?>reuniao/form/delete/<?= $r['id'] ?>"
           class="btn btn-sm btn-danger">Excluir</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<script>
$(function(){
  $('#tblReuniao').DataTable({
    language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'}
  });
});
</script>
