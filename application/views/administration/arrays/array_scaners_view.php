<div class="container-fluid button-container">
    <div class="row">
        <div class="col-md-2 col-md-offset-5">
            <a href="scaner_controller/insert_entry">
                <button type="button" class="btn btn-success bouton-form">Nouveau</button>
            </a>  
        </div>
    </div>
</div>
<div class="container-fluid table-container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <table id="table_scaners" class="table table-bordered">
                <thead>
                    <th>Libellé</th>
                    <th>Libellé Court</th>
                    <th>Service</th>
                    <th>Etablissement</th>
                    <th>Image</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php foreach ($scaners as $scaner):?>
                            <tr>
                                <td><?php echo $scaner->Scaner;?></td>
                                <td><?php echo $scaner->libelle_short;?></td>
                                <td><?php echo $scaner->Service;?></td>
                                <td><?php echo $scaner->Etablissement;?></td>
                                <td><img src="<?php echo ressources_images_scaners_route().$scaner->image;?>" alt="image_scaner"/></td>
                                <td>
                                    <a href="scaner_controller/update_entry/<?php echo $scaner->id;?>">
                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                    </a>
                                    <!--<form action="scaner_controller/update_entry" method="post">
                                        <input type="hidden" name="id_scaner" value="<?php echo $scaner->id;?>">
                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                    </form>-->
                                    <form action="scaner_controller/delete_entry" method="post">
                                        <input type="hidden" name="id_scaner" value="<?php echo $scaner->id;?>">
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
        $('#table_scaners').DataTable({});
    });
</script>
