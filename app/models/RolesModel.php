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
// @date: 3/18/13  1:58 PM                                                              //
// @version: 1.0                                                                        //
// @description:                                                                        //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////

require_once (__SITE_PATH . '/libs/DBUtil.php');
require_once (__SITE_PATH . '/libs/WebUtil.php');

class RolesModel
{
    /* Private properties for the roles controls */
    private $_roleName;
    private $_roleShortName;
    private $_certificateName;
    private $_roleKModuleDefnOwner;
    private $_roleKModuleDefnApprover;
    private $_orgUnitHeadDesignation;
    private $_orgUnitHeadSignature;
    private $_verticalHeadDesignation;
    private $_verticalHeadSignature;
    private $_productLineManagerDesignation;
    private $_productLineManagerSignature;

    /* Private properties for the check boxes */
    private $_changeOrgUnitHeadSign;
    private $_reqNewOrgUnitHeadSign;
    private $_changeVerticalHeadSign;
    private $_reqNewVerticalHeadSign;
    private $_changeProductLineManagerSign;
    private $_reqNewProductLineManagerSign;
    private $_accountID;

    /* Other private properties */
    private $_dbUtil;

    /* Getters and Setters for the properties */
    #region Getters And Setters (Expand to see)
    public function setCertificateName($certificateName)
    {
        $this->_certificateName = $certificateName;
    }

    public function getCertificateName()
    {
        return $this->_certificateName;
    }

    public function setChangeOrgUnitHeadSign($changeOrgUnitHeadSign)
    {
        $this->_changeOrgUnitHeadSign = $changeOrgUnitHeadSign;
    }

    public function getChangeOrgUnitHeadSign()
    {
        return empty($this->_changeOrgUnitHeadSign) ? '' : 'checked';
    }

    public function setChangeProductLineManagerSign($changeProductLineManagerSign)
    {
        $this->_changeProductLineManagerSign = $changeProductLineManagerSign;
    }

    public function getChangeProductLineManagerSign()
    {
        return empty($this->_changeProductLineManagerSign) ? '' : 'checked';
    }

    public function setChangeVerticalHeadSign($changeVerticalHeadSign)
    {
        $this->_changeVerticalHeadSign = $changeVerticalHeadSign;
    }

    public function getChangeVerticalHeadSign()
    {
        return empty($this->_changeVerticalHeadSign) ? '' : 'checked';
    }

    public function setDbUtil($dbUtil)
    {
        $this->_dbUtil = $dbUtil;
    }

    public function getDbUtil()
    {
        return $this->_dbUtil;
    }

    public function setOrgUnitHeadDesignation($orgUnitHeadDesignation)
    {
        $this->_orgUnitHeadDesignation = $orgUnitHeadDesignation;
    }

    public function getOrgUnitHeadDesignation()
    {
        return $this->_orgUnitHeadDesignation;
    }

    public function setOrgUnitHeadSignature($orgUnitHeadSignature)
    {
        $this->_orgUnitHeadSignature = $orgUnitHeadSignature;
    }

    public function getOrgUnitHeadSignature()
    {
        return empty($this->_orgUnitHeadSignature) ? '' : $this->_orgUnitHeadSignature;
    }

    public function setProductLineManagerDesignation($productLineManagerDesignation)
    {
        $this->_productLineManagerDesignation = $productLineManagerDesignation;
    }

    public function getProductLineManagerDesignation()
    {
        return $this->_productLineManagerDesignation;
    }

    public function setProductLineManagerSignature($productLineManagerSignature)
    {
        $this->_productLineManagerSignature = $productLineManagerSignature;
    }

    public function getProductLineManagerSignature()
    {
        return empty($this->_productLineManagerSignature) ? '' : $this->_productLineManagerSignature;
    }

    public function setReqNewOrgUnitHeadSign($reqNewOrgUnitHeadSign)
    {
        $this->_reqNewOrgUnitHeadSign = $reqNewOrgUnitHeadSign;
    }

