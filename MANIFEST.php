<?php
die();

/*
=========================================
Mini Authentication System - MANIFEST
=========================================
Last update: February 3rd 2026

system: Mini Authentication system
Location:
User interface:
Admin Dashboard:

Purpose:
A security gateway designed to verify a user's identity and restrict access to protected areas of a web application.

==========================================
Folder Structure
==========================================
Base folder: 

/schedule
   dataconnect.php



Files to note
---------------------
- Dashboard.php    (Admin Dashboard)
- dbconn.php       (Database Connection)


===========================================
DATABASE TABLES
===========================================
The system uses the "users" table and the Admin relies on the following columns from the table:
--table:user
  - user_id
  - user_name
  - email
  - password
  - role

Run the following SQL to create the system table
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

===============================================
API ENDPOINTS
===============================================
login.php  -- sign into the system
register.php -- register a new user

================================================
HOW TO SET UP THIS PROJECT
=================================================

START THE SERVER
-------------------------------------------------
HOW TO RUN THE PROJECT
Open your browser and type: http://localhost/mini_auth/signup.php

TEST ADMIN LOGIN
-------------------------------------------------
To test the admin features, go to login.php and use:
Username: admin

Password: 'Hashed_admin_passwor1'  
NOTES:
Always use the URL http://localhost/... to open the files.
Do not just double-click the files from your folder, or they won't work.
Make sure "db.php" has the correct database name (interview_test).
*/