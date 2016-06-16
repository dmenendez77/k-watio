<?php
/* Program: Login.php
 *Desc: Login program for users of web.
*/ 
session_start();
include("kwatio_inc.php");
switch (@$_POST['do'])
{
    case "login":
        $cxn = mysqli_connect($host, $user,$passwd,$dbname)
               or die ("Couldn’t connect to server.");
        $sql = "SELECT mail FROM profesionals
                WHERE mail='$_POST[fusername]'";
        $result = mysqli_query($cxn,$sql)
                  or die("Couldn’t execute query.");
        $num = mysqli_num_rows($result); 
        if ($num > 0) // login name was found
        {
            $sql = "SELECT mail FROM professionals
                    WHERE mail=‘$_POST[fusername]'
                    AND password=md5(‘$_POST[fpassword]')";
            $result2 = mysqli_query($cxn,$sql)
                       or die("Couldn’t execute query 2.");
            $num2 = mysqli_num_rows($result2);
            if ($num2 > 0) // password is correct 
            {
                $_SESSION['auth']="yes"; 
                $logname=$_POST['fusername']; 
                $_SESSION['logname'] = $logname; 
                $today = date("Y-m-d h:i:s"); 
                $sql = "INSERT INTO Login (loginName,loginTime)
                        VALUES ('$logname','$today')"; 
                $result = mysqli_query($cxn,$sql)
                        or die("Can’t execute insert query."); 
                header("Location: Member_page.php");
            }
            else // password is not correct 
            {
                $message="The Login Name, '$_POST[fusername]' exists, but you have not entered the correct password! Please try again.<br />";
                include("join.html"); 
            }
        } 
        elseif ($num == 0) // login name not found 
        {
            $message = "The Login Name you entered does not exist! Please try again.<br>";
            include("join.html");
        }
    break;
    case "new":
        /* Check for blanks */
        foreach($_POST as $field => $value)
        {
            if ($field != "telephone") 
        {
            if ($value == "") 
            {
                $blanks[] = $field; 
            }
        }
        }
        if(isset($blanks)) 
        {
            $message_new = "The following fields are blank. Please enter the required information: ";
            foreach($blanks as $value) 
            {
            $message_new .= "$value, "; 
            }
            extract($_POST);
            include("join.html");
            exit();
        }
    /* Validate data */
        foreach($_POST as $field => $value) 
        {
            if(!empty($value)) 
            {
                if(eregi("name",$field) and !eregi("login",$field))
                {
                    if (!ereg("^[A-Za-z' -]{1,50}$",$value)) 
                    {
                    $errors[]="$value is not a valid name.";
                    }
                }
                if(eregi("city",$field)) 
                {
                    if(!ereg("^[A-Za-z0-9.,' -]{1,50}$",$value)) 
                    {
                        $errors[] = "$value is not a valid city.";
                        }
                }
                if(eregi("email",$field)) 
                {
                    if(!ereg("^.+@.+\\..+$",$value)) 
                    {
                    $errors[] = "$value is not a valid email address.";
                    }
                }
                    if(eregi("phone",$field))
                        {
                            if(!ereg("^[0-9)(xX -]{7,20}$",$value)) 
                                {
                                    $errors[] = "$value is not a valid phone number. ";
                                }
                        }
                } // end if empty
            } // end foreach
                if(@is_array($errors)) 
                {
                    $message_new = "";
                    foreach($errors as $value)
                        {
                            $message_new .= $value." Please try again<br />";
                        }
                        extract($_POST); include("join.html"); exit();
                }
                /* clean data */
                $cxn = mysqli_connect($host,$user,$passwd,$dbname);
                foreach($_POST as $field => $value)
                {
                    if($field != "Button" and $field != "do") 
                    {
                        if($field == "password") 
                        {
                            $password = strip_tags(trim($value)); 
                        }
                        else 
                        {
                            $fields[]=$field;
                            $value = strip_tags(trim($value)); 
                            $values[] = mysqli_real_escape_string($cxn,$value); $$field = $value;
                        } 
                    }
                }
                
                /* check whether user name already exists */ 
                $sql = "SELECT name FROM professionals
                    WHERE name = '$loginName'";
                $result = mysqli_query($cxn,$sql)
                          or die("Couldn’t execute select query.");
                $num = mysqli_num_rows($result); 
                if ($num > 0)
                {
                    $message_new = "$loginName already used. Select another User Name.";
            include("join.html"); 
                    exit();
                }
                /* Add new member to database */
                else {
                    //$today = date("Y-m-d");
                    $fields_str = implode(",",$fields); 
                    $values_str = implode('","',$values); 
                    $fields_str .=",createDate";
                    //$values_str .='"'.",".'"'.$today;
                    $fields_str .=",password";
                    $values_str .= '"'.","."md5"."('".$password."')";
                    $sql = "INSERT INTO professionals";
                    $sql .="(".$fields_str.")";
                    
                    $sql .=" VALUES ";
                    $sql .="(".'"'.$values_str.")";
                    $result= mysqli_query($cxn,$sql)
                            or die("Couldn’t execute insert query.");
                    $_SESSION['auth']="yes"; 
                    $_SESSION['logname'] = $loginName;
                    
                    /* send email to new member */ 
                    $emess = "A new Member Account has been set up. "; 
                    $emess.= "Your new Member ID and password are: "; 
                    $emess.= "\n\n\t$loginName\n\t$password\n\n"; 
                    $emess.="We appreciate your interest in Pet"; 
                    $emess.= " Store at PetStore.com. \n\n";
                    $emess.= "If you have any questions or problems,"; 
                    $emess.= " email webmaster@petstore.com"; 
                    $ehead="From: member-desk@petstore.com\r\n";
                    $subj = "Your new Member Account from Pet Store"; 
                    $mailsnd=mail("$email","$subj","$emess","$ehead"); 
                    header("Location: New_member.php");
                }
            break;
            default:
            include("login_form.inc");
            }
?>
