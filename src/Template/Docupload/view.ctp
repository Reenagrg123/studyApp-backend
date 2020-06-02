
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
.data{
    display:block;
}
    .teaxtedit{
        display:none;
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
                <li class="breadcrumb-item"><a href='<?php echo $this->Url->build([  "controller" => "Docupload", "action" => "index"]); ?>'>Upload Question</a></li>
                <li class="breadcrumb-item active" aria-current="page"> View</li>
            </ol>
        </nav>
        <h5 class="card-title"><center><u>QUESTIONS LIST</u></center></h5></br>


    <?php  $i=1;
     $upload_id=$upload_id;
            foreach($data as $d){

            $data=json_decode($d['data']);
            $q_id=$d['id'];

            ?>

    <div id="<?php echo $i; ?>" class="block" onclick="$(this).next().toggle();">  Q. <?php echo $i; ?></div>
    <div class="inner" style="display:none;">
        <?php if($d['type']=='mcq'){ ?>
        <form method="post" id="form<?php echo $i; ?>">
<input type="hidden" name="q_id" value="<?php echo $d['id']; ?>">
            <input type="hidden" name="type" value="<?php echo $d['type']; ?>">
            <button id="edit" onclick="$('#form<?php echo $i; ?>').find('.note-editor').toggle(); $('#form<?php echo $i; ?>').find('.data').toggle(); $('#form<?php echo $i; ?>').find('.click2edit').summernote();$(this).text($(this).text() == 'Cancel' ? 'Edit' : 'Cancel');" class="btn btn-primary"  type="button">Edit </button>
            <a id="save" class="btn btn-primary" onclick="save(this,'<?php echo $i; ?>')" type="button">Save </a>
            <a id="del" class="btn btn-primary" onclick="return confirm('Are you sure you want to delete?? All related data will be deleted !!');"  href='<?php echo $this->Url->build([  "controller" => "Docupload", "action" => "delquestion","id"=>$q_id,"upload"=>$upload_id ]); ?>' type="button">Delete </a>

            <br/>


            <b>Question</b>
<div class="breadcrumb">
    <div class="data"> <?php  echo $data->question; ?></div>
    <textarea class="teaxtedit click2edit" name="question">  <?php  echo $data->question; ?> </textarea>
</div>



            <b>Options</b>
             <?php $j=0;
                     foreach ($data->option as $o){
                    ?>

            <div class="breadcrumb ">
                <div  class="data"> <?php  echo $o; ?></div>
                <textarea class="teaxtedit click2edit" name='option[<?php echo $j; ?>]'>   <?php  echo $o; ?></textarea>

            </div>
            <?php  $j++; } ?>

            <b>Answer</b>
            <?php
                    $p=0;
                    foreach ($data->answer as $a){
                    ?>

            <div class="breadcrumb">
                <div class="data"><?php  echo $a; ?></div>
                <textarea class="teaxtedit click2edit" name="answer[<?php echo $p; ?>]">   <?php  echo $a; ?></textarea>

            </div>
            <?php $p++; } ?>


            <b>Solution</b>
              <?php
                      $t=0;
                      foreach ($data->solution as $s){
                ?>
            <div class="breadcrumb">
                <div class="data"><?php  echo $s; ?></div>
                <textarea class="teaxtedit click2edit" name="solution[<?php echo $t; ?>]">   <?php  echo $s; ?></textarea>

            </div>

            <?php  $t++; } ?>

        </form>
        <?php } if($d['type']=='integer'){ ?>

        <form method="post" id="form<?php echo $i; ?>">
            <input type="hidden" name="q_id" value="<?php echo $d['id']; ?>">
            <input type="hidden" name="type" value="<?php echo $d['type']; ?>">
            <button id="edit" onclick="$('#form<?php echo $i; ?>').find('.note-editor').toggle(); $('#form<?php echo $i; ?>').find('.data').toggle(); $('#form<?php echo $i; ?>').find('.click2edit').summernote();$(this).text($(this).text() == 'Cancel' ? 'Edit' : 'Cancel');" class="btn btn-primary"  type="button">Edit </button>
            <a id="save" class="btn btn-primary" onclick="save(this,'<?php echo $i; ?>')" type="button">Save </a>
            <a id="del" class="btn btn-primary" onclick="return confirm('Are you sure you want to delete?? All related data will be deleted !!');"  href='<?php echo $this->Url->build([  "controller" => "Docupload", "action" => "delquestion","id"=>$q_id,"upload"=>$upload_id ]); ?>' type="button">Delete </a>

            <br/>


            <b>Question</b>
            <div class="breadcrumb">
                <div class="data"> <?php  echo $data->question; ?></div>
                <textarea class="teaxtedit click2edit" name="question">   <?php  echo $data->question; ?></textarea>

            </div>


            <b>Answer</b>

            <?php $m=0; foreach ($data->answer as $a){
                    ?> <div class="breadcrumb">

            <div class="data"> <?php  echo $a; ?></div>
            <textarea class="teaxtedit click2edit" name="answer[<?php echo $m; ?>]">   <?php  echo $a; ?></textarea>

        </div>

            <?php $m++; } ?>

            <b>Solution</b>  <?php $t=0; foreach ($data->solution as $st){
                ?>
            <div class="breadcrumb">
                <div class="data"><?php  echo $st; ?></div>
                <textarea class="teaxtedit click2edit" name="solution[<?php echo $t; ?>]">   <?php  echo $st; ?></textarea>

            </div>

            <?php $t++; } ?>

        </form>



        <?php  } if($d['type']=="paragraph"){ ?>

        <form method="post" id="form<?php echo $i; ?>">
            <input type="hidden" name="q_id" value="<?php echo $d['id']; ?>">
            <input type="hidden" name="type" value="<?php echo $d['type']; ?>">
            <button id="edit" onclick="$('#form<?php echo $i; ?>').find('.note-editor').toggle(); $('#form<?php echo $i; ?>').find('.data').toggle(); $('#form<?php echo $i; ?>').find('.click2edit').summernote();$(this).text($(this).text() == 'Cancel' ? 'Edit' : 'Cancel');" class="btn btn-primary"  type="button">Edit </button>
            <a id="save" class="btn btn-primary" onclick="save(this,'<?php echo $i; ?>')" type="button">Save </a>
            <a id="del" class="btn btn-primary" onclick="return confirm('Are you sure you want to delete?? All related data will be deleted !!');"  href='<?php echo $this->Url->build([  "controller" => "Docupload", "action" => "delquestion","id"=>$q_id,"upload"=>$upload_id ]); ?>' type="button">Delete </a>

            <br/>
            <b>Question</b>
            <div class="breadcrumb">
                <div class="data"> <?php  echo $data->question; ?></div>
                <textarea class="teaxtedit click2edit" name="question">   <?php  echo $data->question; ?></textarea>

            </div>
            <?php $i=0; foreach ($data->innerquestion as $in){ ?>
                    <div style="margin-left:50px;">

                    <?php
                    echo "<b>Inner Question</b><div class='breadcrumb'><div class='data' >".$in->question."</div>  <textarea class='teaxtedit click2edit' name='innerquestion[".$i."][question]'> ".$in->question." </textarea>
    </div><br/>";


                            $t=0;
                        if(! $in->type=='integer'){
                        echo "<b>Options</b>";
                    foreach($in->option as $op){

                    echo "<div class='breadcrumb'><div class='data'>".$op."</div><textarea class='teaxtedit click2edit' name='innerquestion[".$i."][option][".$t."]'> ".$op." </textarea></div>";
                  $t++;
                    }
                        }
                    echo "<b>Answer</b>";
                            $m=0;
                    foreach($in->answer as $op){
                    echo "<div class='breadcrumb'><div class='data'>".$op."</div><textarea class='teaxtedit click2edit' name='innerquestion[".$i."][answer][".$m."]'> ".$op." </textarea></div>";
                   $m++;
                    }
                    echo "<b>Solution</b>";
                            $p=0;
                    foreach($in->solution as $op){
                    echo "<div class='breadcrumb'><div class='data'>".$op."</div><textarea class='teaxtedit click2edit' name='innerquestion[".$i."][solution][".$p."]'> ".$op." </textarea></div>";
                    $p++;
                            }
                    ?>
                    </div>



            <?php $i++; } ?>


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


function save(e,id) {
    $('#form'+id).submit();

   // var markup = $('.click2edit').summernote('code');
  //  $(e).parent().find('.click2edit').summernote('destroy');

}

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