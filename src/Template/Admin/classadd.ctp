
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
            <h3 align="center" > Add Class/Paper </h3>
            <!--<form id="post" method="post" enctype="multipart/form-data">-->

            <form method="post">

                <div class="form-group">
                    <label for="exampleFormControlInput1">Enter a class or paper name</label>
                    <input type="text" name="class" class="form-control" id="exampleFormControlInput1">
                </div>
                <!--<input type="text" class="form-control" id="class" placeholder="Enter a class or paper name">-->
                <!--</div>-->
                <button type="submit" class="btn btn-success mb-2">ADD</button>
            </form>
            <!--</form>-->

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