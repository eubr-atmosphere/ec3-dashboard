<?php
// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['institution']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }
	
$name = $_POST['name'];
$email_address = $_POST['email'];
$institution = $_POST['institution'];
$message = $_POST['message'];
	
// Create the email and send the message
$from = 'ec3@upv.es';
$to = 'amcaar@i3m.upv.es,gmolto@dsic.upv.es'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "[EC3] Contact Form:  $name";
$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nInstitution: $institution\n\nMessage:\n$message";
$headers = "From: ec3@upv.es\r\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address\r\n";	
$headers .= "Content-type: text/plain;charset=iso-8859-1\r\n";
ini_set("sendmail_from",$from);
ini_set("sendmail_path", "/usr/sbin/sendmail -f " . $from . " -t");
if (!mail($to,$email_subject,$email_body,$headers)) {
   echo "There has been a mail error sending to " . $sToEmail . "<br>";
   return false;
} else {
   return true;
}			
?>
