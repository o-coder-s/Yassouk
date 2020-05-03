<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="col-12 col-lg-11 mt-5 mx-auto">
    <form action="">
        <div class="row">
            <div class="input-group mb-3 col-8 col-lg-10">
                <div class="input-group-prepend ">
                    <button class="btn btn-secondary" type="button" id="button-addon1">Chercher</button>
                </div>
                <input id="search" type="text" class="form-control" placeholder="" aria-label="Example text with button addon"
                    aria-describedby="button-addon1">
            </div>
            <div class="col-4 col-lg-2 text-right">
                <a href="<?php echo URLROOT ?>/gestion/aUtilisateur/3" class="btn form-control btn-primary text-light"
                    type="button"><span style="font-weight: bold">+</span>
                    Client</a>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table w-100  table-light border shadow ">
            <thead class="bg-secondary text-white">
                <td>#id</td>
                <td>Nom et prénom</td>
                <td>Date de naissance</td>
                <td>Catégorie</td>
                <td>Versement</td>
                <td>Gestion</td>
            </thead>
            <tbody id="data">

            </tbody>
        </table>
    </div>

    <!-- Modal delete -->
    <div id="delete" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Suppression</h5>
                    <button type="button" class="cancel" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="model-body">
                    <p class="ml-3">Voulez-vous vraiment supprimer ?</p>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-secondary">ANNULER</button>
                    <button id="confirme" class="cancel btn btn-danger">CONFIRMER</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function enableAccount(id){
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT ?>/gestion/enableAccount",
                data: {id:id},
                success:function(response){
                    getClients();
                }
            });
        }
        function disableAccount(id){
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT; ?>/gestion/disableAccount",
                data: {id:id},
                success:function(response){
                    getClients();
                }
            });
        }

        function run() {
            console.log('hello');
            $("#confirme").click(function () {
                $("#confirme").unbind();
                $("#delete").modal('hide');
                console.log("deletion success");
            });
        }
        $('.cancel').click(function(){
            $("#confirme").unbind();
            $(".cancel").unbind();
        });

        function getClients(){
            $.ajax({
                type: 'POST',
                url: "<?php echo URLROOT; ?>/gestion/clients",
                success: function (data) {
                var answer = data.search('>empty<');
                if(answer==-1){
                  $("#search").prop("disabled", false)
                  $('#data').html(data);
                }else{
                  $("#search").prop("disabled", true);
                  $('#data').html('');
                }
                }
            });
        }

        $(document).ready(function () {

            getClients();


            function alignModal() {
                var modalDialog = $(this).find(".modal-dialog");

                // Applying the top margin on modal dialog to align it vertically center
                modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
            }
            // Align modal when it is displayed
            $(".modal").on("shown.bs.modal", alignModal);

            // Align modal when user resize the window
            $(window).on("resize", function () {
                $(".modal:visible").each(alignModal);
            });
        });
    </script>


    <?php require APPROOT . '/views/inc/footer.php'; ?>