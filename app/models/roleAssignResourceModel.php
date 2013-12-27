<?php

require_once __SITE_PATH . '/libs/Form.php';
require_once __SITE_PATH . '/libs/WebUtil.php';
require_once __SITE_PATH . '/libs/DBUtil.php';
require_once __SITE_PATH . '/log4php/Logger.php';
require_once __SITE_PATH . '/libs/db.php';
require_once __SITE_PATH . '/libs/LSCException.php';
require_once __SITE_PATH . '/libs/Session.php';

class roleAssignResourceModel 
{
	private $ktpm;
	private $kttype;
	private $targetdate;
	private $potientalusers;
	private $dbUtil;
	private $session;
	
	public function __construct() 
	{
		$this -> form = new Form();
		$this -> logger = Logger::getLogger("Role Assign/Deassign Resource Model");
		$this -> dbUtil = new DBUtil();
		$this -> session = new Session();		
	}
	
	public function getktpmVal() 
	{
		return $this -> ktpm;
	}
	
	public function getktTypeVal()
	{
		return $this -> kttype;
	}	
	
	public function gettargetDateVal()
	{
		return $this -> targetdate;
	}
	
	public function setktpmVal($ktpm) 
	{
		$this -> ktpm = $ktpm;
	}
	
	public function setktTypeVal($kttype)
	{
		$this -> kttype = $kttype;
	}

	public function settargetDateVal($targetdate)
	{
		$this -> targetdate = $targetdate;
	}
	
	public function setPotentialUsersVal($potientalusers)
	{
		$this -> potientalusers = $potientalusers;
	}	
	
	public function setroleAssignedUsersVal($roleassignedusers)
	{
		$this -> roleassignedusers = $roleassignedusers;
	}	
	
	public function setroleNotifyAssignedUsersVal($roleassignedusers)
	{
		$this -> roleassignedusers = $roleassignedusers;
	}	
	
	function populateKtType()
	{
		return $this -> dbUtil -> getKtType();
	}	
	
	function populateTargetDate()
	{
		return $this -> dbUtil -> getTargetDate();
	}

	function populateKtpmUsers()
	{
		return $this -> dbUtil -> getKTPM();
	}	

	function populatePotentialUsers($roleID)
	{
		//return $this -> dbUtil -> getPotentialUsers($roleID, $searchFlag, $searchText);
		$sqlquery = "select user.id, user.user_name, user.first_name,
        					user.last_name, user.email_address
        			 from	lsc_users user
        			 where	user.is_active = '1'
        			 and	user.id not in
        					(
        						select 	rolemap.user_id
        						from	lsc_role_user_mapping rolemap
        						where	rolemap.is_active = '1'
        						and		rolemap.role_id = ".$roleID. ")";

		$potentialUsers_data = $this->dbUtil->executeSelect($sqlquery);
		return $potentialUsers_data;
	}

	function populateroleAssignedUsers($roleID)
	{
		//return $this -> dbUtil -> getroleAssignedUsers($roleID);
		$sqlquery = "select user.id, user.user_name, user.first_name,
        					user.last_name, user.email_address
        			 from	lsc_role_user_mapping rolemap
        					inner join lsc_users user
        					on (user.id = rolemap.user_id and user.is_active = '1')
        			 where	rolemap.is_active = '1'
        			 and	rolemap.role_id = ".$roleID;
		
		$roleAssignedUsers_data = $this->dbUtil->executeSelect($sqlquery);
		return $roleAssignedUsers_data;
	}

	public function roleAssignResourceSetData()
	{
		$this->setktpmVal(htmlspecialchars($_POST['ktpm']));
		$this->setktTypeVal(htmlspecialchars($_POST['kttype']));
		$this->settargetDateVal(htmlspecialchars($_POST['targetdate']));
		$this->setPotentialUsersVal($_POST['potientalusers']);
	}	
	
	public function roleDeAssignResourceSetData()
	{
		$this->setroleAssignedUsersVal($_POST['roleassignedusers']);
	}
	