    public function getReqNewOrgUnitHeadSign()
    {
        return empty($this->_reqNewOrgUnitHeadSign) ? '' : 'checked';
    }

    public function setReqNewProductLineManagerSign($reqNewProductLineManagerSign)
    {
        $this->_reqNewProductLineManagerSign = $reqNewProductLineManagerSign;
    }

    public function getReqNewProductLineManagerSign()
    {
        return empty($this->_reqNewProductLineManagerSign) ? '' : 'checked';
    }

    public function setReqNewVerticalHeadSign($reqNewVerticalHeadSign)
    {
        $this->_reqNewVerticalHeadSign = $reqNewVerticalHeadSign;
    }

    public function getReqNewVerticalHeadSign()
    {
        return empty($this->_reqNewVerticalHeadSign) ? '' : 'checked';
    }

    public function setRoleKModuleDefnApprover($roleKModuleDefnApprover)
    {
        $this->_roleKModuleDefnApprover = $roleKModuleDefnApprover;
    }

    public function getRoleKModuleDefnApprover()
    {
        return $this->_roleKModuleDefnApprover;
    }

    public function setRoleKModuleDefnOwner($roleKModuleDefnOwner)
    {
        $this->_roleKModuleDefnOwner = $roleKModuleDefnOwner;
    }

    public function getRoleKModuleDefnOwner()
    {
        return $this->_roleKModuleDefnOwner;
    }

    public function setRoleName($roleName)
    {
        $this->_roleName = $roleName;
    }

    public function getRoleName()
    {
        return $this->_roleName;
    }

    public function setRoleShortName($roleShortName)
    {
        $this->_roleShortName = $roleShortName;
    }

    public function getRoleShortName()
    {
        return $this->_roleShortName;
    }

    public function setVerticalHeadDesignation($verticalHeadDesignation)
    {
        $this->_verticalHeadDesignation = $verticalHeadDesignation;
    }

    public function getVerticalHeadDesignation()
    {
        return $this->_verticalHeadDesignation;
    }

    public function setVerticalHeadSignature($verticalHeadSignature)
    {
        $this->_verticalHeadSignature = $verticalHeadSignature;
    }

    public function getVerticalHeadSignature()
    {
        return empty($this->_verticalHeadSignature) ? '' : $this->_verticalHeadSignature;
    }

    public function setAccountID($accountID)
    {
        $this->_accountID = $accountID;
    }

    public function getAccountID()
    {
        return $this->_accountID;
    }

#endregion

    public function __construct()
    {
        $this->_dbUtil = new DBUtil();
    }

    /*
     * Public method that fetches the data required for displaying in
     * the Create Role screen. It fetches the signatures and designation
     * from account level and passes the data as array to the controller.
     */
    public function fetchPageDataForRoleCreation($accountID)
    {
        $this->fetchOrgUnitHeadSignFromAccountTable($accountID);
        $this->fetchVerticalHeadSignFromAccountTable($accountID);
        $this->fetchOrgUnitHeadDesignationFromAccountTable($accountID);
        $this->fetchVerticalHeadDesignationFromAccountTable($accountID);
        return $this->fetchArrayWithCurrentValues();
    }

