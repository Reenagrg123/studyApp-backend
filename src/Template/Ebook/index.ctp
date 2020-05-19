
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
                    <h5 class="card-title"><?php if(isset($edit)){ echo 'EDIT'; }else { echo 'ADD'; }?> E-Book </u></h5>

            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select a category name</label>
                        <select class="form-control" name="c_id" id="c_id" required>
                            <option value="">--Select Option--</option>
                            <?php foreach($class as $c){ ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo $c['class_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Enter an e-book name</label>
                        <input type="text" name="sub_name" class="form-control" id="exampleFormControlInput1" placeholder="Ex: NECRT Class 12th chemistry" value="<?php if(isset($edit)){ echo $editdata['subject_name']; }?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Choose a file(.pdf)</label>

                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="customFile" required>
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mb-2" style="width: 100px; float: right;">
                        <?php if(isset($edit)){ echo 'EDIT'; }else { echo 'ADD'; }   ?> </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">ALL E-Books</h5>
            </div>
            <div class="card-body">
                <table id="table_id" class="cell-border compact stripe hover">
                    <thead>
                    <tr>
                        <th>E-Book Id</th>
                        <th>Category Name</th>
                        <th>E-Book Name</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data as $d){
                            $id=$d['id'];
                            ?>
                    <tr>
                        <td><?php echo $d['id']; ?></td>
                        <td><?php echo $d['Class']['class_name']; ?></td>
                        <td><?php echo $d['subject_name']; ?></td>
                        <td>
                            <a href='<?php echo $this->Url->build([  "controller" => "Admin", "action" => "subject","id"=>$id ]); ?>' ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>


                            <a onclick="return confirm('Are you sure you want to delete , all data will be deleted?');" href="<?php echo $this->Url->build([  "controller" => "Admin", "action" => "delsub","id"=>$id ]); ?>"> <i class="fa fa-times" aria-hidden="true"></i>

                        </a>
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
<style>
h2 {
    font-family: serif;
    font-weight:bold;
    text-align:center;
}
</style>


        <?php if(isset($edit)){
                ?>

<script>
$("#c_id").removeAttr('required');
$("#c_id").parent().hide();
</script>
        <?php
                }?>
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