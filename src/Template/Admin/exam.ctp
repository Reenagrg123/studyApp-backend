
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
            <h3 align="center" ><u>Add Exam </u> </h3>
            <!--<form id="post" method="post" enctype="multipart/form-data">-->

            <form method="post">
            <div class="form-group">
                <label for="exam">Select classes</label></br>
            <label class="checkbox-inline"><input type="checkbox" value=""> 10th</label>
            <label class="checkbox-inline"><input type="checkbox" value=""> 11th</label>
            <label class="checkbox-inline"><input type="checkbox" value=""> 12th</label>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Enter an exam name</label>
            <input type="text" name="class" class="form-control" id="exampleFormControlInput1" value="<?php if(isset($edit)){ echo $editdata['class_name']; }?>" >
        </div>
        <!--<input type="text" class="form-control" id="class" placeholder="Enter a class or paper name">-->
        <!--</div>-->
        <button type="submit" class="btn btn-success mb-2">
            <?php if(isset($edit)){ echo 'Edit'; }else { echo 'Add'; }   ?>


        </button>


    </form>
    <!--</form>-->
</br></br>
<hr/>

        </br></br>
<h3 align="center" ><u>All Exams </u> </h3>

<table id="table_id" class="display">
<thead>
<tr>
    <th>S.No</th>
    <th>Class Name</th>
    <th></th>

</tr>
</thead>
<tbody>

<?php foreach($class as $c){
        $id=$c['id'];
        ?>
<a>

    <td><?php echo $c['id']; ?></td>
    <td><?php echo $c['class_name']; ?></td>
    <td>
    <a href='<?php echo $this->Url->build([  "controller" => "Admin", "action" => "classadd","id"=>$id ]); ?>' ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

    <a onclick="return confirm('Are you sure you want to delete , all data will be deleted?');" href="<?php echo $this->Url->build([  "controller" => "Admin", "action" => "delclass","id"=>$id ]); ?>"> <i class="fa fa-times" aria-hidden="true"></i>

</a>
</td>


</tr>
        <?php } ?>
        </tbody>
        </table>


        </div>

        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->

        <!-- End of Footer -->

<script>
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