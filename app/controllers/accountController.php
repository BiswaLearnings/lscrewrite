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
// @Created by Biswakalyana Mohanty                                                     // 
// @date 2012-12-12                                                      	   			// 
// @version 1.0								       										// 
// @description:                              				// 
//                                                                              		// 
////////////////////////////////////////////////////////////////////////////////////////// 
?>
<?php

require_once __SITE_PATH . '/app/models/addAccountModel.php';
require_once __SITE_PATH . '/app/models/manageAccountModel.php';
require_once __SITE_PATH . '/log4php/Logger.php';

/**
 * 
 */
class accountController extends baseController {


    var $addAccountModel;
    var $manageAccountModel;
    var $template;
    var $logger;
    var $success;
    public $data = array();
    
    public function __construct() {
        $this->addAccountModel = new addAccountModel();
		$this->manageAccountModel = new manageAccountModel();
        $this->template = new Template();
        $this->logger = Logger::getLogger("Account Controller");
	 	$this->data['combos'] = $this->addAccountModel->getCombos();
    }

    public function index() {
        $this->template->display('home', '');
    }
  
    /**
     * @author Biswakalyana Mohanty
     * showManageAccount():Displays the manageAccount.php page
     */
	public function showManageAccount() {
		$accountList = $this->manageAccountModel ->getAccountList();
        $this->template->display('manageAccount', $accountList, 'account');
    }

    /**
     * @author Biswakalyana Mohanty
     * viewAccount($accountId): Gets the account ID from manageAccount.php and displays the corresponding viewAccountt.php page
     */
    public function viewAccount($accountId){
    	$this->data['accountDetails']=$this->manageAccountModel->getAccountDetails($accountId);
    	$this->template->display('viewAccount', $this->data,'account');
    	
    }
    
    /**
     * @author Biswakalyana Mohanty
     * showCreateAccount(): Displays the addAccount.php page
     */
    public function showCreateAccount() {
        $this->logger->info("Display Add Account Form");
       $this->template->display('addAccount',$this->data,'account');
     }

     
      /**
     * @author Biswakalyana Mohanty
     * addAccount(): Accept values from addAccount.php.
     * 	Calls saveAccount()method in addAccountModel.
     *  Displays viewAccount page if account added successfully.
     *  Displays addAccount with error messages if account creation fails 		
     */
    public function addAccount() {
        if(isset($_POST['submit'])){
       foreach($_POST as $key=>$value)
       {
       	if(($key==('submit'))||($key==('globalaccount'))||($key==('signature1'))||($key==('signature2'))||($key==('supportedinindia'))){
       		continue;
       	}
       	else{
       	$this->data['fieldValue'][$key]=$value;
       }
       }
    	
    	if (isset($_POST['supportedinindia'])){
        	$this->data['fieldValue']['supportedinindia']=$_POST['supportedinindia'];
        }
        else{
        	$this->data['fieldValue']['supportedinindia']= null;
        }
       
        foreach ($_FILES as $fieldname => $filedetails)
        {
        	$this->data['fieldValue'][$fieldname] = $filedetails;
        }
       $result=$this->addAccountModel->saveAccount($this->data['fieldValue']);
       if($result["status"]=='error'){
	       	$this->data['accountDetails']['orgunitsignature']=$result['orgunitsignature'];
	       //	$this->data['accountDetails']['accountsignature']=$result['accountsignature'];
	       //	$this->data['accountDetails']['accountlogo']=$result['accountlogo'];
       $this->data['message']=$this->addAccountModel->getvalues($this->data['fieldValue']); 
       $this->template->display('addAccount', $this->data,'account'); 
       }
       else{
       	$this->viewAccount($result["id"]); 
       }
      }
      elseif(isset($_POST['cancel'])){
      	$this->showManageAccount();
      }
    }

    
    /**
     * @author 
     * Gets the account ID from manageAccount.php and displays the corresponding editAccount.php page
     * @param
     * @return type 
     */
    public function showEditAccount($accountId) {
	 	
	 	if(isset($_POST['previous'])){
      	$this->showManageAccount();
	 	}
	 	else{
		 	try{
		 		$this->data['accountDetails']=$this->manageAccountModel->getAccountDetails($accountId);
		 	}
		 	catch(ArrayIndexOutofBoundException $e){
		 		$e->getMessage();
		 	}
		 	$this->data['accountDetails']['id']=$accountId;
	        $this->template->display('editAccount', $this->data ,'account');
    	}
	 }

	 /**
     * @author Biswakalyana Mohanty
     * addAccount(): Accept values from editAccount.php.
     * 	Calls updateAccount()method in addAccountModel.
     *  Displays viewAccount page if account added successfully.
     *  Displays editAccount with error messages if account creation fails 		
     */
	 public function editAccount($accountId) {
    
    	if(isset($_POST['submit'])){
    	$this->data['accountDetails']['id']=$accountId;
    	foreach($_POST as $key=>$value)
       {
	    if(in_array($key, array('submit','isActive','supportedinindia','changeOrgUnitHeadSignature','requestOrgUnitHeadSignature','changeAccountLeadSignature','requestAccountLeadSignature'))) 
    		{
	       		continue;
	       	}
	       	else
	       	{
	       		$this->data['accountDetails'][$key]=$value;
	       	}
       }

    	if (isset($_POST['supportedinindia'])){
        		$this->data['accountDetails']['supportedinindia']=$_POST['supportedinindia'];
        	}
        	else{
        		$this->data['accountDetails']['supportedinindia']= null;
        	}
        if(isset($_POST['isActive'])){
        		$this->data['accountDetails']['supportedinindia'] = 1;
	        }
	        else{
	        	$this->data['accountDetails']['supportedinindia'] = 0;
	        }
        	
        if(!empty($_FILES['orgunitsignature']['tmp_name'])){
        	$this->data['accountDetails']['orgunitsignature']=$_FILES['orgunitsignature'];
        }
        else{
        	$this->data['accountDetails']['orgunitsignature']="keep old image";
        }
	        
	        
    	if(!empty($_FILES['accountsignature']['tmp_name'])){
        		$this->data['accountDetails']['accountsignature']=$_FILES['accountsignature'];
	        }
	        else{
	        	$this->data['accountDetails']['accountsignature']="keep old image";
	        }
    	if(!empty($_FILES['accountlogo']['tmp_name'])){
	        	$this->data['accountDetails']['accountlogo']=$_FILES['accountlogo'];
	        }
	        else{
	        	$this->data['accountDetails']['accountlogo']="keep old image";
	        }
    	$result=$this->addAccountModel->updateAccount($this->data['accountDetails']);
       if($result["status"]=='error'){
	       $this->data['accountDetails']['orgunitsignature']=$result['orgunitsignature'];
	       $this->data['accountDetails']['accountsignature']=$result['accountsignature'];
	       $this->data['accountDetails']['accountlogo']=$result['accountlogo'];
	       $this->data['message']=$this->addAccountModel->getvalues($this->data['accountDetails']); 
	       $this->template->display('editAccount', $this->data,'account'); 
       }
       else{
       	$this->viewAccount($accountId);
       }
    }
    elseif(isset($_POST['cancel'])){
      	$this->showManageAccount();
      }
       
    }
    
   
    
 


}

?>
