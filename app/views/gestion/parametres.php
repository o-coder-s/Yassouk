<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="col-12 mt-4 col-lg-11 mx-auto">

    <div class="permis shadow mt-5 mb-3">
        <div class="row mx-1">
            <div class="col-9 col-md-11">
                <h4 class="px-1 pt-3 pb-2">Permis</h4>
            </div>
            <div class="col-3 col-md-1 mr-auto">
                <a class="btn btn-success mt-3" href="<?php echo URLROOT;?>/gestion/addPermis" role="button">Ajouter
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table border">
                <thead class="bg-secondary text-light">
                    <tr>
                        <th>#</th>
                        <th>catégorie</th>
                        <th>prix</th>
                        <th>prix de rendez-vous</th>
                        <th>code</th>
                        <th>créneaux</th>
                        <th>conduite</th>
                        <th>Heaurs ajouté</th>
                        <th>purcentage ajouté</th>
                        <th>gestion</th>
                    </tr>
                </thead>
                <tbody id="pdata">

                </tbody>
            </table>
        </div>

    </div>

    <!-- Groupes -->
    <div class="shadow mt-3">
        <h4 class="mx-3 pt-4 pb-2">Groupes</h4>
        <div class="form-group form-row mx-2">
            <input type="text" class="form-control col-4 ml-md-3 ml-1 mr-3 mr-md-4 col-md-5" name="" id="nom_grp"
                placeholder="Nom de groupe">
            <input type="text" class="form-control col-4 mr-3 mr-md-4 col-md-5" name="" id="nbr_places"
                placeholder="Nombre des places">
            <div id="btn_change" class="col-3 col-md-1">
                <button type="button" name="" id="" class="btn btn-primary " onclick="addGroupe()" >+Groupe</button>
            </div>
        </div>
        <div class="responsive-table">

            <table class="table">
                <thead class="bg-secondary text-light">
                    <tr>
                        <th>#</th>
                        <th>Nom du groupe</th>
                        <th>Nombre des candidat dans le groupe</th>
                        <th>Nombre des places</th>
                        <th>Gestion</th>
                    </tr>
                </thead>
                <tbody id="groupe">
                    
                </tbody>
            </table>
        </div>
    </div>

    <!-- Planning -->
    <div class="shadow mt-3">
        <div>
            <h4 class="mx-3 pt-4 pb-2">Planning</h4>
            <div class="form-row mx-2">
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="">Temps de départ</label>
                        <select class="form-control" name="temp_d" id="temp_d">
                            
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="">Temps de fin</label>
                        <select class="form-control" name="temp_f" id="temp_f">
                            
                        </select>
                    </div>
                </div>
                <button onclick="editPlanningSave()" type="button" class="btn btn-success mb-2 ml-1">Sauvgarder</button>

            </div>
        </div>
    </div>



    <!-- save examens -->
    <div class="shadow mt-4 mb-5">
        <div>
            <h4 class="mx-3 pt-3 pb-2">Examen</h4>
            <div class="form-row mx-2">
                <div class="form-group col-md-3">
                    <label for="day">Jour d'examen</label>
                    <select class="form-control" name="day" id="day">
                        
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Temps du départ</label>
                    <select class="form-control" name="tmp_start" id="temps_debut">
                        
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Temps du fin</label>
                    <select class="form-control" name="tmp_end" id="temps_fin">
                        
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="">Nombre des places</label>
                    <input type="text" class="form-control" name="nbr_places" id="nbr_p" aria-describedby="helpId"
                        placeholder="">
                </div>

                <button onclick="editSaveExam()" type="button" class="btn btn-success mb-2 ml-1">Sauvgarder</button>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        getPermisParam();
        getPlanningSave();
        getGroupe();
        getSaveExam();
    });


    function deleteGroupe(id){
        $.ajax({
            method: 'POST',
            url: "<?php echo URLROOT;?>/gestion/deleteGroupe",
            data:{id:id},
            success: function (data) {
                getGroupe();
            }
        });
    }

    function addGroupe(){
        //get the data and they batter not being empty
        nom_grp=$('#nom_grp').val().trim();
        nbr_places=$('#nbr_places').val().trim();
        if(nom_grp!=""&&nbr_places!=""){
            $.ajax({
            method: 'POST',
            data:{nom_grp:nom_grp,nbr_places:nbr_places},
            url: "<?php echo URLROOT;?>/gestion/addGroup",
            success: function (data) {
                getGroupe();
                }
            });
        }
    }

    function editPlanningSave() {
        //get data
        start=$('#temp_d').val();
        end=$('#temp_f').val();
        $.ajax({
            method: 'POST',
            url: "<?php echo URLROOT;?>/gestion/editPlanning",
            data:{start:start,end:end},
            success: function (data) {
                location.reload();
            }
        });
    }

    function getPlanningSave(){
        $.ajax({
            method: 'POST',
            url: "<?php echo URLROOT;?>/gestion/getPlanningSave",
            success: function (data) {
               res = data.split("~");
               $('#temp_d').html(res[0]);
               $('#temp_f').html(res[1]);
            }
        });        
    }
    function getSaveExam() {
        $.ajax({
            method: 'POST',
            url: "<?php echo URLROOT;?>/gestion/getSaveExam",
            success: function (data) {
               res = data.split("~");
               $('#temps_debut').html(res[0]);
               $('#temps_fin').html(res[1]);
               $('#nbr_p').val(res[2]);
               $('#day').html(res[3]);
            }
        });
    }

    function editSaveExam(){
        //get the data
        tmp_d=$('#temps_debut').val();
        tmp_f=$('#temps_fin').val();
        nbr_p=$('#nbr_p').val();
        day=$('#day').val();
        $.ajax({
            method: 'POST',
            data : {tmp_d:tmp_d,tmp_f:tmp_f,day:day,nbr_p:nbr_p},
            url: "<?php echo URLROOT;?>/gestion/editExam",
            success: function (data) {
                location.reload();
            }
        });        
    }

    function getPermisParam() {
        $.ajax({
            method: 'POST',
            url: "<?php echo URLROOT;?>/gestion/getPermisParam",
            success: function (data) {
                $('#pdata').html(data);
            }
        });
    }

    function editGroupe(id){
        var current_btn ='<button type="button" name="" id="" class="btn btn-primary " onclick="addGroupe()" >+Groupe</button>';
        var grp_c=$('#nom_grp_'+id).text();
        var nbr_c=$('#nbr_places_'+id).text();
        let btn_edit = '<button type="button" name="" id="editButton" class="btn btn-success " >Modifier</button>';
        $('#btn_change').html(btn_edit);
        $('#nbr_places').val(nbr_c);
        $('#nom_grp').val(grp_c);

        $("#editButton").click(function(){
            //nbr_places nom_grp
            var nbr = $('#nbr_places').val();
            var nom = $('#nom_grp').val();
            $('#nbr_places').val('');
            $('#nom_grp').val('');
            $('#btn_change').html(current_btn);
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT;?>/gestion/editGroup",
                data: {id:id,nbr:nbr,nom:nom},
                success: function (response) {
                    getGroupe();
                }
            });

        });
    } 

    function deletePermis(id){
        $.ajax({
            method: 'POST',
            data: {id:id},
            url: "<?php echo URLROOT;?>/gestion/deletePermis",
            success: function (data) {
                getPermisParam();
            }
        });
    }

    function getGroupe() {
        $.ajax({
            url: "<?php echo URLROOT?>/gestion/getGroupe",
            success: function (data) {
                $('#groupe').html(data);
            }
        });
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>