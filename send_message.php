<?php
require('connection.php');
require('functions.php');
$name=get_safe_vale($con,$_POST['name']);
$email=get_safe_vale($con,$_POST['email']);
$mobile=get_safe_vale($con,$_POST['mobile']);
$comment=get_safe_vale($con,$_POST['message']);
$added_on=date('Y-m-d h:i:s');
mysqli_query($con,"insert into contact_us(name,email,mobile,comment,added_on) values('$name','$email','$mobile','$comment','$added_on')");
header('location:contactSucces.php');
die();

?>