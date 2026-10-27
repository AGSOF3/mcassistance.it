<?php
  if (isset($_GET['id']))
  {
    $var = $_GET['id'];
  }


  @include 'connessioneMail.php';
  

  // $string=@imap_fetchbody($conn, $var, '1');
  // $string=@quoted_printable_decode(@str_replace("=\r\n","",$string));

  
  //   // $string = base64_decode($string);

  //   str_replace("quoted-printable", "", $string);

  //   echo $string;


      $bodyText = imap_fetchbody($conn,$var,1.2);
      if(!strlen($bodyText)>0){
          $bodyText = imap_fetchbody($conn,$var,1);
      }
      $subject = imap_headerinfo($conn,$var);
      $subject = $subject->subject;

      echo $subject."\n".$bodyText;

  @imap_close($conn);

?>