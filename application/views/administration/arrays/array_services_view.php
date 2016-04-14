<div class="container-fluid button-container">
    <div class="row">
        <div class="col-md-2 col-md-offset-5">
            <a href="service_controller/insert_entry">
                <button type="button" class="btn btn-success">Nouveau</button>
            </a>  
        </div>
    </div>
</div>
<div class="container-fluid table-container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <table id="table_service" class="table table-bordered">
                <thead>
                    <th>Libellé</th>
                    <th>Libellé Court</th>
                    <th>Code</th>
                    <th>Service Cible</th>
                    <th>Etablissement</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php foreach ($services as $service):?>
                            <tr>
                                <td><?php echo $service->Service;?></td>
                                <td><?php echo $service->libelle_short;?></td>
                                <td><?php echo $service->code_correspondant;?></td>
                                <td><?php echo $service->service_cible_id;?></td>
                                <td><?php echo $service->Etablissement;?></td>
                                <td>
                                    <a href="service_controller/update_entry/<?php echo $service->id;?>">
                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                    </a>
                                    <!--<form action="service_controller/update_entry_v2" method="post">
                                        <input type="hidden" name="id_service" value="<?php echo $service->id;?>">
                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                    </form>-->
                                    <form action="<?php echo base_url();?>index.php/administration/service_controller/delete_entry" method="post">
                                        <input type="hidden" name="id_service" value="<?php echo $service->id;?>">
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
        $('#table_service').DataTable({});
    });
</script>
