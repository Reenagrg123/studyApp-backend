
<!-- End of Topbar -->
<style>
    .topmargin{
        margin-top:10px;

    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"> Edit Generate Exam </u></h5>
                </div>
                <div class="card-body">

                    <?php if($type==1){ ?>

                    <?php echo $this->Form->create();
                    echo $this->Form->textarea('instruction',['name'=>'instruction','value'=>$instruction,'label'=>'Instruction','class'=>'form-control','required'=>'required','id'=>'summernote']);
                    echo $this->Form->input('total_time',['value'=>$total_time,'label'=>'Total Time','class'=>'form-control','required'=>'required']);
                    echo $this->Form->input('name',['value'=>$name,'label'=>'Name','class'=>'form-control','required'=>'required']);


                    echo $this->Form->input('c_id',['value'=>$exam_id,'options' => $examlist,'label'=>'Exam','class'=>'form-control','required'=>'required']);


                    echo $this->Form->button('Save',['class'=>'btn btn-success mb-2 topmargin']);
                    ?>

                    <?php echo $this->Form->end(); ?>

<?php } ?>
                    <?php if($type==2){ ?>

                    <?php echo $this->Form->create();
                    echo $this->Form->textarea('instruction',['name'=>'instruction','value'=>$instruction,'label'=>'Instruction','class'=>'form-control','required'=>'required','id'=>'summernote']);
                    echo $this->Form->input('total_time',['value'=>$total_time,'label'=>'Total Time','class'=>'form-control','required'=>'required']);
                    echo $this->Form->input('name',['value'=>$name,'label'=>'Name','class'=>'form-control','required'=>'required']);


                    echo $this->Form->input('c_id',['value'=>$exam_id,'options' => $examlist,'label'=>'Exam','class'=>'form-control','required'=>'required','id'=>'c_id']);
                    echo $this->Form->input('s_id',['value'=>$s_id,'options' => $subjectlist,'label'=>' Subject','class'=>'form-control','required'=>'required','id'=>'s_id']);
                    echo $this->Form->input('ex_id',['value'=>$ex_id,'options' => $chapterist,'label'=>'Chapter','class'=>'form-control','required'=>'required','id'=>'ex_id']);


                    echo $this->Form->button('Save',['class'=>'btn btn-success mb-2 topmargin']);
                    ?>

                    <?php echo $this->Form->end(); ?>

                    <?php } ?>
                    <?php if($type==0){ ?>

                    <?php echo $this->Form->create();
                    echo $this->Form->textarea('instruction',['name'=>'instruction','value'=>$instruction,'label'=>'Instruction','class'=>'form-control','required'=>'required','id'=>'summernote']);
                    echo $this->Form->input('total_time',['value'=>$total_time,'label'=>'Total Time','class'=>'form-control','required'=>'required']);
                    echo $this->Form->input('name',['value'=>$name,'label'=>'Name','class'=>'form-control','required'=>'required']);


                    echo $this->Form->input('c_id',['value'=>$exam_id,'options' => $examlist,'label'=>'Class','class'=>'form-control','required'=>'required','id'=>'cc_id']);
                    echo $this->Form->input('s_id',['value'=>$s_id,'options' => $subjectlist,'label'=>'Class Subject','class'=>'form-control','required'=>'required','id'=>'cs_id']);
                    echo $this->Form->input('ex_id',['value'=>$ex_id,'options' => $chapterist,'label'=>'Class Chapter','class'=>'form-control','required'=>'required','id'=>'cex_id']);


                    echo $this->Form->button('Save',['class'=>'btn btn-success mb-2 topmargin']);
                    ?>

                    <?php echo $this->Form->end(); ?>

                    <?php } ?>

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
<?php $url=$this->Url->build([  "controller" => "Generate", "action" => "getdata" ]); ?>
<?php $load=$this->Url->build([  "controller" => "Generate", "action" => "loaddetail" ]); ?>
<script>


    $("#c_id").change(function(){
        var c_id= $("#c_id").val();
        $.post('<?php echo $url; ?>',
            {
                for: "exam",
                type: "subject",
                class: c_id
            },
            function(data, status){
                $("#s_id").html(data);
            });
    });



    $("#s_id").change(function(){
        var c_id= $("#c_id").val();
        var s_id= $("#s_id").val();
        $.post('<?php echo $url; ?>',
            {
                for: "exam",
                type: "excersise",
                class: c_id,
                subject: s_id
            },
            function(data, status){
                $("#ex_id").html(data);
            });
    });



    $("#cc_id").change(function(){
        var c_id= $("#cc_id").val();
        $.post('<?php echo $url; ?>',
            {

                type: "subject",
                class: c_id
            },
            function(data, status){
                $("#cs_id").html(data);
            });
    });



    $("#cs_id").change(function(){
        var c_id= $("#cc_id").val();
        var s_id= $("#cs_id").val();
        $.post('<?php echo $url; ?>',
            {

                type: "excersise",
                class: c_id,
                subject: s_id
            },
            function(data, status){
                $("#cex_id").html(data);
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