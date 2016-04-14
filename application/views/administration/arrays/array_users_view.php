<div class="container-fluid button-container">
    <div class="row">
        <div class="col-md-2 col-md-offset-5">
            <a href="user_controller/insert_entry">
                <button type="button" class="btn btn-success">Nouveau</button>
            </a>  
        </div>
    </div>
</div>
<div class="container-fluid table-container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <table id="table_postes" class="table table-bordered">
                <thead>
                    <th>Poste</th>
                    <th>Statut</th>
                    <th>Service</th>
                    <th>Etablissement</th>
                    <th>Last Connection</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php foreach ($users as $user):?>
                            <tr>
                                <td><?php echo $user->poste;?></td>
                                <td><?php echo $this->data_location->get_user_statuts()[$user->statut_id]["value"];?></td>
                                <td><?php echo $user->Service;?></td>
                                <td><?php echo $user->Etablissement;?></td>
                                <td style="color:<?php echo getColorFromDateTimeDelay($user->date_last_connection);?>"><?php echo $user->date_last_connection;?></td>
                                <td>
                                    <a href="user_controller/update_entry/<?php echo $user->id;?>">
                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                    </a>
                                    <form action="user_controller/delete_entry" method="post">
                                        <input type="hidden" name="id_user" value="<?php echo $user->id;?>">
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
        $('#table_postes').DataTable({});
    });
</script>
