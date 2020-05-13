
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
            <h3 align="center"><u>Generate Test</u>  </h3>
            <form method="post">
            <div class="form-group">
                <label for="exampleFormControlSelect1">Select a Exam Type</label>
                <select class="form-control" name="exam_type" id="exampleFormControlSelect1" required>
                    <option value="">Select Option</option>
                   <option value="0">Practice Test</option>
                    <option value="1">Online Test</option>

                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Select a Class</label>
                <select class="form-control" name="c_id" id="c_id" required>
                    <option value="">Select option</option>
                    <?php foreach($class as $c){ ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['class_name']; ?></option>
                    <?php } ?>

                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Select a Subject</label>
                <select class="form-control" name="s_id" id="s_id" required>


                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Select Capters</label>
                <select class="form-control" name="ex_id" id="ex_id" required>

                </select>
            </div>




            <div class="form-group">
                <label for="exampleFormControlInput1">Enter a Exam name</label>
                <input type="text" name="name" class="form-control" id="" required>
            </div>




                <div class="form-group">
                    <label for="exampleFormControlInput1">Enter Total Timing (In Min)</label>
                    <input type="text" name="total_time" class="form-control" id="exampleFormControlInput1" required>
                </div>


        <!--<div class="file-path-wrapper">-->
        <!--     <input class="file-path validate" type="text" placeholder="Upload your file">-->
        <!--    </div>-->
        <!--    </div>-->
    </br>
    <button type="submit" class="btn btn-success">Submit</button>
</form>




        </br></br>

<h3 align="center"><u>All material</u>  </h3>
        </br></br>
<table id="table_id" class="display">
<thead>
<tr>
    <th>id.No</th>
    <th>Class Name</th>
    <th>Subject Name</th>
    <th>Capter Name</th>
    <th>name</th>

    <th></th>
</tr>
</thead>
<tbody>
<?php foreach($generatedata as $g){
        $id=$g['id'];
        ?>
<tr>
    <td><?php echo $id; ?></td>
    <td><?php echo $g['Class']['class_name']; ?></td>
    <td><?php echo $g['Subject']['subject_name']; ?></td>

    <td><?php echo $g['Exercises']['title']; ?></td>
    <td><?php echo $g['name']; ?></td>

    <td>
        <a href='<?php echo $this->Url->build([  "controller" => "Generate", "action" => "add","id"=>$id ]); ?>' ><i class="fa fa-eye" aria-hidden="true"></i></a>





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
        <?php $url=$this->Url->build([  "controller" => "Generate", "action" => "getdata" ]); ?>
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