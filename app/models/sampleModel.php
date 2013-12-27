<?php

/**
 * Description of sampleModel
 *
 * @author amahalingam
 */
require_once __SITE_PATH . '/libs/Form.php';

class sampleModel {

    var $form;

    public function __construct() {
        $this->form = new Form();
    }

    public function validate($name, $no) {

        if ($name == "amahalingam") {
            $this->form->setValue('Employee Name', "Account Name has been inserted Successfully");
        } else {
            $this->form->setValue('Employee Name', "Please check the Employee Name");
        }

        if ($no == '12345') {
            $this->form->setValue('Employee No', "Account Number has been Inserted Successfully");
        } else {
            $this->form->setValue('Employee No', "Please check the Employee No");
        }
    }

    public function getValues() {
        $vars['emp_name'] = $this->form->value('Employee Name');
        $vars['emp_no'] = $this->form->value('Employee No');
        return $vars;
    }

}

?>
