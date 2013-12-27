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
// @Created by: Rajendra N Mohanty                                                      //
// @date: 2013/03/12  		                                                	   		//
// @version: 1.0								       									//
// @description:                                                                	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////

require_once (__SITE_PATH . '/libs/DBUtil.php');
require_once __SITE_PATH.'/log4php/Logger.php';
require_once __SITE_PATH.'/libs/Form.php'; 

class ModuleListModel
{
	var $logger;
	var $form;
	var $db;
	var $vars= array();
	
	public function __construct() {
       $this->logger = new Logger("Add New Account Model"); 
       $this->form = new form();
       $this->db = new DBUtil();
    } 
	
	function getKnowledge()
	{
		$cond='"module"';
		$cond1='"knode"';
		$rows='meta_code'.','.'meta_text';
		$where='meta_name'.'='.$cond.' AND '.'meta_type'.'='.$cond1;
		return  $this->db->select("lsc_metadata",$rows,$where);
	}
	
	function getAccounts()
	{
		$cond2='1';
		$rows='id'.','.'account_name';
		$where='is_active'.'='.$cond2;
		return  $this->db->select("lsc_account",$rows);
	}
	
	function getModules($knode,$account)
	{
		$cond2='1';
		$rows='id'.','.'module_name';
		$where='k_node'.' = '.$knode.' AND '.'account_id'.' = '.$account.' AND '.'is_active'.'='.$cond2;
		return  $this->db->select("lsc_module",$rows,$where);
	}
	
	function getThreshold(){
		$cond1='"module"'; 
		$cond2='"threshold"';
		$rows='meta_code'.','.'meta_text';
		$where='meta_name'.'='.$cond1.' AND '.'meta_type'.'='.$cond2;
		return  $this->db->select("lsc_metadata",$rows,$where);
	}

	function getModuleDetails($id){
		
		$cond2='1';
		$where='id'.' = '.$id.' AND '.'is_active'.'='.$cond2;
		return  $this->db->select("lsc_module",'*',$where);
	}
	
