
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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Class</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Class</li>
            </ol>
        </nav>
        <h5 class="card-title"><center><u>QUESTIONS LIST</u></center></h5></br>


    <?php  $i=0;
            foreach($data as $d){

            $data=json_decode($d['data']);
            ?>

    <div id="<?php echo $i; ?>" class="block" onclick="$(this).next().toggle();">  Q. <?php echo $i; ?></div>
    <div class="inner" style="display:none;">
        <?php if($d['type']=='mcq'){ ?>
        <form >

            <b>Question</b>
<div class="breadcrumb">
    <?php  echo $data->question; ?>
</div>


            <b>Options</b>
            <?php foreach ($data->option as $o){
                    ?>

            <div class="breadcrumb">
            <?php  echo $o; ?>
            </div>
            <?php } ?>

            <b>Answer</b>
            <?php foreach ($data->answer as $a){
                    ?>

            <div class="breadcrumb">
            <?php  echo $a; ?>
            </div>
            <?php } ?>


            <b>Solution</b>
              <?php foreach ($data->solution as $s){
                ?>
            <div class="breadcrumb">
            <?php  echo $s; ?>
            </div>

            <?php } ?>

        </form>
        <?php } if($d['type']=='integer'){ ?>

        <form >

            <b>Question</b>
            <div class="breadcrumb">
              <?php  echo $data->question; ?>
            </div>


            <b>Answer</b>

            <?php foreach ($data->answer as $a){
                    ?> <div class="breadcrumb">
            <?php  echo $a." "; ?>
        </div>

            <?php } ?>

            <b>Solution</b>  <?php foreach ($data->solution as $st){
                ?>
            <div class="breadcrumb">
            <?php  echo $st; ?>
            </div>

            <?php } ?>

        </form>



        <?php  } if($d['type']=="paragraph"){ ?>

        <form>
            <b>Question</b>
            <div class="breadcrumb">
             <?php  echo $data->question; ?>
            </div>
            <?php foreach ($data->innerquestion as $in){ ?>
                    <div style="margin-left:50px;">

                    <?php
                    echo "<b>Inner Question</b><div class='breadcrumb'>".$in->question."</div><br/>";

                    echo "<b>Options</b>";
                    foreach($in->option as $op){
                    echo "<div class='breadcrumb'>".$op."</div>";
                    }
                    echo "<b>Answer</b>";
                    foreach($in->answer as $op){
                    echo "<div class='breadcrumb'>".$op."</div>";
                    }
                    echo "<b>Solution</b>";
                    foreach($in->solution as $op){
                    echo "<div class='breadcrumb'>".$op."</div>";
                    }
                    ?>
                    </div>



            <?php } ?>


        </form>

        <?php } ?>

    </div>

    <?php $i++;
            } ?>
</div>
</div>

        </div>
        <!-- /.container-fluid -->


        <!-- End of Main Content -->

        <!-- Footer -->

        <!-- End of Footer -->

<script>
$(document).ready(function() {
    $('.summernote').summernote();
});
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