	public function roleNotifyAssignResourceSetData()
	{
		$this->setroleNotifyAssignedUsersVal($_POST['roleassignedusers']);
	}	

	public function roleSearchResourceSetData()
	{
		$this->setroleSearchUserVal(htmlspecialchars($_POST['searchname']));
	}	
	
	public function roleAssignResourceData($roleID, $accountID)
	{
		$targetDate = $this->targetdate;
		$ktType = $this->kttype;
		$ktpm = $this->ktpm;
		$current_date = date("Y-m-d H:i:s");
		
		if ($ktpm == 'none')
		{
			$ktpm_status = '2';
		}
		else
		{
			$ktpm_status = '0';
		}
		
		$loginUserId = $this -> session->getUserId();
		
		foreach ($this->potientalusers as $adduser)
		{
			$rows = array('role_id', 'user_id', 'role_status', 'assign_date', 'role_target_date', 'role_user_ktpm', 'role_user_kttype', 'role_user_ktpm_status', 'role_user_notify', 'is_active', 'created_by', 'created_date');
			$datas = array('role_id' => $roleID, 'user_id' => $adduser, 'role_status' => 'PEND', 'assign_date' => $current_date, 'role_target_date' => $targetDate, 'role_user_ktpm' => $ktpm, 'role_user_kttype' => $ktType, 'role_user_ktpm_status' => $ktpm_status, 'role_user_notify' => '0', 'is_active' => '1', 'created_by' => $loginUserId, 'created_date' => $current_date);
			$this->dbUtil->insert(TBL_ROLE_MAP, $datas, $rows);
			
			$insertSql = "Insert into lsc_role_module_user_mapping (role_id, module_id, user_id, module_status, assign_date, is_active, created_by, created_date)
			select role_id, module_id, ".$adduser.", 'PEND', '".$current_date."', 1, ".$loginUserId.", '".$current_date."' from lsc_role_module_mapping where is_active = 1 and role_id = ".$roleID;
			$this->dbUtil->executeInsert($insertSql);			

		}	
	}
	
	public function roleDeAssignResourceData($roleID, $accountID)
	{
		$current_date = date("Y-m-d H:i:s");
		$loginUserId = $this -> session->getUserId();
		$set = array("is_active = '0'", "modified_by = $loginUserId", "modified_date = '$current_date'");
		
		$email_type = 6;
		$emailTemplate_data = $this -> dbUtil ->getEmailTemplate($email_type);
		
		$account_data = $this -> dbUtil ->getAccountName($accountID);
		$role_data = $this -> dbUtil ->getRoleName($roleID);
		
		foreach ($account_data as $accountInfo)
		{
			$account_fullName = $accountInfo['account_name'];
		}
		
		foreach ($role_data as $roleInfo)
		{
			$role_fullName = $roleInfo['role_name'];
		}
		
		foreach ($emailTemplate_data as $emailtemplate)
		{
			$email_subject = $emailtemplate['email_subject'];
			$email_content = $emailtemplate['email_body'];
		}
				
		foreach ($this->roleassignedusers as $removeuser)
		{
			$this->roleEmailDataPopulate($removeuser, $roleID, $accountID, $account_fullName, $role_fullName, $loginUserId, $email_type, $current_date, $email_subject, $email_content);			
			$where = '';	
			$where = "role_id = $roleID and user_id = $removeuser and is_active = '1' ";
			$this->dbUtil->update(TBL_ROLE_MAP, $set, $where);
		}
	}	
	
	public function roleNotifyAssignResourceData($roleID, $accountID)
	{
		$email_type = 2;
		$current_date = date("Y-m-d H:i:s");
		$loginUserId = $this -> session->getUserId();
		$emailTemplate_data = $this -> dbUtil ->getEmailTemplate($email_type);
		
		$account_data = $this -> dbUtil ->getAccountName($accountID);
		$role_data = $this -> dbUtil ->getRoleName($roleID);
		
		foreach ($account_data as $accountInfo)
		{
			$account_fullName = $accountInfo['account_name'];
		}
		
		foreach ($role_data as $roleInfo)
		{
			$role_fullName = $roleInfo['role_name'];
		}		

		foreach ($emailTemplate_data as $emailtemplate)
		{
			$email_subject = $emailtemplate['email_subject'];
			$email_content = $emailtemplate['email_body'];
		}		

		foreach ($this->roleassignedusers as $notifyuser)
		{
			$this->roleEmailDataPopulate($notifyuser, $roleID, $accountID, $account_fullName, $role_fullName, $loginUserId, $email_type, $current_date, $email_subject, $email_content);
		}
	}

