<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="col-12 mt-4 col-lg-11 mx-auto">
<div class="row mr-2">
    <div class="col-8 col-lg-10 form-group">
        <input type="text" class="form-control" name="vers" id="vers"  placeholder="montante versé">
    </div>
        <button id="btn_vers" type="button" class=" form-control col-4 col-lg-2 btn btn-primary">+ Versement</button>
</div>
<div class="table-responsive">
        <table class="table w-100 table-light border shadow ">
            <thead class="bg-secondary text-white">
                <td>#id</td>
                <td>montant versé</td>
                <td>Date de versement</td>
                <td>Gestion</td>
            </thead>
            <tbody id="data">

            </tbody>
        </table>
    </div>

</div>

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
                    <button data-dismiss="modal" class="cancel btn-sm btn btn-secondary">ANNULER</button>
                    <button id="confirme" class="btn btn-sm btn-danger">CONFIRMER</button>
                </div>
            </div>
        </div>
    </div>


<script>

$(document).ready(function () {
    getVersements(); 
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

function run(id) {
            $("#confirme").click(function () {
                $("#confirme").unbind();
                $("#delete").modal('hide');
                $.ajax({
                    type: "POST",
                    url: "<?php echo URLROOT?>/gestion/deleteVersement",
                    data: {id:id},
                    success: function (response) {
                        getVersements();
                    }
                });
            });
        }
    $('.cancel').click(function(){
        $("#confirme").unbind();
        $(".cancel").unbind();
    });

function edit(id){
    var vers=$('#v'+id).text();
    $('#vers').val(vers);
    $('#btn_vers').text('Modifier');
    $('#btn_vers').removeClass('btn-primary');
    $('#btn_vers').addClass('btn-success');
    $('#btn_vers').unbind();
    $('#btn_vers').attr('id','update_btn');

    $('#update_btn').click(function () { 
        var versn=$('#vers').val();
        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT?>/gestion/updateVersement",
            data: {mont:versn,id:id},
            success: function (response) {
                getVersements();
            }
        });

        $('#update_btn').text('+ Versement');
        $('#update_btn').removeClass('btn-success');
        $('#update_btn').addClass('btn-primary');
        $('#update_btn').unbind();
        $('#update_btn').attr('id','btn_vers');
        $('#vers').val('');
        $('#btn_vers').click(add);
     });
}

function add(){
    var vers=$('#vers').val().trim();
    if(vers!=""){
    $.ajax({
        type: "POST",
        url: "<?php echo URLROOT;?>/gestion/addVersement",
        data: {mont:vers,id:<?php echo $data['id'];?>},
        success: function (response) {
            getVersements();
        }
    });
    }
}

$('#btn_vers').click(add);
function getVersements(){
    $.ajax({
        type: "POST",
        url: "<?php echo URLROOT ?>/gestion/getVersements",
        data: {id:<?php echo $data['id'];?>},
        success: function (response) {
            $('#data').html(response);        
        }
    });
}

</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>