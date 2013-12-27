<?php

//////////////////////////////////////////////////////////////////////////////////////////
//                                                                       	   			//
// NOTICE OF COPYRIGHT                                                   	   			//
//                                                                       	   			//
//                                                                       	   			//
//Copyright (C) 2010 onwards  Computer Sciences Corporation  http://www.csc.com    		//
//                                                                       	   			//
// This program is free software: you can redistribute it and/or modify  	   			//
// it under the terms of the GNU General Public License as published by  	   			//
// the Free Software Foundation, either version 3 of the License, or     	   			//
// (at your option) any later version.                                   	   			//
//                                                                                 		//
// This program is distributed in the hope that it will be useful,                 		//
// but WITHOUT ANY WARRANTY; without even the implied warranty of                  		//
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                   		//
// GNU General Public License for more details.                                    		//
//                                                                                 		//
//  You should have received a copy of the GNU General Public License              		//
//  along with this program.If not, see <http://www.gnu.org/licenses/>.            		//
//							                           									//
// @Created by Achappan Mahalingam                                                      //
// @date 2012-12-12                                                      	   			//
// @version 1.0								       										//
// @description:                              				//
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php

require_once __SITE_PATH . '/app/models/resourceModel.php';
require_once (__SITE_PATH . '/libs/db.php');
require_once (__SITE_PATH . '/libs/DBUtil.php');
require_once (__SITE_PATH . '/libs/WebUtil.php');
require_once __SITE_PATH . '/log4php/Logger.php';
require_once __SITE_PATH . '/libs/Form.php';

/**
 *
 */
class resourceController extends baseController{

    private $model;
    private $template;
    private $logger;
    private $db;
    private $dbUtil;
    private $webUtil;
    private $dbConnection;
    private $form;

    /**
     * To intialise object of this class.
     */
    public function __construct() {
        $this->template = new Template();
        $this->model = new resourceModel();
        $this->logger = Logger::getLogger("Resource Controller");
        $this->db = new db();
        $this->dbConnection = $this->db->getConnection();
        $this->dbUtil = new DBUtil();
        $this->webUtil = new WebUtil();
        $this->form = new Form();
    }

    public function index() {
      $this->template->display('resource');
    }

    /**
     *
     */
    public function addResource() {

        $this->logger->info("Action: Add Resource");

        if ($this->setFormData()) {

            //Validate
            $validation = $this->model->validate();
            $this->logger->info("Validation result : $validation");

            //To retrieve Validation errors
            $errors = $this->model->getErrors();

            $productlines = $this->model->populateProductlines();
            $work_regions = $this->model->populateWorkRegions();
            $timezones = $this->model->populateTimeZones();
            $emp_statuses = $this->model->populateEmpStatuses();

            $countries = $this->model->populateCountry();

            $submitted = $this->model->getSubmittedValues();

            $data = array('errors' => $errors, 'fields' => $submitted, 'emp_statuses' => $emp_statuses, 'productlines' => $productlines, 'work_regions' => $work_regions, 'country' => $countries, 'timezones' => $timezones);

            foreach ($data as $errors) {
                foreach ($errors as $key => $values) {
                    foreach ($values as $key => $value) {
                        $this->logger->debug("Validation errors : $value ");
                    }
                }
            }

            if ($validation == TRUE) {
                $this->logger->info("Validation Success! Saving data into db");
                $this->saveResource($this->model->getValues());
                $success = $this->form->value('success');
                $this->template->display($success, $data, 'user', $submitted);
            } else {

                $count = $this->webUtil->array_value_count($submitted);
                if ($count == 0) {
                    $this->form->setValue('mandatory', "Mandatory fields are required!");
                    $data['mandatory'] = $this->form->value('mandatory');
                    $this->template->display('addResource', $data, 'user', $submitted);
                } else {
                    $this->template->display('addResource', $data, 'user', $submitted);
                }
            }
        } else {
            $productlines = $this->model->populateProductlines();
            $work_regions = $this->model->populateWorkRegions();
            $timezones = $this->model->populateTimeZones();
            $emp_statuses = $this->model->populateEmpStatuses();
            $country = $this->model->populateCountry();
            $data = array('emp_statuses' => $emp_statuses, 'productlines' => $productlines, 'work_regions' => $work_regions, 'country' => $country, 'timezones' => $timezones);

            $this->template->display('addResource', $data, 'user');
        }
    }