	public function roleEmailDataPopulate($userID, $roleID, $accountID, $account_fullName, $role_fullName, $loginUserId, $email_type, $current_date, $email_subject, $email_content)
	{
		if ( $email_type == 2 )
		{
			$sqlquery = "select user.id, user.user_name, user.first_name,
	        					user.last_name, user.email_address,
	        			 		user.pl_managerid, user.reporting_managerid,
	        			 		rolemap.role_user_ktpm, account.lsc_admin,
	    						SUBSTR(DATE_FORMAT(DATE_ADD(rolemap.assign_date, INTERVAL rolemap.role_target_date DAY),'%d-%m-%Y'),1,10) as role_expiry_date
	        			 from	lsc_role_user_mapping rolemap
	        					inner join lsc_users user
	        					on (user.id = rolemap.user_id and user.is_active = '1')
	        			 		inner join lsc_role role
	        			 		on (role.id = rolemap.role_id and role.is_active = '1')
	        			 		inner join lsc_account account
	        			 		on (role.account_id = account.id and account.is_active = '1')
	        			 where	rolemap.is_active = 1
						 and	rolemap.role_user_notify = 0
	        			 and	rolemap.role_id = ".$roleID."
	        			 and	rolemap.user_id = ".$userID."
	        			 and	account.id = ".$accountID;
	
			$email_title = "Role: $role_fullName assigned for $account_fullName. You are requested to complete the learnings by successfully completing the assessments by $roleExpiryDate ";
		}
		else if ( $email_type == 6 )
		{
			$sqlquery = "select user.id, user.user_name, user.first_name,
	        					user.last_name, user.email_address,
	        			 		user.pl_managerid, user.reporting_managerid,
	        			 		rolemap.role_user_ktpm, account.lsc_admin,
	    						SUBSTR(DATE_FORMAT(DATE_ADD(rolemap.assign_date, INTERVAL rolemap.role_target_date DAY),'%d-%m-%Y'),1,10) as role_expiry_date
	        			 from	lsc_role_user_mapping rolemap
	        					inner join lsc_users user
	        					on (user.id = rolemap.user_id and user.is_active = '1')
	        			 		inner join lsc_role role
	        			 		on (role.id = rolemap.role_id and role.is_active = '1')
	        			 		inner join lsc_account account
	        			 		on (role.account_id = account.id and account.is_active = '1')
	        			 where	rolemap.is_active = 1
	        			 and	rolemap.role_id = ".$roleID."
	        			 and	rolemap.user_id = ".$userID."
	        			 and	account.id = ".$accountID;
	
			$email_title="De-assignment from $role_fullName Role on $account_fullName Account under LSC Program";
		}
	
		$roleAssignEmailCCInfo = $this->dbUtil->executeSelect($sqlquery);
			
		$userNameInfo = $this->dbUtil->getUserEmailInfo($userID);
			
		$recordExistsCheck = 0;
			
		foreach ($roleAssignEmailCCInfo as $roleAssignEmaildata)
		{
			$user_plmInfo = $this->dbUtil->getUserEmailInfo($roleAssignEmaildata['pl_managerid']);
			$user_resmgrInfo = $this->dbUtil->getUserEmailInfo($roleAssignEmaildata['reporting_managerid']);
			if ($roleAssignEmaildata['role_user_ktpm'] > 0 )
			{
				$user_ktpmInfo = $this->dbUtil->getUserEmailInfo($roleAssignEmaildata['role_user_ktpm']);
			}
			else
			{
				$user_ktpmInfo = '';
			}
			$user_acctLscAdminInfo = $this->dbUtil->getUserEmailInfo($roleAssignEmaildata['lsc_admin']);
			$user_roleExpiryDate = array($roleAssignEmaildata['role_expiry_date']);
	
			$recordExistsCheck = 1;
		}
			
		if ($recordExistsCheck == 1)
		{
			$email_content_byrecord = '';
			$email_content_byrecord = $email_content;
			$emailcc_data = array('user_plm' => $user_plmInfo, 'user_resmgr' => $user_resmgrInfo, 'user_ktpm' => $user_ktpmInfo, 'user_lscadmin' => $user_acctLscAdminInfo, 'user_role_expirydate' => $user_roleExpiryDate, 'user_info' => $userNameInfo ) ;
	
			foreach ($emailcc_data as $obj_key => $cclist_data)
			{
				if ($obj_key == 'user_lscadmin')
				{
					foreach ($cclist_data as $lscadminrep_data)
					{
						$cc = $lscadminrep_data['email_address'].",".$lscadminrep_data['first_name']." ".$lscadminrep_data['last_name'];
					}
				}
			}
				
			foreach ($emailcc_data as $obj_key => $cclist_data)
			{
				if ($obj_key == 'user_plm')
				{
					foreach ($cclist_data as $plm_data)
					{
						$cc = $cc.",".$plm_data['email_address'].",".$plm_data['first_name']." ".$plm_data['last_name'];
					}
				}
			}
				
			foreach ($emailcc_data as $obj_key => $cclist_data)
			{
				if ($obj_key == 'user_resmgr')
				{
					foreach ($cclist_data as $resmgr_data)
					{
						$cc = $cc.",".$resmgr_data['email_address'].",".$resmgr_data['first_name']." ".$resmgr_data['last_name'];
					}
				}
			}
				
			foreach ($emailcc_data as $obj_key => $cclist_data)
			{
				if ($obj_key == 'user_ktpm')
				{
					foreach ($cclist_data as $ktpm_data)
					{
						$cc = $cc.",".$ktpm_data['email_address'].",".$ktpm_data['first_name']." ".$ktpm_data['last_name'];
					}
				}
			}
				
			foreach ($emailcc_data as $obj_key => $cclist_data)
			{
				if ($obj_key == 'user_info')
				{
					foreach ($cclist_data as $user_data)
					{
						$userFullName = $user_data['first_name']." ".$user_data['last_name'];
					}
				}
			}
				
			foreach ($emailcc_data as $obj_key => $cclist_data)
			{
				if ($obj_key == 'user_role_expirydate')
				{
					foreach ($cclist_data as $roleexpiry_data)
					{
						$roleExpiryDate = $roleexpiry_data;
					}
				}
			}
				
			$email_subject = str_replace("<2>", "$account_fullName", $email_subject);
				
			$email_content_byrecord=str_replace("<1>", "$userFullName", $email_content_byrecord);
			$email_content_byrecord=str_replace("<2>", "$account_fullName", $email_content_byrecord);
			$email_content_byrecord=str_replace("<3>", "$role_fullName", $email_content_byrecord);
				
			$rows = array('account_id', 'role_id', 'user_id', 'email_title', 'email_subject', 'email_text', 'email_cc', 'email_type', 'email_sent', 'is_active', 'created_by', 'created_date');
			$datas = array('account_id' => $accountID, 'role_id' => $roleID, 'user_id' => $userID, 'email_title' => $email_title, 'email_subject' => $email_subject, 'email_text' => $email_content_byrecord, 'email_cc' => $cc, 'email_type' => $email_type, 'email_sent' => '0', 'is_active' => '1', 'created_by' => $loginUserId, 'created_date' => $current_date);
			$this->dbUtil->insert(TBL_EMAIL_NOTIFY, $datas, $rows);
				
			$set = array("modified_by = $loginUserId", "modified_date = '$current_date'", "role_user_notify = '1'");
			$where = '';
			$where = "role_id = $roleID and user_id = $notifyuser and is_active = '1' ";
			$this->dbUtil->update(TBL_ROLE_MAP, $set, $where);
		}
	}
}

?>