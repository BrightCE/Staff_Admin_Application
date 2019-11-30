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

         if(isset($_POST['staff_id'])||(isset($_POST['lastname']) && isset($_POST['firstname'])))
                {
                    //process posted data
                    $staff_id = sanitizeString($_POST['staff_id']);
                    $lastname = sanitizeString($_POST['lastname']);
                    $firstname = sanitizeString($_POST['firstname']);
                    $detail = sanitizeString($_POST['detail']);
                    if($lastname != "")
                        {
                            if($detail== "basic")
                                {
                                     $q_basic = "select staff.id, staff.lastname, staff.firstname, staffpdetail.mobile
                                                 from staff, staffpdetail
                                                 where staff.lastname='$lastname' and staff.firstname='$firstname' and staff.id = staffpdetail.id";

                                    $result = queryMysql($q_basic);
                                    if (mysql_num_rows($result)==0)
                                            {
                                                $mesg = "staff not found. Make sure the Names are correct or use his unique ID number.";
                                                $displayform = TRUE;
                                            }
                                     else
                                     {
                                       display_record($result);
                                       displayfooter();
                                       exit;
                                     }
                                }
                        }
                      else
                        {
                            if($detail== "basic")
                                {
                                     $q_basic = "select staff.id, staff.lastname, staff.firstname, staffpdetail.mobile
                                                 from staff, staffpdetail
                                                 where staff.id ='$staff_id' and staff.id = staffpdetail.id";

                                    $result = queryMysql($q_basic);
                                    if (mysql_num_rows($result)==0)
                                            {
                                                $mesg = "staff not found. Make sure the Names are correct or use his unique ID number.";
                                                $displayform = TRUE;
                                            }
                                     else
                                     {
                                       display_record($result);
                                       displayfooter();
                                       exit;
                                     }
                                }
                        }
                }

    else if(isset($_POST['groupdept']))
            {
                $dept = sanitizeString($_POST['groupdept']);
                $branch = sanitizeString($_POST['groupbranch']);
                $detail = sanitizeString($_POST['detail']);
                if (!$dept == "" && !$branch=="" && !$detail=="")
                    {
                        if ($detail == "basic")
                            {
                                $q_basic = "select staff.id, staff.lastname, staff.firstname, staffpdetail.mobile, staffwdetail.designation,
                                                staffwdetail.department
                                                 from staff, staffpdetail, staffwdetail
                                                 where staffwdetail.branch = '$branch' and staffwdetail.department= '$dept'
                                                        and staff.id = staffwdetail.id and staff.id = staffpdetail.id";

                               $result = queryMysql($q_basic);
                                    if (mysql_num_rows($result)==0)
                                            {
                                                $mesg = "staff not found. Make sure the Names are correct or use his unique ID number.";
                                                $displayform = TRUE;
                                            }
                                     else
                                     {
                                       display_record($result);
                                       displayfooter();
                                       exit;
                                     }
                            }
                         else{
                             $displayform = TRUE;
                         }
                    }
            }
    else
        {
           $displayform = TRUE;
           $mesg = "Please fill either of the forms below for the information you need.";
        }


         if ($displayform)
            {
                displayerrormesg($mesg);
                viewstaff_form();
            }
        displayfooter();
    }

?>
