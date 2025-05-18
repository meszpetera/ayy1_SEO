<?php 
//define the receiver of the email 
$to = 'istvan.farmosi@gmail.com'; 
//define the subject of the email 
$subject = 'Test email with attachment'; 
//create a boundary string. It must be unique 
//so we use the MD5 algorithm to generate a random hash 
$random_hash = md5(date('r', time())); 
//define the headers we want passed. Note that they are separated with \r\n 
$headers = "From: webmaster@example.com\r\nReply-To: webmaster@example.com"; 
//add boundary string and mime type specification 
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
//read the atachment file contents into a string,
//encode it with MIME base64,
//and split it into smaller chunks
$attachment = chunk_split(base64_encode(file_get_contents('attachment.zip'))); 
//define the body of the message. 
ob_start(); //Turn on output buffering 
?> 
--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>" 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

Hello World!!! 
This is simple text email message. 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<h2>Hello World!</h2> 
<p>This is something with <b>HTML</b> formatting.</p> 

--PHP-alt-<?php echo $random_hash; ?>-- 

<?php 
//copy current buffer contents into $message variable and delete current output buffer 
$message = ob_get_clean(); 
//send the email 
$mail_sent = @mail( $to, $subject, $message, $headers ); 
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed"; 
?>

<!--?php
  include_once("common.php");

  if (isauth())
  {
    if (isset($_REQUEST['offerid']))
    {
      $savetoserver = 1;
      //include("offerrequest_createpdf.php");
      
      //define the receiver of the email 
      $to = 'istvan.farmosi@gmail.com'; 
      //define the subject of the email 
      $subject = 'Test email with attachment'; 
      //create a boundary string. It must be unique 
      //so we use the MD5 algorithm to generate a random hash 
      $random_hash = md5(date('r', time())); 
      //define the headers we want passed. Note that they are separated with \r\n 
      $headers = "From: webmaster@example.com\r\nReply-To: webmaster@example.com"; 
      //add boundary string and mime type specification 
      $headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
      //read the atachment file contents into a string,
      //encode it with MIME base64,
      //and split it into smaller chunks
      $attachment = chunk_split(base64_encode(file_get_contents($saved_offer_path))); 
      //define the body of the message. 
      ob_start(); //Turn on output buffering 
      
      include('tpl/offer_email.tpl');
      
      //copy current buffer contents into $message variable and delete current output buffer 
      $message = ob_get_clean(); 
      //send the email 
      $mail_sent = @mail( $to, $subject, $message, $headers ); 
      //if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
      echo $mail_sent ? "Mail sent" : "Mail failed"; 
   
    }
  }
?-->