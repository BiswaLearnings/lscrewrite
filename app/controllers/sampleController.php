<?php

/**
 * Description of sampleController
 *
 * @author amahalingam
 */
require_once __SITE_PATH . '/app/models/sampleModel.php';

class sampleController extends baseController {

    var $model;
    var $template;
    var $vars = array();

    public function __construct() {
        $this->model = new sampleModel();
        $this->template = new Template();
    }

    public function sampleForm() {
        $this->template->display('sampleForm', '');
    }

    public function index() {
        $this->model->validate($_POST['employeeName'], $_POST['employeeNo']);

        $data = $this->model->getValues();
        $this->template->display('sampleForm', $data);
    }

}

?>