    /*
     * Public method that fetches that data from Database for displaying
     * in the Role editing screen.
     */
    public function fetchPageDataForRoleEditing($roleID)
    {
        $result = $this->_dbUtil->select(TBL_ROLES, '*', ' id = '.$roleID);
        if(!empty($result[0]['account_id'])) $this->setAccountID($result[0]['account_id']);
        if(!empty($result[0]['role_name']))  $this->setRoleName($result[0]['role_name']);
        if(!empty($result[0]['role_shortname']))  $this->setRoleShortName($result[0]['role_shortname']);
        if(!empty($result[0]['role_certificate_name']))  $this->setCertificateName($result[0]['role_certificate_name']);
        if(!empty($result[0]['role_module_dfn_owner']))  $this->setRoleKModuleDefnOwner($result[0]['role_module_dfn_owner']);
        if(!empty($result[0]['role_module_df_approver']))  $this->setRoleKModuleDefnApprover($result[0]['role_module_df_approver']);
        if(!empty($result[0]['orgunit_designation']))  $this->setOrgUnitHeadDesignation(intval($result[0]['orgunit_designation']));
        if(!empty($result[0]['vertical_head_designation']))  $this->setVerticalHeadDesignation(intval($result[0]['vertical_head_designation']));
        if(!empty($result[0]['pl_manager_designation']))  $this->setProductLineManagerDesignation(intval($result[0]['pl_manager_designation']));
        if(!empty($result[0]['orgunit_signature']))  $this->setOrgUnitHeadSignature($result[0]['orgunit_signature']);
        if(!empty($result[0]['vertical_head_signature']))  $this->setVerticalHeadSignature($result[0]['vertical_head_signature']);
        if(!empty($result[0]['pl_manager_signature']))  $this->setProductLineManagerSignature($result[0]['pl_manager_signature']);

        $orgUnitHeadSignature = $this->getOrgUnitHeadSignature();
        if(empty($orgUnitHeadSignature))
        {
            $this->fetchOrgUnitHeadSignFromAccountTable($this->getAccountID());
        }
        $verticalHeadSignature = $this->getVerticalHeadSignature();
        if(empty($verticalHeadSignature))
        {
            $this->fetchVerticalHeadSignFromAccountTable($this->getAccountID());
        }
        return $this->fetchArrayWithCurrentValues();
    }

