
<style>
    .block{
        width: 100%;
        height: auto;
        background: white;
        margin: 5px;
        padding: 13px;

    }
.inner{
    width: 100%;
    background: white;
    padding: 10px;
    margin: 4px;
}

</style>
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">


    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->

        <div class="container">
            <h3 align="center" > Questions List </h3>


            <?php  $i=0;
                    foreach($data as $d){

                    $data=json_decode($d['data']);
                    ?>

            <div class="block" onclick="$(this).next().toggle();">  Q. <?php echo $i; ?> </div>

            <div class="inner" style="display:none;">



      <?php  echo json_decode($d['data'])->question; ?>



            </div>





            <?php $i++;
                    } ?>
        </div>
    </div>

</div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->

        <!-- End of Footer -->

<script>
$(document).ready( function () {
    $('#table_id').DataTable();
} );

function validate(){
    var er=true;
    var title = $('#title').val();
    var metades = $('#metades').val();
    var file = $('#customFile').val();
    var content = $('#summernote').val();
    if(title=='' || metades=='' || file=='' || content=='' ){
        alert("All Fields are Required");
        return false;
        er=false;
    }

    if(content.length<100){


        alert("content should be greater than 100 characters");
        return false;
        er=false;
    }
    if(er==true){
        return true;
    }
    else {

        return false;
    }
}

$("#post").submit(function(e){

    if(validate()){
        return ;
    }
    e.preventDefault();
});




$( document ).ready(function() {
    $('#summernote').summernote({height: 300});
});

</script>