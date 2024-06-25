<?php
   setcookie('logged_in', false, time() + (86400 * 30), "/");
   setcookie('username', '', time() - 3600, '/'); // set time to past to delete cookie
   setcookie('name', '', time() - 3600, '/');
   setcookie('surname', '', time() - 3600, '/');
   setcookie('email', '', time() - 3600, '/');
   setcookie('logged_in', '', time() - 3600, '/');
   header("Location: Login.php");