    /*
     * Public method that will be called from the controller in order
     * to validate the data passed. This method will return the error
     * array.
     */
    public function validateAndReturnErrors()
    {
        $errors = array();
        $webUtil = new WebUtil();
        $this->assignCurrentValuesFromPostRequest();

        /* Role Name Validation */
        $roleName = $this->getRoleName();
        if ($webUtil->is_empty($roleName)) {
            $errors[] = "Please enter the Role Name.";
        } else if ($webUtil -> isNumeric($roleName)) {
            $errors[] = "Numeric is not allowed for Role Name.";
        } else if ($webUtil -> isSpecialCharExists($roleName)) {
            $errors[] = "Special characters are not allowed in Role Name.";
        }

        /* Role Short Name Validation */
        $roleShortName = $this->getRoleShortName();
        if ($webUtil->is_empty($roleShortName)) {
            $errors[] = "Please enter the Role Short Name.";
        } else if ($webUtil -> isNumeric($roleShortName)) {
            $errors[] = "Numeric is not allowed for Role Short Name.";
        } else if ($webUtil -> isSpecialCharExists($roleShortName)) {
            $errors[] = "Special characters are not allowed in Role Short Name.";
        }

        /* Certificate Name */
        $certificateName = $this->getCertificateName();
        if ($webUtil->is_empty($certificateName)) {
            $errors[] = "Please enter the Certificate Name.";
        } else if ($webUtil -> isNumeric($certificateName)) {
            $errors[] = "Numeric is not allowed for Certificate Name.";
        } else if ($webUtil -> isSpecialCharExists($certificateName)) {
            $errors[] = "Special characters are not allowed in Certificate Name.";
        }

        /* Role K Module Definition Owner */
        $roleDefnOwner = $this->getRoleKModuleDefnOwner();
        if ($webUtil->is_empty($roleDefnOwner)) {
            $errors[] = "Please enter the Role K Module Definition Owner.";
        } else if ($webUtil -> isNumeric($roleDefnOwner)) {
            $errors[] = "Numeric is not allowed for Role K Module Definition Owner.";
        } else if ($webUtil -> isSpecialCharExists($roleDefnOwner)) {
            $errors[] = "Special characters are not allowed in Role K Module Definition Owner.";
        }

        /* Role K Module Definition Approver */
        $roleDefnApprover = $this->getRoleKModuleDefnApprover();
        if ($webUtil->is_empty($roleDefnApprover)) {
            $errors[] = "Please enter the Role K Module Definition Approver.";
        } else if ($webUtil -> isNumeric($roleDefnApprover)) {
            $errors[] = "Numeric is not allowed for Role K Module Definition Approver.";
        } else if ($webUtil -> isSpecialCharExists($roleDefnApprover)) {
            $errors[] = "Special characters are not allowed in Role K Module Definition Approver.";
        }

        /* Validation for Org Unit Head Designation */
        if($this->getOrgUnitHeadDesignation() == '0')
            $errors[] = "Select Org Unit Head Designation";

        /* Validation for Vertical Head Designation */
        if($this->getVerticalHeadDesignation() == '0')
            $errors[] = "Select Vertical Head Designation";

        /* Product Line Manager Designation */
        if($this->getProductLineManagerDesignation() == '0')
            $errors[] = "Select Product Line Manager Designation";

        /* Validation for the images */
        $orgUnitHeadSign = $this->getOrgUnitHeadSignature();
        if(!empty($orgUnitHeadSign))
        {
            $mergedArray = null;
            $result = $webUtil->isProperSignatureUpload('orgUnitHeadSignature', 'Org Unit Head Signature');
            if(empty($result))
            {
                $mergedArray = $errors;
            }
            else
            {
                $mergedArray = array_merge($errors, $result);
            }
            $errors = $mergedArray;
        }

        $verticalHeadSign = $this->getVerticalHeadSignature();
        if(!empty($verticalHeadSign))
        {
            $mergedArray = null;
            $result = $webUtil->isProperSignatureUpload('verticalHeadSignature', 'Vertical Head Signature');
            if(empty($result))
            {
                $mergedArray = $errors;
            }
            else
            {
                $mergedArray = array_merge($errors, $result);
            }
            $errors = $mergedArray;
        }

        $productLineManagerSign = $this->getProductLineManagerSignature();
        if(!empty($productLineManagerSign))
        {
            $mergedArray = null;
            $result = $webUtil->isProperSignatureUpload('productLineManagerSignature', 'Product Line Manager Signature');
            if(empty($result))
            {
                $mergedArray = $errors;
            }
            else
            {
                $mergedArray = array_merge($errors, $result);
            }
            $errors = $mergedArray;
        }
        return $errors;
    }

    /*
     * Public method used for committing the data to the Database.
     */
    public function saveRole($accountID)
    {
        $rows = array('account_id', 'role_name', 'role_shortname', 'role_module_dfn_owner', 'role_module_df_approver', 'orgunit_designation', 'orgunit_signature', 'vertical_head_designation', '  vertical_head_signature ', 'pl_manager_designation', 'pl_manager_signature', 'role_certificate_name', 'is_active ');
        $values = array('account_id' => $accountID);
        $values = array_merge($values, $this->fetchArrayWithCurrentValues());
        unset($values['ChangeOrgUnitHeadSignature'], $values['ChangeVerticalHeadSignature'], $values['ChangeProductLineManagerSignature'], $values['ReqOrgUnitHeadSignature'], $values['ReqVerticalHeadSignature'], $values['ReqProductLineManagerSignature']);
        $this->_dbUtil->insert(TBL_ROLES, $values, $rows);
    }

