
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
            <h3 align="center" >Upload Mcq </h3>
            <form id="post" method="post" enctype="multipart/form-data">


                <div class="form-group">
                    <label for="exampleInputPassword1">Select Class</label>
                    <select name="class" id="class" class="custom-select" required>
                        <option>Select Category</option>
                        <?php foreach($class as $c){ ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo $c['class_name']; ?></option>
                        <?php } ?>

                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Select Subject</label>
                    <select name="subject" id="subject" class="custom-select" required>
                        <option>Select Subject</option>


                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Select Excersise</label>
                    <select name="exercise" id="exercise" class="custom-select" required>
                        <option>Select Exercise</option>


                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Select Level</label>
                    <select name="exercise" id="level" class="custom-select" required>

                        <option>Easy</option>
                        <option>Medium</option>
                        <option>Hard</option>

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

        <?php $url=$this->Url->build([  "controller" => "docupload", "action" => "getdata" ]); ?>
<script>

$("#class").change(function(){
    var c_id= $("#class").val();
    $.post('<?php echo $url; ?>',
        {
            type: "subject",
            class: c_id
        },
        function(data, status){
            $("#subject").append(data);
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
            $("#exercise").append(data);
        });
});




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