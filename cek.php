<?php
//jika belum login 
if(isset($_SESSION['login'])){
//jika sudah login tidak melakukan apa-apa
}else{
	header('location:login.php');
}
?>