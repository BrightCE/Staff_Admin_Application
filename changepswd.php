<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include 'functions.php';
session_start();
$validuser = FALSE;
$displayform = FALSE;

if (isset ($_SESSION['username']))
    {
        $validuser = TRUE;
        $currentpswd = $_SESSION['passwd'];
    }
else
    {
        echo "you should Sign in to view this page.";
        exit;
    }

if ($validuser)
    {
        displayheader();
        //check if form has bring filled
        if (isset($_POST['oldpswd']))
             {
               $oldpswd = sanitizeString($_POST['oldpswd']);
               $newpswd = sanitizeString($_POST['newpswd']);
               $newpswd2 = sanitizeString($_POST['newpswd2']);
               $username = $_SESSION['username'];
               if ($oldpswd == $currentpswd)
                       {
                          if ($newpswd==$newpswd2)
                                {
                                    //Attempt update
                                    $querry = "UPDATE Users SET passwd = '$newpswd' WHERE username = '$username'";
                                    if (queryMysql($querry))
                                        {
                                            $displayform = FALSE;
                                            $mesg = 'Your password has being successfully changed! ';
                                            displaymesg($mesg);
                                            displayfooter();
                                            exit;
                                        }
                                }
                           else
                                {
                                   $mesg = 'The new passwords are not Identical. Please fill in the required details correctly';
                                   displayerrormesg($mesg);
                                   changepswd_form();
                                }
                       }

             else
                   {
                      $mesg = "Please fill in the required details correctly.";
                      displayerrormesg($mesg);
                      changepswd_form();
                   }
             }

        else
            {
                $displayform = TRUE;
            }

       if ($displayform)
            {
                changepswd_form();
            }
        displayfooter();
    }
?>