    /*
     * Public method used for updating an existing role. Usually
     * called from the edit role screen.
     */
    public function updateRole($roleID)
    {
        $result = $this->_dbUtil->select(TBL_ROLES,'account_id', "id=$roleID");
        $this->setAccountID($result[0]['account_id']);
        $set = array("role_name='{$this->getRoleName()}'", "role_shortname='{$this->getRoleShortName()}'", "role_module_dfn_owner='{$this->getRoleKModuleDefnOwner()}'", "role_module_df_approver='{$this->getRoleKModuleDefnApprover()}'", "orgunit_designation={$this->getOrgUnitHeadDesignation()}", "vertical_head_designation={$this->getVerticalHeadDesignation()}", "pl_manager_designation={$this->getProductLineManagerDesignation()}", "role_certificate_name='{$this->getCertificateName()}'");
        if($this->getChangeOrgUnitHeadSign() == 'checked')
        {
            $set[] = "orgunit_signature='{$this->getOrgUnitHeadSignature()}'";
        }
        if($this->getChangeVerticalHeadSign() == 'checked')
        {
            $set[] = "vertical_head_signature='{$this->getVerticalHeadSignature()}'";
        }
        $pl_manager_sign = $this->getProductLineManagerSignature();
        //This condition differs from others because the PLLineMgr may or may not have a default sign.
        //Therefore the checkbox might not always be available onscreen.
        if($this->getChangeProductLineManagerSign() == 'checked' || !empty($pl_manager_sign))
        {
            $set[] = "pl_manager_signature='{$this->getProductLineManagerSignature()}'";
        }
        $where = "id=$roleID";
        $this->_dbUtil->update(TBL_ROLES, $set, $where);
    }

    /*
     * Private method that fetches the Level 1 signature from the account table
     */
    private function fetchOrgUnitHeadSignFromAccountTable($accountID)
    {
        $result = $this->_dbUtil->select(TBL_ACCOUNTS, 'orgunit_signature', "id=".$accountID);
        if (isset($result))
        {
            $this->setOrgUnitHeadSignature($result[0]['orgunit_signature']);
        }
    }

    /*
     * Private method that fetches the Level 2 signature from the account table.
     */
    private function fetchVerticalHeadSignFromAccountTable($accountID)
    {
        $result = $this->_dbUtil->select(TBL_ACCOUNTS, 'account_signature', "id=".$accountID);
        if(isset($result))
        {
            $this->setVerticalHeadSignature($result[0]['account_signature']);
        }
    }

    /*
     * Private method that fetches the Level 1 Designation from the account table
     */
    private function fetchOrgUnitHeadDesignationFromAccountTable($accountID)
    {
        $result = $this->_dbUtil->select(TBL_ACCOUNTS, 'orgunit_designation', "id=".$accountID);
        if (isset($result))
        {
            $this->setOrgUnitHeadDesignation($result[0]['orgunit_designation']);
        }
    }

    /*
    * Private method that fetches the Level 2 signature from the account table.
    */
    private function fetchVerticalHeadDesignationFromAccountTable($accountID)
    {
        $result = $this->_dbUtil->select(TBL_ACCOUNTS, 'account_designation', "id=".$accountID);
        if(isset($result))
        {
            $this->setVerticalHeadDesignation($result[0]['account_designation']);
        }
    }
    /*
     * Converts all the properties available in the current instance to an associative array
     * so that it can be used from the template to display the values.
     */
    private function fetchArrayWithCurrentValues()
    {
        $pageFields = array();
        //Normal controls
        $pageFields["RoleName"] = $this->getRoleName();
        $pageFields["RoleShortName"] = $this->getRoleShortName();
        $pageFields["RoleKModuleDefnOwner"] = $this->getRoleKModuleDefnOwner();
        $pageFields["RoleKModuleDefnApprover"] = $this->getRoleKModuleDefnApprover();
        $pageFields["OrgUnitHeadDesignation"] = $this->getOrgUnitHeadDesignation();
        $pageFields["OrgUnitHeadSignature"] = $this->getOrgUnitHeadSignature();
        $pageFields["VerticalHeadDesignation"] = $this->getVerticalHeadDesignation();
        $pageFields["VerticalHeadSignature"] = $this->getVerticalHeadSignature();
        $pageFields["ProductLineManagerDesignation"] = $this->getProductLineManagerDesignation();
        $pageFields["ProductLineManagerSignature"] = $this->getProductLineManagerSignature();
        $pageFields["CertificateName"] = $this->getCertificateName();
        $pageFields["isActive"] = '1';

        // CheckBox
        $pageFields["ChangeOrgUnitHeadSignature"] = $this->getChangeOrgUnitHeadSign();
        $pageFields["ChangeVerticalHeadSignature"] = $this->getChangeVerticalHeadSign();
        $pageFields["ChangeProductLineManagerSignature"] = $this->getChangeProductLineManagerSign();
        $pageFields["ReqOrgUnitHeadSignature"] = $this->getReqNewOrgUnitHeadSign();
        $pageFields["ReqVerticalHeadSignature"] = $this->getReqNewVerticalHeadSign();
        $pageFields["ReqProductLineManagerSignature"] = $this->getReqNewProductLineManagerSign();

        return $pageFields;
    }

