<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- navbar -->

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="col-12 col-lg-11 mx-auto">

    <h1 class="mt-3">Dashbord</h1>
    <!-- Informations -->
    <div class="row mt-3 mx-1 border shadow ">

        <div class="col-6 col-sm-6 col-md-3 col-lg-3 ">
            <div class="col-11 mx-auto text-center text-white bg-green m-3">
                <h5 class="pt-4 pb-2">Candidats</h5>
                <div class="dropdown-divider"></div>
                <h4 class="pt-2 pb-4"><?php echo $data['Candidat'] ?></h4>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-3 col-lg-3">
            <div class="col-11 mx-auto text-center text-white bg-flue m-3">
                <h5 class="pt-4 pb-2">Moniteurs</h5>
                <div class="dropdown-divider"></div>
                <h4 class="pt-2 pb-4"><?php echo $data['Moniteur'] ?></h4>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-3 col-lg-3">
            <div class="col-11 mx-auto text-center text-white bg-info m-3">
                <h5 class="pt-4 pb-2">Clients</h5>
                <div class="dropdown-divider"></div>
                <h4 class="pt-2 pb-4"><?php echo $data['Client'] ?></h4>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-3 col-lg-3">
            <div class="col-11 mx-auto text-center text-white bg-blue m-3">
                <h5 class="pt-4 pb-2">Véhiculs</h5>
                <div class="dropdown-divider"></div>
                <h4 class="pt-2 pb-4"><?php echo $data['Vehicul'] ?></h4>
            </div>
        </div>
    </div>

    <!-- List d'examens -->
    <h4 class="mt-5 d-none exam">List des examens de cette semaine</h4>
    <table class="exam d-none table table-light border shadow w-100">
        <thead class="bg-primary text-white">
            <td>#id</td>
            <td>Nom et prénom</td>
            <td>Niveau</td>
            <td>Catégorie</td>
            <td>Status</td>
        </thead>
        <tbody id="exam_list">
            
        </tbody>
    </table>
    <!-- Inscrit cette semaine -->
    <h4 class="mt-5 d-none insc">List des inscription de cette semaine</h4>
    <table class="insc d-none table table-light border shadow w-100">
        <thead class="bg-secondary text-white">
            <td>#id</td>
            <td>Nom et prénom</td>
            <td>Date de naissance</td>
            <td>Type</td>
            <td>Code</td>
        </thead>
        <tbody id="insc_list">
        </tbody>
    </table>

</div>
<script>
    $(document).ready(function () {
        $.ajax({
            url: "<?php echo URLROOT;?>/Admin/listInscription",
            success: function (data) {
                var answer = data.search('empty');
                if(answer == -1){
                $('.insc').removeClass('d-none');
                $('#insc_list').html(data);                   
                }else{
                $('.insc').addClass('d-none');
                console.log(data);    
                }
            }
        });
        $.ajax({
            url: "<?php echo URLROOT;?>/Admin/ListExamen",
            success: function (data) {
                var answer = data.search('empty');
                if(answer == -1){
                $('.exam').removeClass('d-none');
                $('#exam_list').html(data);                   
                }else{
                $('.exam').addClass('d-none'); 
                }
            }
        });
     });    
    // uncomment this section when yo finish everything
    setInterval(function(){ 
        $.ajax({
            url: "<?php echo URLROOT;?>/Admin/listInscription",
            success: function (data) {
                var answer = data.search('empty');
                if(answer == -1){
                $('.insc').removeClass('d-none');
                $('#insc_list').html(data);                   
                }else{
                $('.insc').addClass('d-none');  
                }
            }
        });}, 5000); 

    setInterval(function(){ 
        $.ajax({
            url: "<?php echo URLROOT;?>/Admin/ListExamen",
            success: function (data) {
                var answer = data.search('empty');
                if(answer == -1){
                $('.exam').removeClass('d-none');
                $('#exam_list').html(data);                   
                }else{
                $('.exam').addClass('d-none');   
                }
            }
        });}, 5000); 
       
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>