<?php
include ('..\dbh.php');
include ('..\user.php');
include('header.php');

?>
<style type="text/css">
    .saveBtn{
        visibility: hidden;
    }
</style>
<!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row mb-1">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Sales Directors</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Revenue Payers
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">                                    
                                    <h4 class="card-title">
                                        <a href="addUser.php" class="btn btn-primary "><i class="la la-book"></i>Generate Report</a>
                                        <a href="addUser.php" class="btn btn-success "><i class="la la-book"></i>Paid Report</a>
                                        <a href="addUser.php" class="btn btn-info "><i class="la la-book"></i>unpaid Report</a>
                                    </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">                                        
                                        <?php
                                            if (isset($_POST['submit'])) 
                                            {
                                                $id = $_POST['id'];
                                                // $userID = $_POST['userID'];
                                                $object->updatePayment($id);
                                            }
                                            
                                        ?>

                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered dom-jQuery-events">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Email</th>
                                                        <th>Payment Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $results = $object->getAllRevenueHistory();

                                                    if(!empty($results)){
                                                    $i=1;$sum = 0;
                                                    foreach($results as $value) { 
                                                    ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td id="fullname<?php echo $value['id'] ?>"><?=$object->getemail($value['user_id'])?></td>
                                                        <td id="email<?php echo $value['id'] ?>"><?=$object->paymentStatus($value['verification'])?></td>
                                                        <th>
                                                        <form method="post" action="">
                                                            <input type="hidden" name="id" value="<?=$value['id']?>">
                                                            <button onclick="return confirm('Aprroved <?=$value['id']?>')" class="btn btn-success" type="submit" name="submit"> <i class="la la-check"></i> Approve</button>
                                                        </form>
                                                        
                                                        <!-- <a href="#" class="btn btn-success " data-toggle="modal" data-target="#large"  id="">Approve</a> -->
                                                        </th>
                                                        
                                                    </tr>

                                                <?php $i++;$sum = $sum+$value['amount']; }
                                                }
                                                else{

                                                    } ?>
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
            </div>
        </div>
    </div>
    <!-- END: Content-->
<?php include 'footer.php'; ?>
<script>
    $(document).ready(function(){

    $('.cancel-button').on('click',function(){        
        swal({
            title: "Are you sure?",
            text: "To Delete This Record!",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: false,
                },
                confirm: {
                    text: "Delete",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: false
                }
            }
        })
        .then((isConfirm) => {
            if (isConfirm) {
                var id=this.id;
                $.ajax({
                  type:'post',
                  url:'function.php',
                  data:{
                   deleteSd:'deleteSd',
                   id:id,
                  },
                  success: function(inputValue){
                    if (inputValue=="success") 
                    {
                        swal("Deleted!", "Your Record has been deleted.", "success");
                    setTimeout(function(){// wait for 5 secs(2)
                       location.reload(); // then reload the page.(3)
                  }, 1000); 
                    }
                    else{swal("Error", "Your Record is safe Please try again", "error");}
                    
                    }
                });
                
            } 
            // else {
            //     swal("Cancelled", "Your Record is safe", "error");
            // }
        });

    });   

});
</script>
<script> 
        function print() { 
            var divContents = document.getElementById("GFG").innerHTML; 
            var a = window.open('', '', 'height=500, width=500'); 
            a.document.write('<html>'); 
            a.document.write('<body > <h1>Div contents are <br>'); 
            a.document.write(divContents); 
            a.document.write('</body></html>'); 
            a.document.close(); 
            a.print(); 
        } 
      
</script>