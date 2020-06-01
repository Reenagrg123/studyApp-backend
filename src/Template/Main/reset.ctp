<?= $this->Html->css("/css/sb-admin-2.css"); ?>

<?= $this->Html->css("post.css"); ?>

<?= $this->Html->css("post_responsive.css"); ?>

<body class="bg-gradient-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div>
            </br></br></br></br>
            <div class="card o-hidden border-0 shadow-lg ">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->

                    <?= $this->Flash->render(); ?>

                    <!--<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>-->
                    <!--<div class="col-sm-6">-->
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Set New Password</h1>
                        </div>
                        <form method="post">


                           <?php if(isset($usernotfound)){  ?>
                            <label style="color:red;" for="exampleInputEmail1">Unable To Identify the User</label>

                            <?php }else{ ?>

                            <div class="form-group">
                                <label for="exampleInputEmail1">New Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Set New Password</button>


                            <?php } ?>

                           </form>
                    </div>
                </div>