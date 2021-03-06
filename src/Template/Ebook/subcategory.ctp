
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php if(isset($edit)){ echo 'EDIT'; }else { echo 'ADD'; }   ?> SUB-CATEGORIES </u></h5>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group" >
                            <label for="exampleFormControlSelect1">Select a category name</label>
                            <select class="form-control" name="cat_id" id="c_id" required>
                                <option value="">--Select Option--</option>
                                <?php foreach($allcat as $c){ ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="exampleFormControlInput1">Enter a Sub-category name</label>
                            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Ex: NCERT BOOKS" value="<?php if(isset($edit)){ echo $editdata['name']; }?>" required>
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
                    <h5 class="card-title">ALL SUB-CATEGORIES</h5>
                </div>
                <div class="card-body">
                    <table id="table_id" class="cell-border compact stripe hover">
                        <thead>
                        <tr>
                            <th>S No.</th>
                            <th>Category Name</th>
                            <th>Sub-Category Name</th>
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
                            <td><?php echo $c['Category']['name']; ?></td>
                            <td><?php echo $c['name']; ?></td>
                            <td>

                                <a href='<?php echo $this->Url->build([  "controller" => "Ebook", "action" => "subcategory","id"=>$id ]); ?>' >
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                <a onclick="return confirm('Are you sure you want to delete?? All related data will be deleted !!');" href="<?php echo $this->Url->build([  "controller" => "Ebook", "action" => "delsubcategory","id"=>$id ]); ?>"> <i class="fa fa-times" aria-hidden="true"></i>


                        </a>
                        </td>
                        </tr>
                        <?php $i++; } ?>
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