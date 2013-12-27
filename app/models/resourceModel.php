<?php

/**
 * Description of resourceModel
 *
 * @author amahalingam
 */
require_once __SITE_PATH . '/libs/Form.php';
require_once __SITE_PATH . '/libs/WebUtil.php';
require_once __SITE_PATH . '/libs/DBUtil.php';
require_once __SITE_PATH . '/log4php/Logger.php';

class resourceModel {
    /*
     * Variables
     */

    private $shortId;
    private $firstName;
    private $lastName;
    private $email;
    private $city;
    private $country;
    private $timezone;
    private $plmShortId;
    private $empStatus;
    private $productline;
    private $rmShortId;
    private $workRegion;
    private $userRole = array();
    private $isActive;
    private $form;
    private $logger;
    private $dbUtil;

    /**
     *
     */
    public function __construct() {
        $this->form = new Form();
        $this->logger = Logger::getLogger("Resource Model");
        $this->dbUtil = new DBUtil();
    }

    /**
     *
     * @param type $shortid
     */
    public function setShortid($shortid) {
        $this->shortId = $shortid;
    }

    /**
     *
     * @return type
     */
    public function getShortid() {
        return $this->shortId;
    }

    /**
     *
     * @param type $firstname
     */
    public function setFirstName($firstname) {
        $this->firstName = $firstname;
    }

    /**
     *
     * @return type
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     *
     * @param type $lastname
     */
    public function setLastName($lastname) {
        $this->lastName = $lastname;
    }

    /**
     *
     * @return type
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     *
     * @param type $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     *
     * @return type
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     *
     * @param type $city
     */
    public function setCity($city) {
        $this->city = $city;
    }

    /**
     *
     * @return type
     */
    public function getCity() {
        return $this->city;
    }

    /**
     *
     * @param type $country
     */
    public function setCountry($country) {
        $this->country = $country;
    }

    /**
     *
     * @return type
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     *
     * @param type $plm_shortid
     */
    public function setPlmShortId($plm_shortid) {
        $this->plmShortId = $plm_shortid;
    }

    /**
     *
     * @return type
     */
    public function getPlmShortId() {
        return $this->plmShortId;
    }

    /**
     *
     * @param type $emp_status
     */
    public function setEmpStatus($emp_status) {
        $this->empStatus = $emp_status;
    }

    /**
     *
     * @return type
     */
    public function getEmpStatus() {
        return $this->empStatus;
    }

    /**
     *
     * @param type $productline
     */
    public function setProductLine($productline) {
        $this->productline = $productline;
    }

    /**
     *
     * @return type
     */
    public function getProductLine() {
        return $this->productline;
    }

    /**
     *
     * @param type $timezone
     */
    public function setTimezone($timezone) {
        $this->timezone = $timezone;
    }

    /**
     *
     * @return type
     */
    public function getTimezone() {
        return $this->timezone;
    }

    /**
     *
     * @param type $rm_shortid
     */
    public function setRmShortId($rm_shortid) {
        $this->rmShortId = $rm_shortid;
    }

    /**
     *
     * @return type
     */
    public function getRmShortId() {
        return $this->rmShortId;
    }

    /**
     *
     * @param type $workregion
     */
    public function setWorkRegion($workregion) {
        $this->workRegion = $workregion;
    }

    /**
     *
     * @return type
     */
    public function getWorkRegion() {
        return $this->workRegion;
    }

    /**
     *
     * @param type $userRole
     */
    public function setUserRole($userRole) {
        $this->userRole = $userRole;
    }

    /**
     *
     * @return type
     */
    public function getUserRole() {
        return $this->userRole;
    }

    /**
     *
     * @param type $userRole
     */
    public function setIsActive($isactive) {
        $this->isActive = $isactive;
    }

    /**
     *
     * @return type
     */
    public function getIsActive() {
        return $this->isActive;
    }

    public function save($table, $data, $rows) {
        $this->dbUtil->insert($table, $data, $rows);
    }

    public function update($table, $set, $where) {
        $this->dbUtil->update($table, $set, $where);
    }

    /**
     *
     */
    function populateTimeZones() {
        $timezones = $this->dbUtil->getTimeZones();
        return $timezones;
    }

    /**
     *
     * @return type
     */
    function populateProductlines() {
        return $this->dbUtil->getProduclines();
    }

    /**
     *
     * @return type
     */
    function populateEmpStatuses() {
        return $this->dbUtil->getEmpStatus();
    }

    /**
     *
     * @return type country
     */
    function populateCountry() {

        return $this->dbUtil->getCountry();
    }

    /**
     *
     */
    function populateWorkRegions() {
        return $this->dbUtil->getWorkRegions();
    }

    /**
     *
     */
    function populateUserRoles() {
        return $this->dbUtil->getUserRole();
    }


