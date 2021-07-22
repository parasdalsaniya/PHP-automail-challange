<?php
/**
 * Get the email id from user and validate it, 
 * update in database and send verification link to mail 
 * 
 * PHP version 7.4.10
 * 
 * @author     Paras Dalsaniya <parasdalsaniya8@gmail.com>
 * @copyright  1997-2005 The PHP Group
 * @version    1.0
 * @since      File available since Release 1.0
 * @deprecated File is not deprecated  
 */
$message = null;

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    if (Valid_email($email)) {
        $emailkey = md5($email.time());

        if (Insert_Subscriber_data($email, $emailkey)) {

            if (Send_mail($email, $emailkey)) {
                $message = "Verification mail sent to $email";
            } else {
                $message = 'Somthing went wrong please try after some time';
            }

        } else {
            $message = 'User already exist';
        }

    } else {
        $message = 'please enter valid Email';
    }

}

/**
 * Check whether the email field should not empty and entered mail is valid email
 * 
 * @param string $email 
 * 
 * @return bool 
 */
function Valid_email( $email )
{
    return !strlen($email) === 0 || filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Insert the user data ito database
 * 
 * @param string $email 
 * @param string $emailkey 
 * 
 * @return bool
 */
function Insert_Subscriber_data( $email, $emailkey)
{
    include_once 'db_connection.php';
    $insert_sql = $connection->prepare('INSERT INTO subscriber (email, emailkey) VALUES (?, ?)');
    $insert_sql->bind_param("ss", $email, $emailkey);
    return $insert_sql->execute();
}

/**
 * Send verification mail to subscriber
 * 
 * @param string $email  
 * @param string $emailkey 
 * 
 * @return bool
 */
function Send_mail( $email, $emailkey)
{
    if (isset($_SERVER['SERVER_NAME'])) {    
        $server_name = $_SERVER['SERVER_NAME'];
    } else {
        die();
    }
    $from = FROM ;
    $subject = 'XKCD Verification';
    $message = "Please verify your account<br>
                <a href='$server_name/php-parasdalsaniya/verification.php?usersign=$emailkey'>
                    Verify here
                </a>
                ";
    $headers = 'MIME-Version: 1.0' . PHP_EOL;
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . PHP_EOL;
    $headers .= "From: $from";

    return mail($email, $subject, $message, $headers);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XKCD</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="content">
        <h1>Subscribe</h1>
        <h5>Enter your mail to subscribe XKCD</h5>
        <form method="POST">
            <input type="text" name="email" placeholder="Email" class="textfield">
            <input type="submit" value="Subscribe" class="submit">
        </form>
        <h5>
            <?php
                echo $message;
            ?>
        </h5>
    </div>
</body>
</html>
