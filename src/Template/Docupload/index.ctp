
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
            <h3 align="center"><u>Upload Question Bank</u></h3>
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
                    <input type="text" name="title" class="form-control" id="" required>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput1">Enter correct answer marks</label>
                    <input type="text" name="correct_mark" class="form-control" id="exampleFormControlInput1" required>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput1">Enter wrong answer marks</label>
                    <input type="text" name="wrong_mark" class="form-control" id="exampleFormControlInput1" required>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select type of questions</label>
                    <select class="form-control" name="q_type" required>
                        <option value="mcq" >Mcq</option>
                        <option value="integer" >Integer</option>
                        <option value="paragraph" >Paragraph</option>
                    </select>
                </div>




                <label for="exampleFormControlInput1">Select a file(.zip)</label>

                <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input" id="customFile" required>
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>

                <!--<div class="file-path-wrapper">-->
                <!--     <input class="file-path validate" type="text" placeholder="Upload your file">-->
                <!--    </div>-->
                <!--    </div>-->
            </br>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>

    </br></br>
<h3 align="center"><u>Question Bank</u>  </h3>
        </br></br>
<table id="table_id" class="display">
<thead>
<tr>
    <th>File Id</th>
    <th>Class Name</th>
    <th>Subject Name</th>
    <th>Chapter Name</th>
    <th>Correct Marks</th>
    <th>Wrong Marks</th>
    <th></th>

</tr>
</thead>
<tbody>
<?php foreach($record as $r){
        $id=$r['id'];
        $has=$r['hashid'];
        ?>
<tr>

    <td><?php echo $id; ?></td>
    <td><?php echo $r['Class']['class_name']; ?></td>
    <td><?php echo $r['Subject']['subject_name']; ?></td>
    <td><?php echo $r['Exercises']['title']; ?></td>
    <td><?php echo $r['correct_mark']; ?></td>
    <td><?php echo $r['wrong_mark']; ?></td>
    <td>

        <a href='<?php echo $this->Url->build([  "controller" => "Docupload", "action" => "view","id"=>$has ]); ?>'> <i class="fa fa-eye" aria-hidden="true"></i></a>

    </td>


</tr>

<?php } ?>
</tbody>
</table>

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