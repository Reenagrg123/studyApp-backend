
<!-- End of Topbar -->

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
                    <h5 class="card-title">UPLOAD STUDY MATERIAL</h5>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">

<input type="hidden" name="upload_for" value="0"/>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select Class</label>

                        <select class="form-control" name="class" id="class" required>
                            <option value="">Select Option</option>
                            <?php foreach($class as $c){ ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo $c['class_name']; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select a subject</label>
                        <select class="form-control" name="subject" id="subject" required>
                            <?php foreach($subject as $c){ ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo $c['subject_name']; ?></option>
                            <?php } ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select a chapter</label>
                        <select class="form-control" name="ch_id" id="exercise" required>
                            <?php foreach($subject as $c){ ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo $c['subject_name']; ?></option>
                            <?php } ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Enter a topic name</label>
                        <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="Ex: Basic Integration " required>
                    </div>

           <div class="form-group">
                <label for="exampleFormControlSelect1">Select Type </label>
          <select class="form-control" name="upload_type" id="upload_type" required>
                       <option value="">Select Option</option>
                        <option value="0">Pdf</option>
                        <option value="1">Youtube Link</option>
                        <option value="2">Both</option>
          </select>
                        </div>


                <div class="form-group">
                    <label for="exampleFormControlInput1">Enter a you-tube link</label>
                    <input type="text" name="link" class="form-control" id="exampleFormControlInput1" >
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput1">Select a PDF file</label>

                    <div class="custom-file">
                        <input type="file" name="file" class="form-control" id="customFile" >

                    </div>
                </div>
                <!--<div class="file-path-wrapper">-->
                <!--     <input class="file-path validate" type="text" placeholder="Upload your file">-->
                <!--    </div>-->
                <!--    </div>-->

                <button type="submit" class="btn btn-success" style="width: 100px; float: right;">SUBMIT</button>
            </form>
        </div>
    </div>
</div>
<div class="col-8">
<div class="card">
    <div class="card-header">
        <h5 class="card-title">ALL MATERIAL</h5>
    </div>
    <div class="card-body">
        <table id="table_id" class="cell-border compact stripe hover">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Class Name</th>
                <th>Subject Name</th>
                <th>Chapter</th>
                <th>Topic Name</th>


                <th></th>

            </tr>
            </thead>
            <tbody>
            <?php

            $i=1;
            foreach($records as $r){
                    $id=$r['id'];

                    ?>
            <a>
                <td><?php echo $i; ?></td>
                <td><?php echo $r['Class']['class_name']; ?></td>
                <td><?php echo $r['Subject']['subject_name']; ?></td>
                <td><?php echo $r['Exercises']['title']; ?></td>

                <td><?php echo $r['name']; ?></td>



                <td>
                    <a href="#" id="preview" onclick="show(`<?php echo $id; ?>`);" ><i class="fa fa-info" aria-hidden="true"></i></a>


                    <a onclick="return confirm('Are you sure you want to delete , all data will be deleted?');" href="<?php echo $this->Url->build([  "controller" => "Docupload", "action" => "delmaterial","id"=>$id ]); ?>"> <i class="fa fa-times" aria-hidden="true"></i></a>
                <a href="<?php echo $this->Url->build([  "controller" => "Docupload", "action" => "edit","id"=>$id ]); ?>"> <i class="fa fa-edit" aria-hidden="true"></i></a>


                </td>
</tr>
            <?php $i++;  } ?>

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
<?php $load=$this->Url->build([  "controller" => "Docupload", "action" => "loaddetail" ]); ?>

<script>


    function show(id){
        $.post('<?php echo $load; ?>',
            {
                type: "1",
                id: id
            },
            function(data, status){
                $("#load").html(data);
                $('#exampleModal').modal('toggle')
            });

    }


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
        responsive: true,

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