<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'functions.php';
session_start();
$error = $username = $password = "";
$validuser = FALSE;

if (isset ($_SESSION['username']))
    {
        $validuser = TRUE;
    }
else if (isset ($_POST['username']))
    {
        $username = sanitizeString($_POST['username']);
        $password = sanitizeString($_POST['password']);

        if ($username == "" || $password == "")
            {
                $error = "Not all fields were entered";
            }
        else
            {
                $query = "SELECT username,password FROM login
                        WHERE username='$username' AND password='$password'";

                if (mysql_num_rows(queryMysql($query)) == 0)
                    {
                       $mesg = "Sorry! Username and password is incorrect.<br>
                                 Please try <a href = 'index.html'> signing in </a> again.";
                        displayheader();
                        displaymesg($mesg);
                        displayfooter();
                        exit;
                    }
                else
                    {
                        $_SESSION['username'] = $username;
                        $_SESSION['passwd'] = $password;
                        $validuser = TRUE;
                    }
            }
    }

if ($validuser)
    {
        $mesg = "Welcome to My Staff Management Software!";
        displayheader();
        displaymesg($mesg);
        displayfooter();
    }
?>

