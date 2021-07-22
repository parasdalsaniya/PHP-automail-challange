# 📧 [PHP automail challange](https://www.paraspatel.tech)

**This is php application that accepts the visitor's email address and email them random XKCD comics every five minutes.**

## 📝 Description

* You can visit the web application [here](https://www.paraspatel.tech).
* Enter valid mail address and submit.
* Get verification link through an email.
* Verify your email address.
* Now, you will get an email after every five minits.
* Email includes a inline image, image attachment and unsubscribe link.
* You can unsubscribe this mail via unsubscribe link.

![demo](https://paraspatel.tech/homepage.png)

## 📜 Main Features

* User can not subscribe using fake email.
* Email contents inline image as well as image attachment.
* User can unsubscribe service at any time.

## 🛠️ Build With

  `PHP 7`  `HTML 5`  `CSS 3`

## ✔️ Software requirements

  `Xampp Server`

## 📥 Installation

* Clone or download source code from [here](https://github.com/parasdalsaniya).

### File Structure

<pre>
 --php-parasdalsaniya
         |
         |-- index.php
         |
         |-- verification.php
         |
         |-- send_mail.php
         |
         |-- unsubscribe.php
         |
         |-- db_connection.php
         |
         |-- db_variables.php
</pre>

### Database Configuration

1. Download `xampp` from [here](https://www.apachefriends.org/index.html).
2. Install `xampp` server on your device.
3. Turn on `apache` and `MySQL` server.
4. Create a new database in `phpmyadmin`.
5. Create a database table `subscribers` with mention columns and make id as a primery key and email as an unique.

    |id   |email   |emailkey   |validation   |subscription  |
    |---  |------  |------     |---          |---           |
    |int  |string  |string     |int          |int           |

6. Configure `SERVER_NAME`, `USER_NAME`, `PASSWORD` and `DATABASE_NAME` according to your database in db_variables.php.

### Configuration for sending email

1. We have to configure `xampp` server for send email from localhost.
2. You have to turn on google less secure app access from [here](https://myaccount.google.com/lesssecureapps?pli=1&rapt=AEjHL4MDWHhMPbqeGgY5ZVsdiB-a6un9yNn-CoWBxYwi220T6Q6wekLHVsZAE8SgY3EUxDmtte9uOrU4fmO6gVrY4KNs_B4ktw).
3. Go to c:\xampp\php and open the php.ini file.
    * Find `[mail function]` by pressing `ctrl+f` and changes the values mention below
    * SMTP=smtp.gmail.com
    * smtp_port=587
    * sendmail_from=yourgmail@gmail.com
    * sendmail_path="\"C:\xampp\sendmail\sendmail.exe\" -t"
4. Go to C:\xampp\sendmail and open the sendmail.ini file.
    * smtp_server=smtp.gmail.com
    * smtp_port=587
    * error_logfile=error.log
    * debug_logfile=debug.log
    * auth_username=yourgmail@gmail.com
    * auth_password=yourgmailpassword
5. Configure cron job for schedule email.
    * [Configure cron job in cpanel](https://blog.cpanel.com/how-to-configure-a-cron-job/)
    * [Configure cron job in windows](https://medium.com/@shraddha_kulkarni/run-php-cron-in-windows-513fb1aa53a5)
  
## 📞 Contact

**Paras Dalsaniya**
<br>parasdalsaniya8@gmail.com
