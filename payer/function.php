<?php
include ('..\dbh.php');
include ('..\user.php');

if(isset($_POST['edit_sd']))
{
	 $id=$_POST['row_id'];
	 $fullname=$_POST['fullname'];
	 $email=$_POST['email'];
	 $phone=$_POST['phone'];
	 $identType=$_POST['identType'];
	 $identNo=$_POST['identNo'];

	 $object = $object->update_sd($fullname,$email,$phone,$identType,$identNo,$id);
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

if (isset($_POST['revorkUser'])) {
	$id = $_POST['id'];
	$object = $object->revorkUser($id);
}

if (isset($_POST['unrevorkUser'])) {
	$id = $_POST['id'];
	$object = $object->unrevorkUser($id);
}

?>