<?php
defined ('_JEXEC') or die ('Not Access');
?>

<?php

if(isset($_POST['RName']))

{
	
    $to = "disha.goyal@befreeit.com.au";
    $from = "noreply@superrecords.com.au";
    $subject = "Free Trial Registration";
    
    $name = $_POST['RName'];
    $practiceName = $_POST['RPracticeName'];
    $email = $_POST['REmail'];
    $phone = $_POST['Phone'];
    $state = $_POST['state'];
    
    $message = '
    <table align="center" border="0">
        <tr>
            <td align="right">
                Client Name :
            </td>
            <td>
                '.$name.'
            </td>
        </tr>
        <tr>
            <td align="right">
                Practice Name :
            </td>
            <td>
                '.$practiceName.'
            </td>
        </tr>
        <tr>
            <td align="right">
                Email Id :
            </td>
            <td>
                '.$email.'
            </td>
        </tr>
		 <tr>
            <td align="right">
                Phone Number :
            </td>
            <td>
                '.$phone.'
            </td>
        </tr>
        <tr>
            <td align="right">
                State :
            </td>
            <td>
                '.$state.'
            </td>
        </tr>
    </table>
             ';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= 'From: '.$from . "\r\n";
    mail($to,$subject,$message,$headers);

}
?>