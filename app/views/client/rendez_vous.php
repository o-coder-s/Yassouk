<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>
<style>
    /* td:hover {
        background-color: grey;
        color: white;
        cursor: pointer;
    } */
    td{
        height:110px;
        min-width:160px;
    }

    .table-responsive::-webkit-scrollbar{
       
    }

    #scroll-hide::-webkit-scrollbar {
	width:0px;
    }
    .caze:hover{
        opacity: .8;
        cursor:pointer;
    }
    .empty{
        color:grey;
    }
    .empty:hover{
        opacity: .8;
        cursor:pointer;
        background-color:grey;
        color:white;
    }
</style>

<div class="col-12 col-lg-11 mx-auto">
    <div class="col-12 shadow bg-info text-white mt-5">
        <div class="row py-2">
            <div class="col">
                <span onClick="previous()" class="bg-info my-auto" onMouseOver="this.style.color='grey'"
                    onMouseOut="this.style.color='white'" style="cursor:pointer;">
                    < Précedent</span> 
            </div> 
            <div class="col text-center">
                <span onClick="today()" class="bg-info text-center  text-center my-auto"
                    onMouseOver="this.style.color='grey'" onMouseOut="this.style.color='white'" style="cursor:pointer;">
                    Cette semaine</span> <span id=year></span>
            </div>
            <div class="col text-right">
                <span class="bg-info my-auto" onMouseOver="this.style.color='grey'"
                    onMouseOut="this.style.color='white'" onClick="next()" style="cursor:pointer;">Suivant ></span>
            </div>
        </div>
    </div>
    <div class="table-responsive mb-5">
        <table id="data" class="text-center w-100 bg-secondary shadow border text-light">

        </table>
    </div>
</div>


<!-- Modal add -->
<div id="add" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une seance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="cancel">&times;</span>
                </button>
            </div>
            <div class="model-body">
                <div class="my-2 mb-4">
                    <label class="pl-3" for="">Groupe</label>
                    <select class="form-control ml-3 col-11" name="gSelect" id="gCreateSelect">
                        <!-- Eliminate - group in the future -->
                        <?php foreach ($data['groups'] as $grp) {echo '<option value="'.$grp->id_grp.'">'.$grp->nom_grp.'</option>';}?>
                    </select>
                    <label class="pl-3" for="">Moniteur</label>
                    <select class="form-control ml-3 col-11" name="gSelect" id="mCreateSelect">
                        <?php foreach ($data['moniteurs'] as $mnt) {echo '<option value="'.$mnt['moniteur']['id_mnt'].'">'.$mnt['user']['nom'].'</option>';}?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="cancel btn btn-sm btn-secondary">ANNULER</button>
                <button id="addConfirme" class="btn btn-sm btn-success">AJOUTER</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        today();
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

    function addP(d, t) {
        d = d + " " + t + ":00";
        //get the choosed monitor and vehicul
        
        $('#add').modal('show');
        $('#addConfirme').click(function () {
            
            $('#add').modal('hide');
            $('#addConfirme').unbind();

            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT;?>/gestion/addRdv/",
                data: {
                    d: d,
                },
                success: function (response) {
                    currentWeek();
                    return false;
                }
            });

        });
    }

    function today() {
        $.ajax({
            url: "<?php echo URLROOT;?>/gestion/getPlanning",
            success: function (data) {
                result = data.split('~');
                $('#data').html(result[0]);
                $('#year').html(result[1]);

            }
        });
    }

    function next() {
        id = $('th[id]').attr('id');
        $.ajax({
            url: "<?php echo URLROOT;?>/gestion/nextWeek/"+id,
            success: function (data) {
                result = data.split('~');
                $('#data').html(result[0]);
                $('#year').html(result[1]);
            }
        });
    }

    function previous() {
        id = $('th[id]').attr('id');
        $.ajax({
            url: "<?php echo URLROOT;?>/gestion/previousWeek/"+id,
            success: function (data) {
                result = data.split('~');
                $('#data').html(result[0]);
                $('#year').html(result[1]);
            }
        });
    }
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>