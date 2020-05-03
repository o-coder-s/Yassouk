<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>


<div class="col-11 mx-auto">

    <!--INFORMATIONS-->
    <div class="row mt-5">
        <!--Lessons suivants-->
        <div class="col-11 col-lg-5  mx-1 mx-auto  shadow p-4 my-2 border">
            <div class="row ">
                <div class="col Ls-bg-red text-white text-center py-2 ">
                    <h4>Suivants</h4>
                </div>
            </div>

            <div id="data">
            
            </div>

        </div>
        <!--Status-->
        <div class="col-11 col-lg-6 ml-0 mx-auto  mx-1 shadow border p-4 my-2">
            <div class="row">
                <div class="col bg-green text-white text-center py-2 ">
                    <h4>Status</h4>
                </div>
            </div>

            <div class="row text-center">
                <!-- Payement -->
                <div class="col-10 col-md mt-4 mr-1 mx-auto mr-md-2 border shadow">
                    <div class="row">
                        <div class="col bg-orange text-light p-2">
                            <h5>Payements</h5>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col text-left">
                            Montant
                        </div>
                        <div class="col text-right">
                        <?php echo $data['info']['payement']['montant'] ?>DA
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col text-left">
                            Versement
                        </div>
                        <div class="col text-right">
                        <?php echo $data['info']['payement']['payee'] ?>DA
                        </div>
                    </div>
                    <div class="row my-2 ">
                        <div class="col text-left">
                            Restant
                        </div>
                        <div class="col text-right ">
                        <?php echo $data['info']['payement']['restant'] ?>DA
                        </div>
                    </div>
                </div>
                <!-- RENDEZ-VOUS -->
                <div class="col-10 col-md mt-4 ml-1 mx-auto ml-md-2  border shadow">
                    <div class="row">
                        <div class="col bg-special text-light p-2">
                            <h5>Rendez-vous</h5>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col text-left ">
                            Total
                        </div>
                        <div class="col text-right ">
                            <?php echo $data['info']['rdvs']['total'] ?>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col text-left ">
                            Terminés
                        </div>
                        <div class="col text-right">
                        <?php echo $data['info']['rdvs']['termine'] ?>
                        </div>
                    </div>
                    <div class="row my-2 ">
                        <div class="col text-left ">
                            Restants
                        </div>
                        <div class="col text-right">
                        <?php echo $data['info']['rdvs']['restant'] ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h3 class="text-center mt-5">
                        Permis de catégorie <?php echo  $data['permis']; ?>
                    </h3>
                </div>
            </div>

        </div>
    </div>

    <!--Planing-->
    
</div>

<script>
    $(document).ready(function () {
        getSuivants();
    });

    function getSuivants(){
        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT; ?>/client/getSuivants",
            success: function (response) {  
                $('#data').html(response);
            }
        });
    }
</script>


<?php require APPROOT . '/views/inc/footer.php'; ?>