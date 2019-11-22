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
<script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+510+',height='+430+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

</script>
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
                    <div class="col-md-12" style="margin-bottom: 5px">
                    <h6 class="text-danger">Please filter by month and report type</h6>
                            <form action="" method="post">
                                <select class="form-control " name="month" style="margin-bottom: 10px" required>
                                    <option value="" >Select Month</option>
                                    <?php
                                        $object->month();
                                    ?>
                                </select> <br>
                                <select class="form-control" name="type" required>
                                    <option value="">Select Report Type</option>
                                    <option value="1">Paid Report</option>
                                    <option value="0">UnPaid Report</option>
                                </select>
                                <button type="submit" name="fetch_report" class="btn btn-info pull-right " style="margin: 5px;"><i class="la la-arrow-down"> </i> fetch</button>
                            </form>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">                                    
                                    <h4 class="card-title">
                                    </h4>
                                   <!--  <a href="" class="btn btn-success pull-right" style="margin-right: 36px;" id="btn"> <i class="la la-print"> </i> Print</a> -->
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show" id="printarea">
                                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">   
                                        <div class="table-responsive" >
                                            <table class="table table-striped table-bordered dom-jQuery-events">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Email</th>
                                                        <th>Payment Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($_POST['fetch_report'])) {

                                                        $month = $_POST['month'];
                                                        $type = $_POST['type'];
                                                        $results = $object->revenueReport($month,$type);
                                                        if(!empty($results)){
                                                        $i=1;
                                                        ?><a href="javascript:void(0);"  onClick="popUpWindow('http://localhost/rms/salesDirector/print.php?print=<?php echo $month.','.$type;?>');" class="btn btn-success pull-right" style="margin-right: 36px; margin-top:-5px;" > <i class="la la-print"> </i> Print</a><?php
                                                        foreach($results as $value) { 
                                                        ?>

                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td id="fullname<?php echo $value['id'] ?>"><?=$object->getemail($value['user_id'])?></td>
                                                        <td id="email<?php echo $value['id'] ?>"><?=$object->paymentStatus($value['verification'])?></td>
                                                        
                                                    </tr>

                                                <?php $i++; }
                                                }
                                                else{

                                                    }
                                                }
                                                else{

                                                 
                                                }?>
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
        $("#btn").click(function () {
    //Hide all other elements other than printarea.
    $("#printarea").show();
    window.print();
});
      
</script>