<?php

require_once __SITE_PATH . '/app/models/settingsModel.php';
require_once __SITE_PATH . '/log4php/Logger.php';
require_once __SITE_PATH . '/libs/Session.php';
require_once __SITE_PATH . '/libs/DBUtil.php';

/**
 *
 * This class is used to manage CRUD operation for Metadata.
 */
class settingsController extends baseController {

    //Template variables
    private $template;
    //db function call
    private $dbUtil;
    //combo value
    private $combovalue;
    //details value
    private $detailsvalue;
    //type
    private $type;
    //data
    private $data;
    //logger
    private $logger;

    /**
     * Constructot to intialise this class
     */
    public function __construct() {
        $this->template = new Template();
        $this->settingsModel = new settingsModel();
        $this->dbUtil = new DBUtil();
        $this->combovalue = $this->settingsModel->populatetypeValues();
        $this->logger = Logger::getLogger("========= Metadata Controller =========== ");
    }

    /**
     * Its landing page to display metadata and used to add new meta data
     */
    public function settingsview() {
        $this->logger->info("Action Settings View ");
        $this->template->display('listsettings', $this->combovalue, 'settings', '');
    }

    /**
     * Used to edit existing metadata
     * @param type $id
     */
    public function editsettingsview($id) {

        $this->logger->info("Action Edit Settings View ");
        $this->data = $this->settingsModel->getcombovalues($id);

        foreach ($this->data as $value) {
            $this->fields['id'] = $value['id'];
            $this->fields['Combovalue'] = $value['meta_text'];
            $this->fields['isactive'] = $value['is_active'];
            $this->fields['meta_code'] = $value['meta_code'];
            $this->fields['combotype'] = $value['meta_type'];
        }

        $this->template->display_data('editlistsettings', $this->combovalue, 'settings', $this->fields);
    }

    /**
     * Used to save new meta data.
     */
    public function savesettingsview() {

        $this->logger->info("Action Save Settings View ");
        $this->fields['combotype'] = $_POST["combotype"];
        $this->fields['Combovalue'] = $_POST["Combovalue"];

        if(!empty($_POST["timedetails"])){
            $this->fields['timedetails'] = $_POST["timedetails"];
        }

        if ($_POST["isactive"] == 'on') {
            $this->fields['isactive'] = 1;
        } else {
            $this->fields['isactive'] = 0;
        }

        $validResult = $this->settingsModel->savecombovalue($this->fields);

        if ($validResult == 0) {
            $this->type = $this->settingsModel->getcombotypevalues($this->fields['combotype']);
            foreach ($this->type as $value) {
                $this->fields['combotype'] = $value['type'];
            }
            $this->template->display('viewsetting', $this->fields, 'settings');
        } else {
            $error = $this->settingsModel->geterror();
            $data = $this->settingsModel->populatetypeValues();
            $this->template->display_data('listsettings', $data, 'settings', $this->fields, '', $error);
        }
    }

    /**
     * Used to view metadatas.
     * @param type $id
     */
    public function viewsettingsview($id) {

        $this->logger->info("Action View Settings View ");
        $this->data = $this->settingsModel->getcombovalues($id);

        foreach ($this->data as $value) {
            $this->fields['Combovalue'] = $value['meta_text'];
            $this->fields['isactive'] = $value['is_active'];
            $this->fields['timezonedetails'] = $value['meta_code'];
            $this->fields['combotype'] = $value['meta_type'];
            $this->type = $this->settingsModel->getcombotypevalues($this->fields['combotype']);
            foreach ($this->type as $value) {
                $this->fields['combotype'] = $value['type'];
            }
        }

        $this->template->display('viewsetting', $this->fields, 'settings', '');
    }

    /**
     * Used to add new metadata
     */
    public function index() {
        $this->logger->info("Action Index ");
        $this->template->display('listsettings');
    }

    /**
     * To manage metadata like view and edit the existing metadatas.
     */
    public function managesettingsview() {
        $this->logger->info("Action Manage Settings View ");
        $this->template->display('displaylistsettings', $this->combovalue, 'settings', '', '');
    }

    /**
     * Used to display existing metadata
     */
    public function displaysettingsview() {

        $this->logger->info("Action Display Settings View ");
        $id = $_POST["combotype"];
        $this->detailsvalue = $this->settingsModel->displaysettings($id);
        $this->fields['combotype'] = $id;
        $this->template->display_data('displaylistsettings', $this->combovalue, 'settings', $this->fields['combotype'], $this->detailsvalue);
    }

    /**
     * Used to update existing metadata while editing.
     */
    public function updatesettingsview() {

        $this->logger->info("Action Update Settings View ");
        $this->fields['id'] = $_POST["id"];
        $this->fields['combotype'] = $_POST["combotype"];
        $this->fields['Combovalue'] = $_POST["Combovalue"];
        $this->fields['meta_code'] = $_POST["timedetails"];

        if ($_POST["isactive"] == 'on') {
            $this->fields['isactive'] = 1;
        } else {
            $this->fields['isactive'] = 0;
        }

        $validResult = $this->settingsModel->updatecombovalue($this->fields);

        if ($validResult == 0) {

            $this->type = $this->settingsModel->getcombotypevalues($this->fields['combotype']);

            foreach ($this->type as $value) {
                $this->fields['combotype'] = $value['type'];
            }

            $this->template->display('viewsetting', $this->fields, 'settings');
        } else {

            $error = $this->settingsModel->geterror();
            $this->type = $this->settingsModel->getcombotypevalues($this->fields['combotype']);

            foreach ($this->type as $value) {
                $this->fields['combotype'] = $value['type'];
            }

            $this->template->display_data('listsettings', $this->fields, 'settings', $this->fields, '', $error);
        }
    }
}
