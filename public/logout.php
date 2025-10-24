<?php

session_start();
session_unset();
session_destroy();

header("Location: /owl-school/public/index.php"); 
exit;
