
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
<div class="container-fluid" >

<!-- Page Heading -->


<!-- Content Row -->

<!-- Content Row -->

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a type="button" href="#" onclick="window.history.back();">Generate Exam</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Add Question</li>
        </ol>
    </nav>

<!-- Content Row -->
<!-- Content Row -->
<div class="row" >
    <div class="col-10">
        <div class="card" style="margin-left: 150px;">
            <div class="card-header">
                <h5 class="card-title">ADD QUESTIONS</h3>
                <p>Select the following fields to see the uploaded questions files!! </p>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select a class name</label>
                            <select class="form-control" name="c_id" id="c_id" required>
                                <option value="">Select Option</option>
                                <?php foreach($class as $c){ ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo $c['class_name']; ?></option>
                                <?php } ?>

                            </select>
                        </div>

                        <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>" required>

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Select a subject name</label>
                                <select class="form-control" name="s_id" id="s_id" required>


                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Select a chapter name</label>
                                <select class="form-control" name="ex_id" id="ex_id" required>

                                </select>
                            </div>


                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Select from uploaded files</label>
                                <select class="form-control" name="up_id" id="up_id" required>

                                </select>
                            </div>


                        </br>
                        <button type="submit" class="btn btn-success" style="width: 150px; float: left;">View Questions</button>
                    </br>
                </form>

            </div>
        </div>
    </div>


</br></br>

<input id="generateid" type="hidden" value="<?php  if(isset($id)){ echo $id; } ?>" />

        <?php if(isset($data)){ ?>
<div class="row" >
<div class="col-12">
    <div class="card" style="margin-left: 150px;">
        <div class="card-header">
            <h5 class="card-title">QUESTIONS LIST</h3>
            <p>Expand to view the question!! </p>
            <div class="card-body">
                <?php  $i=0;
                        foreach($data as $d){
                        $qid=$d['id'];
                        $data=json_decode($d['data']);
                        ?>

                <div id="<?php echo $i; ?>" class="block" style="display:flex;" onclick="$(this).next().toggle();">  Q. <?php echo $i; ?>  <div style="width:90%;"><button style="float:right;" onclick="add('<?php echo $qid ?>',this)" class="btn btn-primary"> Add Question</button></div> </div>
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
                        $(e).text("Remove Question");
                    }else{
                        $(e).text("Add Question");
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