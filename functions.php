<?php // Example 21-1: functions.php
$dbhost  = 'localhost';    // Unlikely to require changing
$dbname  = 'staffmanager';       // Modify these...
$dbuser  = 'root';   // ...variables according
$dbpass  = '1981bce';   // ...to your installation
$appname = "Robin's Nest"; // ...and preference

mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());

function createTable($name, $query)
{
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br />";
}

function queryMysql($query)
{
    $result = mysql_query($query) or die (mysql_error());
	 return $result;
}

function destroySession()
{
    $_SESSION=array();
    
    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}

function sanitizeString($var)
{
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return mysql_real_escape_string($var);
}

function showProfile($user)
{
    if (file_exists("$user.jpg"))
        echo "<img src='$user.jpg' align='left' />";

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if (mysql_num_rows($result))
    {
        $row = mysql_fetch_row($result);
        echo stripslashes($row[1]) . "<br clear=left /><br />";
    }
}
function filled_out($form_vars) {
  // test that each variable has a value
  foreach ($form_vars as $key => $value) {
     if ((!isset($key)) || ($value == '')) {
        return false;
     }
  }
  return true;
}

function valid_email($address) {
  // check an email address is possibly valid
  if (ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $address)) {
    return true;
  } else {
    return false;
  }
}

//function to display header
function displayheader()
{
   echo <<<_END
   <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Company Name</title>
        <link href="style.css" rel= "stylesheet" type="text/css"  />
        <script type="text/javascript" src = "script.js"></script>
        <script src="validatefunctions.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="pro_dropdown_2/pro_dropdown_2.css" />
        <script src="pro_dropdown_2/stuHover.js" type="text/javascript"></script>
    </head>
    <body>

   <div id="wrapper">
        <div class="tittle"> <h3>Company Name</h3> <hr/></div>
        <div class="menu">
        <ul id="nav">
	<li class="top"><a href="dashboard.php" class="top_link"><span>Home</span></a></li>
	<li class="top"><a href="#" id="products" class="top_link"><span class="down">Staff</span></a>
		<ul class="sub">
			<li><a href="register.php" >Register Staff</a></li>
			<li><a href="viewstaff.php">View Staff</a></li>
            <li><a href="edit.php">Edit Staff Detail</a></li>
            <li><a href="delete.php">Delete Staff</a></li>
		</ul>

	<li class="top"><a href="#" id="services" class="top_link"><span>Rumeration</span></a></li>
    <li class="top"><a href="#" id="products" class="top_link"><span class="down">Messages</span></a>
		<ul class="sub">
			<li><a href="textmessage.php" >Text Staff</a></li>
			<li><a href="email.php">Email Staff</a></li>
		</ul>
	<li class="top"><a href="changepswd.php" id="contacts" class="top_link"><span >Change Password</span></a></li>
    <li class="top"><a href="signout.php" id="contacts" class="top_link"><span >Signout</span></a></li>
</ul>
</div>
_END;
}

//function to display footer
function displayfooter()
{
   echo <<<_END
        </div>
  <div id="footer">
      <p>Copyright © 2013 Company Name |
      Designed by <a href="http://www.brightprogrammes.com">Bright Programmes.</a></p>
  </div>
    </body>

</html>
_END;
}
//function to display success message
function displaymesg($mesg)
    {
        echo <<<_END
       <div class = "regform">
        <div class="container">
       $mesg
       </div>
        </div>
_END;
    }
//function to display error message
function displayerrormesg($mesg)
    {
       echo <<<_END
          <div class="error">
       $mesg
       </div>
_END;
    }

