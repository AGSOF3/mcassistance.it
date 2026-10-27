<?php
if (isset($_GET['id'])) //id della mail
{
  $var = $_GET['id'];
}
if (isset($_GET['item'])) //allegato
{
  $item = $_GET['item'];
}

	@include 'connessioneMail.php'; 
	echo base64_decode(@imap_fetchbody($conn, $var, $item));
	@imap_close($conn);

?>