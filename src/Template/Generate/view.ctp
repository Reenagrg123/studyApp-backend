
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

<!-- Page Heading -->


<!-- Content Row -->

<!-- Content Row -->



<!-- Content Row -->
<div class="row">

    <!-- Content Column -->

    <div class="container">





    </br></br>

<input id="generateid" type="hidden" value="<?php  if(isset($id)){ echo $id; } ?>" />

<?php if(isset($data)){  ?>
<h3 align="center"><u> Questions List</u>  </h3>
<?php  $i=0;
        foreach($data as $d){
        $qid=$d['id'];
        $data=json_decode($d['data']);
        ?>

<div id="<?php echo $i; ?>" class="block" style="display:flex;" onclick="$(this).next().toggle();">  Q. <?php echo $i; ?>  <div style="width:90%;"><button style="float:right;" onclick="add('<?php echo $qid ?>',this)" class="btn btn-primary"> Delete</button></div> </div>
<div class="inner" style="display:none;">
    <?php if($d['type']=='mcq'){ ?>
    <form >


        Q.  <?php  echo $data->question; ?>


        <?php foreach ($data->option as $o){
                ?>

        <?php  echo $o; ?>
        <?php } ?>

        <p>Answer</p>
        <?php foreach ($data->answer as $a){
                ?>
        <?php  echo $a." "; ?>



        <?php } ?>



        Sol.  <?php foreach ($data->solution as $s){
            ?>

        <?php  echo $s; ?>


        <?php } ?>

    </form>
    <?php } if($d['type']=='integer'){ ?>

    <form >


        Q.  <?php  echo $data->question; ?>



        <p>Answer</p>
        <?php foreach ($data->answer as $a){
                ?>
        <?php  echo $a." "; ?>


        <?php } ?>

        Sol.  <?php foreach ($data->solution as $st){
            ?>

        <?php  echo $st; ?>


        <?php } ?>

    </form>



    <?php  } if($d['type']=="paragraph"){ ?>

    <form>
        Q.  <?php  echo $data->question; ?>

        <?php foreach ($data->innerquestion as $in){
                echo $in->question."<br/>";

                foreach($in->option as $op){
                echo $op;
                }

                foreach($in->answer as $op){
                echo $op;
                }

                foreach($in->solution as $op){
                echo $op;
                }
                ?>




        <?php } ?>


    </form>

    <?php } ?>



</div>
<?php $i++;
        } ?>

<?php } ?>

</div>

        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->

        <!-- End of Footer -->
        <?php $url=$this->Url->build([  "controller" => "Generate", "action" => "getdata" ]); ?>
        <?php $urlexam=$this->Url->build([  "controller" => "Generate", "action" => "getupload" ]); ?>
        <?php $add=$this->Url->build([  "controller" => "Generate", "action" => "addquestion" ]); ?>

<script>


$("#c_id").change(function(){
    var c_id= $("#c_id").val();
    $.post('<?php echo $url; ?>',
        {
            type: "subject",
            class: c_id
        },
        function(data, status){
            $("#s_id").html(data);
        });
});



$("#s_id").change(function(){
    var c_id= $("#c_id").val();
    var s_id= $("#s_id").val();
    $.post('<?php echo $url; ?>',
        {
            type: "excersise",
            class: c_id,
            subject: s_id
        },
        function(data, status){
            $("#ex_id").html(data);
        });
});



$("#ex_id").change(function(){
    var c_id= $("#c_id").val();
    var s_id= $("#s_id").val();
    var ex_id= $("#ex_id").val();
    $.post('<?php echo $urlexam; ?>',
        {
            type: "upload",
            class: c_id,
            subject: s_id,
            chapter: ex_id
        },
        function(data, status){
            $("#up_id").html(data);
        });
});

function add(qid,e){
    var id=$("#generateid").val();
    $.post('<?php echo $add; ?>',
        {
            qid: qid,
            id: id

        },
        function(data, status){


            if(JSON.parse(data).add=='1'){
                $(e).text("Delete");
            }else{
                $(e).parent().parent().next().remove();
                $(e).parent().parent().remove();

                $(e).text("Add");
            }

            // $("#up_id").html(data);
        });

}










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

$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

</script>