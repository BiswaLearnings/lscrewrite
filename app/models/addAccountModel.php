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
// @Created by Biswakalyana Mohanty                                                      // 
// @date 2012-12-12                                                      	   			// 
// @version 1.0								       										// 
// @description:                              	    // 
//                                                                              		// 
////////////////////////////////////////////////////////////////////////////////////////// 
?>
<?php
/**
 * 
 */
require_once __SITE_PATH.'/log4php/Logger.php';
require_once __SITE_PATH.'/libs/Form.php';
require_once __SITE_PATH.'/libs/db.php';
require_once __SITE_PATH.'/libs/DBUtil.php';
class addAccountModel{
	
	var $logger;
	var $form;
	var $db;
	public $vars = array();
	public $submittedValues = array();
	private $accountFields = array();
	
	
    public function __construct() {
       $this->logger = new Logger("Add New Account Model"); 
       $this->form = new form();
       $this->db = new DBUtil();
    }
    
    /**
     * @author Biswakalyana Mohanty
     * fetch all combo field values from DB that will be required in add or edit account screen
     */
    public function getCombos(){

    	$row = "meta_code as id, meta_text as Meta_value, meta_type as type";
    	$where="meta_name='account'";
    	$result=$this->db->select('lsc_metadata',$row,$where);
    	return $result;
    }
    
    public function redirectToForm(){
      $template = new Template();
      $template->show('addAccount','','account');
    }
    
    
     /**
     * @author Biswakalyana Mohanty
     * Creates a new account in DB
     * calls Valid() method.
     * If all fields are valid, then save the details in DB
     */
    public function saveAccount($fieldValue)
    {
    	
    	$validResult = $this->valid($fieldValue,'create');
    	if($validResult==0)
		{
			$this->audit('create');
			$this->accountFields['is_active']=1;
			$table='lsc_account';
			$i=0;
			foreach ($this->accountFields as $key=>$value) {
				$rows[$i]=$key;
				$values[$i]=$value;
				$i++;
			}
			//$rows=array("account_name", "account_shortname", "account_description", "global_account", "region_id", "account_verticalid", "primary_scope", "account_statusid", "supported_india", "Account_executive_globalid", "orgunit_designation", "orgunit_headid","orgunit_signature","content_type_ou", "account_lead_india", "account_designation", "account_leadid","account_signature","content_type_al", "lsc_admin","account_logo","is_active", "created_by", "created_date", "modified_by", "modified_date");
			//$values=array($this->accountFields['account_name'],$this->accountFields['account_shortname'],$this->accountFields['account_description'],$this->accountFields['global_account'],$this->accountFields['region_id'],$this->accountFields['account_verticalid'],$this->accountFields['primary_scope'],$this->accountFields['account_statusid'],$this->accountFields['supported_india'],$this->accountFields['Account_executive_globalid'],$this->accountFields['orgunit_designation'],$this->accountFields['orgunit_headid'],$this->accountFields['orgunit_signature'],$this->accountFields['content_type_ou'],$this->accountFields['account_lead_india'],$this->accountFields['account_designation'],$this->accountFields['account_leadid'],$this->accountFields['account_signature'],$this->accountFields['content_type_al'],$this->accountFields['lsc_admin'],$this->accountFields['account_logo'],$this->accountFields['is_active'],$this->accountFields['created_by'],$this->accountFields['created_date'],$this->accountFields['modified_by'],$this->accountFields['modified_date']);
			$success = $this->db->insert($table, $values,$rows);
			
			if ($success==1) {
				$accountId = $this->db->select($table,'MAX(id) as id');
				$this->submittedValues["id"] = $accountId[0]["id"];
				$this->submittedValues["status"]="success";
				$_SESSION['createAccount']='';
				return $this->submittedValues;
			}
			
		}
		else
		{
			$this->submittedValues["status"]="error";
				return $this->submittedValues;
		}
    }
    
    /**
     * @author Biswakalyana Mohanty
     * Updates a account details in DB
     * calls Valid() method.
     * If all fields are valid, then save the details in DB
     */
    public function updateAccount($accountDetails)
    {
  
    	$this->submittedValues["id"] = $accountDetails['id'];
  		$validResult = $this->valid($accountDetails,'update');
    	if($validResult==0)
		{
			$this->audit('update');
			$table='lsc_account';
			$where="id=".$accountDetails['id'];
			foreach ($this->accountFields as $key => $row) {
            	if (is_string($row)){
               		$values[$key] = $key."='" . $row . "'";
            	}
            	else{
            		$values[$key] = $key."=" . $row;
            	}
			}
			$success=$this->db->update($table, $values,$where);
		if ($success==1) {
			
				$this->submittedValues["status"]="success";
				return $this->submittedValues;
			}
		}
		else
		{
			$this->submittedValues["status"]="error";
				return $this->submittedValues;
		}
    }
    
