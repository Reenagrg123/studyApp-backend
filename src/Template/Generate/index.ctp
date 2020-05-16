
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->


    <!-- Content Row -->

    <!-- Content Row -->



    <!-- Content Row -->
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">GENERATE TEST</h5>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select test type</label>
                            <select class="form-control" name="exam_type" id="exampleFormControlSelect1" required>
                                <option value="">--Select Option--</option>
                                <option value="0">Practice Test</option>
                                <option value="1">Online Test</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select level of test</label>
                            <select class="form-control" name="level" id="exampleFormControlSelect1" required>
                                <option value="">--Select Option--</option>
                                <option value="0">Easy </option>
                                <option value="1">Medium </option>
                                <option value="2">Hard</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select a class name</label>
                            <select class="form-control" name="c_id" id="c_id" required>
                                <option value="">--Select option--</option>
                                <?php foreach($class as $c){ ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo $c['class_name']; ?></option>
                                <?php } ?>

                            </select>
                        </div>

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
                            <label for="exampleFormControlInput1">Enter test title </label>
                            <input type="text" name="name" class="form-control" placeholder="Ex: Definite integration test" id="" required>
                        </div>




                        <div class="form-group">
                            <label for="exampleFormControlInput1">Enter duration of test (in minutes)</label>
                            <input type="text" name="total_time" class="form-control" id="exampleFormControlInput1" placeholder="Ex: 120" required>
                        </div>


                        <!--<div class="file-path-wrapper">-->
                        <!--     <input class="file-path validate" type="text" placeholder="Upload your file">-->
                        <!--    </div>-->
                        <!--    </div>-->
                    </br>
                    <button type="submit" class="btn btn-success">Generate</button>
                </form>

            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">GENERATED TESTS</h5>
            </div>
            <div class="card-body">
                <table id="table_id" class="cell-border compact stripe hover">
                    <thead>
                    <tr>
                        <th>Test Id</th>
                        <th>Class Name</th>
                        <th>Subject Name</th>
                        <th>Chapter Name</th>
                        <th>Test Title</th>

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
                            <a href='<?php echo $this->Url->build([  "controller" => "Generate", "action" => "view","id"=>$id ]); ?>' ><i class="fa fa-eye" aria-hidden="true"></i></a>

                            <a href='<?php echo $this->Url->build([  "controller" => "Generate", "action" => "add","id"=>$id ]); ?>' ><i class="fa fa-plus" aria-hidden="true"></i></a>

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

<style>
h2 {
    font-family: serif;
    font-weight:bold;
    text-align:center;
}
</style>
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