	/**
     *
     * @return array
     */
    public function getValues() {

        $vars['shortid'] = $this->form->value('shortid');
        $vars['firstName'] = $this->form->value('firstName');
        $vars['lastName'] = $this->form->value('lastName');
        $vars['email'] = $this->form->value('email');
        $vars['city'] = $this->form->value('city');
        $vars['country'] = $this->form->value('country');
        $vars['timezone'] = $this->form->value('timezone');
        $vars['plm_shortid'] = $this->form->value('plm_shortid');
        $vars['productline'] = $this->form->value('productline');
        $vars['emp_status'] = $this->form->value('emp_status');
        $vars['rm_shortid'] = $this->form->value('rm_shortid');
        $vars['work_region'] = $this->form->value('work_region');
        $vars['user_role'] = $this->form->value('user_role');
        $vars['isActive'] = $this->form->value('isActive');
        return $vars;
    }


    /**
     *
     * @return array
     */
    public function getSubmittedValues() {

        $vars['shortid'] = $this->form->value('shortid');
        $vars['firstName'] = $this->form->value('firstName');
        $vars['lastName'] = $this->form->value('lastName');
        $vars['email'] = $this->form->value('email');
        $vars['city'] = $this->form->value('city');
        $vars['country'] = $this->form->value('country');
        $vars['timezone'] = $this->form->value('timezone');

		$webUtil = new WebUtil();
		$plm_short_id = $this->form->value('plm_shortid');
		 $rows = "id,user_name";
        $where = "id='$plm_short_id'";
        $plm_result = $this->dbUtil->select(TBL_USERS, $rows, $where);

		foreach ($plm_result as $value) {
			$plm_name = $value[user_name];
			$plm_id = $value[id];
		}

        $vars['plm_username'] = $plm_name;
		$vars['plm_shortid'] = $plm_id;
        $vars['productline'] = $this->form->value('productline');
        $vars['emp_status'] = $this->form->value('emp_status');
		$rm_short_id=$this->form->value('rm_shortid');
		$rows = "id,user_name";
        $where = "id='$rm_short_id'";
        $rm_result = $this->dbUtil->select(TBL_USERS, $rows, $where);

		foreach ($rm_result as $value) {
			$rm_name = $value[user_name];
			$rm_id = $value[id];
		}

        $vars['rm_username'] = $rm_name;
		$vars['rm_shortid'] = $rm_id;
        $vars['work_region'] = $this->form->value('work_region');
        $vars['user_role'] = $this->form->value('user_role');
        $vars['isActive'] = $this->form->value('isActive');
        return $vars;
    }

    /**
     *
     * @return array
     */
    public function getErrors() {
        $vars['emptyData'] = $this->form->error('emptyData');
        $vars['shortid'] = $this->form->error('shortid');
        $vars['firstName'] = $this->form->error('firstName');
        $vars['lastName'] = $this->form->error('lastName');
        $vars['email'] = $this->form->error('email');
        $vars['timezone'] = $this->form->error('timezone');
        $vars['plmShortId'] = $this->form->error('plm_shortid');
        $vars['rmShortId'] = $this->form->error('rm_shortid');
        $vars['user_role'] = $this->form->error('user_role');
        $vars['user_exists'] = $this->form->error('user_exists');
        $vars['email_exists'] = $this->form->error('email_exists');
        $vars['plm_not_exists'] = $this->form->error('plm_not_exists');
        $vars['rm_not_exists'] = $this->form->error('rm_not_exists');
        return $vars;
    }