function display_record($record)
    {
        $num = mysql_num_rows($record);
        for ($i = 0; $i < $num; ++$i)
            {
                $row = mysql_fetch_row($record);
             echo <<<_END
               <div class = "regform">
               <table cellspacing="5" align="center" cellpadding="10">
                    <tr>
                        <td rowspan = "4"> <img src="passports/$row[0].jpg" alt="Staff passport" width = "150px" height = "200px"></td>
                        <td>Staff ID: </td><td class= "tdleft">$row[0]</td>
                    </tr>
                    <tr>
                        <td>Lastname: </td><td class= "tdleft">$row[1]</td>
                    </tr>
                    <tr>
                        <td>Firstname: </td><td class= "tdleft">$row[2]</td>
                    </tr>
                    <tr>
                        <td>Mobile No.: </td><td class= "tdleft">$row[3]</td>
                    </tr>
                    <tr>
                        <td>Designation:</td><td class= "tdleft">$row[4]</td>
                        <td>Department: </td><td class= "tdleft">$row[5]</td>
                    </tr>
                </table>
                <hr/>
                 </div>

_END;
            }
    }

    function registration_form()
    {
        echo <<<_END

        <div class = "pagetitle"><h3>Staff Registration Form.</h3> <br>
            Please fill in the required details in the form below to add a staff record to the database.<br>
            Note that feilds marked with asterisks are compulsory.</div>
        <div class ="regform">
        <form name="application" action="register.php" method="POST" onSubmit = "return validate(this)">
           <div class = "pagetitle"><h4>Basic Details</h4><hr></div>
            <table cellspacing="5" align="center" cellpadding="10">
               <tr>
                   <td>Surname: </td><td><input type="text" name="lastname" size="45"><span>*</span></td>
                   <td>First Name: </td><td><input type="text" name="firstname" size="45"><span>*</span></td>
               </tr>
               <tr>
                   <td>Other Name: </td><td><input type="text" name="othername" size="47"></td>
               </tr>
             </table>
             <div class = "pagetitle"><h4>Personal Details</h4><hr></div>
                <table cellspacing="5" align="center" cellpadding="10">
               <tr>
                   <td>E-mail: </td><td><input type="text" name="email" size="45"><span>*</span></td>
                   <td>Phone No.: </td><td><input type="text" name="phone" size="45" maxlength = "11"><span>*</span></td>
               </tr>
               <tr>
                   <td>Mobile No: </td><td><input type="text" name="mobile" size="47"></td>
               </tr>
               <tr>
                   <td>Address: </td><td colspan="3"><input type="text" name="address" size="120"></td>
               </tr>
               </table>
               <div class = "pagetitle"><h4>Work Details</h4><hr></div>
                <table cellspacing="5" align="center" cellpadding="10">
               
               <tr>
                   <td>Branch: </td><td><input type="text" name="branch" size="45"><span>*</span></td>
                   <td>Department: </td><td><input type="text" name="dept" size="45"><span>*</span></td>
               </tr>
               <tr>
                   <td>Designation: </td><td><input type="text" name="desg" size="45"><span>*</span></td>
               </tr>
                <tr><td><br></td></tr>
               <tr>
                   <td colspan="2" style="text-align:center"><input type="submit" value="Register"></td>
                   <td colspan="2" style="text-align:center"><input type="reset" value="Reset"></td>
               </tr>
        </table>
        
        </form>

    </div>
_END;
    }//end registration form

    //function to display passport upload form
  function uploadform($staffname)
    {
        echo <<<_END

        <div class = "pagetitle"><h3>Staff Registration.</h3> <br>
            </div>
        <div class ="regform">
            <br><p>$staffname</p>
            <div class = "container">
            <form method="post" action="register.php" enctype="multipart/form-data">
            <input type = "hidden" name= "MAX_FILE_SIZE" value= "1000000" />
            <br> Image: <input type="file" name="passport"  />
            <input type='submit' value='Save Passport' />
        </form>
    </div>
    </div>
_END;
    }
    //function to display view staff form

    function viewstaff_form()
        {
            echo <<<_END
       <div class = "pagetitle"><h3>View Staff Details.</h3></div>


        <div class = "regform">
                <p>Please fill either of the forms below for the information you need.</p>
             <form name="viewdetails" action="viewstaff.php" method="POST">
                <p>Enter the I.D. number or both Surname and Firstname of the staff whoes details you want to view. </p>
                <table cellspacing="5" align="center" cellpadding="10">
                    <tr>
                       <td>Member I.D. No.: </td><td style = "text-align = Left"><input type="text" name="staff_id" size="20"></td>
                    </tr>
                    <tr>
                       <td colspan = "2" style = "text-align = center"><h3> OR </h3></td>
                    </tr>
                    <tr>
                        <td>Surname: </td><td><input type="text" name="lastname" size="20"></td>
                        <td>First Name: </td><td><input type="text" name="firstname" size="20"></td>
                    </tr>
                    <tr>
                    <td>Choose details: </td><td class= "tdleft"><select name="detail" size="1">
                                <option value="basic">Basic Records</option>
                                <option value="all">All records</option>
                                </select>
                                </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:right"><input type="submit" value="Submit"></td>
                        <td colspan="2" style="text-align:left"><input type="reset" value="Reset"></td>
                    </tr>
          </table>
          <hr>

        </form>
               
             <form action="viewstaff.php" method="POST">
                    <table cellspacing="2" align="center" cellpadding="5">

                    <tr>
                        <td>Department: </td><td><select name="groupdept" size="1">
                                <option value="public sector">PSG</option>
                                <option value="admin">Admin</option>
                                <option value="alldept">All Departments</option>
                                </select></td>
                        <td>Branch: </td><td><select name="groupbranch" size="1">
                                <option value="Leventis">Main Branch</option>
                                <option value="stadiumRd">Stadium Road</option>
                                <option value="artilery">Artilery</option>
                                <option value="allbranches">All Branches</option>
                                </select>
                                </td></td>
                    </tr>
                    <tr>
                    <td>Choose details: </td><td class= "tdleft"><select name="detail" size="1">
                                <option value="basic">Basic Records</option>
                                <option value="all">All records</option>
                                </select>
                                </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:right"><input type="submit" value="Submit"></td>
                        <td colspan="2" style="text-align:left"><input type="reset" value="Reset"></td>
                    </tr>
          </table>
             </form>
        </div>

_END;

        }
function changepswd_form()
    {
         echo <<<_END
       <div class = "pagetitle"><h3>Change Password.</h3></div>

        <div class = "regform">
            <form method="post" action="changepswd.php">
            <table cellspacing="5" align="center" cellpadding="5">
                    <tr>
                       <td>Old Password: </td><td style = "text-align = Left"><input type="password" name="oldpswd" size="20"></td>
                    </tr>
                    <tr>
                       <td>New Password: </td><td style = "text-align = Left"><input type="password" name="newpswd" size="20"></td>
                    </tr>
                    <tr>
                        <td>Repeat Password: </td><td style = "text-align = Left"><input type="password" name="newpswd2" size="20"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right"><input type="submit" value="Submit"></td><td style="text-align:left"><input type="reset" value="Reset"></td>
                    </tr>
                </table>
             </form>
        </div>
_END;
    }
?>
