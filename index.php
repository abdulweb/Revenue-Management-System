<?php
//session_start();
include('dbh.php');
include('user.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Revenue Management System</title>
<link rel="shortcut icon" type="image/x-icon" href="assets/uploads/settings/<?=$fevicon?>">
 <!-- Meta-Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- //Meta-Tags -->
    
    <!-- css files -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link rel="stylesheet" type="text/css" href="assets/admin/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/admin/css/components.css">
    <!-- //css files -->
    
    <!-- google fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- //google fonts -->
    <style>
        .alert-warning {
    border-color: #FF9149!important;
    background-color: #FFBC90!important;
    color: #963B00!important;
}
.alert {
    position: relative;
}
.mb-2, .my-2 {
    margin-bottom: 1.5rem!important;
}
.alert {
    padding: .75rem 1rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: .25rem;
}
    </style>
</head>
<body>

<div class="signupform">
    <div class="container">
        <!-- main content -->
        <div class="agile_info">
            <div class="w3l_form">
                <div class="left_grid_info">
                    <h1 class="text-uppercase" style="color: seagreen">Revenue Managment System</h1>
                    <p class="font-italic text-success">SOSSA Revenue Management System </p>
                    <small> <i class="text-danger"> Note : </i> If you have any problem kindly contact the Fin. Sec</small> <br>
                    Not a Member? <a href="register.php"  class="font-italic text-primary "> Register Now !!!</a>
                    <!-- <img src="assets/uploads/settings/farm_img.jpg" class=""> -->
                    
                </div>
            </div>
            <div class="w3_info">
            <?php
                if(isset($_POST['login_btn']))
                {
                    $username = $_POST['email'];
                    $password = $_POST['password'];
                    $object = new user();
                   $object->login($username,$password);
                }
            ?>
                <h2>Login to your Account</h2>
                <p>Enter your details to login.</p>
                <?php require_once('assets/constants/check-reply.php'); ?>
                <form action="" method="POST" autocomplete="OFF">
                    <label>Email Address</label>
                    <div class="input-group">
                        <span class="fa fa-envelope" aria-hidden="true"></span>
                        <input type="email" name="email" placeholder="Enter Your Email" required=""> 
                    </div>
                    <label>Password</label>
                    <div class="input-group">
                        <span class="fa fa-lock" aria-hidden="true"></span>
                        <input type="password" name="password" placeholder="Enter Password" required="">
                    </div>                     
                        <button class="btn btn-success btn-block text-white" type="submit" name="login_btn">Login</button >                
                </form>
            </div>
        </div>
        <!-- //main content -->
    </div>
    <!--  -->
<div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                                     aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel1">Basic Modal</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>Check First Paragraph</h5>
                                                    <p>Oat cake ice cream candy chocolate cake chocolate cake cotton candy dragée apple pie. Brownie carrot
                                                        cake candy canes bonbon fruitcake topping halvah. Cake sweet roll cake cheesecake cookie chocolate cake
                                                        liquorice. Apple pie sugar plum powder donut soufflé.</p>
                                                    <p>Sweet roll biscuit donut cake gingerbread. Chocolate cupcake chocolate bar ice cream. Danish candy
                                                        cake.</p>
                                                    <hr>
                                                    <h5>Some More Text</h5>
                                                    <p>Cupcake sugar plum dessert tart powder chocolate fruitcake jelly. Tootsie roll bonbon toffee danish.
                                                        Biscuit sweet cake gummies danish. Tootsie roll cotton candy tiramisu lollipop candy cookie biscuit pie.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-outline-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
<!--  -->

    <!-- footer -->
    <div class="footer">
        <p class="font-italic" style="color: seagreen">&copy; <?php echo date('Y'); ?>  All Rights Reserved | Design by Aliyu Malami Umar.</p>
    </div>
    <!-- footer -->
</div>
    <
    <!-- BEGIN: Vendor JS-->
    <script src="assets/admin/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="assets/admin/vendors/js/forms/select/select2.full.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="assets/admin/js/core/app-menu.min.js"></script>
    <script src="assets/admin/js/core/app.min.js"></script>
    <script src="assets/admin/js/scripts/customizer.min.js"></script>
    <script src="assets/admin/js/scripts/footer.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="assets/admin/js/scripts/forms/select/form-select2.min.js"></script>
    <script src="assets/admin/js/scripts/modal/components-modal.min.js"></script>

</body>
</html>