    /*
     * Sets the values of the current instance based on the values fetched from the
     * user using the POST request.
     */
    private function assignCurrentValuesFromPostRequest()
    {
        //Normal Controls
        if(isset($_POST['roleName'])) $this->setRoleName($_POST['roleName']);
        if(isset($_POST['roleShortName'])) $this->setRoleShortName($_POST['roleShortName']);
        if(isset($_POST['certName'])) $this->setCertificateName($_POST['certName']);
        if(isset($_POST['roleModuleDefinitionOwner'])) $this->setRoleKModuleDefnOwner($_POST['roleModuleDefinitionOwner']);
        if(isset($_POST['roleModuleDefinitionApprover'])) $this->setRoleKModuleDefnApprover($_POST['roleModuleDefinitionApprover']);
        if(isset($_POST['orgUnitHeadDesignation'])) $this->setOrgUnitHeadDesignation(intval($_POST['orgUnitHeadDesignation']));
        if(isset($_POST['verticalHeadDesignation'])) $this->setVerticalHeadDesignation(intval($_POST['verticalHeadDesignation']));
        if(isset($_POST['productLineManagerDesignation'])) $this->setProductLineManagerDesignation(intval($_POST['productLineManagerDesignation']));

        //File Upload Controls
        if(!empty($_FILES['orgUnitHeadSignature']['tmp_name'])) $this->setOrgUnitHeadSignature(addslashes(file_get_contents($_FILES['orgUnitHeadSignature']['tmp_name'])));
        if(!empty($_FILES['verticalHeadSignature']['tmp_name'])) $this->setVerticalHeadSignature(addslashes(file_get_contents($_FILES['verticalHeadSignature']['tmp_name'])));
        if(!empty($_FILES['productLineManagerSignature']['tmp_name'])) $this->setProductLineManagerSignature(addslashes(file_get_contents($_FILES['productLineManagerSignature']['tmp_name'])));

        //CheckBoxes
        if(isset($_POST['changeOrgUnitHeadSignature'])) $this->setChangeOrgUnitHeadSign($_POST['changeOrgUnitHeadSignature']);
        if(isset($_POST['requestOrgUnitHeadSignature'])) $this->setReqNewOrgUnitHeadSign($_POST['requestOrgUnitHeadSignature']);
        if(isset($_POST['changeVerticalHeadSignature'])) $this->setChangeVerticalHeadSign($_POST['changeVerticalHeadSignature']);
        if(isset($_POST['requestVerticalHeadSignature'])) $this->setReqNewVerticalHeadSign($_POST['requestVerticalHeadSignature']);
        if(isset($_POST['changeProductLineManagerSignature'])) $this->setChangeProductLineManagerSign($_POST['changeProductLineManagerSignature']);
        if(isset($_POST['requestProductLineManagerSignature'])) $this->setReqNewProductLineManagerSign($_POST['requestProductLineManagerSignature']);
    }
}
