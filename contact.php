<?php
include("connect.php");
//page_top.php var setup
$page_title = "Contact | Sam's Books";
$curPage  = "Contact";
$jsPaths = array('js/main.js');
require_once('page_top.php');
?>
		<form class="row" name="contactform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" validate>
			<div class="col-12">
				<label for="name" class="form-label">Name</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Name" required maxlength="50">
			</div>
			<div class="col-12">
					<label for="email" class="form-label">Email</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com" required maxlength=80">
			</div>
			<div class="col-12">
				<label for="contact_reason" class="form-label">State</label>
				<select class="form-select" id="contact_reason" name="contact_reason" required>
				<option selected disabled value="">Choose...</option>
				<option value="Problem With Site">Problem With Site</option>
				<option value="Problem With Database">Problem With Database</option>
				<option value="Questions">Questions</option>
				<option value="Anonymous Death Threat">Anonymous Death Threats</option>
				<option value="Other">Other</option>
				</select>
			</div>
			<div class="col-12">
				<label for=comments" class="form-label">Comments</label>
				<input type="text" class="form-control" id="comments" name="comments" required>
			</div>
			<div class="col-12">
				<button class="btn btn-primary" type="submit">Submit</button>
			</div>
		</form>
<?php
include ("page_bottom.php");
//Send email
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $email_to = "jamesspidercat@gmail.com";
    $email_subject = "Book Site Feedback";
 
    function died($error) {
		echo $error;
        die();
    }
 
 
    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['comments'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
    $name = $_POST['name'];
    $email_from = $_POST['email']; 
    $comments = $_POST['comments']; 
    $contact_reason = $_POST['contact_reason'];
    $email_message = "\n\n\n";
 
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Contact Reason: ".clean_string($contact_reason)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
// create email headers
    $headers = 'From: '.$email_from."\r\n".'Reply-To: '.$email_from."\r\n" .'X-Mailer: PHP/' . phpversion();
	$myfile = fopen("new_mail.txt", "a") or die("Unable to open file");
	$mail_content = $email_message;
    fwrite($myfile, $mail_content);
    fclose($myfile);
    $retval = mail($email_to, $email_subject, $email_message, $headers); 
    if( $retval == true ) {
        echo "Message sent successfully";
        die();
    }else{
        echo 'Message could not be sent...';
    }
}
?>