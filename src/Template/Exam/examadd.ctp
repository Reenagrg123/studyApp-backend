
        <?= $this->Html->script("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"); ?>


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
            <h3 align="center" >  <?php if(isset($edit)){ echo 'Edit'; }else { echo 'Add'; }   ?>
                Exam </h3>
            <!--<form id="post" method="post" enctype="multipart/form-data">-->

            <form method="post">

                <div class="form-group">
                    <label for="exampleFormControlInput1">Select Class</label>
                    <br/>
                    <select class="form-control" id="multiselect" multiple="multiple" required>
                        <?php foreach($class as $c){ ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo $c['class_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>


                <input type="hidden" name="c_id" id="c_id" />
                <div class="form-group">
                    <label for="exampleFormControlInput1">Enter Exam Name</label>
                    <input type="text" name="name" class="form-control" id="exampleFormControlInput1" value="<?php if(isset($edit)){ echo $editdata['exam_name']; }?>" required>
                </div>
                <!--<input type="text" class="form-control" id="class" placeholder="Enter a class or paper name">-->
                <!--</div>-->
                <button type="submit" class="btn btn-success mb-2">
                    <?php if(isset($edit)){ echo 'Edit'; }else { echo 'Add'; }   ?>


                </button>


            </form>
            <!--</form>-->
        </br></br>
    <hr/>

</br></br>

<table id="table_id" class="display">
<thead>
<tr>
    <th>S.No</th>
    <th>Exam Name</th>
    <th>Added Class Name</th>
    <th></th>

</tr>
</thead>
<tbody>

<?php foreach($exam as $c){
        $id=$c['id'];
        ?>
<a>

    <td><?php echo $c['id']; ?></td>
    <td><?php echo $c['exam_name']; ?></td>
    <td><?php echo $c['classlist']; ?></td>
    <td>
    <a href='<?php echo $this->Url->build([  "controller" => "Exam", "action" => "examadd","id"=>$id ]); ?>' ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

    <a onclick="return confirm('Are you sure you want to delete , all data will be deleted?');" href="<?php echo $this->Url->build([  "controller" => "Exam", "action" => "delclass","id"=>$id ]); ?>"> <i class="fa fa-times" aria-hidden="true"></i>

</a>
</td>


</tr>
        <?php } ?>
        </tbody>
        </table>


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
$("#multiselect").removeAttr("required");
$("#multiselect").parent().hide();
</script>
        <?php
                }?>

<script>
$(document).ready(function() {
    $('#multiselect').multiselect({
        buttonWidth : '160px',

        nonSelectedText: 'Select Class',
        onChange: function(element, checked) {
            var brands = $('#multiselect option:selected');
            var d='';
            var selected = [];
            $(brands).each(function(index, brand){
                // console.log($(this).val());
                d+=d+$(this).val()+',';
                //   var fieldID = $(this).prev().attr("id");
                //   $('#' + fieldID).val("hello world");
                //selected.push([$(this).val()]);
            });
            $("#c_id").val(d);

            console.log(selected);
        }
    });
});


function getSelectedValues() {

    var selectedVal = $("#multiselect").val();
    for(var i=0; i<selectedVal.length; i++){
        function innerFunc(i) {
            setTimeout(function() {
                location.href = selectedVal[i];
            }, i*2000);
        }
        innerFunc(i);
    }
}


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