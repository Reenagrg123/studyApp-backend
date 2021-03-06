
<!-- End of Topbar -->
<style>
    .topmargin{
        margin-top:10px;

    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a type="button" href="#" onclick="window.history.back();">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Edit</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"> Edit User </u></h5>
                </div>
                <div class="card-body">

                    <?php echo $this->Form->create();
                    echo $this->Form->input('f_name',['value'=>$name,'label'=>'Full Name','class'=>'form-control','required'=>'required']);
                    echo $this->Form->input('email',['value'=>$email,'label'=>'Email','class'=>'form-control','required'=>'required']);
                    echo $this->Form->input('class',['value'=>$class,'options' => $classlist,'label'=>'Class','class'=>'form-control','required'=>'required']);
                    echo $this->Form->input('gender',['value'=>$gender,'options' => array(""=>"Select Gender","Male"=>"Male","Female"=>"Female"),'label'=>'Gender','class'=>'form-control','required'=>'required']);
                      echo $this->Form->input('mobile',['value'=>$mob,'label'=>'Mobile No','class'=>'form-control','required'=>'required','type'=>'number']);
?>
                    <div class="input text required"><label for="dob">D.O.B</label><input type="date" name="dob" class="form-control" required="required" id="dob" value="<?php echo $dob; ?>"></div>

                    <?php

                    echo $this->Form->button('Save',['class'=>'btn btn-success mb-2 topmargin']);
                    ?>




                    <?php echo $this->Form->end(); ?>



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