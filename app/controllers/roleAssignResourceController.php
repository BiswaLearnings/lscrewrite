<?php
require_once __SITE_PATH . '/app/models/roleAssignResourceModel.php';
require_once (__SITE_PATH . '/libs/db.php');
require_once (__SITE_PATH . '/libs/DBUtil.php');
require_once (__SITE_PATH . '/libs/WebUtil.php');
require_once __SITE_PATH . '/log4php/Logger.php';
require_once __SITE_PATH . '/libs/Form.php';
class roleAssignResourceController extends baseController
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
		$this->model = new roleAssignResourceModel();
		$this->logger = Logger::getLogger("RoleAssign Controller");
		$this->db = new db();
		$this->dbConnection = $this->db->getConnection();
		$this->dbUtil = new DBUtil();
		$this->webUtil = new WebUtil();
		$this->form = new Form();
	}
	
	public function index()
	{
		
	}
	
	public function assignResource($queryString)
	{
		$roleID = $queryString[0];
		$accountID = $queryString[1];
		$kttype = $this->model->populateKtType();
		$targetdate = $this->model->populateTargetDate();
		$potientalusers = $this->model->populatePotentialUsers($roleID);
		$roleAssignedUsers = $this->model->populateroleAssignedUsers($roleID);
		$ktpm = $this->model->populateKtpmUsers();
		$data = array('submissionURL' => sprintf('?load=roleAssignResource/processResource/%s/%s', $roleID, $accountID), 'kttype' => $kttype, 'targetdate' => $targetdate, 'potientalusers' => $potientalusers, 'ktpm' => $ktpm, 'roleassignedusers' => $roleAssignedUsers, 'roleID' => $roleID, 'accountID' => $accountID);
		$this->template->display('assignResource', $data, 'role');
	}
	
	public function processResource($queryString)
	{
		$roleID = $queryString[0];
		$accountID = $queryString[1];		
		if (isset($_POST['addbutton']))
		{
			$this->model->roleAssignResourceSetData();			
			$this->model->roleAssignResourceData($roleID, $accountID);
			$data = array('0' => $roleID, '1' => $accountID);
			$this->assignResource($data);
		}
		else if (isset($_POST['rembutton']))
		{
			$this->model->roleDeAssignResourceSetData();
			$this->model->roleDeAssignResourceData($roleID, $accountID);
			$data = array('0' => $roleID, '1' => $accountID);
			$this->assignResource($data);
		}		
		else if (isset($_POST['notifybutton']))
		{
			$this->model->roleNotifyAssignResourceSetData();
			$this->model->roleNotifyAssignResourceData($roleID, $accountID);
			$data = array('0' => $roleID, '1' => $accountID);
			$this->assignResource($data);
		}
	}
	
}	
?>