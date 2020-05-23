
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->


    <!-- Content Row -->

    <!-- Content Row -->



    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit E-Book </u></h5>

                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group" >
                            <label for="exampleFormControlSelect1">Select a category name</label>
                            <select class="form-control" name="cat_id" id="c_id" required>
                                <option value="">--Select Option--</option>
                                <?php foreach($class as $c){ ?>
                                    <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Enter an e-book name</label>
                            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Ex: NECRT Class 12th chemistry" value="<?php echo $data['name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Choose a file(.pdf)</label>

                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="customFile" >
                                <label class="custom-file-label" for="customFile">Choose file</label>
                                <p><?php echo $data['file']; ?></p>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mb-2" style="width: 100px; float: right;">
                           Save </button>
                    </form>
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

$('#c_id option[value=<?php echo $data["cat_id"]; ?>]').attr('selected','selected');

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