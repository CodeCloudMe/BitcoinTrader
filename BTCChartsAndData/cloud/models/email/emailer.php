<?php

	extract($_REQUEST);
	if(!isset($email)){
		echo(json_encode(array("status"=>"fail", "reason"=>"no email")));
		return;

	}
	$resp = sendTheMail($email, "Confirmation", "Thanks for visiting TravCork! <br><br>Your request is currently being processed. We will contact you as soon as we confirm the best date. Please standby.", "Thanks for visiting TravCork!<br><br>-TravCork \n\nYour request is currently being processed. We will contact you as soon as we confirm the best date. Please standby.\n\n -TravCork Support");

	$resp1 = sendTheMail("m@140ventures.com", "Someone Wants a Request", "the email is ".$email, "Someone Wants a Request", "the email is ".$email);



	echo(json_encode($resp));


	function sendTheMail($email, $subject, $htmlContent, $textContent){


		require_once 'class.phpmailer.php';


		$mail = new PHPMailer;

		$mail->IsSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'support@travcork.com';                            // SMTP username
		$mail->Password = 'travCorkRocks';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

		$mail->From = 'support@travcork.com';
		$mail->FromName = "TravCork Support";
		//$mail->AddAddress('mariah@ppincjobs.com', 'Mariah');  // Add a recipient
		$mail->AddAddress($email);               // Name is optional
		$mail->AddReplyTo('info@travcork.com', "TravCork Support");
		//$mail->AddCC('cc@example.com');
		//$mail->AddBCC('bcc@example.com');

		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		//$mail->AddAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->AddAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->IsHTML(true);                                  // Set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $htmlContent;
		$mail->AltBody = $textContent;

		if(!$mail->Send()) {


		echo(json_encode(array("status"=>"fail", "reason"=>"connection error".$mail->ErrorInfo )));
		   //echo 'Message could not be sent.';
		   //echo 'Mailer Error: ' . $mail->ErrorInfo;
		   
}
echo(json_encode(array("status"=>"success", "reason"=>"sent")));
//echo 'Message has been sent to'. $email;



	}

	
	

?>