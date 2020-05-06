
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
            <h3 align="center" > Add Subject </h3>
            <form method="post">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select a class/paper</label>
                    <select class="form-control" name="c_id" id="exampleFormControlSelect1">
                       <?php foreach($class as $c){ ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo $c['class_name']; ?></option>
                        <?php } ?>

                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Enter a subject name</label>
                    <input type="text" name="sub_name" class="form-control" id="exampleFormControlInput1">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>

            </form>
        </div>
    </div>

</div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->

        <!-- End of Footer -->

<script>


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