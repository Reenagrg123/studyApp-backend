
<!-- End of Topbar -->
<style>
    .topmargin{
        margin-top:10px;

    }
</style>
<!-- Begin Page Content -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href='<?php echo $this->Url->build([  "controller" => "Docupload", "action" => "materials"]); ?>'>Material</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Edit</li>
    </ol>
</nav>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"> Edit Material </u></h5>
                </div>
                <div class="card-body">



                    <?php echo $this->Form->create('form',['type'=>'file']);


                    echo $this->Form->input('c_id',['value'=>$c_id,'options' => $classlist,'label'=>'Class','class'=>'form-control','required'=>'required','id'=>'c_id']);
                    echo $this->Form->input('s_id',['value'=>$s_id,'options' => $subjectlist,'label'=>'Class Subject','class'=>'form-control','required'=>'required','id'=>'s_id']);
                    echo $this->Form->input('ch_id',['value'=>$ch_id,'options' => $chapterlist,'label'=>'Class Chapter','class'=>'form-control','required'=>'required','id'=>'ch_id']);
                    echo $this->Form->input('type',['value'=>$type,'options' => array(""=>"Select Type","0"=>"Pdf","1"=>"Youtube Link","2"=>"Both"),'label'=>'Type','class'=>'form-control','required'=>'required']);
                    echo $this->Form->input('name',['value'=>$name,'label'=>'Topic Name','class'=>'form-control','required'=>'required']);


                    echo $this->Form->input('link',['value'=>$link,'label'=>'Youtube Link','class'=>'form-control']);
                    echo $this->Form->input('file',['value'=>$file,'label'=>'File','class'=>'form-control','type'=>'file']);
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

<style>
    h2 {
        font-family: serif;
        font-weight:bold;
        text-align:center;
    }
</style>
<?php $url=$this->Url->build([  "controller" => "docupload", "action" => "getdata" ]); ?>

<?php $load=$this->Url->build([  "controller" => "Generate", "action" => "loaddetail" ]); ?>
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



    $("#s_id").change(hffunction(){
        var c_id= $("#c_id").val();
        var s_id= $("#s_id").val();
        $.post('<?php echo $url; ?>',
            {
                type: "excersise",
                class: c_id,
                subject: s_id
            },
            function(data, status){
                $("#ch_id").html(data);
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
        $('#summernote').summernote();
    });

</script>