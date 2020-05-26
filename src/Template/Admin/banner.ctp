
<!-- End of Topbar -->






        <!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->


<!-- Content Row -->

<!-- Content Row -->

<!-- Modal -->

<!-- Content Row -->
<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">GENERATE BANNER</h5>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">


                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Banner For</label>
                        <select class="form-control" name="type" id="type" required>
                            <option value="">--Select option--</option>
                           <option value="0">Learn</option>
                            <option value="1">Exam</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select Class/Exam</label>
                        <select class="form-control" name="c_id" id="c_id" required>


                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select Subject</label>
                        <select class="form-control" name="s_id" id="s_id" required>


                        </select>
                    </div>

                    <input type="hidden" name="exam_type" value="1"/>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Enter test title </label>
                        <input type="file" name="file" class="form-control"  required>
                    </div>




                    <div class="form-group">
                        <label for="comment">Message:</label>
                        <textarea class="form-control" rows="5" name="msg" id="comment" required></textarea>
                    </div>


                    <!--<div class="file-path-wrapper">-->
                    <!--     <input class="file-path validate" type="text" placeholder="Upload your file">-->
                    <!--    </div>-->
                    <!--    </div>-->
                </br>
                <button type="submit" class="btn btn-success">Add</button>
            </form>

        </div>
    </div>
</div>
<div class="col-8">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Banner</h5>
        </div>
        <div class="card-body">
            <table id="table_id" class="cell-border compact stripe hover">
                <thead>
                <tr>
                    <th>Test Id</th>
                    <th>Exam/Class Name</th>
                    <th>Subject Name</th>
                    <th>File </th>
                    <th>Message</th>

                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($banner as $g){
                        $id=$g['id'];
                        ?>
                <tr>

                    <td><?php echo $id; ?></td>
                    <td><?php echo $g['class']; ?></td>
                    <td><?php echo $g['subject']; ?></td>
                    <td><img src="<?php echo $g['file']; ?>" /></td>
                    <td><?php echo $g['msg']; ?></td>

                    <td>


                        <a onclick="return confirm('Are you sure you want to delete?? All related data will be deleted !!');" href='<?php echo $this->Url->build([  "controller" => "Admin", "action" => "delbanner","id"=>$id ]); ?>' ><i class="fa fa-times" aria-hidden="true"></i></a>

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
        <?php $url=$this->Url->build([  "controller" => "Admin", "action" => "getdata" ]); ?>
        <?php $load=$this->Url->build([  "controller" => "Generate", "action" => "loaddetail" ]); ?>

<script>

$(document).ready(function() {
    $('.summernote').summernote();
});

$("#type").change(function(){
    var c_id= $("#type").val();
    $.post('<?php echo $url; ?>',
        {

            type: c_id
        },
        function(data, status){
            $("#c_id").html(data);
        });
});



$("#c_id").change(function(){
    var c_id= $("#c_id").val();
    var gfor= $("#type").val();
    $.post('<?php echo $url; ?>',
        {
            for: gfor,
            class: c_id,
            type: 5
        },
        function(data, status){
            $("#s_id").html(data);
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



$( document ).ready(function() {
    $('#summernote').summernote();
});

$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

</script>