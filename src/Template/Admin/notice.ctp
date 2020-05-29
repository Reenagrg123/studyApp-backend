
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php if(isset($edit)){ echo 'EDIT'; }else { echo 'ADD'; }   ?> NOTICE </u></h5>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Enter a notice</label>
                        <textarea name="notice" class='summernote'  ><?php if(isset($edit)){ echo $editdata['notive']; }?></textarea>
                      </div>
                    <button type="submit" class="btn btn-success mb-2" style="width: 100px; float: right;">
                        <?php if(isset($edit)){ echo 'EDIT'; }else { echo 'ADD'; }   ?> </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">ALL NOTICES</h5>
            </div>
            <div class="card-body">
                <table id="table_id" class="cell-border compact stripe hover">
                    <thead>
                    <tr>
                        <th>S No.</th>

                        <th>Notice</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=1;
                    foreach($data as $c){
                            $id=$c['id'];
                            ?>
                    <a>
                        <td><?php echo $i; ?></td>

                        <td><?php echo $c['notice']; ?></td>

                        <td>

                    <a onclick="return confirm('Are you sure you want to delete , all data will be deleted?');" href="<?php echo $this->Url->build([  "controller" => "Admin", "action" => "delnotice","id"=>$id ]); ?>"> <i class="fa fa-times" aria-hidden="true"></i></a>

                    <a href="<?php echo $this->Url->build([  "controller" => "Admin", "action" => "editnotice","id"=>$id ]); ?>"> <i class="fa fa-edit" aria-hidden="true"></i></a>

                    </td>

                </tr>
                <?php $i++;   } ?>
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

$( document ).ready(function() {
    $('.summernote').summernote();
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
    $('#summernote').summernote(
    );
});

</script>