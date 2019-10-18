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
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard
                                </li>
                            </ol>
                            <h6 style="color: darkblue">Welcome <?=$_SESSION['user']?></h6>
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
                                                $amount = trim($_POST['amount']);
                                                $userID = $_SESSION['user_id'];
                                                $month = trim($_POST['month']);
                                               $object->payRevenue($amount,$userID,$month);
                                            }
                                        ?>
                                        <h6 class="text-danger">To pay for Previous year click <a href="" data-toggle="modal" data-target="#large">Here</a></h6>
                                        <form class="form-horizontal" action="" method="post" novalidate enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <h5> Amount <small>(in number)</small><span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <input type="number" name="amount" class="form-control mb-1" required data-validation-required-message="amount in number is required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <h5>Email <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <input type="email" name="email" class="form-control mb-1" required data-validation-required-message="Email is required" value="<?=$_SESSION['user']?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                 <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <h5>Month Paying <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <select class="form-control mb-1" required data-validation-required-message="User Type is required"  id="month" onchange="showme('plateno'. this)" name="month">
                                                                <option>Select Month Paying for</option>
                                                                <?php $object->month(); ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-12" id="plateno">
                                                    <div class="form-group">
                                                        <h5>To<span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" name="to" class="form-control mb-1" required data-validation-required-message="Phone Number is required" value="0019231234" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                 <div class="col-lg-6 col-md-12">
                                                    <div class="text-right">
                                                        <button type="submit" name="btn_save" class="btn btn-success" onclick="return conifrm('Ready to Pay?');">Pay <i class="la la-thumbs-o-up position-right"></i></button>
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

      <!--  -->
<div class="modal fade text-left" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title text-white text-uppercase" id="myModalLabel1"> Comming soon</h4>
                <button type="button" class="close text-danger font-bold" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
    </div>
</div>
</div>
<!--  -->
    <!-- END: Content-->

    <?php include 'footer.php'; ?>