HOW TO SET UP THIS PROJECT
START THE SERVER
Open XAMPP or WAMP Control Panel.
Start "Apache" and "MySQL".
SETUP THE DATABASE
Go to your browser and open: http://localhost/phpmyadmin/
Create a new database named: interview_test
Click on the "SQL" tab.
Paste the "CREATE TABLE" code provided in the instructions and click "Go".
(This creates the 'users' table and the 'admin' user).
PREPARE THE FILES
Go to your computer folder: C:\xampp\htdocs\
Create a new folder named: mini_auth
Put all these files inside that folder:
db.php
signup.php
api-save.php
login.php
api-check.php
dashboard.php
logout.php

HOW TO RUN THE PROJECT
Open your browser and type: http://localhost/mini_auth/signup.php
TEST ADMIN LOGIN
To test the admin features, go to login.php and use:
Username: admin
Password: 'Hashed_admin_passwor1'  
NOTES:
Always use the URL http://localhost/... to open the files.
Do not just double-click the files from your folder, or they won't work.
Make sure "db.php" has the correct database name (interview_test).