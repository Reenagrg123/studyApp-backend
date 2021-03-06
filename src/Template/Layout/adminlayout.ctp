<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->Html->charset(); ?>

    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Demo project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv=Content-Type content="text/html; charset=windows-1252">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <?= $this->Html->css("bootstrap4/bootstrap.min.css"); ?>

    <?= $this->Html->css("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"); ?>

    <?= $this->Html->css("/css/sb-admin-2.min.css"); ?>
    <?= $this->Html->css("https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"); ?>

    <?= $this->Html->css("/css/bootstrap4/bootstrap.min.css"); ?>
    <?= $this->Html->css("https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"); ?>

    <?= $this->Html->script("https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"); ?>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/js/all.min.js" rel="stylesheet"
          type="text/css">

    <?= $this->Html->css("https://cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote.css");?>

    <?= $this->Html->css("https://cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote-bs3.css");?>

    <?= $this->Html->css("//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"); ?>
    <?= $this->Html->meta ( 'favicon.ico', '/favicon.png', array (
    'type' => 'icon'
    ) );  ?>


    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<body id="page-top">
<style>

</style>
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon">
                <!--<i class="fa fa-laugh-wink"></i>-->
                <img src="http://theacademyplus.com/favicon.png" style="width:40px;margin-left: 10px;border-radius: 100%;" >
            </div>
            <div class="sidebar-brand-text" style="margin-right:15px">Academy Plus</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="">
                <i class="fa fa-tachometer" aria-hidden="true"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->


        <!-- Nav Item - Pages Collapse Menu
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-fw fa-cog"></i>
            <span>Components</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Custom Components:</h6>
              <a class="collapse-item" href="buttons.html">Buttons</a>
              <a class="collapse-item" href="cards.html">Cards</a>
            </div>
          </div>
        </li>
  -->

        <!-- Divider -->


        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                <span>Class</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner rounded" style="background-color: #beccf3">


                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Admin", "action" => "classadd" ]); ?>">
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                    <span>Add Class</span></a>

                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Admin", "action" => "subject" ]); ?>">
                    <i class="fa fa-book" aria-hidden="true"></i>
                    <span>Add Subject</span></a>


                    <a class="collapse-item" href="<?php echo $this->Url->build([  "controller" => "Admin", "action" => "excersise" ]); ?>">
                    <i class="fa fa-file" aria-hidden="true"></i>
                    <span>Add Chapters</span></a>


                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                <span><b>Exam</b></span>
            </a>
            <div id="collapseTwoo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner rounded" style="background-color: #beccf3">


                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Exam", "action" => "examadd" ]); ?>">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    <span>Add Exam</span></a>

                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Exam", "action" => "subject" ]); ?>">
                    <i class="fa fa-book" aria-hidden="true"></i>
                    <span>Add Subject</span></a>


                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Exam", "action" => "excersise" ]); ?>">
                    <i class="fa fa-file" aria-hidden="true"></i>
                    <span>Add Chapters</span></a>



                </div>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoo5" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-upload" aria-hidden="true"></i>
                <span>Upload Material</span>
            </a>
            <div id="collapseTwoo5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner rounded" style="background-color: #beccf3">

                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Docupload", "action" => "materials" ]); ?>">
                    <i class="fa fa-file" aria-hidden="true"></i>
                    <span>Upload Class Material</span></a>
                    <!--
                                <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Docupload", "action" => "exammaterials" ]); ?>">
                                <i class="fa fa-file" aria-hidden="true"></i>
                                <span>Upload Exam Material</span></a>
                    -->

                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Docupload", "action" => "index" ]); ?>">
                    <i class="fa fa-question" aria-hidden="true"></i>
                    <span>Upload Test Questions</span></a>

                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoo6" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                <span>Generate Exam Test</span>
            </a>
            <div id="collapseTwoo6" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner rounded" style="background-color: #beccf3">


                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Generate", "action" => "fullsyllabus" ]); ?>">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    <span>Full-Syllabus Test</span></a>

                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Generate", "action" => "generateexam" ]); ?>">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    <span>Chapter-Wise Test</span></a>

                    <!--
                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Docupload", "action" => "test" ]); ?>">
                    <i class="fa fa-file" aria-hidden="true"></i>
                    <span>Exam</span></a>
                    -->

                </div>
            </div>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="<?php	echo $this->Url->build([  "controller" => "Generate", "action" => "practicetest" ]); ?>">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            <span>Generate Practice Test</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                <span>E-Book</span>
            </a>
            <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner rounded" style="background-color: #beccf3">


                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Ebook", "action" => "category" ]); ?>">
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                    <span>Add Category</span></a>

                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Ebook", "action" => "subcategory" ]); ?>">
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                    <span>Add Sub Category</span></a>

                    <a class="collapse-item" href="<?php	echo $this->Url->build([  "controller" => "Ebook", "action" => "index" ]); ?>">
                    <i class="fa fa-book" aria-hidden="true"></i>
                    <span>Add E-Book</span></a>
                </div>
            </div>
        </li>

        </li>
        <li class="nav-item ">
            <a class="nav-link" href="<?php	echo $this->Url->build([  "controller" => "Admin", "action" => "notice" ]); ?>">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            <span>Add Notice</span></a>
        </li>

        </li>
        <li class="nav-item ">
            <a class="nav-link" href="<?php	echo $this->Url->build([  "controller" => "Admin", "action" => "testimonials" ]); ?>">
            <i class="fa fa-table" aria-hidden="true"></i>

            <span>Testimonials</span></a>
        </li>

        </li>
        <li class="nav-item ">
            <a class="nav-link" href="<?php	echo $this->Url->build([  "controller" => "Admin", "action" => "users" ]); ?>">
            <i class="fa fa-user-circle-o" aria-hidden="true"></i>

            <span>Users</span></a>
        </li>

        </li>
        <li class="nav-item ">
            <a class="nav-link" href="<?php	echo $this->Url->build([  "controller" => "Admin", "action" => "banner" ]); ?>">
            <i class="fa fa-user-circle-o" aria-hidden="true"></i>

            <span>Banners</span></a>
        </li>


        </li>
        <li class="nav-item ">
            <a class="nav-link" href="<?php	echo $this->Url->build([  "controller" => "Admin", "action" => "contact" ]); ?>">
            <i class="fa fa-user-circle-o" aria-hidden="true"></i>

            <span>Contact</span></a>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
        </li>





        <!-- Nav Item - Tables -->


        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <!--<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">-->
                <!--  <div class="input-group">-->
                <!--    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">-->
                <!--    <div class="input-group-append">-->
                <!--      <button class="btn btn-primary" type="button">-->
                <!--        <i class="fa fa-search fa-sm"></i>-->
                <!--      </button>-->
                <!--    </div>-->
                <!--  </div>-->
                <!--</form>-->

                <!-- Topbar Navbar -->
                <a class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <!--<li class="nav-item dropdown no-arrow d-sm-none">-->
                    <!--  <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                    <!--    <i class="fa fa-search fa-fw"></i>-->
                    <!--  </a>-->
                    <!-- Dropdown - Messages -->
                    <!--  <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">-->
                    <!--    <form class="form-inline mr-auto w-100 navbar-search">-->
                    <!--      <div class="input-group">-->
                    <!--        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">-->
                    <!--        <div class="input-group-append">-->
                    <!--          <button class="btn btn-primary" type="button">-->
                    <!--            <i class="fa fa-search fa-sm"></i>-->
                    <!--          </button>-->
                    <!--        </div>-->
                    <!--      </div>-->
                    <!--    </form>-->
                    <!--  </div>-->
                    <!--</li>-->

                    <!-- Nav Item - Alerts -->
                    <!--<li class="nav-item dropdown no-arrow mx-1">-->
                    <!--  <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                    <!--    <i class="fa fa-bell fa-fw"></i>-->
                    <!-- Counter - Alerts  -->
                    <!--    <span class="badge badge-danger badge-counter">1</span>-->
                    <!--  </a>-->

                    <!--<li class="nav-item dropdown no-arrow mx-1">-->
                    <!--  <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                    <!--     <p>Equatio</p>-->
                    <!--     Counter - Alerts  -->
                    <!--    <span class="badge badge-danger badge-counter">1</span>-->
                    <!--  </a>-->
                    <!-- Dropdown - Alerts -->
                    <!--  <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">-->
                    <!--    <h6 class="dropdown-header">-->
                    <!--      Alerts Center-->
                    <!--    </h6>-->

                    <!--    <a class="dropdown-item d-flex align-items-center" href="#">-->
                    <!--      <div class="mr-3">-->
                    <!--        <div class="icon-circle bg-primary">-->
                    <!--          <i class="fa fa-file-alt text-white"></i>-->
                    <!--        </div>-->
                    <!--      </div>-->
                    <!--      <div>-->
                    <!--        <div class="small text-gray-500"><?php echo $noti['date']; ?></div>-->
                    <!--        <span class="font-weight-bold">sdfsdgs</span>-->
                    <!--      </div>-->
                    <!--    </a>-->

                    <!--    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>-->
                    <!--  </div>-->
                    <!--</li>-->



                    <i class="fa fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <a class="nav-link" href="<?php	echo $this->Url->build([  "controller" => "Main", "action" => "logout" ]); ?>">



                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">  Logout</span>

                    <i class="fa fa-sign-out" aria-hidden="true"></i>


                </a>

                </ul>

            </nav>


            <?= $this->Flash->render() ?>

            <?= $this->fetch('content') ?>


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?php	echo $this->Url->build([  "controller" => "Admin", "action" => "logout" ]); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!--<style>-->
    <!--li span{-->
    <!--    color:white;-->
    <!--    font-weight:400px;-->
    <!--    font-size:20px;-->
    <!--}-->


    <!--</style>-->


    <?= $this->Html->script("/js/bootstrap.bundle.js"); ?>
    <?= $this->Html->script("/js/sb-admin-2.min.js"); ?>


    <?= $this->Html->script("/js/jquery.mb.YTPlayer.js"); ?>
    <?= $this->Html->script("/js/bootstrap/popper.js"); ?>
    <?= $this->Html->script("/js/bootstrap/bootstrap.min.js"); ?>
    <?= $this->Html->script("/js/owl.carousel.js"); ?>

    <?= $this->Html->script("/js/easing.js"); ?>

    <?= $this->Html->script("/js/masonry.js"); ?>
    <?= $this->Html->script("/js/custom.js"); ?>

    <?= $this->Html->script("/js/parallax.min.js"); ?>

    <?= $this->Html->script("//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"); ?>

    <?= $this->Html->script("https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"); ?>

    <?= $this->Html->script("https://cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote.min.js"); ?>
</body>
</html>
