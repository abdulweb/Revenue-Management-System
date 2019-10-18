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
                    <h3 class="content-header-title">Sales Directors</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item"><a href="manageUsers.php">Revenue Payers</a>
                                </li>
                                <li class="breadcrumb-item active">View User
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
                                        <a href="editUser.php" class="btn btn-info "><i class="la la-pencil"></i>Edit User</a>
                                        <?php 
                                            if ($value['active'] == 1) {
                                        ?>
                                        <a href="#" class="btn btn-success revork-button" id="<?=$value['id']?>"><i class="la la-user"></i>Revork Permission</a>
                                        <?php
                                        }
                                        else
                                        {
                                        ?>
                                         <a href="#" class="btn btn-warning unrevork-button" id="<?=$value['id']?>"><i class="la la-user"></i>Unrevork Permission</a>
                                        <?php
                                        }
                                        ?>
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
                                                    $profiles = $object->getprofile($getID);
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
                                                    $getPassports = $object->getPassport($getID);
                                                    foreach ($getPassports as $key ) {
                                                    
                                                 ?>
                                                 <img src="<?=$key['passport']?>" class="img img-thumbnail" height="100">

                                                 <?php
                                                 }
                                                 ?>
                                                 <button class="btn btn-danger btn block cancel-button" style="margin-top: 5px;"> <i class="la la-trash"> </i> Delete</button>
                                            </div>
                                        </div>
                                        
                                       <!--  </div> -->
                                        
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
    $(document).ready(function(){

    $('.revork-button').on('click',function(){        
        swal({
            title: "Are you sure?",
            text: "To Revork This  User Permission!",
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
                    text: "Revork",
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
                   revorkUser:'revorkUser',
                   id:id,
                  },
                  success: function(inputValue){
                    if (inputValue=="success") 
                    {
                        swal("Revorked!", "This User Permission has been Revorked.", "success");
                    setTimeout(function(){// wait for 5 secs(2)
                       location.reload(); // then reload the page.(3)
                  }, 1000); 
                    }
                    else{swal("Error", "Please try again", "error");}
                    
                    }
                });
                
            } 
        });

    });   

});
</script>
<script>
    $(document).ready(function(){

    $('.unrevork-button').on('click',function(){        
        swal({
            title: "Are you sure?",
            text: "To Revork This  User Permission!",
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
                    text: "Unrevork",
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
                   unrevorkUser:'unrevorkUser',
                   id:id,
                  },
                  success: function(inputValue){
                    if (inputValue=="success") 
                    {
                        swal("Revorked!", "This User Permission has been Revorked.", "success");
                    setTimeout(function(){// wait for 5 secs(2)
                       location.reload(); // then reload the page.(3)
                  }, 1000); 
                    }
                    else{swal("Error", "Please try again", "error");}
                    
                    }
                });
                
            } 
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
 document.getElementById("fullname"+id).innerHTML="<input type='text' class='form-control' autofocus id='fullname_text"+id+"' value='"+fullname+"'>";
 document.getElementById("email"+id).innerHTML="<input type='text' class='form-control' id='email_text"+id+"' value='"+email+"'>";
 document.getElementById("phone"+id).innerHTML="<input type='text' class='form-control' id='phone_text"+id+"' value='"+phone+"'>";    
 document.getElementById("editBtn"+id).style.visibility="hidden";
 document.getElementById("saveBtn"+id).style.visibility="visible";
}

function save_sd(id)
{
 var fullname=document.getElementById("fullname_text"+id).value;
 var email=document.getElementById("email_text"+id).value;
 var phone=document.getElementById("phone_text"+id).value;
    
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
  },
  success:function(response) {
   if(response=="success")
   {
    document.getElementById("fullname"+id).innerHTML=fullname;
    document.getElementById("email"+id).innerHTML=email;
    document.getElementById("phone"+id).innerHTML=phone;

    document.getElementById("editBtn"+id).style.visibility="visible";
    document.getElementById("saveBtn"+id).style.visibility="hidden";
    //alert('Record Updated Successfully');
    swal("Updated!", "Product Record has been Update.", "success");
                setTimeout(function(){// wait for 5 secs(2)
                   location.reload(); // then reload the page.(3)
              }, 1000);
   }
   else{
    alert('response');
   }
  }

 });
}

        </script>