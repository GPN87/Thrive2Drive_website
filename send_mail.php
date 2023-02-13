<?php
$webmaster_email = "info@thrive2drive.com.au";
$contact_page = "contactform.html";
$error_page = "error_message.html";
$thankyou_page = "thank_you.html";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/
$email_address = $_REQUEST['email_address'] ;
$comments = $_REQUEST['comments'] ;
$name = $_REQUEST['name'] ;
$phone = $_REQUEST['phone'];
$msg = 
"Name: " . $name . "\r\n" . 
"Email: " . $email_address . "\r\n" .
"Phone: " . $phone . "\r\n" .
"Comments: " . $comments ;

/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// If the user tries to access this script directly, redirect them to the contact form,
if (!isset($_REQUEST['email_address'])) {
header( "Location: $contact_page" );
}
/* 
If email injection is detected, redirect to the error page.
If you add a form field, you should add it here.
*/
elseif ( isInjected($email_address) || isInjected($name)  || isInjected($comments) ) {
header( "Location: $error_page" );
}
// If we passed all previous tests, send the email then redirect to the thank you page.
else {

	mail( "$webmaster_email", "Contact Form Results", $msg, "from: info@thrive2drive.com.au" );

	header( "Location: $thankyou_page" );
}
?>
