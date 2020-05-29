
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
            <li class="breadcrumb-item"><a type="button" href="#" onclick="window.history.back();">Banner</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Edit</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"> Edit Banner </u></h5>
                </div>
                <div class="card-body">

                    <?php echo $this->Form->create('form',['type'=>'file']);
                     echo $this->Form->input('type',['value'=>$type,'options' => array(""=>"Select Gender","0"=>"Learn","1"=>"Exam"),'label'=>'Upload For','class'=>'form-control','required'=>'required']);
                    echo $this->Form->input('c_id',['value'=>$c_id,'options' => $classlist,'label'=>'Class','class'=>'form-control','required'=>'required','id'=>'c_id']);
                    echo $this->Form->input('s_id',['value'=>$s_id,'options' => $subjectlist,'label'=>'Subject','class'=>'form-control','required'=>'required','id'=>'s_id']);

                    echo $this->Form->input('file',['value'=>$file,'label'=>'File','class'=>'form-control','required'=>'required','type'=>'file']);
                    echo $file;
                    echo "<br/>";

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
<?php $url=$this->Url->build([  "controller" => "Admin", "action" => "getdata" ]); ?>
<style>
    h2 {
        font-family: serif;
        font-weight:bold;
        text-align:center;
    }
</style>

<script>

    $("#type").change(function(){
        var c_id= $("#type").val();
        $.post('<?php echo $url; ?>',
            {

                type: c_id
            },
            function(data, status){
                $("#c_id").html(data);
            });
    });



    $("#c_id").change(function(){
        var c_id= $("#c_id").val();
        var gfor= $("#type").val();
        $.post('<?php echo $url; ?>',
            {
                for: gfor,
                class: c_id,
                type: 5
            },
            function(data, status){
                $("#s_id").html(data);
            });
    });






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