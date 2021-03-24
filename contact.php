<?php
include("connect.php");
//page_top.php var setup
$page_title = "Contact | Sam's Books";
$curPage  = "Contact";
$jsPaths = array('js/main.js','js/contact.js');
require_once('page_top.php');
?>
        <form name="contactform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table>
<tr>
 <td>
  <label for="name">Name *</label>
 </td>
 <td>
  <input  type="text" name="name" id='name' maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td>
  <label for="email">Email Address *</label>
 </td>
 <td>
  <input  type="text" name="email" id="email" maxlength="80" size="30">
 </td>
</tr>
<tr>
 <td>
  <label for="contact_reason">Reason for contacting *</label>
 </td>
 <td>
<select id="contact_reason" name="contact_reason">
    <option value="Problem With Site">Problem With Site</option>
    <option value="Problem With Database">Problem With Database</option>
    <option value="Questions">Questions</option>
    <option value="Anonymous Death Threat">Anonymous Death Threats</option>
    <option value="Other">Other</option>
</select>
 </td>
</tr>
<tr>
 <td>
  <label for="comments">Comments *</label>
 </td>
 <td>
  <textarea  name="comments" id="comments" maxlength="1000" cols="25" rows="6"></textarea>
 </td>
</tr>
<tr>
 <td colspan="2" style="text-align:center">
  <input type="submit" value="Submit">
 </td>
</tr>
</table>
<p id="error"></p>
<?php //Send email
if(isset($_POST['email'])) {
    
    $email_to = "jamesspidercat@gmail.com";
    $email_subject = "Book Site Feedback";
 
    function died($error) {
        $error_full = "We are very sorry, but there were error(s) found with the form you submitted. These errors appear below.<br /><br />".$error."<br /><br />Please fix these errors and resubmit the form.<br /><br />";
        echo 
'<script>
    resubmit("'.$error_full.'");
</script>';
        die();
    }
 
 
    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['comments'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
    $name = $_POST['name']; // required
    $email_from = $_POST['email']; // required
    $comments = $_POST['comments']; // required
    $contact_reason = $_POST['contact_reason'];
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br/>';
  }
  if(strlen($comments) < 2) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br/>';
  }
 
    if(strlen($error_message) > 0) {
    died($error_message);
    }
    $email_message = "\n\n";
 
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
    $retval = mail($email_to, $email_subject, $email_message, $headers); 
    if( $retval == true ) {
        echo "Message sent successfully...";
        die();
    }else{
        echo '<script>resubmit("Message could not be sent...");</script>';
    }
}
?>
</form>
<?php
include ("page_bottom.php");
?>