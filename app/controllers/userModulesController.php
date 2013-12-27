<?php
require_once __SITE_PATH . '/app/models/userModulesModel.php';
require_once (__SITE_PATH . '/libs/db.php');
require_once (__SITE_PATH . '/libs/DBUtil.php');
require_once (__SITE_PATH . '/libs/WebUtil.php');
require_once __SITE_PATH . '/log4php/Logger.php';
require_once __SITE_PATH . '/libs/Form.php';
class userModulesController extends baseController
{
	private $model;
	private $template;
	private $logger;
	private $db;
	private $dbUtil;
	private $webUtil;
	private $dbConnection;
	private $form;

	public function __construct()
	{
		$this->template = new Template();
		$this->model = new userModulesModel();
		$this->logger = Logger::getLogger("User Modules Controller");
		$this->db = new db();
		$this->dbConnection = $this->db->getConnection();
		$this->dbUtil = new DBUtil();
		$this->webUtil = new WebUtil();
		$this->form = new Form();
	}

	public function index()
	{

	}

	public function userAssignedTasks($queryString)
	{
		$taskType = $queryString;
		if ($taskType == 'roles')
		{
			$userAssignedRoles = $this->model->getUserAssignedTasks();
			$data = array('assignedroles' => $userAssignedRoles, 'tasktype' => $taskType);
			$this->template->display('userModules', $data, 'user');
		}
		else if ($taskType == 'modules')
		{
			$knode = $this->model->populateKnodeElement();
			$userAssignedModules = $this->model->getUserAssignedTasks();
			$data = array('assignedmodules' => $userAssignedModules, 'tasktype' => $taskType, 'knode' => $knode);
			$this->template->display('userModules', $data, 'user');
		}	
	}
	
	public function userOnChangeTasks($queryString)
	{
		$actionType = $queryString[0];
		$knodeVal = $queryString[1];

		if ($actionType == 'K')
		{
			$knode = $this->model->populateKnodeElement();
			if ($knodeVal > 1)
			{	
				$userAccountData = $this->model->getUserAccountData($knodeVal);
			}
			else
			{
				$userAccountData = $this->model->getUserRoleData($knodeVal);
			}		
			$data = array('knodeval' => $knodeVal, 'assignedmodules' => $userAccountData, 'tasktype' => 'modules', 'knode' => $knode );
			$this->template->display('userModules', $data, 'user');			
		}
		else if ($actionType == 'A')
		{
			$accountVal = $queryString[2];
			$knode = $this->model->populateKnodeElement();
			$userAccountData = $this->model->getUserAccountData($knodeVal);
			$userRoleData = $this->model->getUserRoleData($knodeVal, $accountVal);
			$userAssignedData = array_merge($userAccountData, $userRoleData);
			$data = array('knodeval' => $knodeVal, 'accountval' => $accountVal, 'assignedmodules' => $userAssignedData, 'tasktype' => 'modules', 'knode' => $knode );
			$this->template->display('userModules', $data, 'user');			
		}	
	}

	
	public function userShowDetails()
	{
		$knodeSel = $_REQUEST["knode"];
		$accountSel = $_REQUEST["accountname"];
		$roleSel = $_REQUEST["rolename"];

		if (isset($_POST['showdetails']))
		{
			$knode = $this->model->populateKnodeElement();
			$userAccountData = $this->model->getUserAccountData($knodeSel);
			$userRoleData = $this->model->getUserRoleData($knodeSel, $accountSel);			
			$userAssignedModules = array_merge($userAccountData, $userRoleData);
			$userModuleData = $this->model->getUserAssignedModulesData($knodeSel, $accountSel, $roleSel);
			$data = array('knodeval' => $knodeSel, 'accountval' => $accountSel, 'roleval' => $roleSel, 'assignedmodules' => $userAssignedModules, 'tasktype' => 'modules', 'knode' => $knode, 'griddata' => $userModuleData);
			$this->template->display('userModules', $data, 'user');
		}			
	}
}
?>