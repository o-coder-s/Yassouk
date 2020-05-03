<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="col-12 col-lg-11 mx-auto mt-5">
    <form action="">
        <div class="row">
            <div class="col-8 col-lg-10 input-group mb-3">
                <div class="input-group-prepend ">
                    <button class="btn btn-secondary" type="button" id="button-addon1">Chercher</button>
                </div>
                <input id="search" type="text" class="form-control" placeholder="" aria-label="Example text with button addon"
                    aria-describedby="button-addon1">
            </div>


            <div class="col-4 col-lg-2  text-right">
                <a href="<?php echo URLROOT ?>/gestion/aUtilisateur/1" class="w-100 btn bg-blue text-light"
                    type="button"><span style="font-weight: bold">+</span><i class="fa fa-male" style="width:2em; "
                        aria-hidden="true"></i>Moniteur</a>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table w-100 table-light border shadow ">
            <thead class="bg-secondary text-white">
                <td>#id</td>
                <td>Nom et prénom</td>
                <td>Date de naissance</td>
                <td>Date de début de travail</td>
                <td>Gestion</td>
            </thead>
            <tbody id="data">

            </tbody>
        </table>
    </div>
</div>

<!-- Modal delete -->
<div id="delete" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suppression</h5>
                <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="model-body">
                <p class="ml-3">Voulez-vous vraiment supprimer ?</p>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="cancel btn btn-sm btn-secondary">ANNULER</button>
                <button id="confirme" class="btn btn-sm btn-danger">CONFIRMER</button>
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
                    getMoniteurs();
                }
            });
        }
        function disableAccount(id){
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT; ?>/gestion/disableAccount",
                data: {id:id},
                success:function(response){
                    getMoniteurs();
                }
            });
        }

    function run(id) {

        $("#confirme").click(function () {
            $("#confirme").unbind();
            $('#delete').modal('hide');
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT ?>/gestion/sMoniteur/",
                data: {id: id},
                success: function (response) {
                    console.log(response);
                    getMoniteurs();
                }
            });

        });
    }

    $('.cancel').click(function(){
            $("#confirme").unbind();
            $(".cancel").unbind();
        });

    function getMoniteurs() {
        $.ajax({
            type: 'POST',
            url: "<?php echo URLROOT; ?>/gestion/moniteurs",
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

        getMoniteurs();

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