	function updateModule($id,$fieldValue){
		 
		$columnvalues= array();
		$columnvalues['modulename']=$fieldValue[0];
		$columnvalues['Trainingminutes']=$fieldValue[1];
		$columnvalues['Isconfidential']=$fieldValue[2];
		$columnvalues['Threshold']=$fieldValue[3];
		$columnvalues['isactive']=$fieldValue[4];
		$valid=$this->ValidateTrainingMin($columnvalues['Trainingminutes']);
		if ($valid == 0){
			return 0;
		}
		$where='id'.' = '.$id;
		$set =Array(" module_name = '". $columnvalues['modulename']."',
					training_minutes = '".$columnvalues['Trainingminutes']."',
					is_confidential = ".$columnvalues['Isconfidential'].",
					module_threshold = ".$columnvalues['Threshold'].",
					is_active = ".$columnvalues['isactive']);
		return  $this->db->update("lsc_module",$set,$where);
	}
	
	public function AddModule($knode,$accountid,$fieldValue){
		 
    	$columnvalues= array();
    	$columnvalues['knode']=$knode;
    	$columnvalues['accountid']=$accountid;
		$columnvalues['modulename']=$fieldValue[0];
		$columnvalues['Trainingminutes']=$fieldValue[1];
		$columnvalues['IsConfidential']=$fieldValue[2];
		$columnvalues['Threshold']=$fieldValue[3];
		$columnvalues['isactive']=$fieldValue[4];
		//
		$valid=$this->ValidateModuleName($knode,$accountid,$fieldValue[0],$fieldValue[1]);
		if ($valid == 0){
			return 0;
		}
		else {
			$rows[1]= 'k_node';
			$rows[2]= 'account_id';
			$rows[3]= 'module_name';
			$rows[4]= 'training_minutes';
			$rows[5]= 'is_confidential';
			$rows[6]= 'module_threshold';
			$rows[7]= 'is_active';
			return  $this->db->insert("lsc_module",$columnvalues,$rows);
		}
    }
   
    public function getvalues($fieldValue){
      	foreach($fieldValue as $key=>$value){
    		if($this->form->value($key)!=NULL){
    			$this->vars[$key]=$this->form->value($key);
    		}
    	}
    	return $this->vars;
	} 
	
	public function ValidateMangeModuleFields($knode){
		if($knode==0){
        	$this->form->setValue('knode','Please select a Knowledge Node *');
        	return 0;
		}
		else {
			return 1;
		}
	}
	
	public function ValidateTrainingMin($trainingMinutes)
    {
        if($trainingMinutes==NULL){
        	$this->form->setValue('Trainingminutes','Training Minutes can not be blank');
        	return 0;
        }
        else{
	    	//length validation
	    	$length=strlen($trainingMinutes);
	    	//special character validation
	    	$nameArray = str_split($trainingMinutes);
	    	for($i=0;$i<$length;)
	    	{
	    		$ascii=ord($nameArray[$i]);
	    		if(($ascii>47)&&($ascii<58))
	    		{
	    			$i++;
	    		}
	    		else
	    		{
	    			$this->form->setValue('Trainingminutes', 'Only numeric values are allowed in Training Minutes');
	    			break;
	    		}
	    	}
	       	if ($i==$length){
	       		if ($length>3) {
	       			$this->form->setValue('Trainingminutes', 'Training Minutes should not contain more than 3 digits');
    				return 0;
	       		}
	       		else {
	       			return 1;	
	       		}
	    			
	    	}
	    	else {
	    		return 0;
	    	} 
    	}
    }
	
    public function ValidateModuleName($knode,$accountid,$moduleName,$Trainingminutes)
    {
        $errorTraining=$this->ValidateTrainingMin($Trainingminutes);
        
    	if($moduleName==NULL){
        	$this->form->setValue('moduleName','Module Name can not be blank');
        	$error=0;
        }
        else{
	    	//length validation
	    	$length=strlen($moduleName);
	    	//special character validation
	    	$nameArray = str_split($moduleName);
	    	for($i=0;$i<$length;)
	    	{
	    		$ascii=ord($nameArray[$i]);
	    		if((($ascii>64)&&($ascii<91))||(($ascii>96)&&($ascii<123))||(($ascii>47)&&($ascii<58))||($ascii==32))
	    		{
	    			$i++;
	    		}
	    		else
	    		{
	    			$this->form->setValue('moduleName', 'Only Alpha numeric values are allowed in Module Name');
	    			break;
	    		}
	    	}
	       	if ($i==$length){
	       		if ($length>40) {
	       			$this->form->setValue('moduleName', 'Module Name should not contain more than 40 characters');
    				$error=0;
	       		}
	       		else {
	       			$error=1;	
	       		}
	    			
	    	}
	    	else {
	    		$error=0;
	    	} 
    	}
    	//
    	if (($errorTraining==0) || ($error==0)){
    		return 0;
    	}
    	else {
    		//Check from the DataBase
	    	 
			$rows='id';
			$where='k_node'.' = '.$knode.' AND '.'account_id'.' = '.$accountid.' AND '.'module_name'.'="'.$moduleName.'"';
			$temp=array();
			$temp= $this->db->select("lsc_module",$rows,$where);
			foreach($temp as $key=>$val){
				foreach($val as $key1=>$val1)
				{
					if ($val1!=""){
						$this->form->setValue('OldModuleName', 'One or All Module Names are exist in the Database');
	    				return 0;
					}
				}
			}
    		return 1;
    	}
    }
    
    //Quiz Maintenance :Start
	function getStatus()
	{
		$cond='"module"';
		$cond1='"status"';
		$rows='meta_code'.','.'meta_text';
		$where='meta_name'.'='.$cond.' AND '.'meta_type'.'='.$cond1;
		return  $this->db->select("lsc_metadata",$rows,$where);
	}
	function getGradingMethod()
	{
		$cond='"module"';
		$cond1='"gradingmethod"';
		$rows='meta_code'.','.'meta_text';
		$where='meta_name'.'='.$cond.' AND '.'meta_type'.'='.$cond1;
		return  $this->db->select("lsc_metadata",$rows,$where);
	}
	function getGradeBoundary()
	{
		$cond='"module"';
		$cond1='"gradeboundary"';
		$rows='meta_code'.','.'meta_text';
		$where='meta_name'.'='.$cond.' AND '.'meta_type'.'='.$cond1;
		return  $this->db->select("lsc_metadata",$rows,$where);
	}
	function getAttemptsAllowed()
	{
		$cond='"module"';
		$cond1='"attemptsallowed"';
		$rows='meta_code'.','.'meta_text';
		$where='meta_name'.'='.$cond.' AND '.'meta_type'.'='.$cond1;
		return  $this->db->select("lsc_metadata",$rows,$where);
	}
	function getQuestionPerPage()
	{
		$cond='"module"';
		$cond1='"questionperpage"';
		$rows='meta_code'.','.'meta_text';
		$where='meta_name'.'='.$cond.' AND '.'meta_type'.'='.$cond1;
		return  $this->db->select("lsc_metadata",$rows,$where);
	}
	function GetQuizID($moduleID){
		$cond='1';
		$rows='id';
		$where='module_id'.'='.$moduleID.' AND '.'is_active'.'='.$cond;
		return  $this->db->select("lsc_module_quiz",$rows,$where);
	}
	function GetFeedBackID($quizID){
		$cond='1';
		$rows='id';
		$where='quiz_id'.'='.$quizID.' AND '.'is_active'.'='.$cond;
		return  $this->db->select("lsc_quiz_feedback",$rows,$where);
	}
	function GetQuizDetails($moduleID){
		$cond='1';
		$where='module_id'.'='.$moduleID.' AND '.'is_active'.'='.$cond;
		return  $this->db->select("lsc_module_quiz",'*',$where);
	}
	function GetFeedbackDetails($quizID){
		$where='quiz_id'.'='.$quizID;
		return  $this->db->select("lsc_quiz_feedback",'*',$where);
	} 
	function InsertQuiz($moduleID,$generalDetails){
		
		$columnvalues= array();
		$columnvalues['moduleID']=$moduleID;
    	$columnvalues['assessmentName']=$generalDetails[0];
    	$columnvalues['timeLimit']=$generalDetails[1];
		$columnvalues['questionPerPage']=$generalDetails[2];
		$columnvalues['ShuffleQ']=$generalDetails[3];
		$columnvalues['ShuffleWithinQ']=$generalDetails[4];
		$columnvalues['attemptsAllowed']=$generalDetails[5];
		$columnvalues['gradingMethod']=$generalDetails[6];
		$columnvalues['reqGrade']=$generalDetails[7];
		$columnvalues['isActive']=$generalDetails[8];
		//
		$valid=$this->CheckRequiredField($generalDetails[0],$generalDetails[1]);
		if ($valid==0){
			return 0; 
		}
		//
		$rows[1]= 'module_id';
		$rows[2]= 'quiz_name';
		$rows[3]= 'time_limit';
		$rows[4]= 'question_perpage';
		$rows[5]= 'shuffle_questions';
		$rows[6]= 'shuffle_within_questions';
		$rows[7]= 'attempts_allowed';
		$rows[8]= 'grading_methods';
		$rows[9]= 'required_grade';
		$rows[10]= 'is_active';
		//
		return  $this->db->insert("lsc_module_quiz",$columnvalues,$rows);
	} 
	
	function UpdateQuiz($quizID,$moduleID,$generalDetails){
		$columnvalues= array();
		$columnvalues['assessmentName']=$generalDetails[0];
    	$columnvalues['timeLimit']=$generalDetails[1];
		$columnvalues['questionPerPage']=$generalDetails[2];
		$columnvalues['ShuffleQ']=$generalDetails[3];
		$columnvalues['ShuffleWithinQ']=$generalDetails[4];
		$columnvalues['attemptsAllowed']=$generalDetails[5];
		$columnvalues['gradingMethod']=$generalDetails[6];
		$columnvalues['reqGrade']=$generalDetails[7];
		$columnvalues['isActive']=$generalDetails[8];
		//
		
		$valid=$this->CheckRequiredField($generalDetails[0],$generalDetails[1]);
		if ($valid==0){
			return 0; 
		}
		$where='id'.' = '.$quizID.' AND '.'module_id'.'='.$moduleID;
		//
		$set =Array(" quiz_name = '". $columnvalues['assessmentName']."',
					time_limit = '".$columnvalues['timeLimit']."',
					question_perpage = ".$columnvalues['questionPerPage'].",
					shuffle_questions = ".$columnvalues['ShuffleQ'].",
					shuffle_within_questions = ".$columnvalues['ShuffleWithinQ'].",
					attempts_allowed = ".$columnvalues['attemptsAllowed'].",
					grading_methods = ".$columnvalues['gradingMethod'].",
					required_grade = ".$columnvalues['reqGrade'].",
					is_active = ".$columnvalues['isActive']);
					
		return  $this->db->update("lsc_module_quiz",$set,$where);
	}
	
	function InsertQuizFeedback($quizID,$feedbackDetails){
		foreach($feedbackDetails as $key=>$value){
			$status=$value[0];
			$grade=$value[1];
			$isActive=$value[2];
			$columnvalues= array();
			$columnvalues['quizID']=$quizID;
    		$columnvalues['feedbackCode']=$status;
    		$columnvalues['maxGrade']=$grade;
    		$columnvalues['minGrade']=$grade-1;
    		$columnvalues['isActive']=$isActive;
    		//    		
    		$rows[1]= 'quiz_id';
			$rows[2]= 'feedback_code';
			$rows[3]= 'max_grade';
			$rows[4]= 'min_grade';
			$rows[5]= 'is_active';
			//
			$insertStatus=$this->db->insert("lsc_quiz_feedback",$columnvalues,$rows);
		}
	}
	
	function UpdateQuizFeedback($quizID,$feedbackDetails){
		$AllIDs=array();
		$AllIDs=$this->GetFeedBackID($quizID);
		foreach($AllIDs as $Key=>$Value){
			$idArray[$Key]=$Value['id'];
		}
		$counter=0;
		foreach($feedbackDetails as $key=>$value){
			$status=$value[0];
			$grade=$value[1];
			$isActive=$value[2];
			$columnvalues= array();
			$columnvalues['feedbackCode']=$status;
    		$columnvalues['maxGrade']=$grade;
    		$columnvalues['minGrade']=$grade-1;
    		$columnvalues['isActive']=$isActive;
    		// 
    		$id=$idArray[$counter];
    		
    		$where='id'.' = '.$id.' AND '.'quiz_id ='.$quizID;
    		//    		
			$set =Array(" feedback_code = ". $columnvalues['feedbackCode'].",
					max_grade = ".$columnvalues['maxGrade'].",
					min_grade = ".$columnvalues['minGrade'].",
					is_active = ".$columnvalues['isActive']);
			
			$updateStatus=$this->db->update("lsc_quiz_feedback",$set,$where);
			$counter++;
		}
	}
	
	public function CheckRequiredField($assessmentName,$timeLimits)
    {
       	$error=1;
    	if($assessmentName==NULL){
        	$this->form->setValue('assessmentName','Assessment Name can not be blank');
        	$error=0;
        }
    	if($timeLimits==NULL){
        	$this->form->setValue('timeLimit','Time Limit(minutes) can not be blank');
        	$error=0;
        }
        return $error;
    }
    
    function getContentDetails($moduleID){
    	$cond='1';
		$where='module_id'.'='.$moduleID.' AND '.'is_active'.'='.$cond;
		return  $this->db->select("lsc_quiz_assessment_content",'*',$where);
    }
	function getContents($contentID){
    	$cond='1';
		$where='id'.'='.$contentID.' AND '.'is_active'.'='.$cond;
		return  $this->db->select("lsc_quiz_assessment_content",'*',$where);
    }
    function deleteContent($contentID){
    	$where='id'.'='.$contentID;
    	$this->db->delete("lsc_quiz_assessment_content",$where);
    }
    function SaveContentFile($contentID,$moduleID,$fieldValue){
		
    	//echo "contentType : ".$fieldValue[1];
		$columnvalues= array();
		$columnvalues['moduleID']=$moduleID;
    	$columnvalues['contentName']=$fieldValue[0];
    	$columnvalues['contentType']=$fieldValue[1];
    	if ($fieldValue[1]==0){
			$columnvalues['url']=$fieldValue[2];
			$columnvalues['skillport']=$fieldValue[3];
			$columnvalues['fileContent']='';
			$columnvalues['fileName']='';
			$columnvalues['fileType']='';
    	}
    	if ($fieldValue[1]==1){
    		$columnvalues['url']=$fieldValue[2];
			$columnvalues['skillport']=$fieldValue[3];
			$columnvalues['fileContent']=addslashes(file_get_contents($fieldValue[4]['tmp_name']));
			$columnvalues['fileName']=$fieldValue[4]['name'];
			$columnvalues['fileType']=pathinfo($fieldValue[4]['name'],PATHINFO_EXTENSION);
    	}
		$columnvalues['IsActive']=$fieldValue[5];
		//
		//print_r($columnvalues);
		$valid=$this->CheckMandatoryField($fieldValue[0],$fieldValue[1],$fieldValue[2],$fieldValue[4]);
    	if ($valid==0){
			return 0; 
		}
		$rows[1]= 'module_id';
		$rows[2]= 'content_name';
		$rows[3]= 'content_type';
		$rows[4]= 'url';
		$rows[5]= 'skillport_requried';
		$rows[6]= 'file_content';
		$rows[7]= 'file_name';
		$rows[8]= 'file_type';
		$rows[9]= 'is_active';
		//
		if ($contentID==''){
			return  $this->db->insert("lsc_quiz_assessment_content",$columnvalues,$rows);
		}
		else {
			$where='id'.' = '.$contentID;
    		//
			$set =Array(" module_id = ". $columnvalues['moduleID'].",
					content_name = '".$columnvalues['contentName']."',
					content_type = ".$columnvalues['contentType'].",
					url = '".$columnvalues['url']."',
					skillport_requried = ".$columnvalues['skillport'].",
					file_content = '".$columnvalues['fileContent']."',
					file_name = '".$columnvalues['fileName']."',
					file_type = '".$columnvalues['fileType']."',
					is_active = ".$columnvalues['IsActive']);
			
			return $this->db->update("lsc_quiz_assessment_content",$set,$where);
		}
	} 
	public function CheckMandatoryField($contentName,$contentType,$url,$contentFile){
		$error=1;
		if($contentName==NULL){
	       	$this->form->setValue('contentName','Content Name can not be blank.');
	       	$error=0;
       	}
		if ($contentType==1){
			if($contentFile['tmp_name']==NULL){
	        	$this->form->setValue('contentFile','Content File can not be blank.');
	        	$error=0;
       		}
			if($contentFile['error']==4 || $contentFile['error']==1 || $contentFile['error']==2){
	        	$this->form->setValue('fileUpload','Error in file upload.');
	        	$error=0;
	        }
        } 
        else {
	    	if($url==NULL){
	        	$this->form->setValue('url','URL can not be blank.');
	        	$error=0;
	        }
        }
        return $error;
	}
	function InsertQuestion($QuestionDetails){
		//
		$rows[1]= 'quiz_id';
		$rows[2]= 'serial';
		$rows[3]= 'question_type';
		$rows[4]= 'question_text';
		$rows[5]= 'grade';
		$rows[6]= 'in_quiz';
		$rows[7]= 'is_active';
		//
		return  $this->db->insert("lsc_quiz_question",$QuestionDetails,$rows);
	}
	function GetQuestionDetails($quizID){
		$cond='1';
		$where='quiz_id'.'='.$quizID.' AND '.'is_active'.'='.$cond;
		return  $this->db->select("lsc_quiz_question",'*',$where);
	}
	function GetQuestionType(){
		$cond='1';
		$metaname='"quiz"';
		$meta_type='"questiontype"';
		$where='meta_name'.'='.$metaname.' AND '.'meta_type'.'='.$meta_type;
		return  $this->db->select("lsc_metadata",'*',$where);
	}
}

