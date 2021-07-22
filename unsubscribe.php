<?php
/**
 * Verify the email of user
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
    $update_subscription = 0;

    if ($error == null) {
        $Subscription_status = Check_Subscription_status($userkey);

        if ($Subscription_status == 1) {
            
            $unsubscribe = $connection->prepare(" UPDATE subscriber SET subscription=? where emailkey=? ");
            $unsubscribe->bind_param("is", $update_subscription, $userkey);
            if (!$unsubscribe->execute()) {
                $error = 'Somthing went wrong please try after some time';
            }

        } else {
            $error = 'You already unsubscribe service';
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
function Check_Subscription_status($userkey)
{
    include 'db_connection.php';
    $sql = " SELECT subscription FROM subscriber WHERE emailkey='$userkey' ";
    $result = mysqli_query($connection, $sql);
    $subscription_status = mysqli_fetch_object($result);
    return $subscription_status->subscription;
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
            echo ($error==null) ? 'Unsubscribe successful' : $error;
            ?>
        </h2>
    </div>
</body>
</html>
