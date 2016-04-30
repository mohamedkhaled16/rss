<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        $str_length = new Zend_Validate_StringLength(array("min" => 8, "max" => 20));
        $str_length->setMessage("Password should be min 8 max 20 characters");
        /* Form Elements & Other Definitions Here ... */
        $id = new Zend_Form_Element_Hidden("id");

        $name = new Zend_Form_Element_Text("name");
        $name->setRequired();
        $name->addValidator(new Zend_Validate_Alpha());
        $name->setlabel("Name:");
        $name->setAttrib("class",array("form-control","col-lg-9" ));

        $name->setAttrib("placeholder","Enter your name");



        $username = new Zend_Form_Element_Text("username");
        $username->setRequired();
        $username->addValidator(new Zend_Validate_Alpha());
        $username->setlabel("User Name:");
        $username->setAttrib("class",array("form-control","col-lg-9" ));
        $username->setAttrib("placeholder","Enter your user name");
        $username->addValidator(new Zend_Validate_Db_NoRecordExists(
            array(
                'table' => 'user',
                'field' => 'username'
            )
        ));

        $signture= new Zend_Form_Element_Text("signture");
        $signture->setRequired();
        $signture->addValidator(new Zend_Validate_Alpha());
        $signture->setlabel("signture:");
        $signture->setAttrib("class",array("form-control","col-lg-9" ));
        $signture->setAttrib("placeholder","Enter your signture");


        $email = new Zend_Form_Element_Text("email");
        $email->setRequired();
        $email->setAttrib("class",array("form-control","col-lg-9" ));

        $email->addValidator(new Zend_Validate_EmailAddress());
        $email->addValidator(new Zend_Validate_Db_NoRecordExists(
            array(
                'table' => 'user',
                'field' => 'email'
            )
        ));
        $email->setlabel("Email:");
        $email->setAttrib("placeholder","Enter your Email");

        $password = new Zend_Form_Element_Password("password");
        $password->setRequired();
        $password->setlabel("Password : ");
        $password->setAttrib("class",array("form-control","col-lg-9" ));
        $password->addValidator($str_length);


        $cpassword = new Zend_Form_Element_Password("cpassword");
        $cpassword->setRequired();
        $cpassword->setlabel("Confirm Password : ");
        $cpassword->setAttrib("class",array("form-control","col-lg-9" ));
        $cpassword->addValidator(new Zend_Validate_StringLength(array('min' => 1, 'max' => 10)));

        $gender = new Zend_Form_Element_Radio('gender');
        $gender->setLabel('Gender');
        $gender->setRequired();
       // $gender->setAttrib("class",array("form-control","col-lg-9" ));
        $gender->addMultiOptions(array(
            'Female' => 'Female',
            'Male' => 'Male',
        ));

        $country = new Zend_Form_Element_Select('country');
        $country->setLabel('Country');
        $country->setAttrib("class",array("form-control","col-lg-9" ));
        $country->addMultiOptions(array(
            'Egypt' => 'Egypt',
            'England' => 'England',
            'Japan' => 'Japan',
            'Chine' => 'Chine',
        ));

        $role = new Zend_Form_Element_Select('role');
        $role->setLabel('Role');
        $role->setAttrib("class",array("form-control","col-lg-9" ));
        $role->addMultiOptions(array(
            'Admin' => 'Admin',
            'User' => 'User',
        ));

        $photo=new Zend_Form_Element_File('photo');
        $photo->addValidator(new Zend_Validate_File_Count(array("min" => 0, "max" => 1)))
                ->addValidator(new Zend_Validate_File_Size(array("min" => 1, "max" => 2097152)));
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib("class","btn-lg btn-primary");
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('class','form-horizontal');
        $this->addElements(array($id,$name, $username,$email,$signture,$password,$cpassword,$gender,$country,$role,$photo, $submit));
    }

}

