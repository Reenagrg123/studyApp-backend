
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
            <h3 align="center" >   <?php if(isset($edit)){ echo 'Edit'; }else { echo 'Add'; }   ?>
                chapters </h3>
            <form method="post">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select a class/paper</label>
                    <select class="form-control" name="c_id" id="c_id" required>
                        <option value="">Select Option</option>
                        <?php foreach($class as $c){ ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo $c['exam_name']; ?></option>
                        <?php } ?>

                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select a subject</label>
                    <select class="form-control" name="s_id" id="s_id" required>


                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Enter a chapter name</label>
                    <input type="text" name="exercise" class="form-control" id="exampleFormControlInput1" value="<?php if(isset($edit)){ echo $editdata['title']; }?>" required>
                </div>
                <button type="submit" class="btn btn-success">  <?php if(isset($edit)){ echo 'Edit'; }else { echo 'Add'; }   ?>
                </button>

            </form>

        </br></br>
    <h3 align="center" ><u>All Chapters</u> </h3>
</br></br>
<table id="table_id" class="display">
<thead>
<tr>
    <th>S.No</th>
    <th>Class Name</th>
    <th>Subject Name</th>
    <th>Chapter Name</th>
    <th></th>

</tr>
</thead>
<tbody>

<?php foreach($exdata as $ex){
        $id=$ex['id'];
        ?>
<tr>
    <td><?php echo $ex['id']; ?></td>
    <td><?php echo $ex['Exam']['exam_name']; ?></td>
    <td><?php echo $ex['Examsubject']['subject_name']; ?></td>
    <td><?php echo $ex['title']; ?></td>
    <td>
        <a href='<?php echo $this->Url->build([  "controller" => "Exam", "action" => "excersise","id"=>$id ]); ?>' ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

        <a onclick="return confirm('Are you sure you want to delete , all data will be deleted?');" href="<?php echo $this->Url->build([  "controller" => "Exam", "action" => "delexercise","id"=>$id ]); ?>"> <i class="fa fa-times" aria-hidden="true"></i>

    </a>


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
        <?php if(isset($edit)){
                ?>

<script>
$("#c_id").removeAttr("required");
$("#s_id").removeAttr("required");

$("#c_id").parent().hide();
$("#s_id").parent().hide();

</script>
        <?php
                }?>
        <?php $url=$this->Url->build([  "controller" => "Exam", "action" => "getdata" ]); ?>


<script>


$("#c_id").change(function(){
    var c_id= $("#c_id").val();
    $.post('<?php echo $url; ?>',
        {
            type: "subject",
            class: c_id
        },
        function(data, status){
            $("#s_id").html(data);
        });
});



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