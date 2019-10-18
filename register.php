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
<body style="background: #ccc">

    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row mb-1">
        </div>
        <div class="content-body"><section class="flexbox-container">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0 pb-0">
                    <div class="card-title text-center">
                        <h4 class="text-uppercase" style="color: seagreen">Revenue Managment System</h4>
                    </div>
                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-1"><span>Please Sign Up</span></h6>
                </div>
                <div>
                        <?php
                            if (isset($_POST['registerBtn'])) {
                                $fullname = $_POST['fullname'];
                                $phoneNo = $_POST['phoneNo'];
                                $ident_type = $_POST['ident_type'];
                                $identNo = $_POST['identNo'];
                                $email = $_POST['email'];
                                $password = $_POST['password'];
                                $object->insertPayer($fullname,$email,$phoneNo,$identNo,$ident_type,$password);
                            }
                        ?>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" method="post" action="" validate enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-6">
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="text" name="fullname" id="first_name" class="form-control" placeholder="Fullname" tabindex="1" required data-validation-required-message="Full Name is required">
                                        <div class="form-control-position">
                                            <i class="ft-user"></i>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="number" name="phoneNo" id="last_name" class="form-control" placeholder="Phone Number" tabindex="2" required>
                                        <div class="form-control-position">
                                            <i class="ft-user"></i>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="file" name="passport" id="display_name" class="form-control" placeholder="passport" tabindex="3" required data-validation-required-message= "Please enter display name.">
                                <div class="form-control-position">
                                    <i class="ft-user"></i>
                                </div>
                                <div class="help-block font-small-3"></div>
                            </fieldset>
                            <fieldset class="form-group position-relative has-icon-left">
                                <select class="form-control mb-1" required data-validation-required-message="User Type is required"  id="iden" onchange="showme('plateno'. this)" name="ident_type">
                                    <option>Select User type</option>
                                    <option value="Driver">Driver</option>
                                    <option value="Shop Owner">Shop Owner</option>
                                </select>
                                <div class="form-control-position">
                                    <i class="ft-user"></i>
                                </div>
                                <div class="help-block font-small-3"></div>
                            </fieldset>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" name="identNo" id="display_name" class="form-control" placeholder="Identification No" tabindex="3" required data-validation-required-message= "Please enter display name.">
                                <div class="form-control-position">
                                    <i class="ft-user"></i>
                                </div>
                                <div class="help-block font-small-3"></div>
                            </fieldset>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" tabindex="4" required data-validation-required-message= "Please enter email address.">
                                <div class="form-control-position">
                                    <i class="ft-mail"></i>
                                </div>
                                <div class="help-block font-small-3"></div>
                            </fieldset>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12">
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" tabindex="5" required>
                                        <div class="form-control-position">
                                            <i class="la la-key"></i>
                                        </div>
                                        <div class="help-block font-small-3"></div>
                                    </fieldset>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-6">
                                    <button type="submit" name="registerBtn" class="btn btn-success btn-lg btn-block text-white"><i class="la la-user"> </i> Register</button>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <a  href="index.php" class="btn btn-danger btn-lg btn-block"><i class="ft-unlock"></i> Login</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
        </div>
      </div>
    </div>
    <!-- END: Content-->
   
    <!-- footer -->
    <div class="footer">
        <p class="font-italic" style="color: seagreen">&copy; <?php echo date('Y'); ?>  All Rights Reserved | Design by Aliyu Malami Umar.</p>
    </div>
    <!-- footer -->
</div>

 <!-- BEGIN: Page Vendor JS-->
    <script src="assets/admin/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <script src="assets/admin/vendors/js/forms/icheck/icheck.min.js"></script>
    <!-- END: Page Vendor JS-->

    !-- BEGIN: Page JS-->
    <script src="assets/admin/js/scripts/forms/form-login-register.min.js"></script>
    <!-- END: Page JS-->

</body>
</html>