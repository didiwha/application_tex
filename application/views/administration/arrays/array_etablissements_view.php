<div class="container-fluid button-container">
    <div class="row">
        <div class="col-md-2 col-md-offset-5">
            <a href="etablissement_controller/insert_entry">
                <button type="button" class="btn btn-success">Nouveau</button>
            </a>  
        </div>
    </div>
</div>
<div class="container-fluid table-container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <table id="table_etablissements" class="table table-bordered">
                <thead>
                    <th>Libellé</th>
                    <th>Libellé Court</th>
                    <th>Code</th>
                    <th>Code Postal</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php foreach ($etablissements as $etablissement):?>
                            <tr>
                                <td><?php echo $etablissement->libelle;?></td>
                                <td><?php echo $etablissement->libelle_short;?></td>
                                <td><?php echo $etablissement->code;?></td>
                                <td><?php echo $etablissement->code_postal;?></td>
                                <td>
                                    <a href="etablissement_controller/update_entry/<?php echo $etablissement->id;?>">
                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                    </a>
                                    <form action="etablissement_controller/delete_entry" method="post">
                                        <input type="hidden" name="id_etablissement" value="<?php echo $etablissement->id;?>">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#table_etablissements').DataTable({});
    });
</script>
