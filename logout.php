<?php
session_start();
session_destroy();
header('location:login.php');
exit;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>