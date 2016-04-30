<?php

class Application_Form_Rss extends Zend_Form
{

    public function init()
    {
        
/* Form Elements & Other Definitions Here ... */
        $id = new Zend_Form_Element_Hidden("id");

        $site_name = new Zend_Form_Element_Text("site_name");
        $site_name->setRequired();
        $site_name->addValidator(new Zend_Validate_Alpha());
        $site_name->addFilter(new Zend_Filter_StringTrim())
                ->addFilter(new Zend_Filter_StripTags());
        $site_name->setlabel("Site Name:");
        $site_name->setAttrib("class",array("form-control","col-lg-9" ));
        $site_name->setAttrib("placeholder","Enter site name ...");



        $site_rss_url = new Zend_Form_Element_Text("site_rss_url");
        $site_rss_url->setRequired();
        $site_rss_url->setlabel("Site Rss URL:");
        $site_rss_url->setAttrib("class",array("form-control","col-lg-9" ));
        $site_rss_url->setAttrib("placeholder","Enter your user name");
        $site_rss_url->addValidator(new Zend_Validate_Db_NoRecordExists(
            array(
                'table' => 'rss',
                'field' => 'site_rss_url'
            )
        ));

        $site_description= new Zend_Form_Element_Textarea("site_description");
        $site_description->setRequired();
        $site_description->addFilter(new Zend_Filter_StringTrim())
                ->addFilter(new Zend_Filter_StripTags());
        $site_description->setlabel("Description:");
        $site_description->setAttrib("class",array("form-control","col-lg-9" ));
        $site_description->setAttrib("placeholder","Enter Description");
        $site_description->setAttrib('cols', '40')->setAttrib('rows', '4');




        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib("class","btn-lg btn-primary");
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('class','form-horizontal');
        $this->addElements(array($id,$site_name,$site_rss_url,$site_description,$submit));
    }


    


}

