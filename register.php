<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include 'functions.php';
session_start();
$validuser = FALSE;
$displayform = FALSE;
$uploadform = FALSE;

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

        if (!isset($_POST['lastname']))
            {
                if (isset($_FILES['passport']['name']))
                    {

                        //process file upload it is an image file
                        if ($_FILES['passport']['type']!= 'text/plain')

                                {
                                    $staff_id = $_SESSION['staff_id'];

                                    switch($_FILES['passport']['type'])
                                        {
                                             case "image/gif": $saveto = "passports/$staff_id.gif";
                                             break;
                                             case "image/jpeg": $saveto = "passports/$staff_id.jpg";
                                             break;
                                             case "image/png": $saveto = "passports/$staff_id.png";
                                             break;
                                             default:           $mesg = "picture format not supported please"; $uploadform = TRUE;
                                             break;
                                        }

                                        //check if file exist in temporary folder
                                    if (is_uploaded_file($_FILES['passport']['tmp_name']))
                                        {
                                           //attempt to move file
                                            if (move_uploaded_file($_FILES['passport']['tmp_name'], $saveto))
                                                {
                                                    $mesg= "Staff details saved! You can <a href='register.php'>add another staff</a>";
                                                    $displayform = TRUE;
                                                    $_SESSION['staff_id']="";
                                                }
                                            else
                                                {
                                                   $mesg= "Fatal error! Image could not be saved. Please contact your software vendor.";
                                                   displaymesg($mesg);
                                                   displayfooter();
                                                                exit;
                                                }
                                        }
                            }

            else    {
                        $mesg= "File format not recognised! please upload only images.";
                        $uploadform = TRUE;
                    }
                }
        else
            {
                $displayform = TRUE;
                $mesg = 'Please fill in the required details in the form below to add a staff record to the database';
            }
    }

//check if form feilds are filled out and process it.
if (isset($_POST['lastname']) && isset($_POST['firstname']))
    {
        //process form detail and display photo upload form.
        //assign variables
        if (sanitizeString($_POST['staff_id'])== ""){$staff_id = "NULL";}
        else {$staff_id = sanitizeString($_POST['staff_id']);}
        $lastname = sanitizeString($_POST['lastname']);
        $firstname = sanitizeString($_POST['firstname']);
        if (sanitizeString($_POST['othername'])== ""){$othername = "NULL";}
        else {$othername = sanitizeString($_POST['othername']);}
        $address = sanitizeString($_POST['address']);
        $phone = sanitizeString($_POST['phone']);
        $mobile = sanitizeString($_POST['mobile']);
        $email = sanitizeString($_POST['email']);
        $branch = sanitizeString($_POST['branch']);
        $dept = sanitizeString($_POST['dept']);
        $desg = sanitizeString($_POST['desg']);


        if ($lastname == "" || $firstname == "")
            {
                $uploadform = FALSE;
                $displayform = TRUE;
                $mesg = 'Please fill in the required details CORRECTLY';
            }

        else
            {
                //attempt to add record into database
                $q_staff = "INSERT INTO staff VALUES (NULL, '$lastname','$firstname', '$othername')";

                if (queryMysql($q_staff))
                    {
                        
                        $staff_id =  mysql_insert_id();
                        $q_detail = "INSERT INTO staffpdetail VALUES ('$staff_id', '$mobile','$phone', '$email', '$address')";
                        $q_wdetail = "INSERT INTO staffwdetail VALUES ('$staff_id', '$desg','$dept', '$branch')";

                        if (queryMysql($q_detail) && queryMysql($q_wdetail))
                            {
                                $uploadform = TRUE;
                                $staffname= "Please Upload $lastname $firstname's passport.";
                                $_SESSION['staff_id'] = $staff_id;
                            }
                    }
                else
                    {
                        $mesg = "Sorry, we could not register this Staff at this time. Please try again later.".
                        "</br>If the problem persists, please contact your Database Administrator.";
                        $displayform = TRUE;
                    }
            }


    }


        if ($displayform)
            {
                displayerrormesg($mesg);
                registration_form();
            }
        elseif($uploadform)
            {
                uploadform($staffname);
            }

    

        displayfooter();
    }
    echo <<<_END
    <script type="text/javascript">
function validate(form)
{
	fail  = validatename(form.lastname.value)
	fail += validatename(form.firstname.value)
	fail += validateEmail(form.email.value)
    fail += validatenumber(form.phone.value)
    fail += validatename(form.branch.value)
    fail += validatename(form.dept.value)
    fail += validatename(form.desg.value)
	if (fail == "") return true
	else {
            fail = "Please fill all the compulsory feilds correctly."
                alert(fail); return false }
}
</script>
_END;
?>
