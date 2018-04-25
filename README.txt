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