    /**
     *
     * @param type $callback
     */
    public function saveResource($callback) {
        if (isset($callback) || $callback != null) {
            $rows = array('user_name', 'first_name', 'last_name', 'email_address', 'city', 'country', 'time_zone', 'pl_managerid', 'product_line', 'employee_type', 'reporting_managerid', 'region', 'role', 'is_active');

            $this->model->save(TBL_USERS, $callback, $rows);
            $this->form->setValue("success", "successUser");
            $this->logger->info("Data inserted Successfully on table");
        }
    }

    /**
     *
     * @param type $id
     */
    public function editResource($id) {
        $this->logger->info("Start: Edit resource");

        $rows = "*";
        $where = "id=$id";
        $result = $this->dbUtil->select(TBL_USERS, $rows, $where);

        $productlines = $this->model->populateProductlines();
        $work_regions = $this->model->populateWorkRegions();
        $timezones = $this->model->populateTimeZones();
        $emp_statuses = $this->model->populateEmpStatuses();
        $user_roles = $this->model->populateUserRoles();
        $countries = $this->model->populateCountry();

        foreach ($result as $key => $value) {
            $pl_managerid = $value[pl_managerid];
            $reporting_managerid = $value[reporting_managerid];
        }
        $plm = $this->dbUtil->getPLManagerName($pl_managerid);

        $rm = $this->dbUtil->getResourceManagerName($reporting_managerid);
        $data = array('fields' => $result, 'plm_name' => $plm, 'rm_name' => $rm, 'emp_statuses' => $emp_statuses, 'productlines' => $productlines, 'work_regions' => $work_regions, 'country' => $countries, 'timezones' => $timezones, 'user_roles' => $user_roles);
        $this->logger->info("End: Edit resource");
        $this->template->display('editResource', $data, 'user');
    }

    /**
     *
     * @param type $data
     */
    public function updateResource($data) {
        $this->logger->info("Start: update resource");
        $countries = array();
        if ($this->setFormData()) {

            //Validate
            $validation = $this->model->validate();
            $this->logger->info("Validation result while updation: $validation");

            //To retrieve Validation errors
            $errors = $this->model->getErrors();

            $productlines = $this->model->populateProductlines();
            $work_regions = $this->model->populateWorkRegions();
            $timezones = $this->model->populateTimeZones();
            $emp_statuses = $this->model->populateEmpStatuses();

            $countries = $this->model->populateCountry();


            $submitted = $this->model->getSubmittedValues();

            $data = array('errors' => $errors, 'callbacks' => $submitted, 'emp_statuses' => $emp_statuses, 'productlines' => $productlines, 'work_regions' => $work_regions, 'country' => $countries, 'timezones' => $timezones);

            foreach ($data as $obj_key => $errors) {
                foreach ($errors as $key => $values) {
                    foreach ($values as $key => $value) {
                        $this->logger->debug("Validation errors : $value ");
                    }
                }
            }

            if ($validation == TRUE) {
                $this->logger->info("Validation Success! updating datas into db");

                $set = array("user_name='$submitted[shortid]'", "first_name='$submitted[firstName]'",
                    "last_name='$submitted[lastName]'", "email_address='$submitted[email]'",
                    "city= '$submitted[city]'", "country='$submitted[country]'", "time_zone= '$submitted[timezone]' ",
                    "pl_managerid=$submitted[plm_shortid]", "product_line='$submitted[productline]'",
                    "employee_type='$submitted[emp_status]'", "reporting_managerid=$submitted[rm_shortid]",
                    "region='$submitted[work_region]'", "role='$submitted[user_role]'", "is_active='$submitted[isActive]'");
                $where = "user_name='$submitted[shortid]'";
                $this->model->update(TBL_USERS, $set, $where);
                $this->template->display('success');
            } else {

                $count = $this->webUtil->array_value_count($submitted);
                if ($count == 0) {
                    $this->form->setValue('mandatory', "Mandatory fields are required!");
                    $data['mandatory'] = $this->form->value('mandatory');
                    $this->template->display('editResource', $data, 'user', $submitted);
                } else {
                    $this->template->display('editResource', $data, 'user', $submitted);
                }
            }
        } else {
            $productlines = $this->model->populateProductlines();
            $work_regions = $this->model->populateWorkRegions();
            $timezones = $this->model->populateTimeZones();
            $emp_statuses = $this->model->populateEmpStatuses();
            $country = $this->model->populateCountry();

            $data = array('emp_statuses' => $emp_statuses, 'productlines' => $productlines, 'work_regions' => $work_regions, 'country' => $country, 'timezones' => $timezones);
            $this->template->display('editResource', $data, 'user');
        }
        $this->logger->info("End: update resource");
    }

