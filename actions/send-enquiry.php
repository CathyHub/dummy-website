<?
require_once("../functions/connect.php");
require_once("../functions/smtpsend.php");

// BR
function br($val) {
    return str_replace("\n", " <br/>", $val);
}

extract($_POST);
$d = date("F j, Y H:i");
$phptime = time();

if($name && $email && $phone && $message) {

    $smtp_user  = "primalsurfacing@mailchimp.emotedigital.com.au";
    $smtp_pass  = "tnDdmWRB1JeoU1XU_vZJOA";

    $smtp_host  = "smtp.mandrillapp.com";

    $to         = "cathy.zhang@emotedigital.com.au";
    // $to         = "info@primalsurfacing.com.au";

    $toName     = "";
    $from       = $to;
    $fromName   = $toName;
    $subject    = "New enquiry from Primal Surfacing website";

    $text       = "
Sent: $d
Name: $name
Email: $email
Phone: $phone
Message: $message
";

    $messagehtml = br($message);
    $html       = "
    <b>Sent:</b> <i>$d</i>
    <br><br>
    <table cellpadding='5'>
        <tr>
            <td>
                <b>Name</b>
            </td>
            <td>
                $name
            </td>
        </tr>
        <tr>
            <td>
                <b>Email</b>
            </td>
            <td>
                $email
            </td>
        </tr>
        <tr>
            <td>
                <b>Phone</b>
            </td>
            <td>
                $phone
            </td>
        </tr>
        <tr>
            <td>
                <b>Message</b>
            </td>
            <td>
                $message
            </td>
        </tr>
    </table>
    ";

    smtp_mail_adv($smtp_user, $smtp_pass, $smtp_host, $to, $from, $fromName, $email, $name, $subject, $text, $html);

    mysql_query("INSERT INTO enquiries(name, email, phone, message, time_sent) VALUES('$name', '$email', '$phone', '$message', '$d')") or die(mysql_error());
}
?>