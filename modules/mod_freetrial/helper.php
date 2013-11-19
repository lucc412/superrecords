<?php

defined ('_JEXEC') or die ('Not Access');

    $db = JFactory::getDBO();

    $query = $db->getQuery(true);

    $query->select ('name') -> from ('#__users');

    $db->setQuery($query);

    $rows= $db->loadObjectList();   

    class modFreeTrialHelper
    {
        public function initialize($params) 
	{
            $this->to_email =  $params->get('to_email');
            $this->from_email = $params->get('from_email');
            $this->subject = $params->get('subject');
            $this->thankmsg = 'Thank You';
            $this->success_url = $params->get('success_url');
            $this->failure_url = $params->get('failure_url');
            $this->session =& JFactory::getSession();

            return $this;
	}
        
        function process_registration_form()
        {
            $to = $this->to_email;
            $from = $this->from_email;
            $subject = $this->subject;

            $name = $_POST['RName'];
            $practiceName = $_POST['RPracticeName'];
            $email = $_POST['REmail'];
            $phone = $_POST['Phone'];
            $state = $_POST['state'];
            $captcha = @$_POST['ct_captcha'];

            $message = '
            <table border="0" width="50%">
                <tr><td colspan="2">A new enquiry has been submitted for free trial registration.</td></tr>
                <tr>
                    <td>
                        Name :
                    </td>
                    <td>
                        '.$name.'
                    </td>
                </tr>
                <tr>
                    <td>
                        Practice Name :
                    </td>
                    <td>
                        '.$practiceName.'
                    </td>
                </tr>
                <tr>
                    <td>
                        Email Address :
                    </td>
                    <td>
                        '.$email.'
                    </td>
                </tr>
                         <tr>
                    <td>
                        Phone Number :
                    </td>
                    <td>
                        '.$phone.'
                    </td>
                </tr>
                <tr>
                    <td>
                        State :
                    </td>
                    <td>
                        '.$state.'
                    </td>
                </tr>
            </table>';

            $flagSubmit = TRUE;

            // Only try to validate the captcha if the form has no errors
            // This is especially important for ajax calls
            if ($flagSubmit) 
            {
                require_once dirname(__FILE__) .DS.'tmpl/securimage/securimage.php';
                $securimage = new Securimage();

                if ($securimage->check($captcha) == false) {
                    //$errors = 'Invalid Code Entered';
                    $flagSubmit = FALSE;
                }
            }

            if ($flagSubmit) 
            {
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                $headers .= 'From: '.$from . "\r\n";
                mail($to,$subject,$message,$headers);
            }
            
            return $flagSubmit;
        }
        
    }
?>