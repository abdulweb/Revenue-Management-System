<?php
include ('..\dbh.php');
include ('..\user.php');

if(isset($_POST['edit_sd']))
{
	 $id=$_POST['row_id'];
	 $fullname=$_POST['fullname'];
	 $email=$_POST['email'];
	 $phone=$_POST['phone'];

	 $object = $object->update_sd($fullname,$email,$phone,$id);
}

if (isset($_POST['edit_cat'])) {
	$id = $_POST['row_id'];
	$name = $_POST['name'];

	$object = $object->update_cat($name, $id);
}

if (isset($_POST['deleteSd'])) {
	$id = $_POST['id'];
	$object = $object->deleteSd($id);
}

if (isset($_POST['delete_product'])) {
	$id = $_POST['row_id'];
	$object = $object->delete_product($id);
}

if (isset($_POST['addCart'])) {
	$quantity = $_POST['quantity'];
	// $productID = $_POST['productID'];
	// $custName = $_POST['custName'];
	$object = $object->cart($quantity);
}

?>