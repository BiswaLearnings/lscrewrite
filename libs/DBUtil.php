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
// @description: Database Manipulation functionalities                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php

require_once __SITE_PATH . '/log4php/Logger.php';
require_once __SITE_PATH . '/libs/Form.php';
require_once __SITE_PATH . '/libs/db.php';
require_once __SITE_PATH . '/libs/LSCException.php';

/**
 *
 */
class DBUtil extends CustomException {

    private $today;
    private $logger;
    private $form;
    private $result;
    private $lastId;
    private $database;
    private $dbConnection;

    /*
     * Constructor for this Class
     */

    function __construct() {
        $this->today = date("l, jS F Y h:i a");
        $this->logger = Logger::getLogger("DBUtil");
        $this->form = new Form();
        $this->database = new db();
        $this->dbConnection = $this->database->getConnection();
    }

    /**
     *
     * @param type $username
     * @return type
     */
    function getUserInfo($username) {

        try {
            $sql = "SELECT * FROM " . TBL_USERS . " WHERE user_name='$username'";
            $stmt = $this->dbConnection->prepare($sql);
            if (!$stmt) {
                echo "\nPDO::errorInfo():\n";
                echo $stmt->errorInfo();
            }
            $stmt->execute();

            /* Exercise PDOStatement::fetch styles */
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->finally();
        }

        return $result;
    }

    /**
     *
     * @param type $table
     * @param type $rows
     * @param type $where
     * @param type $order
     * @return type
     */
    public function select($table, $rows = '*', $where = null, $order = null) {

        $query = 'SELECT ' . $rows . ' FROM ' . $table;
        if ($where != null)
            $query .= ' WHERE ' . $where;
        if ($order != null)
            $query .= ' ORDER BY ' . $order;
        try {
            $this->getConnectionObject();
            $sql = $this->dbConnection->prepare($query);
            $sql->execute();
            $this->result = $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->finally();
            return $e->getMessage() . '' . $e->getTraceAsString() . '';
        }
        return $this->result;
    }
    
    public function executeSelect($query)
    {
    	try 
    	{
    		$this->getConnectionObject();
    		$sql = $this->dbConnection->prepare($query);
    		$sql->execute();
    		$this->result = $sql->fetchAll(PDO::FETCH_ASSOC);
    	} 
    	catch (PDOException $e) 
    	{
    		$this->finally();
    		return $e->getMessage() . '' . $e->getTraceAsString() . '';
    	}
    	return $this->result;
    }
    
    public function executeInsert($query)
    {
    	try 
    	{
    		$ins = $this->dbConnection->prepare($query);
    		$ins->execute();
    		$this->lastId = $this->dbConnection->lastInsertId();
    		return true;
    	} 
    	catch (PDOException $e) 
    	{
    		$this->finally();
    		return $e->getMessage();
    	}    	
    }    
    
    /**
     *
     * @param type $table
     * @param type $values
     * @param type $rows
     * @return type
     */
    public function insert($table, $values, $rows = null) {

        $insert = 'INSERT INTO ' . $table;

        foreach ($rows as $key => $row) {
            if (is_string($rows[$key]))
                $rows[$key] = "" . $rows[$key] . "";
        }
        $rows = implode(',', $rows);
        $insert .= ' (' . $rows . ')';

        foreach ($values as $key => $value) {
            if (is_string($values[$key]))
                $values[$key] = "'" . $values[$key] . "'";
        }
		$values = implode(',', $values);
        $insert .= ' VALUES (' . $values . ');';
        //echo $insert;
        try {
            $ins = $this->dbConnection->prepare($insert);
            $ins->execute();
            $this->lastId = $this->dbConnection->lastInsertId();
            return true;
        } catch (PDOException $e) {
            $this->finally();
            return $e->getMessage();
        }
    }

    /**
     *
     * @param type $table
     * @param type $values
     * @param type $where
     * @return type
     */
    public function update($table, $values, $where = null) {

        $query = 'UPDATE ' . $table;

        foreach ($values as $key => $row) {
            if (is_string($values[$key]))
                $values[$key] = "" . $values[$key] . "";
        }

        $values = implode(',', $values);
        $query .= ' SET ' . $values . ' ';
		
        if ($where != null)
            $query .= ' WHERE ' . $where;
           
        try {
            $sql = $this->dbConnection->prepare($query);
            $sql->execute();
            return true;
		
        } catch (PDOException $e) {
            return $e->getMessage() . '' . $e->getTraceAsString() . '';
        }
    }

    function searchEmail($email){
        try {
            $sql = "SELECT * FROM " . TBL_USERS . " WHERE email_address='$email'";
            $stmt = $this->dbConnection->prepare($sql);
            if (!$stmt) {
                echo "\nPDO::errorInfo():\n";
                echo $stmt->errorInfo();
            }
            $stmt->execute();

            /* Exercise PDOStatement::fetch styles */
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->finally();
        }
        return $result;
    }


    /**
     *
     * @param type $id
     * @return type
     */
    function getPLManagerName($id){
        $rows = "user_name";
        $where = "id='$id'";
        $plm_result = $this->select(TBL_USERS, $rows, $where);
        return $plm_result;
    }

