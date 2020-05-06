
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
            <h3 align="center" > Post Your Idea </h3>
            <form id="post" method="post" enctype="multipart/form-data">


                <div class="form-group">
                    <label for="exampleInputPassword1">Select Exercise</label>
                    <select name="exercise" class="custom-select" required>
                        <option>Select Category</option>


                        <option  value="1">1 </option>


                    </select>
                </div>



                <div class="custom-file">

                    <input type="file" name="file" class="custom-file-input" id="customFile" required>
                    <label class="custom-file-label" for="customFile">Choose zip</label>

                </div>

                <!--
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Content</label>
                                    <textarea name="content" id="summernote" cols="30" rows="10" required>
                      <h3 style="text-align: center; "><a href="http://www.jquery2dotnet.com" style="background-color: rgb(255, 255, 255); line-height: 1.428571429;">jquery2dotnet</a></h3>
                   </textarea>
                                    <small id="emailHelp" class="form-text text-muted">Your Idea Should be greater than 100 characters.</small>
                                </div>

                -->

                <button type="submit" class="btn btn-primary">Submit</button>
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