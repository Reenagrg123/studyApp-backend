
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->


    <!-- Content Row -->

    <!-- Content Row -->
    <!-- Content Row -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Class</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Class</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">UPLOAD QUESTION BANK</h5>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select Upload For</label>
                            <select class="form-control" name="upload_for" id="upload_for" required>
                                <option value="">--Select Option--</option>
                                <option value="0">Class</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select a class name</label>
                            <select class="form-control" name="c_id" id="class" required>
                                <option value="">--Select Option--</option>
                                <?php foreach($class as $c){ ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo $c['class_name']; ?></option>
                                <?php } ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select a subject name</label>
                            <select class="form-control" name="s_id" id="subject" required>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select a chapter name</label>
                            <select class="form-control" name="ex_id" id="exercise" required>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Enter a topic name</label>
                            <input type="text" name="title" class="form-control" id="" placeholder="Ex: Basic Intergration Questions" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Enter correct answer marks</label>
                            <input type="text" name="correct_mark" class="form-control" id="exampleFormControlInput1" placeholder="Ex: 4" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Enter wrong answer marks</label>
                            <input type="text" name="wrong_mark" class="form-control" id="exampleFormControlInput1" placeholder="Ex: 1" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select type of questions</label>
                            <select class="form-control" name="q_type" required>
                                <option value="mcq" >Mcq</option>
                                <option value="integer" >Integer</option>
                                <option value="paragraph" >Paragraph</option>
                            </select>
                        </div>



                        <div class="form-group">
                            <label for="exampleFormControlInput1">Select a file(.zip)</label>

                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="customFile" required>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>

                        <!--<div class="file-path-wrapper">-->
                        <!--     <input class="file-path validate" type="text" placeholder="Upload your file">-->
                        <!--    </div>-->
                        <!--    </div>-->

                        <button type="submit" class="btn btn-success" style="width: 100px; float: right;">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">QUESTION BANK</h5>
                </div>
                <div class="card-body">
                    <table id="table_id" class="cell-border compact stripe hover">
                        <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Class Name</th>
                            <th>Type Of Qns</th>
                            <th>Created At</th>
                            <th></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($record as $r){
                                $id=$r['id'];
                                $has=$r['hashid'];
                                ?>
                        <tr>

                            <td><?php echo $r['title']; ?></td>
                            <td><?php echo $r['Class']['class_name']; ?></td>
                            <td><?php echo $r['type'] ?></td>
                            <td><?php echo $r['Exercises']['title']; ?></td>
                            <!--<td><?php echo $r['correct_mark']; ?></td>-->
                            <!--<td><?php echo $r['wrong_mark']; ?></td>-->
                            <td>

                                <a href='<?php echo $this->Url->build([  "controller" => "Docupload", "action" => "view","id"=>$has ]); ?>'> <i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a onclick="return confirm('Are you sure you want to delete , all data will be deleted?');" href="<?php echo $this->Url->build([  "controller" => "Admin", "action" => "delexercise","id"=>$id ]); ?>"> <i class="fa fa-times" aria-hidden="true"></i>
                            </td>


                        </tr>

                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->

        <!-- End of Footer -->
        <?php $url=$this->Url->build([  "controller" => "docupload", "action" => "getdata" ]); ?>


<script>

$("#class").change(function(){
    var c_id= $("#class").val();
    $.post('<?php echo $url; ?>',
        {
            type: "subject",
            class: c_id
        },
        function(data, status){
            $("#subject").html(data);
        });
});



$("#subject").change(function(){
    var c_id= $("#class").val();
    var s_id= $("#subject").val();
    $.post('<?php echo $url; ?>',
        {
            type: "excersise",
            class: c_id,
            subject: s_id
        },
        function(data, status){
            $("#exercise").html(data);
        });
});

$(document).ready( function () {
    $('#table_id').DataTable({
        columnDefs: [
            {
                targets: -1,
                className: 'dt-body-center',
                className:'dt-head-center'

            }
        ]
    })
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