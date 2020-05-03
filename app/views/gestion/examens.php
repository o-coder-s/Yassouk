<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="col-11 mx-auto mt-5">
<div class="table-responsive">
        <table class="table w-100 table-light border shadow ">
            <thead class="bg-secondary text-white">
                <td>#id</td>
                <td>Date </td>
                <td>Total</td>
                <td>Success</td>
                <td>Echec</td>
                <td>Details</td>
            </thead>
            <tbody id="data">

            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function(){
        getExams();
    });


    function getExams(){
        $.ajax({
            type: "POST",
            url: "<?php echo URLROOT?>/gestion/getExams",
            success: function (response) {
                $('#data').html(response);
            }
        });
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>