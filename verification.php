<?php
/**
 * Verify the email id of subscriber
 * 
 * PHP version 7.4.10
 * 
 * @author     Paras Dalsaniya <parasdalsaniya8@gmail.com>
 * @copyright  1997-2005 The PHP Group
 * @version    1.0
 * @since      File available since Release 1.0
 * @deprecated File is not deprecated  
 */
require_once 'db_connection.php';

if (isset($_GET['usersign'])) {
    
    $userkey = $_GET['usersign'];
    $userkey = filter_var($userkey, FILTER_SANITIZE_STRING);
    $update_validation = 1;

    if ($error == null) {
        $verification_status = Check_Verification_status($userkey);

        if ($verification_status == 0) {
            
            $verification = $connection->prepare(" UPDATE subscriber SET validation=? where emailkey=? ");
            $verification->bind_param("is", $update_validation, $userkey);
            if (!$verification->execute()) {
                $error = 'Somthing went wrong please try after some time';
            }

        } else {
            $error = 'Already Verified';
        }
    }
} else {
    die();
}
/**
 * Check that user is already verified or not
 * 
 * @param string $userkey 
 *  
 * @return bool
 */
function Check_Verification_status($userkey)
{
    include 'db_connection.php';
    $sql = " SELECT validation FROM subscriber WHERE emailkey='$userkey' ";
    $result = mysqli_query($connection, $sql);
    $validation_status = mysqli_fetch_object($result);
    return $validation_status->validation;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="content">
        <h2>
            <?php
            echo ($error==null) ? "Verification Successful" : $error ;
            ?>
        </h2>
    </div>
</body>
</html>
