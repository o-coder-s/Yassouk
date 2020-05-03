<?php require APPROOT . '/views/inc/header.php'; ?>
<!--navbar -->
<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="col-12 col-lg-11 mx-auto">

    <h1 class="mt-3">Dashbord</h1>
    <!-- Informations -->
    <div class="row mt-3 mx-1 ">

        <div class="col-12 col-lg-6 border shadow mx-auto mb-4">

            <div class="row">
                <div class="col-6">
                    <div class="col-11 mx-auto text-center text-white bg-green m-3">
                        <h5 class="pt-4 pb-2">Ressources</h5>
                        <div class="dropdown-divider"></div>
                        <h4 class="pt-2 pb-4"><?php echo 10 ?></h4>
                    </div>
                </div>
                <div class="col-6">
                    <div class="col-11 mx-auto text-center text-white bg-flue m-3">
                        <h5 class="pt-4 pb-2">Contributions</h5>
                        <div class="dropdown-divider"></div>
                        <h4 class="pt-2 pb-4"><?php echo 10 ?></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="col-11 mx-auto text-center text-white bg-info m-3">
                        <h5 class="pt-4 pb-2">Clients</h5>
                        <div class="dropdown-divider"></div>
                        <h4 class="pt-2 pb-4"><?php echo 10 ?></h4>
                    </div>
                </div>
                <div class="col-6 ">
                    <div class="col-11 mx-auto text-center text-white bg-blue m-3">
                        <h5 class="pt-4 pb-2">Groupes</h5>
                        <div class="dropdown-divider"></div>
                        <h4 class="pt-2 pb-4"><?php echo 10 ?></h4>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12 col-lg-5 border shadow mx-auto mb-4">

            <div class="col-12  mx-1 mx-auto my-3">
                <div class="row ">
                    <div class="col Ls-bg-red text-white text-center py-2 ">
                        <h4>Lessons suivants</h4>
                    </div>
                </div>
                <div id="data">
                    
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        getSuivants();
    });

    function getSuivants() {
        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT;?>/candidat/getSuivants",
            success: function (response) {
                $('#data').html(response);
            }
        });

    }
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>