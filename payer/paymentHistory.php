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
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active"> Payment History
                                </li>
                            </ol>
                        
                        </div>
                    </div>
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
                                    <h4 class="card-title"><a href="addUser.php" class="btn btn-primary "><i class="la la-plus"></i>Add New</a></h4>
                                    <a href="printInvoice.php" class="btn btn-info pull-right" id="btn" > <i class="la la-download"></i> Print/Download</a>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">                                        
                                        
                                        <div class="table-responsive" id="printarea">
                                            <table class="table table-striped table-bordered dom-jQuery-events">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Month</th>
                                                        <th>Status</th>
                                                        <th>Date</th>
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
                                                        <td id="phone<?php echo $value['id'] ?>"><?=$value['date_paid']?></td>
                                                        <td><?=$value['amount']?></td>

                                                        </td>
                                                    </tr>

                                                <?php $i++;$sum = $sum+$value['amount']; }
                                                }
                                                else{

                                                    } ?>
                                                    <tr>
                                                        <td colspan="4" class="text-uppercase"><strong>Total : </strong></td>
                                                        <td colspan="3"><?=$sum?></td>
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