    /**
     * Validation
     * @return boolean
     */
    public function validate() {
        $this->logger->info("Start: Resource Validation!");
        $webUtil = new WebUtil();
        $user_result = $this->dbUtil->getUserInfo($this->shortId);

        //Short Id.
        if ($webUtil->is_empty($this->shortId)) {
            $this->form->setError('shortid', "Please enter your short id.");
        } else if ($webUtil->isNumeric($this->shortId)) {
            $this->form->setError('shortid', "Numeric is not allowed for Short Id.");
        } else if ($webUtil->isSpecialCharExists($this->shortId)) {
            $this->form->setError('shortid', "Special characters are not allowed in Short Id.");
        } else if (($user_result['user_name'] == $this->shortId) && ($_POST['update']!='update')) {
            $this->form->setError('user_exists', "This username(<b>".$this->shortId."</b>) already exists.");
	    $this->form->setValue('shortid', $this->shortId);
        } else {
            $this->form->setValue('shortid', $this->shortId);
        }

        //First Name.
        if ($webUtil->is_empty($this->firstName)) {
            $this->form->setError('firstName', "Please enter your firstname.");
        } else if ($webUtil->isNumeric($this->firstName)) {
            $this->form->setError('firstName', "Numeric is not allowed for Firstname.");
        } else if ($webUtil->isStringContainsNumbers($this->firstName)) {
            $this->form->setError('firstName', "Alpha Numeric is not allowed for Firstname.");
        } else if ($webUtil->isSpecialCharExists($this->firstName)) {
            $this->form->setError('firstName', "Special characters are not allowed in First Name.");
        } else {
            $this->form->setValue('firstName', $this->firstName);
        }

        //Last Name
        if ($webUtil->is_empty($this->lastName)) {
            $this->form->setError('lastName', "Please enter your lastname.");
        } else if ($webUtil->isNumeric($this->lastName)) {
            $this->form->setError('lastName', "Numeric is not allowed for Lastname.");
        } else if ($webUtil->isStringContainsNumbers($this->lastName)) {
            $this->form->setError('lastName', "Alpha Numeric is not allowed for Lastname.");
        } else if ($webUtil->isSpecialCharExists($this->lastName)) {
            $this->form->setError('lastName', "Special characters are not allowed in Lastname.");
        } else {
            $this->form->setValue('lastName', $this->lastName);
        }

        //Email
        if ($webUtil->is_empty($this->email)) {
            $this->form->setError('email', "Please enter your email address.");
        } else if ($webUtil->isValidEmailAddress($this->email)) {
            $this->form->setError('email', "Please enter valid email.");
        } else if (($user_result['email_address'] == $this->email) && ($_POST['update']!='update')) {
            $this->form->setError('email_exists', "This Email Address (<b>".$this->email."</b>) already exists.");
			$this->form->setValue('email', $this->email);
        } else {
            $this->form->setValue('email', $this->email);
        }

        //No validation for city, country, emp_status, region
        if (!$webUtil->is_empty($this->city)) {
            $this->form->setValue('city', $this->city);
        }

        if (!$webUtil->is_empty($this->country)) {
            $this->form->setValue('country', $this->country);
        }

        if (!$webUtil->is_empty($this->productline)) {
            $this->form->setValue('productline', $this->productline);
        }

        if (!$webUtil->is_empty($this->empStatus)) {
            $this->form->setValue('emp_status', $this->empStatus);
        }

        if (!$webUtil->is_empty($this->workRegion)) {
            $this->form->setValue('work_region', $this->workRegion);
        }


        if (!$webUtil->is_empty($this->isActive)) {
            $this->form->setValue('isActive', $this->isActive);
        }

        if ($webUtil->is_empty($this->timezone)) {
            $this->form->setError('timezone', "Please enter your timezone.");
        } else {
            $this->form->setValue('timezone', $this->timezone);
        }

        //PLM Short Id
        $pl_result = $this->dbUtil->getUserInfo($this->plmShortId);
        if ($webUtil->is_empty($this->plmShortId)) {
            $this->form->setError('plm_shortid', "Please enter your plm shortid.");
        } else if ($webUtil->isNumeric($this->plmShortId)) {
            $this->form->setError('plm_shortid', "Numeric is not allowed for plm shortid.");
        } else if ($webUtil->isSpecialCharExists($this->plmShortId)) {
            $this->form->setError('plm_shortid', "Special characters are not allowed in plm shortid.");
        } else if (!isset($pl_result[id])) {
            $this->form->setError('plm_not_exists', "PL Manager not exists. Please enter existing one.");
			 $this->form->setValue('plm_shortid', $pl_result[id]);
        } else {
            $this->form->setValue('plm_shortid', $pl_result[id]);
        }

        //Resource Manager Shortid.
        $rm_result = $this->dbUtil->getUserInfo($this->rmShortId);
        if ($webUtil->is_empty($this->rmShortId)) {
            $this->form->setError('rm_shortid', "Please enter your resource manger shortid.");
        } else if ($webUtil->isNumeric($this->rmShortId)) {
            $this->form->setError('rm_shortid', "Numeric is not allowed for resource manger shortid.");
        } else if ($webUtil->isSpecialCharExists($this->rmShortId)) {
            $this->form->setError('rm_shortid', "Special characters are not allowed in resource manger shortid.");
        } else if (!isset($rm_result[id])) {
            $this->form->setError('rm_not_exists', "Resource Manager not exists. Please enter existing one.");
			$this->form->setValue('rm_shortid', $rm_result[id]);
        } else {
            $this->form->setValue('rm_shortid', $rm_result[id]);
        }

        if ($webUtil->is_empty($this->userRole)) {
            $this->form->setError('user_role', "Please enter your user role.");
        } else {
            if (is_array($this->userRole)) {
                $this->form->setValue('user_role', substr(implode(', ', $this->userRole), 0));
            } else {
                $this->form->setValue('user_role', $this->userRole);
            }
        }

        $errors = $this->getErrors();

        $this->logger->info("Validation: errors Identified");
        $e_count = $webUtil->array_value_count($errors);
        if ($e_count == 0) {
            $this->logger->info("End: Resource Validation errors are not exists");
            return TRUE;
        } else {
            $this->logger->info("End: Resource Validation errors are exists");
            return FALSE;
        }
    }

}

?>
