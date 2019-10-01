<?php
include ('..\dbh.php');
include ('..\user.php');
include('header.php');

?>
<style type="text/css">
    .saveBtn{
        visibility: hidden;
    }
    @media print {
    /* Hide everything in the body when printing... */
    body.printing * { display: none; }
    /* ...except our special div. */
    body.printing #print-me { display: block; }
    }

    @media screen {
        /* Hide the special layer from the screen. */
        #print-me { display: none; }
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
                                    <h4 class="card-title"><a href="addUser.php" class="btn btn-primary "><i class="la la-plus"></i>Add New</a></h4>
                                    <a href="" class="btn btn-info pull-right" id="btn" > <i class="la la-download"></i> Print/Download</a>
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
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone Number</th>
                                                        <th>Identification Type</th>
                                                        <th>Identification Number</th>
                                                        <th>Created Date</th>
                                                        <th>Control</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $results = $object->getRevnuePayer();

                                                    if(!empty($results)){
                                                    $i=1;
                                                    foreach($results as $value) { 
                                                    ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td id="fullname<?php echo $value['id'] ?>"><?=$object->getUserName($value['id'])?></td>
                                                        <td id="email<?php echo $value['id'] ?>"><?=$value['email']?></td>
                                                        <td id="phone<?php echo $value['id'] ?>"><?=$value['phone']?></td>
                                                        
                                                        <?php
                                                        $profiles = $object->getprofile($value['id']);
                                                        foreach ($profiles as $profile) {
                                                        ?>
                                                        <td id="identType<?php echo $value['id'] ?>"><?=$profile['identification_type']?></td>
                                                        <td id="identNo<?php echo $value['id'] ?>"><?=$profile['identification_no']?></td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td><?=$value['date_add']?></td>
                                                        
                                                        <td>
                                                            <a title="Edit" href="#" class="btn btn-icon btn-primary mr-1 mb-1" onclick="edit_sds('<?php echo $value['id'];?>');" id="editBtn<?php echo $value['id'] ?>"><i class="la la-edit"></i></a>
                                                            <!--  -->
                                                            <a title="View" href="viewUser.php?id=<?php echo htmlentities($value['id']);?>" class="btn btn-icon btn-info mr-1 mb-1"><i class="la la-eye"></i></a>

                                                            <button type="button" class="btn btn-icon btn-danger mr-1 mb-1 cancel-button" id="<?=$value['id']?>"><i class="la la-trash"></i></button>

                                                            <a title="Edit" href="#" class="btn btn-icon btn-success mr-1 mb-1 saveBtn" onclick="save_sd('<?php echo $value['id'];?>');" id="saveBtn<?php echo $value['id'] ?>"><i class="la la-save"></i></a>



                                                        </td>
                                                    </tr>
                                                <?php $i++; }
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
 function edit_sds(id)
{
    //alert('hey');
 //var title=document.getElementById("title"+id).innerHTML;
 var fullname=document.getElementById("fullname"+id).innerHTML;
 var email=document.getElementById("email"+id).innerHTML;
 var phone=document.getElementById("phone"+id).innerHTML;
 var identType=document.getElementById("identType"+id).innerHTML;
 var identNo=document.getElementById("identNo"+id).innerHTML;
 document.getElementById("fullname"+id).innerHTML="<input type='text' class='form-control' autofocus id='fullname_text"+id+"' value='"+fullname+"'>";
 document.getElementById("email"+id).innerHTML="<input type='text' class='form-control' id='email_text"+id+"' value='"+email+"'>";
 document.getElementById("phone"+id).innerHTML="<input type='text' class='form-control' id='phone_text"+id+"' value='"+phone+"'>";    
 document.getElementById("identType"+id).innerHTML="<input type='text' class='form-control' id='identType_text"+id+"' value='"+identType+"'>";    
 document.getElementById("identNo"+id).innerHTML="<input type='text' class='form-control' id='identNo_text"+id+"' value='"+identNo+"'>";    
 document.getElementById("editBtn"+id).style.visibility="hidden";
 document.getElementById("saveBtn"+id).style.visibility="visible";
}

function save_sd(id)
{
 var fullname=document.getElementById("fullname_text"+id).value;
 var email=document.getElementById("email_text"+id).value;
 var phone=document.getElementById("phone_text"+id).value;
 var identType=document.getElementById("identType_text"+id).value;
 var identNo=document.getElementById("identNo_text"+id).value;
    
 $.ajax
 ({
  type:'post',
  url:'function.php',
  data:{
   edit_sd:'edit_sd',
   row_id:id,
   fullname:fullname,
   email:email,
   phone:phone,
   identType:identType,
   identNo:identNo,
  },
  success:function(response) {
   if(response=="success")
   {
    document.getElementById("fullname"+id).innerHTML=fullname;
    document.getElementById("email"+id).innerHTML=email;
    document.getElementById("phone"+id).innerHTML=phone;
    document.getElementById("identType"+id).innerHTML=identType;
    document.getElementById("identNo"+id).innerHTML=identNo;

    document.getElementById("editBtn"+id).style.visibility="visible";
    document.getElementById("saveBtn"+id).style.visibility="hidden";
    //alert('Record Updated Successfully');
    swal("Updated!", "Product Record has been Update.", "success");
                setTimeout(function(){// wait for 5 secs(2)
                   location.reload(); // then reload the page.(3)
              }, 1000);
   }
   else{
    alert(response);
   }
  }

 });
}

$("#btn").click(function () {
    //Hide all other elements other than printarea.
    $("#printarea").show();
    window.print();
});


        </script>