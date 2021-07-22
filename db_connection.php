<?php
/**
 * Creat a connection with database
 * 
 * PHP version 7.4.10
 * 
 * @author     Paras Dalsaniya <parasdalsaniya8@gmail.com>
 * @copyright  1997-2005 The PHP Group
 * @version    1.0
 * @since      File available since Release 1.0
 * @deprecated File is not deprecated 
 */
require_once 'db_variables.php';
$error = null;
$connection = mysqli_connect(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
if (!$connection) {
    $error = 'We are not be able to connect to you';
    die();
}

?>
