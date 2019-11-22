<?php
include ('..\dbh.php');
include ('..\user.php');

?>
<script language="javascript" type="text/javascript">
function f2()
{
window.close();
}
function f3()
{
window.print(); 
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>

<body>
<table width="100%" border="2" class="table table-hover">
    <?php 
        $get = $_GET['print'];
        // echo $get;
        $array_explode = explode(',', $get,2);
        // print_r($array_explode);
        $month = $array_explode[0];
        $type = $array_explode[1];
        $results = $object->revenueReport($month,$type);
			?>
  <tr>
    <td colspan="3" align="center" width="100%">Report for <?=$month?></td>
  </tr>
			
	<tr>
    <th>#</th>
    <th>Email</th>
    <th>Payment Status</th> 
  </tr>
  <?php
  $i = 1;
   foreach($results as $value) { 
                                                        ?>
  <tr>
    <td><?=$i?></td>
    <td id="fullname<?php echo $value['id'] ?>"><?=$object->getemail($value['user_id'])?></td>
    <td id="email<?php echo $value['id'] ?>"><?=$object->paymentStatus($value['verification'])?></td>
  </tr>

    <?php $i++; }
  ?>

  
  <tr>
    <td colspan="2" align="right" ><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="14%">&nbsp;</td>
          <td width="35%" class="comb-value"><label>
            <input name="Submit" type="submit" class="txtbox4" value="Prints this Document " onClick="return f3();" />
          </label></td>
          <td width="3%">&nbsp;</td>
          <td width="26%"><label>
            <input name="Submit2" type="submit" class="txtbox4" value="Close this document " onClick="return f2();"  />
          </label></td>
          <td width="8%">&nbsp;</td>
          <td width="14%">&nbsp;</td>
        </tr>
      </table>
        </form>    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</body>
</html>
