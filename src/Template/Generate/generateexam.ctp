
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->


    <!-- Content Row -->

    <!-- Content Row -->



    <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="load">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Content Row -->
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">GENERATE TEST</h5>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">

<input type="hidden" name="exam_type" value="2"/>
                        <input type="hidden" name="level" value=0"/>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Instruction:</label>
                            <textarea name="instruction" class='summernote'  ></textarea>
                        </div>


                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select a Exam name</label>
                            <select class="form-control" name="c_id" id="c_id" required>
                                <option value="">--Select option--</option>
                                <?php foreach($class as $c){ ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo $c['exam_name']; ?></option>
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
<th>S No.</th>
                        <th>Class Name</th>
                        <th>Subject Name</th>
                        <th>Chapter Name</th>
                        <th>Test Title</th>

                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=1;
                    foreach($generatedata as $g){
                            $id=$g['id'];
                            ?>
                    <tr>
<td><?php echo $i; ?></td>
                        <td><?php echo $g['exam']['exam_name']; ?></td>
                        <td><?php echo $g['examsubject']['subject_name']; ?></td>

                        <td><?php echo $g['examexercise']['title']; ?></td>
                        <td><?php echo $g['name']; ?></td>

                        <td>
                            <a href="#" id="preview" onclick="show(`<?php echo $id; ?>`);" ><i class="fa fa-info" aria-hidden="true"></i></a>

                            <a href='<?php echo $this->Url->build([  "controller" => "Generate", "action" => "view","id"=>$id ]); ?>' ><i class="fa fa-eye" aria-hidden="true"></i></a>

                            <a href='<?php echo $this->Url->build([  "controller" => "Generate", "action" => "add","id"=>$id ]); ?>' ><i class="fa fa-plus" aria-hidden="true"></i></a>
                            <a href='<?php echo $this->Url->build([  "controller" => "Generate", "action" => "edit","id"=>$id,"type"=>2 ]); ?>' ><i class="fa fa-edit" aria-hidden="true"></i></a>

                        </td>


                    </tr>
                    <?php $i++;  } ?>
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
        <?php $load=$this->Url->build([  "controller" => "Generate", "action" => "loaddetail" ]); ?>

<script>

function show(id){
    $.post('<?php echo $load; ?>',
        {
            type: "2",
            id: id
        },
        function(data, status){
            $("#load").html(data);
            $('#exampleModal').modal('toggle')
        });

}

$("#c_id").change(function(){
    var c_id= $("#c_id").val();
    $.post('<?php echo $url; ?>',
        {
            for: "exam",
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
            for: "exam",
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
    $('.summernote').summernote();
});

$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

</script>