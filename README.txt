Installation Guide:
~~~~~~~~~~~~~~~~~~~

1. Installing 'PHPMailer':
To be able to use the email services on "Forgot my password" option, download and install PHPMailer from the link below:
https://github.com/PHPMailer/PHPMailer
(Prefered way: installing 'composer' program, and then installing PHPMailer with the line: "composer require phpmailer/phpmailer").

2. Import SQL dump file from SQL_DUMP folder. if using mysql, command should be:
	"mysqldump -u root -p userdb.sql > C:/.../mysql/mysqlXX.X.XX/bin/"
	where the path specified is for the mysql db directory.

2. Copy directory files to correct folder:
	If using locale web server such as Apache: Copy to the to the web-server web pages folder ('www').
	
3. Start the main log-in page 'login.php'
~~~~~~~~~~~~~~~~~~~

Files Description:
~~~~~~~~~~~~~~~~~~~
1. login.php - log-in page using bootstrap UI. including login, sign-up and 'forgot my password' forms using
'modal' bootstrap.
2. errors.php - small php code for alerting error messages from the 'errors' array object.
3. index.php - user-panel page, including both UI and php logic (querying certain data from DB such as
login history).
4. server.php - PHP logic for logging-in and signing-up from the login page.
5. resetPassword.php - including 'forgot my password' page and PHP logic for matching up password-reset token,
querying the user and changing password.