    /**
     *
     * @param type $id
     * @return type
     */
    function getResourceManagerName($id){
        $rows = "user_name";
        $where = "id=$id";
        $rm_result = $this->select(TBL_USERS, $rows, $where);
        return $rm_result;
    }

    /**
     *
     * @return type
     */
    function getAccountList() {
        return $this->select(TBL_ACCOUNTS);
    }


    /**
     *
     * @return type
     */
    function getWorkRegions() {
        $rows = "meta_code,meta_text";
        $where = "meta_type='workregion'";
        $work_regions = $this->select(META_DATA, $rows, $where);

        return $work_regions;
    }

    /**
     *
     * @return type
     */
    function getTimeZones() {
        $rows = "meta_code,meta_text";
        $where = "meta_type='timezone'";
        $timezones = $this->select(META_DATA, $rows, $where);
        return $timezones;
    }

    /**
     *
     * @return type
     */
    function getProduclines() {
        $rows = "meta_code,meta_text";
        $where = "meta_type='productline'";

        $produclines = $this->select(META_DATA, $rows, $where);

        return $produclines;
    }

    function getKtType() 
	{
    	$rows = "meta_code,meta_text";
    	$where = "meta_type='kt_type'";
    
    	$kttypeVal = $this->select(META_DATA, $rows, $where);
    
    	return $kttypeVal;
    }

    function getTargetDate()
    {
    	$rows = "meta_code,meta_text";
    	$where = "meta_type='targetdate'";
    
    	$targetdateVal = $this->select(META_DATA, $rows, $where);
    
    	return $targetdateVal;
    }

    function getKTPM()
    {
    	$rows = "id, user_name, first_name, last_name ";
    	$where = "is_active = 1 and role like '%4%' ";
    	$ktpmUsers_result = $this->select(TBL_USERS, $rows, $where);
    	return $ktpmUsers_result;
    }    

    /**
     *
     * @return type
     */
    function getEmpStatus() {
        $rows = "meta_code,meta_text";
        $where = "meta_type='empstatus'";
        $emp_statuses = $this->select(META_DATA, $rows, $where);
        return $emp_statuses;
    }

    /**
     *
     * @return type
     */
    function getCountry() {
        $rows = "meta_code,meta_text";
        $where = "meta_type='country'";
        $country = $this->select(META_DATA, $rows, $where);
        return $country;
    }

    /**
     *
     */
    function getUserRole() {
        $rows = "meta_code,meta_text";
        $where = "meta_type='role'";
        $user_roles = $this->select(META_DATA, $rows, $where);

        return $user_roles;
    }
    
    function getGrades() {
        $rows = "meta_code,meta_text";
        $where = "meta_type='grade'";
        $grades = $this->select(META_DATA, $rows, $where, 'meta_text');
        return $grades;
    }
    
    function getKnodeElement()
    {
    	$rows = "meta_code,meta_text";
    	$where = "meta_name='module' and meta_type = 'knode' and is_active = 1 ";
    	$knode_datas = $this->select(META_DATA, $rows, $where);
    	
    	return $knode_datas;
    }    
	
    function getEmailTemplate($emailType)
    {
    	$rows = "id, email_subject, email_body, remarks, is_active";
    	$where = "is_active ='1' and id = $emailType ";
    	$email_data = $this->select(TBL_EMAIL_TEMPLATE, $rows, $where);
    	
    	return $email_data;
    }
    
    function getUserEmailInfo($userID)
    {
    	$rows = "id, first_name, last_name, email_address";
    	$where = " id = $userID and is_active = '1' ";
    	$rm_result = $this->select(TBL_USERS, $rows, $where);
    	return $rm_result;
    }
    
    function getAccountName($accountID)
    {
    	$rows = "id, account_name";
    	$where = " id = $accountID and is_active = '1' ";
    	$rm_result = $this->select(TBL_ACCOUNTS, $rows, $where);
    	return $rm_result;
    }
    
    function getRoleName($roleID)
    {
    	$rows = "id, role_name";
    	$where = " id = $roleID and is_active = '1' ";
    	$rm_result = $this->select(TBL_ROLES, $rows, $where);
    	return $rm_result;
    }    
    
    /* public function update($table, $set, $where) {
      $update = 'Update ' . $table;

      $update .= ' Set ' . $set  ;
      if ($where != null)
      $update .= ' WHERE ' . $where;

      try {
      $ins = $this->dbConnection->prepare($update);
      $ins->execute();


      } catch (PDOException $e) {
      return $e->getMessage();
      }
      } */
    public function delete($table, $where) {
        $query = 'DELETE FROM ' . $table;
        if ($where != null)
            $query .= ' WHERE ' . $where;
            
        try {
            $this->dbConnection->exec($query);
        } catch (PDOException $e) {
            $this->finally();
            return $e->getMessage();
        }

    }

    function finally() {
        $this->dbConnection = null;
    }

    function getConnectionObject() {
        if ($this->dbConnection == null) {

            $this->dbConnection = $this->database->getConnection();
        }
        return $this->dbConnection;
    }

}

?>