    /**
     *
     */
    public function viewResource() {

        $data = $this->dbUtil->select(TBL_USERS);
        $this->template->display('viewResource', $data, 'user', '');
    }

    /**
     *
     * @param type $id
     */
    public function resourceProfile($id) {

        $rows = "*";
        $where = "id=$id";
        $result = $this->dbUtil->select(TBL_USERS, $rows, $where);

        foreach ($result as $value) {
            $pl_managerid = $value[pl_managerid];
            $reporting_managerid = $value[reporting_managerid];
        }

        $plm = $this->dbUtil->getPLManagerName($pl_managerid);

        $rm = $this->dbUtil->getResourceManagerName($reporting_managerid);

        $productlines = $this->model->populateProductlines();
        $work_regions = $this->model->populateWorkRegions();
        $timezones = $this->model->populateTimeZones();
        $emp_statuses = $this->model->populateEmpStatuses();
        $user_roles = $this->model->populateUserRoles();
        $countries = $this->model->populateCountry();
        $data = array('fields' => $result, 'plm_name' => $plm, 'rm_name' => $rm, 'emp_statuses' => $emp_statuses, 'productlines' => $productlines, 'work_regions' => $work_regions, 'country' => $countries, 'timezones' => $timezones, 'user_roles' => $user_roles);

        $this->template->display('resourceProfile', $data, 'user');
    }

