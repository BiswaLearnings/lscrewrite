<?php
//////////////////////////////////////////////////////////////////////////////////////////
//                                                                                      //
// NOTICE OF COPYRIGHT                                                                  //
//                                                                                      //
//                                                                                      //
//Copyright (C) 2010 onwards  Computer Sciences Corporation  http://www.csc.com         //
//                                                                                      //
// This program is free software: you can redistribute it and/or modify                 //
// it under the terms of the GNU General Public License as published by                 //
// the Free Software Foundation, either version 3 of the License, or                    //
// (at your option) any later version.                                                  //
//                                                                                      //
// This program is distributed in the hope that it will be useful,                      //
// but WITHOUT ANY WARRANTY; without even the implied warranty of                       //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                        //
// GNU General Public License for more details.                                         //
//                                                                                      //
//  You should have received a copy of the GNU General Public License                   //
//  along with this program.If not, see <http://www.gnu.org/licenses/>.                 //
//                                                                                      //
// @Created by: Venkatakrishnan                                                         //
// @date: 3/13/13  9:50 AM                                                              //
// @version: 1.0                                                                        //
// @description:                                                                        //
//                                                                                      //
////////////////////////////////////////////////////////////////////////////////////////// 

require_once __SITE_PATH . '/log4php/Logger.php';
require_once __SITE_PATH . '/app/models/RolesListModel.php';
require_once __SITE_PATH . '/app/models/RolesModel.php';
require_once __SITE_PATH . '/app/models/certificateModel.php';
require_once __SITE_PATH . '/libs/DBUtil.php';

/*The roles controller used for Adding/Deleting roles.*/
class RolesController extends baseController
{
    private $_logger;
    private $_template;


    public function __construct()
    {
        $this->_template = new Template();
        $this->_logger = Logger::getLogger("Roles Controller");
    }

    public function index() {}

    /**
     * The action method for Roles listing page
     * The method runs only when the account ID is 
     * passed. Otherwise it means that it is an
     * illegal request and hence will redirect to
     * 404 page not found
     */
    function roleList($accountID)
    {
        $this->_logger->info("Action: Role List");
        if(isset($accountID))
        {
            $roleListModel = new RolesListModel();
            $data = array();
            $data["roles"] = $roleListModel->getRolesData($accountID);
            $data["accountID"] = $accountID;
            $this->_template->display('roleList', $data, 'role');
            $this->_logger->info("Role list displayed successfully to user");
        }
        else
        {
            $this->_logger->info("Invalid request made to roles/roleList");
            $this->_template->display('Error404', '', '');
        }
    }

    /*
     * The action method for Role Deletion
     * Deletes the role and displays the role listing
     * page again.
     */
    function deleteRole($data)
    {
        $this->_logger->info("Action: Role List");
        if(count($data) < 2)
        {
            $this->_logger->info("Invalid request made to roles/deleteRole");
            $this->_template->display('Error404', '', '');
            return;
        }
        $rolesModel = new RolesListModel();
        $rolesModel->deleteRole($data[1]);
        $this->_logger->info("RoleID : {$data[1]} successfully deleted from table.");
        $this->roleList($data[0]);
    }

    /*
     * This action method creates a new role under
     * the given account. If the accountID is not
     * passed, then 404 is thrown.
     */
    function addRole($accountID)
    {
        $this->_logger->info("Action: Add Role");
        if(isset($accountID))
        {
            $this->_logger->info("Request for adding new role under AccountID:{$accountID}");
            $model = new RolesModel();
            $data = array('submissionURL' => sprintf('?load=roles/processAddRole/%s', $accountID), 'accountID' => $accountID);
            $pageFields = $model->fetchPageDataForRoleCreation($accountID);
            $this->_template->display_data('RoleAndSignature', $data, 'role', $pageFields);
            $this->_logger->info("Successfully displayed Add Role screen");
        }
        else
        {
            $this->_logger->info("Invalid request made to roles/addRole");
            $this->_template->display('Error404', '', '');
        }
    }

    /*
     * This method processes the role processing. Basically this is the
     * action that processes the POST from addRoles and does the validation.
     */
    function processAddRole($accountID)
    {
        $this->_logger->info("Action: Process Add Role");
        $this->_logger->info("Processing data obtained for the New Role under AccountID : $accountID");
        $model = new RolesModel();
        $data = array('submissionURL' => sprintf('?load=roles/processAddRole/%s', $accountID), 'accountID' => $accountID);
        $errors = $model->validateAndReturnErrors();
        if(!empty($errors))
        {
            $this->_logger->error("Following errors found while processing : ". implode(';', $errors));
            $this->_template->display_data('RoleAndSignature', $data, 'role', $model->fetchPageDataForRoleCreation($accountID), '', $errors);
        }
        else
        {
            $this->_logger->info("No Errors found while processing.");
            $model->saveRole($accountID);
            $this->roleList($accountID);
            $this->_logger->info("Successfully added new role");
        }
    }

    /*
     * This action method is for editing a current role with
     * the give roleID. If role id is not passed 404 is thrown.
     */
    function editRole($roleID)
    {
        $this->_logger->info("Action: Edit Role");
        $model = new RolesModel();
        if(isset($roleID))
        {
            $this->_logger->info("Request for editing role. RoleID : {$roleID}");
            $pageFields = $model->fetchPageDataForRoleEditing($roleID);
            $data = array('submissionURL' => sprintf('?load=roles/processEditRole/%s', $roleID), 'accountID' => $model->getAccountID());
            $this->_template->display_data('RoleAndSignature', $data, 'role', $pageFields);
            $this->_logger->info("Successfully displayed Edit Role screen");
        }
        else
        {
            $this->_logger->info("Invalid request made to roles/editRole");
            $this->_template->display('Error404', '', '');
        }
    }

    /*
     * This action method processes the POST request received from
     * roles/editRole. If does the validation and updates the database.
     */
    function processEditRole($roleID)
    {
        $this->_logger->info("Action: Process Edit Role");
        $this->_logger->info("Processing data obtained for editing the role with RoleID : {$roleID}");
        $model = new RolesModel();
        $errors = $model->validateAndReturnErrors();
        if(!empty($errors))
        {
            $this->_logger->error("Following errors found while processing : ". implode(';', $errors));
            $pageData = $model->fetchPageDataForRoleEditing($roleID);
            $data = array('submissionURL' => sprintf('?load=roles/processEditRole/%s', $roleID), 'accountID' => $model->getAccountID());
            $this->_template->display_data('RoleAndSignature', $data, 'role', $pageData, '', $errors);
        }
        else
        {
            $this->_logger->info("No Errors found while processing.");
            $model->updateRole($roleID);
            $this->roleList($model->getAccountID());
            $this->_logger->info("Successfully edited role with RoleID : {$roleID}");
        }
    }
    
	/**
     * @author Biswakalyana Mohanty
     * showCertificate($roleId):
     * This will call getCertificateDetails() of certficateModel.php
     * Call the generateCertificate.php file
     */
    function showCertificate($roleId)
    {
    	$certificateModel = new certificateModel();
    	$certificateDetails=$certificateModel->getCertificateDetails($roleId);
    	$this->_template->display('generateCertificate', $certificateDetails, 'role');
    }
}
