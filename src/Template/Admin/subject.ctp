
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


        </br></br>
    <h3 align="center" ><u>All Subjects</u> </h3>
</br></br>
<table id="table_id" class="display">
<thead>
<tr>
    <th>S.No</th>
    <th>Class Name</th>
    <th>Subject Name</th>
    <th></th>
    <th></th>
</tr>
</thead>
<tbody>

<tr>
    <td>1</td>
    <td>10th</td>
    <td>Physics</td>
    <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>
    <td><i class="fa fa-times" aria-hidden="true"></i></td>

</tr>
<tr>
    <td>1</td>
    <td>11th</td>
    <td>Physics</td>
    <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>
    <td><i class="fa fa-times" aria-hidden="true"></i></td>

</tr>
<tr>
    <td>3</td>
    <td>12th</td>
    <td>Chemistry</td>
    <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>
    <td><i class="fa fa-times" aria-hidden="true"></i></td>

</tr>
<tr>
    <td>4</td>
    <td>Jee Mains</td>
    <td>Physics</td>
    <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>
    <td><i class="fa fa-times" aria-hidden="true"></i></td>

</tr>
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