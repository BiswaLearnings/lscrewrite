<?php
require_once __SITE_PATH . '/libs/Form.php';
require_once __SITE_PATH . '/libs/WebUtil.php';
require_once __SITE_PATH . '/libs/DBUtil.php';
require_once __SITE_PATH . '/log4php/Logger.php';
require_once __SITE_PATH . '/libs/db.php';
require_once __SITE_PATH . '/libs/LSCException.php';
require_once __SITE_PATH . '/libs/Session.php';

class userModulesModel
{
	private $dbUtil;
	private $session;
		
	public function __construct()
	{
		$this -> form = new Form();
		$this -> logger = Logger::getLogger("User Modules Model");
		$this -> dbUtil = new DBUtil();
		$this -> session = new Session();
	}	
	
	function populateKnodeElement()
	{
		return $this -> dbUtil -> getKnodeElement();
	}	
	
	public function getUserAssignedRoles()
	{
		$loginUserId = $this->session->getUserId();
		$userID = $loginUserId;
		
		$sqlquery = "select account.account_name as acctname, role.role_name as rolename,
							metarole.meta_text as rolestatus, metaregion.meta_text as region,
							DATE_FORMAT(DATE_ADD(rolemap.certified_date, INTERVAL 1 YEAR),'%d-%b-%y') as certified_date,
							account.id as account_id, role.id as role_id 
				 	 from	lsc_users user
							inner join lsc_role_user_mapping rolemap
							on (user.id = rolemap.user_id and rolemap.is_active = 1)
							inner join lsc_role role
							on (role.id = rolemap.role_id and role.is_active = 1)
							inner join lsc_account account
							on (account.id = role.account_id and account.is_active = 1)
							inner join lsc_metadata metarole
							on (rolemap.role_status = metarole.meta_code and metarole.meta_name = 'role' and metarole.meta_type = 'status' and metarole.is_active = 1)
							inner join lsc_metadata metaregion
							on (account.region_id = metaregion.meta_code and metaregion.meta_name = 'account' and metaregion.meta_type = 'Region' and metaregion.is_active = 1)				
					where	user.is_active = 1
					and		rolemap.user_id = ".$userID;

		$userAssignedTasks_data = $this->dbUtil->executeSelect($sqlquery);
		return $userAssignedTasks_data;
	}
	
	public function getUserAssignedTasks()
	{
		$loginUserId = $this->session->getUserId();
		$userID = $loginUserId;
	
		$sqlquery = "select account.account_name as acctname, role.role_name as rolename,
							metarole.meta_text as rolestatus, metaregion.meta_text as region,
							DATE_FORMAT(DATE_ADD(rolemap.certified_date, INTERVAL 1 YEAR),'%d-%b-%y') as certified_date,
							account.id as account_id, role.id as role_id
				 	 from	lsc_users user
							inner join lsc_role_user_mapping rolemap
							on (user.id = rolemap.user_id and rolemap.is_active = 1)
							inner join lsc_role role
							on (role.id = rolemap.role_id and role.is_active = 1)
							inner join lsc_account account
							on (account.id = role.account_id and account.is_active = 1)
							inner join lsc_metadata metarole
							on (rolemap.role_status = metarole.meta_code and metarole.meta_name = 'role' and metarole.meta_type = 'status' and metarole.is_active = 1)
							inner join lsc_metadata metaregion
							on (account.region_id = metaregion.meta_code and metaregion.meta_name = 'account' and metaregion.meta_type = 'Region' and metaregion.is_active = 1)
					where	user.is_active = 1
					and		rolemap.user_id = ".$userID;
	
		$userAssignedTasks_data = $this->dbUtil->executeSelect($sqlquery);
		return $userAssignedTasks_data;
	}	
	
	public function getUserAccountData($knodeVal)
	{
		$loginUserId = $this->session->getUserId();
		$userID = $loginUserId;
	
		$sqlquery = "select distinct account.account_name as acctname, account.id as account_id
					from 	lsc_role_user_mapping rolemap
							inner join lsc_role_module_mapping modulemap
							on (rolemap.role_id = modulemap.role_id and modulemap.is_active = 1)
							inner join lsc_module module
							on (module.id = modulemap.module_id and module.is_active = 1)
							inner join lsc_role role
							on (role.id = rolemap.role_id and role.is_active = 1)
							inner join lsc_account account
							on (account.id = role.account_id and account.is_active = 1)
					where	rolemap.is_active = 1
					and		rolemap.user_id = ".$userID."
					and		module.k_node	= ".$knodeVal;		

		$userAssignedAccount_data = $this->dbUtil->executeSelect($sqlquery);
		return $userAssignedAccount_data;
	}
	
	public function getUserRoleData($knodeVal, $accountVal = 0)
	{
		$loginUserId = $this->session->getUserId();
		$userID = $loginUserId;
	
		$sqlquery = "select distinct role.role_name as rolename, role.id as role_id
					from 	lsc_role_user_mapping rolemap
							inner join lsc_role_module_mapping modulemap
							on (rolemap.role_id = modulemap.role_id and modulemap.is_active = 1)
							inner join lsc_module module
							on (module.id = modulemap.module_id and module.is_active = 1)
							inner join lsc_role role
							on (role.id = rolemap.role_id and role.is_active = 1)
							inner join lsc_account account
							on (account.id = role.account_id and account.is_active = 1)
					where	rolemap.is_active = 1
					and		rolemap.user_id = ".$userID."
					and		module.k_node	= ".$knodeVal;
		
		if ($knodeVal > 1)
		{
			$sqlquery .= " and role.account_id = ".$accountVal;
		}							
					
		$userAssignedRole_data = $this->dbUtil->executeSelect($sqlquery);
		return $userAssignedRole_data;
	}	

	public function getUserAssignedModulesData($knodeID, $accountID, $roleID)
	{
		$loginUserId = $this->session->getUserId();
		$userID = $loginUserId;
		
		$sqlquery = "select module.module_name,module.id as module_id,
							DATE_FORMAT(DATE_ADD(rolemodmap.assign_date, INTERVAL module.module_threshold DAY),'%d-%b-%y') as targetdate, 
							meta.meta_text as module_status, role.role_name, role.id as role_id, 
							DATE_FORMAT(rolemodmap.completed_date, '%d-%b-%y') as completed_date
					 from	lsc_role role
							inner join lsc_role_module_user_mapping rolemodmap
							on (rolemodmap.role_id = role.id and rolemodmap.is_active = 1)
							inner join lsc_module module
							on (module.id = rolemodmap.module_id and module.is_active = 1)
							inner join lsc_metadata meta
							on (meta.meta_code = rolemodmap.module_status and meta.meta_name = 'module' and meta_type = 'status' and meta.is_active = 1)
					where 	role.is_active = 1
					and 	role.id = ".$roleID."
					and 	module.k_node = ".$knodeID."
					and 	rolemodmap.user_id = ".$userID;
		
		if ($knodeID > 1)
		{
			$sqlquery .= " and role.account_id = ".$accountID;
		}

		//echo "<br>";
		//echo "Debug SQL as : $sqlquery";
	
		$userAssignedModules_data = $this->dbUtil->executeSelect($sqlquery);
		return $userAssignedModules_data;
	}	
}
?>