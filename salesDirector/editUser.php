<?php
include ('..\dbh.php');
include ('..\user.php');
include('header.php');
if (empty($_GET['id'])) {
    header('location:manageUsers.php');
}
else
$getID = $_GET['id'];

$results = $object->getOneUser($getID);
foreach ($results as $key => $value) {
    # code...
?>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row mb-1">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Manage Sale Director</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item"><a href="manageUsers.php">Revenue Payers</a>
                                </li>
                                <li class="breadcrumb-item active">Add Revenue Payers
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Input Validation start -->
                <section class="input-validation">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <?php
                                            if(isset($_POST['btn_save']))
                                            {
                                                $fullname = $_POST['fullname'];
                                                $userID = $_POST['userID'];
                                                $identificationType = $_POST['ident_type'];
                                                $identificationNo = $_POST['ident_no'];
                                               $object->UpdateUser($fullname,$userID,$identificationNo,$identificationType);
                                            }
                                        ?>
                                        <form class="form-horizontal" action="" method="post" novalidate enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <h5> Full Name <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" name="fullname" class="form-control mb-1" required data-validation-required-message="Full Name is required" value="<?=$object->getUserName($value['id'])?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <h5>Email <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <input type="email" name="email" class="form-control mb-1" required data-validation-required-message="Email is required" value="<?=$value['email']?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                 <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <h5>Phone Number <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <input type="number" name="phone" class="form-control mb-1" maxlength="11" required data-validation-required-message="Phone Number is required" value="<?=$value['phone']?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $profiles = $object->getprofile($getID);
                                                        foreach ($profiles as $profile) {
                                                            # code...
                                                    ?>
                                                 <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <h5>Identification type <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <select class="form-control mb-1" required data-validation-required-message="User Type is required"  id="iden" onchange="showme('plateno'. this)" name="ident_type">
                                                                <option value="<?=$profile['identification_type']?>"><?=$profile['identification_type']?></option>
                                                                <option>Select User type</option>
                                                                <option value="Driver">Driver</option>
                                                                <option value="Shop Owner">Shop Owner</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-12" id="plateno">
                                                    <div class="form-group">
                                                        <h5>Identification Number <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" name="ident_no" class="form-control mb-1" required data-validation-required-message="Phone Number is required" value="<?=$profile['identification_no']?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                 <div class="col-lg-6 col-md-12">
                                                    <div class="text-right">
                                                        <input type="hidden" name="userID" value="<?=$value['id']?>">
                                                        <button type="submit" name="btn_save" class="btn btn-success">Submit <i class="la la-thumbs-o-up position-right"></i></button>
                                                        <a href="categories" class="btn btn-danger">Cancel <i class="la la-close position-right"></i></a>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Input Validation end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->


    <?php }

    include 'footer.php'; ?>