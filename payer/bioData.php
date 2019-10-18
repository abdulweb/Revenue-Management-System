<?php
include ('..\dbh.php');
include ('..\user.php');
include('header.php');
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
                                <li class="breadcrumb-item active">Bio-Data
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
                                                $userID = $_SESSION['user_id'];
                                                $identificationType = $_POST['ident_type'];
                                                $identificationNo = $_POST['ident_no'];
                                               $object->UpdateUser($fullname,$userID,$identificationNo,$identificationType);
                                            }


                                            $results = $object->getOneUser($_SESSION['user_id']);
                                            foreach ($results as $key => $value) 
                                            { ?>

                                             <div class="row">
                                                <div class="col-md-9">
                                                <div class="table-responsive">
                                                <table class="table table-bordered dom-jQuery-events" style="border: 1px solid #cca">
                                                    
                                                    
                                                        <tr>
                                                            <th>Name</th>
                                                            <td><?=$object->getUserName($value['id'])?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Email</th>
                                                            <td><?=$value['email']?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phone Number</th>
                                                            <td><?=$value['phone']?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Created Date</th>
                                                            <td><?=$value['date_add']?></td>
                                                           
                                                        </tr>
                                                    <?php 
                                                    }
                                                    $profiles = $object->getprofile($_SESSION['user_id']);
                                                        foreach ($profiles as $profile) {
                                                            # code...
                                                    ?>
                                                        <tr>
                                                            <th>User Type</th>
                                                            <td><?=$profile['identification_type']?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Identification Number</th>
                                                            <td><?=$profile['identification_no']?></td>
                                                        </tr>
                                                    <?php
                                                }
                                                ?>
                                                </table>
                                            </div>
                                            </div>
                                            <!-- passport section -->
                                            <div class="col-md-3">
                                            
                                                <?php
                                                    $getPassports = $object->getPassport($_SESSION['user_id']);
                                                    foreach ($getPassports as $key ) {
                                                    
                                                 ?>
                                                 <img src="<?='..\salesDirector/'.$key['passport']?>" class="img img-thumbnail" height="100">

                                                 <?php
                                                 }
                                                 ?>
                                                 <a class="btn btn-info btn block cancel-button text-white" data-toggle="modal" data-target="#large" style="margin-top: 5px;"> <i class="la la-edit"> </i> Edit</a>
                                            </div>
                                        </div>

                                    
                                       
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

     <!--  -->
<div class="modal fade text-left" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title text-white text-uppercase" id="myModalLabel1"> User Permission</h4>
                <button type="button" class="close text-danger font-bold" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <form class="form-horizontal" method="post" action="" validate enctype="multipart/form-data">
                        <div class="form-group">
                            <h5> Full Name <span class="required">*</span></h5>
                            <div class="controls">
                                <input type="text" name="fullname" class="form-control mb-1" required data-validation-required-message="Full Name is required" value="<?=$object->getUserName($value['id'])?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Email <span class="required">*</span></h5>
                            <div class="controls">
                                <input type="email" name="email" class="form-control mb-1" required data-validation-required-message="Email is required" value="<?=$value['email']?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Phone Number <span class="required">*</span></h5>
                            <div class="controls">
                                <input type="number" name="phone" class="form-control mb-1" maxlength="11" required data-validation-required-message="Phone Number is required" value="<?=$value['phone']?>" readonly>
                            </div>
                        </div>
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
                        <div class="form-group">
                            <h5>Identification Number <span class="required">*</span></h5>
                            <div class="controls">
                                <input type="text" name="ident_no" class="form-control mb-1" required data-validation-required-message="Phone Number is required" value="<?=$profile['identification_no']?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" name="btn_save" class="btn btn-success">Save changes</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-1"></div>
            </div>
            
        </div>
    </div>
</div>
<!--  -->

    <!-- END: Content-->


    <?php include 'footer.php'; ?>

