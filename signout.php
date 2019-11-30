<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include 'functions.php';
session_start();
$validuser = FALSE;
if (isset($_SESSION['username']))
{
    destroySession();
    $error = 'You have been logged out. Please ' .
         "<a href='index.html'>click here</a> to view the home page.";
 }

else {$error = "You cannot sign out because you are not logged in! Please <a href='index.html'>click here</a> to Sign in.";}
displayheader();
displaymesg($error);
echo <<<_END
<script>
document.location.href = 'http://localhost/staffmanager/index.html'
</script>
_END;
displayfooter();

?>
