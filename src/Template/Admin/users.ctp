
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ALL USERS</h5>
                </div>
                <div class="card-body">
                    <table id="table_id" class="cell-border compact stripe hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Student Class</th>
                             <th>Mobile No.</th>
                               <th>Gender</th>
                                 <th>D.O.B</th>
                            <th></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($users as $c){
                                $id=$c['id'];
                                if($c['type']=='admin'){
                                continue;
                                }

                                ?>

                            <td><?php echo $c['id']; ?></td>
                            <td><?php echo $c['f_name']; ?></td>
                            <td><?php echo $c['email']; ?></td>
                           <td><?php echo $c['Class']['class_name']; ?></td>
                           <td><?php echo $c['mobile']; ?></td>
                            <td><?php echo $c['gender']; ?></td>
                             <td><?php echo $c['dob']; ?></td>
                            <td>
                             <a onclick="return confirm('Are you sure you want to delete?? All related data will be deleted !!');" href="<?php echo $this->Url->build([  "controller" => "Admin", "action" => "deluser","id"=>$id ]); ?>"> <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                           <a href='<?php echo $this->Url->build([  "controller" => "Admin", "action" => "edituser","id"=>$id ]); ?>' ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

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

<script>
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




$( document ).ready(function() {
    $('#summernote').summernote({height: 300});
});

</script>