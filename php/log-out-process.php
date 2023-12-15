<?php

session_start();

// unset all session variables to handle the log in status, related to the php session
unset($_SESSION["isLoggedIn"]);
unset($_SESSION["login"]);
unset($_SESSION["avatarPath"]);

// destroy the PHP session
session_destroy();