    /**
     *
     */
    public function bulkUploadResource() {

        if (isset($_POST['submit'])) {

            $filepath = __SITE_PATH . "/tmp/";

            $filename = $_FILES["importFile"]["name"];
            $ext = explode('.', $filename);

            if ($ext[1] == 'csv' || $ext[1] == 'xls' || $ext[1] == 'xlsx') {

                $file = $filepath . $filename;

                move_uploaded_file($_FILES['importFile']['tmp_name'], $file);

                $handle = fopen($file, 'r');
                $i = 0;
                $excel_datas = array();

                while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                    $i++;
                    $rows = array('user_name', 'first_name', 'last_name',
                        'email_address', 'city', 'country', 'time_zone',
                        'pl_managerid', 'product_line', 'employee_type',
                        'reporting_managerid', 'region', 'role', 'is_active');

                    if ($i != 1) {

                        $user_result = $this->dbUtil->getUserInfo($data[0]);

                        if ($this->webUtil->is_empty($data[0])) {
                            $this->form->setError('u_empty_errors' . $i . ' ', 'Empty data not allowed at column ' . $i . '');
                        } else if ($this->webUtil->isNumeric($data[0])) {
                            $this->form->setError('u_numeric_errors' . $i . ' ', 'Digits are not allowed at column ' . $i . ' => ' . $data[0] . '');
                        } else if ($this->webUtil->isSpecialCharExists($data[0])) {
                            $this->form->setError('u_schar_errors' . $i . ' ', 'Special characters not allowed at column ' . $i . ' => ' . $data[0] . '');
                        } else if (($user_result['user_name'] == $data[0]) && ($_POST['update'] != 'update')) {
                            $this->form->setError('user_exists', "This username(<b>" . $data[0] . "</b>) already exists.");
                        } else {
                            $excel_datas[$i]['username'] = $data[0];
                        }

                        $excel_datas[$i]['firstname'] = $data[1];
                        $excel_datas[$i]['lastname'] = $data[2];
                        $email_result = $this->dbUtil->searchEmail($data[3]);

                        if ($this->webUtil->is_empty($data[3])) {
                            $this->form->setError('email_empty_errors' . $i . ' ', 'Empty data not allowed at column ' . $i . '');
                        } else if ($this->webUtil->isNumeric($data[3])) {
                            $this->form->setError('email_numeric_errors' . $i . ' ', 'Digits are not allowed at column ' . $i . ' => ' . $data[3] . '');
                        } else if ($this->webUtil->isValidEmailAddress($data[3])) {
                            $this->form->setError('email_error', '' . $data[3] . ' is not a valid email address at column ' . $i . '.');
                        } else if ((!empty($email_result)) && ($_POST['update'] != 'update')) {
                            $this->form->setError('email_exists', "This Email Address (<b>" . $data[3] . "</b>) already exists.");
                            $this->form->setValue('email', $this->email);
                        } else {
                            $excel_datas[$i]['email_address'] = $data[3];
                        }

                        $excel_datas[$i]['city'] = $data[4];


                        $excel_datas[$i]['country'] = $data[5];

                        $plm = $this->dbUtil->getUserInfo($data[7]);

                        if ($this->webUtil->is_empty($data[7])) {
                            $this->form->setError('plm_empty_errors_' . $i . ' ', 'Empty data not allowed at column ' . $i . '');
                        } else if ($this->webUtil->isNumeric($data[7])) {
                            $this->form->setError('plm_numeric_errors' . $i . ' ', 'Digits are not allowed at column ' . $i . ' => ' . $data[7] . '');
                        } else if (empty($plm['id'])) {
                            $this->form->setError('plm_exists', "This plm (<b>" . $data[7] . "</b>) not exists in LSC System.");
                        } else {
                            $excel_datas[$i]['pl_manager_id'] = $plm['id'];
                        }

                        $rm = $this->dbUtil->getUserInfo($data[10]);

                        if ($this->webUtil->is_empty($data[10])) {
                            $this->form->setError('rm_empty_errors_' . $i . ' ', 'Empty data not allowed at column ' . $i . '');
                        } else if ($this->webUtil->isNumeric($data[10])) {
                            $this->form->setError('rm_numeric_errors' . $i . ' ', 'Digits are not allowed at column ' . $i . ' => ' . $data[10] . '');
                        } else if (empty($rm['id'])) {
                            $this->form->setError('rm_exists', "This Resource manager (<b>" . $data[10] . "</b>) not exists.");
                        } else {
                            $excel_datas[$i]['rm_shortid'] = $rm['id'];
                        }

                        if ($this->webUtil->is_empty($data[12])) {
                            $this->form->setError('role_empty_errors_' . $i . ' ', 'Empty data not allowed at column ' . $i . '');
                        } else if (!$this->webUtil->isNumeric($data[12])) {
                            $this->form->setError('role_alnumeric_errors' . $i . ' ', 'Characters not allowed at column ' . $i . '');
                        } else {
                            $excel_datas[$i]['role'] = $data[12];
                        }

                        $excel_datas[$i]['isactive'] = $data[13];

                        $e_count = $this->webUtil->array_value_count($this->form->getErrorArray());

                        if ($e_count == 0) {
                            $data[7] = $plm['id'];
                            $data[10] = $rm['id'];
                            $this->dbUtil->insert(TBL_USERS, $data, $rows);
                        }
                    }
                }

                $errors = $this->form->getErrorArray();

                if ($e_count != 0) {
                    $callback = $errors;
                    $this->template->display('bulkUploadResource', $data = null, 'user', $callback);
                } else {
                    if (!empty($excel_datas)) {
                        $data = $excel_datas;

                        $this->template->display('bulkUploadResource', $data, 'user');
                    }
                }
                fclose($handle);
                unlink($file);
            } else {
                echo "Invalid file";
            }
        } else {
            $this->template->display('bulkUploadResource', '', 'user');
        }
    }

    /**
     *
     * @return boolean
     */
    public function setFormData() {
        if (isset($_POST['submit'])) {
            //set shortid
            $this->model->setShortid(htmlspecialchars($_POST['shortId']));
            //set firstname
            $this->model->setFirstName(htmlspecialchars($_POST['firstName']));
            //set lastname
            $this->model->setLastName(htmlspecialchars($_POST['lastName']));
            //set email
            $this->model->setEmail(htmlspecialchars($_POST['email']));
            //set city
            $this->model->setCity(htmlspecialchars($_POST['city']));
            //set country
            $this->model->setCountry(htmlspecialchars($_POST['country']));
            //set timezone
            $this->model->setTimezone(htmlspecialchars($_POST['timezone']));
            //set plm shortid
            $this->model->setPlmShortId(htmlspecialchars($_POST['plm_shortid']));
            //set productline

            $this->model->setProductLine(htmlspecialchars($_POST['productline']));
            //set employee status
            $this->model->setEmpStatus(htmlspecialchars($_POST['emp_status']));
            //set plm resource manager shortid
            $this->model->setRmShortId(htmlspecialchars($_POST['rm_shortid']));
            //set work region
            $this->model->setWorkRegion(htmlspecialchars($_POST['work_region']));
            //set user role
            $this->model->setUserRole($_POST['role']);
            //set isActive
            if (isset($_POST['isActive'])) {
                $this->model->setIsActive(1);
            } else {
                $this->model->setIsActive(0);
            }
            return true;
        }
    }

}
?>

