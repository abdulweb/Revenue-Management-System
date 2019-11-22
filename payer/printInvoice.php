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
                    <!-- <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active"> Payment History
                                </li>
                            </ol>
                        
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="content-body">
                <!-- Input Validation start -->
             <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header"> 
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">                                        
                                        
                                        <div class="table-responsive">
                                        <div class="row">
                                        <?php
                                        $results = $object->getOneUser($_SESSION['user_id']);
                                            foreach ($results as $key => $value) 
                                            { ?>
                                            <div class="col-md-12"><h2 class="text-uppercase text-center font-italic">Revenue Management system</h2></div>
                                            <div class="col-md-6">
                                                <h2>Invoice</h2>
                                                <h6>Date Generate : <?=date('Y/m/d')?></h6>
                                            </div>
                                            <div class="col-md-6"></div>
                                            <div class="col-md-12">
                                                <h3> <strong>Name : </strong> <span class="text-uppercase"><?=$object->getUserName($value['id'])?></span></h3>
                                                <h3><strong>Phone Number : </strong> <?=$value['phone']?></h3>
                                                <h3><strong>Email : </strong> <?=$value['email']?></h3>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Month</th>
                                                        <th>Status</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $results = $object->getRevenueHistory($_SESSION['user_id']);

                                                    if(!empty($results)){
                                                    $i=1;$sum = 0;
                                                    foreach($results as $value) { 
                                                    ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td id="fullname<?php echo $value['id'] ?>"><?=$value['month_paid']?></td>
                                                        <td id="email<?php echo $value['id'] ?>"><?=$object->paymentStatus($value['verification'])?></td>
                                                        <td><?=$value['amount']?></td>
                                                        
                                                        
                                                        
                                                    </tr>

                                                <?php $i++;$sum = $sum+$value['amount']; }
                                                }
                                                else{

                                                    } ?>
                                                   
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td  class="text-uppercase text-info">Total Paid : </td>
                                                        <td class="text-dark"><?=$sum;?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td  class="text-uppercase text-success">Amount Approved : </td>
                                                        <td class="text-dark"><?=$object->checkApprovedPayment($_SESSION['user_id'])?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td  class="text-uppercase text-danger">Amount Pending/Reject : </td>
                                                        <td class="text-dark"><?=$object->checkUnApprovedPayment($_SESSION['user_id'])?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- DOM - jQuery events table -->
                <!-- Input Validation end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <?php include 'footer.php'; ?>