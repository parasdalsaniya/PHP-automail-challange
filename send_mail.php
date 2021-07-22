<?php
/**
 * Send the xkcd email to verified user with inline image and image attachment 
 * 
 * PHP version 7.4.10
 * 
 * @author     Paras Dalsaniya <parasdalsaniya8@gmail.com>
 * @copyright  1997-2005 The PHP Group
 * @version    1.0
 * @since      File available since Release 1.0
 * @deprecated File is not deprecated  
 */

if (!isset($_SERVER['SERVER_NAME'])) {
    include_once 'db_connection.php';

    $sql = "SELECT email, emailkey FROM subscriber WHERE subscription ='1' AND validation='1'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        while ( $row = mysqli_fetch_row($result) ) {
            if (!Send_mail($row[0], $row[1])) {
                echo 'Not be able to send mail';
            }
        }
    } else {
        echo 'Somethings wents wrong';
    }
} else {
    die();
}
/**
 * Send a xkcd mail to verified subscribers
 * 
 * @param string $to_email 
 * @param string $emailkey 
 * 
 * @return bool 
 */
function Send_mail($to_email, $emailkey) 
{
    $random_number = Random_xkcd();
    $image_url = Image_url($random_number);
    $attachment_data = Attachment_data($image_url);
    $attachment_name = "xkcd$random_number.jpeg";
    $server_name = 'localhost';
    $eol = PHP_EOL;
    $from = FROM ;

    $subject = 'xkcd';
    $body = "<img src=$image_url><br>
            <a href='$server_name/php-parasdalsaniya/unsubscribe.php?usersign=$emailkey'>
                Unsubscrib Here;
            </a>";
    $separator = md5(time());

    $headers = '';
    $headers .= 'MIME-Version: 1.0' . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"" . $eol;
    $headers .= "FROM: $from";
    
    // HTML message
    $message = '';
    $message .= '--'.$separator.$eol;
    $message .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
    $message .= "Content-Transfer-Encoding: 7bit" . $eol . $eol;
    $message .= $body . $eol;
    
    // Attachment
    $message .= '--'.$separator.$eol;
    $message .= "Content-Type: application/octet-stream; name=\"".$attachment_name."\"".$eol;
    $message .= "Content-Transfer-Encoding: base64" . $eol;
    $message .= "Content-Disposition: attachment" . $eol . $eol;
    $message .= $attachment_data . $eol;
    $message .= '--' . $separator . '--';

    return mail($to_email, $subject, $message, $headers);
}

/**
 * Get a random xkcd number from json file
 * 
 * @return int $random_number 
 */
function Random_xkcd()
{
    $url = 'https://xkcd.com/info.0.json';
    $url = Sanitize_url($url);
    $json = file_get_contents($url);
    $xkcd_info = json_decode($json, true);
    $random_number = rand(1, $xkcd_info['num']);
    return $random_number;
}

/**
 * Get a url of xkcd image using random number
 * 
 * @param int $random_number 
 * 
 * @return string  
 */
function Image_url($random_number)
{
    $url = "https://xkcd.com/{$random_number}/info.0.json";
    $url = Sanitize_url($url);
    $json = file_get_contents($url);
    $image_url = json_decode($json, true);
    return $image_url['img'];
}

/**
 * Convert image into 64bit data for attachment
 * 
 * @param string $image_url  
 * 
 * @return string 
 */
function Attachment_data($image_url)
{
    $image = file_get_contents($image_url); 
    $encode = base64_encode($image);
    return chunk_split($encode); 
}

/**
 * Sanitize the json url
 * 
 * @param string $url 
 * 
 * @return string $nurl 
 */
function Sanitize_url($url) 
{
    $nurl = filter_var($url, FILTER_SANITIZE_URL);
    return $nurl;
}

?>