    /**
     * @author Biswakalyana Mohanty
     * Calls valid<fieldname> function for all the fields
     */
public function valid($fieldValue,$calledFrom)
	{
	
		$validResult=0;
		foreach($fieldValue as $key=>$value)
		{
			if (in_array($key, array('id','changeOrgUnitHeadSignature','requestOrgUnitHeadSignature','changeAccountLeadSignature','requestAccountLeadSignature','logo'))) {
				continue;
			}
			else{
				
				$functionName='valid'.$key;
				if($key == 'accountshortname'){
					$validResult=$validResult + $this->$functionName($value,$calledFrom);
				}
				else{
				$validResult=$validResult + $this->$functionName($value);
				}
			}
			
		}
    	
    	/*
    	 * When an error state triggers in a field, respective validation method will return 1 or 2. 
    	 * So that $validResult field value will become non-Zero.
    	 * When there is no error in any of the fields So that $validResult field value will remain as 0.
    	 */
		return $validResult;
	}
//Account Name validation
   public function validaccountname($accountName)
    {
        if($accountName==NULL){
        	$this->form->setValue('accountname','Account name can not be blank *');
        	return 1;
        }
        else{
    	//length validation
    	$length=strlen($accountName);
    	if($length<40){
    		
    	    		//special character validation
    	$nameArray = str_split($accountName);
    	for($i=0;$i<$length;)
    	{
    		$ascii=ord($nameArray[$i]);
    		if((($ascii>64)&&($ascii<91))||(($ascii>96)&&($ascii<123))||(($ascii>47)&&($ascii<58))||($ascii==32))
    		{
    			$i++;
    		}
    		else
    		{
    			$this->form->setValue('accountname', 'Only Alpha numeric are allowed in Account name *');
    			break;
    		}
    	}
    	
    	if($i==$length){
    		$this->accountFields['account_name']=$accountName;
    		return 0;
    	}
    	else{
    		return 1;
    	}
    	}
    	else{
    		$this->form->setValue('accountname', 'Account name should not contain more than 40 characters *');
    		return 2;
    	}
    }
    }
//Account Acronym validation
    public function validaccountshortname($Name,$calledFrom){
        if($Name==NULL){
        	$this->form->setValue('accountshortname', 'Account Acronym can not be blank *');
        	return 1;
        }
        else{
        	//length validation
    	$length=strlen($Name);
    	if($length<20){
    		
    		//special character validation
    		$nameArray = str_split($Name);
    		for($i=0;$i<$length;)
    		{
    			$ascii=ord($nameArray[$i]);
    			if((($ascii>64)&&($ascii<91))||(($ascii>96)&&($ascii<123))||(($ascii>47)&&($ascii<58)||($ascii==32)))
    			{
    				$i++;
    			}
    			else
    			{
    			$this->form->setValue('accountshortname', 'Only Alpha numeric are allowed in Account acronym *');
    			return 1;
    			}
    		}
    		
    		if($calledFrom=='create')
    		{
    			$checkShortname = $this->db->select("lsc_account","id","account_shortname='".$Name."'");
    				if(!empty($checkShortname[0]["id"]))
    				{
    					$this->form->setValue('accountshortname', 'Account shortname already exists *');
    					return  1;
    				}
    				else
    				{
    					 
    					$this->accountFields['account_shortname']=$Name;
    					return 0;
    				}
    			}
    			else if($calledFrom=='update')
    			{
    				$this->accountFields['account_shortname']=$Name;
    				return 0;
    		}
    		
    	}
    	else{
    	$this->form->setValue('accountshortname', 'Account name should not contain more than 20 characters *');
    	return 2;
    	}
    }
    }
 //Account Description validation
    public function validaccountdescription($description)		
       {		
    	if($description==NULL){
    		$this->form->setValue('accountdescription', 'Account Description cannot be blank *');
    		return 1;
    	}
    	else{
    		$this->accountFields['account_description']=$description;
    		return  0;
    	}
    	
    }
//Account Region validation
    public function validregionid($region)					
    {
    	if($region==NULL)
    	{
    		$this->form->setValue('regionid', 'Select a region *');
    		return 1;
    	}
    	else{
    		$this->accountFields['region_id']=$region;
    		return  0;
    	}
    }
//Is Global field validation
    public function validglobalaccount($global)				
    {
    	
    	if ($global==NULL)
    	{
    		$this->form->setValue('globalaccount', 'Select an option for the field Global account *');
    		return 1;
    	}
    	else if ($global=='Yes'){
    		$this->accountFields['global_account']=1;
    		return  0;
    	}
    	else if ($global=='No'){
    		$this->accountFields['global_account']=0;
    		return  0;
    	}
    }
//Account Vertical field validation
    public function validaccountverticalid($vertical)				
    {
    	if ($vertical==NULL)
    	{
    		$this->form->setValue('accountverticalid', 'Select an Account Vertical *');
    		return 1;
    	}
    else{
    		$this->accountFields['account_verticalid']=$vertical;
    		return  0;
    	}
    }
//Account status field validation
    public function validaccountstatusid($status)					
    {
    	if ($status==NULL)
    	{
    		$this->form->setValue('accountstatusid', 'Select an Account Status *');
    		return 1;
    	}
    else{
    		$this->accountFields['account_statusid']=$status;
    		return  0;
    	}
    }
//Primary engagement scope field validation
    public function validprimaryengagmentscope($scope)						
    {
    	if ($scope==NULL)
    	{
    		$this->form->setValue('primaryengagmentscope', 'Select a Primary engagement scope *');
    		return 1;
    	}
    else{
    		$this->accountFields['primary_scope']=$scope;
    		return  0;
    	}
    }
// Already supported by CSC India field validation
    public function validsupportedinindia($supported)				
    {
    	if ($supported==NULL)
    	{
    		$this->form->setValue('supportedinindia', 'Select an option for the field Already Supported by CSC India *');
    		return 1;
    	}
     	else if($supported=='Yes'){
    		$this->accountFields['supported_india']=1;
    		return  0;
    	}
   		else if($supported=='No'){
    		$this->accountFields['supported_india']=0;
    		return  0;
    	}
    }
//Account executive field validation    
  	public function validAccountexecutiveglobalid($accountExec)
  	{
  		if ($accountExec==null) {
  			$this->form->setValue('Accountexecutiveglobalid','Enetr an Account Executive');
  			return 1;
  		}
  	else{
  			$where="user_name='".$accountExec."'";
    		$result=$this->db->select("lsc_users","*",$where);
    		if ($result==null) {
    			$this->form->setValue('Accountexecutiveglobalid','Enetr a avlid user for Account Executive');
    			return 1;
    		}
    		else{
  			$this->accountFields['Account_executive_globalid']=$result[0]['id'];
    		return  0;
    		}
    	}
  	}
//Org unit head designation dropdown validation.
  	 public function validorgunitdesignation($orgUnitHead){
  	 	if ($orgUnitHead==NULL)
  	 	{
  	 		$this->form->setValue('orgunitdesignation', 'Select an Org Unit Head Designation *');
  	 		return 1;
  	 	}
  	 else{
    		$this->accountFields['orgunit_designation']=$orgUnitHead;
    		return  0;
    	}
  	 }
//Org unit head field validation.
	public function validorgunithead($OrgUnitHead){
  	 	if ($OrgUnitHead==NULL)
  	 	{
  	 		$this->form->setValue('orgunithead', 'Select an Org Unit Head *');
  	 		return 1;
  	 	}
	else{
    	$where="user_name='".$OrgUnitHead."'";
    		$result=$this->db->select("lsc_users","*",$where);
    		if ($result==null) {
    			$this->form->setValue('orgunithead', 'Select a valid user for Org Unit Head *');
    			return 1;
    		}
    		else{
    			$this->accountFields['orgunit_headid']=$result[0]['id'];
    		return  0;
    		}
			
    	}
  	 }
//Org unit head signature field validation.
	public function validorgunitsignature($OrgUnitHead){
		if($OrgUnitHead=="keep old image"){
			$image = $this->db->select("lsc_account","orgunit_signature","id=".$this->submittedValues["id"]);
			$this->submittedValues['orgunitsignature']= $image[0]["orgunit_signature"];
			return 0;
		}
  	 	elseif ($OrgUnitHead['error']==0)
  	 	{
  	 		$imgdetails = getimagesize($OrgUnitHead['tmp_name']);
  	 		 $validImageTypes = array("image/jpg", "image/gif", "image/png", "image/x-png", "image/bmp", "image/jpeg", "image/pjpeg");
  	 		 if(in_array($imgdetails['mime'],$validImageTypes))
  	 		{
  	 			if ($OrgUnitHead['size']>2097152)
  	 			{
  	 				$this->form->setValue('orgunitsignature', 'Org Unit Head signature file is more than 2MB *');
  	 				$_SESSION['createAccount']['orgunitsignature'] = null;
  	 				return 1;
  	 			}
  	 			else {
  	 				$this->accountFields['content_type_ou'] = $imgdetails['mime'];
  	 				$this->accountFields['orgunit_signature'] = addslashes(file_get_contents($OrgUnitHead['tmp_name']));
  	 				$_SESSION['createAccount']['orgunitsignature']= $this->accountFields['orgunit_signature'];
  	 				$this->submittedValues['orgunitsignature'] = $this->accountFields['orgunit_signature'];
  	 				return 0;
  	 			}
  	 		}
  	 		else{
  	 			$this->form->setValue('orgunitsignature', 'Upload a .jpeg or .png file for Org Unit Head signature *');
  	 			$_SESSION['createAccount']['orgunitsignature'] = null;
  	 			return 1;
  	 		}
  	 	}
  	 	else if ($OrgUnitHead['error']==4)
  	 	{
  	 		if (!empty($_SESSION['createAccount']['orgunitsignature'])) {
  	 			$this->accountFields['orgunit_signature'] = $_SESSION['createAccount']['orgunitsignature'];
  	 			$this->submittedValues['orgunitsignature'] = $_SESSION['createAccount']['orgunitsignature'];
  	 			return 0;
  	 		}
  	 		else{
  	 			$this->form->setValue('orgunitsignature', 'Upload an Org Unit Head signature *');
  	 			return 1;
  	 		}
  	 		
  	 	}
  	 }
// Account lead in India field validation
	public function validaccountleadinindia($accountLeadIndia)
	{
		if ($accountLeadIndia==null) {
			$this->form->setValue('accountleadinindia','Select an Account lead in India');
		}
		else{
			$where="user_name='".$accountLeadIndia."'";
			$result=$this->db->select("lsc_users","*",$where);
			if ($result==null){
			$this->form->setValue('accountleadinindia','Select a valid userid for Account lead in India');	
			return  1;
			}
			else{
			$this->accountFields['account_lead_india']=$result[0]['id'];
			return 0;
			}
			
		}
	}
  	 //Account Lead Designation field validation.
	public function validAccountdesignation($accountLead){
  	 	if ($accountLead==NULL)
  	 	{
  	 		$this->form->setValue('Accountdesignation', 'Select an Account lead Designation *');
  	 		return 1;
  	 	}
	else{
    		$this->accountFields['account_designation']=$accountLead;
    		return  0;
    	}
  	 }
//Account Lead field validation. 
	public function validaccountleadid($accountLead){
  	 	if ($accountLead==NULL)
  	 	{
  	 		$this->form->setValue('accountleadid', 'Select an Account lead *');
  	 		return 1;
  	 	}
	else{
			$where="user_name='".$accountLead."'";
			$result=$this->db->select("lsc_users","*",$where);
			if ($result==null) {
				$this->form->setValue('accountleadid', 'Select a valid user for Account lead *');
				return 1;
			}
			else{
    		$this->accountFields['account_leadid']=$result[0]['id'];
    		return  0;
			}
    		
    	}
  	 }
//Account Lead Signature field validation. 
	public function validaccountsignature($accountLead){
	if($accountLead=="keep old image"){
			$image =  $this->db->select("lsc_account","account_signature","id=".$this->submittedValues["id"]);
			$this->submittedValues['accountsignature']= $image[0]["account_signature"];
			return 0;
		}
  	 elseif ($accountLead['error']==0)
   	{
   		$imgdetails = getimagesize($accountLead['tmp_name']);
   		$validImageTypes = array("image/jpg", "image/gif", "image/png", "image/x-png", "image/bmp", "image/jpeg", "image/pjpeg");
   		 if(in_array($imgdetails['mime'],$validImageTypes))
   		{
   			if ($accountLead['size']>2097152)
   			{
   				$this->form->setValue('accountsignature', 'Account lead signature file is more than 2MB *');
   				$_SESSION['createAccount']['accountsignature'] = null;
   				return 1;
   			}
   			else {
   				$this->accountFields['content_type_al'] = $imgdetails['mime'];
   				$this->accountFields['account_signature'] = addslashes(file_get_contents($accountLead['tmp_name']));
   				$_SESSION['createAccount']['accountsignature']= $this->accountFields['account_signature'];
   				return 0;
   			}
   		}
   		else{
   			$this->form->setValue('accountsignature', 'Upload a .jpeg or .png file for Account signature *');
   			$_SESSION['createAccount']['accountsignature'] = null;
   			return 1;
   		}
   	}
   	else if ($accountLead['error']==4)
   	{
   		if (!empty($_SESSION['createAccount']['accountsignature'])) {
   			$this->accountFields['account_signature'] = $_SESSION['createAccount']['accountsignature'];
   			return 0;
   		}
   		else{
   			$this->form->setValue('accountsignature', 'Upload an Account Lead signature *');
   			return 1;
   		}
   		
   	}
  	 }
//LSC Admin representative field validation
	public function validLSCadmin($lscAdmin){
  	 	if ($lscAdmin==NULL)
  	 	{
  	 		$this->form->setValue('LSCadmin', 'Select a LSC Admin Representative *');
  	 		return 1;
  	 	}
	else{
			$where="user_name='".$lscAdmin."'";
    		$result=$this->db->select("lsc_users","*",$where);	
    		if ($result==null) {
    			$this->form->setValue('LSCadmin', 'Select a valid user for LSC Admin Representative *');
    			return  1;
    		}
    		else{
			$this->accountFields['lsc_admin']=$result[0]['id'];
			return  0;
    		}
    		
    	}
  	 }
//Account Logo validation
	public function validaccountlogo($logo){
	if($logo=="keep old image"){
		$image = $this->db->select("lsc_account","account_logo","id=".$this->submittedValues["id"]);	
		$this->submittedValues['accountlogo']= $image[0]["account_logo"];
		return 0;
		}
  	elseif ($logo['error']==0)
  	 	{
  	 		$imgdetails = getimagesize($logo['tmp_name']);
  	 		$validImageTypes = array("image/jpg", "image/gif", "image/png", "image/x-png", "image/bmp", "image/jpeg", "image/pjpeg");
  	 		 if(in_array($imgdetails['mime'],$validImageTypes))
  	 		{
  	 			if ($logo['size']>2097152)
  	 			{
  	 				$this->form->setValue('accountlogo', 'Account logo is more than 2MB *');
  	 				$_SESSION['createAccount']['accountlogo'] = null;
  	 				return 1;
  	 			}
  	 			else {
  	 				$this->accountFields['account_logo'] = addslashes(file_get_contents($logo['tmp_name']));
  	 				$_SESSION['createAccount']['accountlogo'] = $this->accountFields['account_logo'];
  	 				return 0;
  	 			}
  	 		}
  	 		else{
  	 			$this->form->setValue('accountlogo', 'Upload a .jpeg or .png file for Account Logo *');
  	 			$_SESSION['createAccount']['accountlogo'] = null;
  	 			return 1;
  	 		}
  	 	}
  	 	else if ($logo['error']==4)
  	 	{
  	 		if(!empty($_SESSION['createAccount']['accountlogo'])){
  	 			$this->accountFields['account_logo'] = $_SESSION['createAccount']['accountlogo'];
  	 			return 0;
  	 		}
  	 		else{
  	 			$this->form->setValue('accountlogo', 'Upload an Account logo *');
  	 			return 1;
  	 		}
  	 		
  	 	}
	}  

	public function validisActive($isActive){
		$this->accountFields['is_active']= $isActive;
	}
//This function will return all the error messages
    public function getvalues($fieldValue){
    	foreach($fieldValue as $key=>$value){
       		if($this->form->value($key)!=NULL){
    			$this->vars[$key]=$this->form->value($key);
    		}
    	}
    	//print_r($this->vars);
    	return $this->vars;
        }
    
//This function will set all audit data in $this->accountFields array
	public function audit($calledFrom)
	{
		if($calledFrom=='create'){
		$this->accountFields['created_by'] = $_SESSION['userid'];
		$this->accountFields['created_date'] = date('d.m.y h:i:s');
		$this->accountFields['modified_by'] = $_SESSION['userid'];
		$this->accountFields['modified_date'] = date('d.m.y h:i:s');
	}
	elseif($calledFrom=='update')
		$this->accountFields['modified_by'] = $_SESSION['userid'];
		$this->accountFields['modified_date'] = date('d.m.y h:i:s');
	}
}
?>
