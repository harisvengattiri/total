<?php
include "config.php";
session_start(); 
session_destroy();
header('Location:'.BASEURL.'/login?status=logout');
