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
// @Created by Rajendra N Mohanty                                                       // 
// @date 2013-03-13                                                      	   			// 
// @version 1.0								       										// 
// @description:                              				// 
//                                                                              		// 
////////////////////////////////////////////////////////////////////////////////////////// 
?>
<?php

require_once __SITE_PATH . '/app/models/moduleListModel.php';
require_once __SITE_PATH . '/log4php/Logger.php';
require_once __SITE_PATH . '/libs/excel/PHPExcel.php';
require_once (__SITE_PATH . '/libs/WebUtil.php');

/**
 * 
 */
class moduleController extends baseController {

    var $template;
    var $logger;
    var $moduleListModel;
    public $data = array();
	
    public function __construct() {
        $this->template = new Template();
        $this->logger = Logger::getLogger("Module Controller");
        //
        $this->moduleListModel = new ModuleListModel();
    	$this->data['knowledge'] = $this->moduleListModel->getKnowledge();
    	$this->data['account'] = $this->moduleListModel->getAccounts();
    }
	
    public function index() {
        $this->template->display('index','', '');
    }
    
	public function showModules() {
      	
      	$knode = $_REQUEST["knowledgenode"];
      	if(isset($_REQUEST["account"])) {
      		$accountid = $_REQUEST["account"];	
      	}
      	else {
      		$accountid=0;
      	}
      	$value1['knode']="";
      	$error=$this->moduleListModel->ValidateMangeModuleFields($knode);
		if ($error==0){
			$this->data['message']=$this->moduleListModel->getvalues($value1);
			$this->template->display('manageModule',$this->data,'module'); 
		}
		else {
			if (isset($_POST['submit']) && $knode!=0) {
	    		//update action
	    		$this->data['module'] = $this->moduleListModel->getModules($knode,$accountid);
	        	$this->data['combos'] = array($knode,$accountid);
		  		$this->template->display('manageModule',$this->data,'module');
			} else if (isset($_POST['addModule']) && $knode!=0) {
		    	//Other action
		    	$this->data['BASE']=array($knode,$accountid);
		    	$this->data['threshold'] = $this->moduleListModel->getThreshold();
	    		$this->template->display('addModule',$this->data,'module');
			} else {
		    	$this->template->display('manageModule',$this->data,'module');
			}
		}
       
    }
    
    public function createModule(){
    	$knode = $_REQUEST["knowledgenode"];
      	if(isset($_REQUEST["account"])) {
      		$accountid = $_REQUEST["account"];	
      	}
      	else {
      		$accountid=0;
      	}
      	$this->data['BASE']=array($knode,$accountid);
		$this->data['threshold'] = $this->moduleListModel->getThreshold();
	    $this->template->display('addModule',$this->data,'module');
    }
	public function showManageModules() {
		$this->template->display('manageModule',$this->data,'module');
    }
    
    public function editModules($id) {
    	$this->data['threshold'] = $this->moduleListModel->getThreshold();
    	$this->data['details'] = $this->moduleListModel->getModuleDetails($id);
    	$this->template->display('editModule',$this->data,'module','');
    }
      	
	public function updateModuleDetails($param) {
		
		$param = explode(',',$param);
		foreach($param as $key=>$value){
			$id = $param[0];
			$knode = $param[1];
			$accountid = $param[2];
		}
		if (isset($_POST['submit'])) {
			$fieldValue = array();
			//
			$moduleName = $_REQUEST["moduleName"];
	      	$trainingMinutes = $_REQUEST["trainingMinutes"];
	      
	      	if (isset($_REQUEST["IsConfidential"])){
	      		$IsConfidential = 1;
	      	}
	      	else {
	      		$IsConfidential = 0;
	      	}
	      	
	      	$threshold = $_REQUEST["threshold"];
	      	
			if (isset($_REQUEST["IsActive"])){
	      		$IsActive = 1;
	      	}
	      	else {
	      		$IsActive = 0;
	      	}
			//
			
			$fieldValue = array($moduleName,$trainingMinutes,$IsConfidential,$threshold,$IsActive);
			//
			 
			$return=$this->moduleListModel->updateModule($id,$fieldValue);
			if ($return==0) {
				$arr[0]=array();
				$value1['id']=$id;
	    		$value1['k_node']=$knode;
	    		$value1['account_id']=$accountid;
	            $value1['module_name']=$moduleName;
	            $value1['training_minutes']=$trainingMinutes;
	            $value1['is_confidential']=$IsConfidential;
	        	$value1['module_threshold']=$threshold;
	            $value1['is_active']=$IsActive;
	            $arr[0]=$value1;
	            $value2['Trainingminutes']="";
				$this->data['details']= $arr;
				$this->data['message']=$this->moduleListModel->getvalues($value2);
				$this->data['threshold'] = $this->moduleListModel->getThreshold();
    			$this->template->display('editModule',$this->data,'module');
			}
			if ($return==1) {
				$this->data['module'] = $this->moduleListModel->getModules($knode,$accountid);
				$this->data['combos'] = array($knode,$accountid);
		  		$this->template->display('manageModule',$this->data,'module');
			}
		}
		else if (isset($_POST['cancel'])) {
			$this->data['combos'] = array($knode,$accountid);
    		$this->data['module'] = $this->moduleListModel->getModules($knode,$accountid);
	  		$this->template->display('manageModule',$this->data,'module');
		}
    }
       
	public function AddModuleDetails($param){
		$param = explode(',',$param);
		foreach($param as $key=>$value){
			$knode = $param[0];
			$accountid = $param[1];
		}
		if (isset($_POST['submit'])) {
			$moduleName = $_REQUEST['moduleName']; 
			$trainingMin = $_REQUEST['trainingMin']; 
			
			if (isset($_POST['isConfidential'])){
				$isConfidential = $_REQUEST['isConfidential'];
			}   
			$threshold = $_REQUEST['threshold'];
			if (isset($_POST['isActive'])){
				$isActive = $_REQUEST['isActive'];
			} 
			$status=1;
			//
			$fieldArr= array();
			foreach($moduleName as $a => $b) {
				if (isset($isConfidential[$a])){
		      		$IsConfidential = 1;
		      	}
		      	else {
		      		$IsConfidential = 0;
		      	}
		      	if (isset($isActive[$a])){
		      		$IsActive = 1;
		      	}
		      	else {
		      		$IsActive = 0;
		      	} 
				//	      	
			    $fieldValue = array($moduleName[$a],$trainingMin[$a],$IsConfidential,$threshold[$a],$IsActive);
				//
				$return=$this->moduleListModel->AddModule($knode,$accountid,$fieldValue);
				if ($return != 1) {
					$fieldArr[$a]=array($moduleName[$a],$trainingMin[$a],$IsConfidential,$threshold[$a],$IsActive);
					$value1['moduleName']="";
		            $value1['Trainingminutes']="";
		            $value1['OldModuleName']="";
		            $this->data['message']=$this->moduleListModel->getvalues($value1);
		            $status=0;
				}
			}
			if ($status==1){
				$this->data['module'] = $this->moduleListModel->getModules($knode,$accountid);
				$this->data['combos'] = array($knode,$accountid);
				$this->template->display('manageModule',$this->data,'module');
			}
			else {
				//
				$this->data['BASE']=array($knode,$accountid);
	    		$this->data['threshold'] = $this->moduleListModel->getThreshold();
	    		//
	    		$this->data['AddDetails']=$fieldArr;
    			$this->template->display('addModule',$this->data,'module');
    			
			}
		}
		else if (isset($_POST['cancel'])) {
			$this->data['module'] = $this->moduleListModel->getModules($knode,$accountid);
			$this->data['combos'] = array($knode,$accountid);
			$this->template->display('manageModule',$this->data,'module');
		}
	}
	//For Quiz Maintenance : Start
 	function addEditAssessment($param){
 		$param = explode(',',$param);
		foreach($param as $key=>$value){
			$moduleID = $param[0];
			$moduleName = $param[1];
		}
 		$this->data['HeaderForAss'] = array($moduleID,$moduleName);
 		$this->data['status'] = $this->moduleListModel->getStatus();
 		$this->data['gradingmethod'] = $this->moduleListModel->getGradingMethod();
 		$this->data['gradeboundary'] = $this->moduleListModel->getGradeBoundary();
 		$this->data['attemptsallowed'] = $this->moduleListModel->getAttemptsAllowed();
 		$this->data['questionperpage'] = $this->moduleListModel->getQuestionPerPage();
 		//
 		$result=$this->moduleListModel->GetQuizID($moduleID);
    	if(!empty($result)){
    		foreach($result as $key=>$value){
    			$quizID=$value['id'];
    		}
    		$this->data['quizDetails']=$this->moduleListModel->GetQuizDetails($moduleID);
    		$this->data['feedbackDetails']=$this->moduleListModel->GetFeedbackDetails($quizID);
    	}
    	//
    	$this->template->display('addEditAssessment',$this->data,'module');
    }
    function AddUpdateAssessmentDetails($moduleID){
    	//
    	$isActive=0;
    	$values=array();
    	$values = $this->moduleListModel->getModuleDetails($moduleID);
    	foreach ($values as $key => $value) {
	     	$knode=$value['k_node'];
	    	$accountid=$value['account_id'];
	        $Modulename=$value['module_name'];
    	}
    	//
    	$assessmentName = $_REQUEST["assessmentName"];
    	$timeLimit = $_REQUEST["timeLimit"];
    	$questionPerPage = $_REQUEST["questionPerPage"];
    	$ShuffleQ = $_REQUEST["ShuffleQ"];
    	$ShuffleWithinQ = $_REQUEST["ShuffleWithinQ"];
    	$attemptsAllowed = $_REQUEST["attemptsAllowed"];
    	$gradingMethod = $_REQUEST["gradingMethod"];
    	$reqGrade = $_REQUEST["reqGrade"];
    	$isActive = $_REQUEST["IsActive"];
    	if (isset($isActive)) $isActive=1;
    	
    	$generalDetails=array($assessmentName,$timeLimit,$questionPerPage,$ShuffleQ,$ShuffleWithinQ,$attemptsAllowed,$gradingMethod,$reqGrade,$isActive);
    	//
    	$status1 = $_REQUEST["status1"];
    	$status2 = $_REQUEST["status2"];
    	$status3 = $_REQUEST["status3"];
    	$status4 = $_REQUEST["status4"];
    	$status5 = $_REQUEST["status5"];
    	$gradeBoundary1 = $_REQUEST["gradeBoundary1"];
    	$gradeBoundary2 = $_REQUEST["gradeBoundary2"];
    	$gradeBoundary3 = $_REQUEST["gradeBoundary3"];
    	$gradeBoundary4 = $_REQUEST["gradeBoundary4"];
    	$gradeBoundary5 = $_REQUEST["gradeBoundary5"];
    	//catching up the input value incase of error
    	$fieldNames=array();
    	$fieldNames['assessmentName']="";
    	$fieldNames['timeLimit']="";
    	$arr[0]=array();
		$value1['quiz_name']=$assessmentName;
	    $value1['time_limit']=$timeLimit;
	    $value1['question_perpage']=$questionPerPage;
	    $value1['shuffle_questions']=$ShuffleQ;
	    $value1['shuffle_within_questions']=$ShuffleWithinQ;
	    $value1['attempts_allowed']=$attemptsAllowed;
	    $value1['grading_methods']=$gradingMethod;
	    $value1['required_grade']=$reqGrade;
	    $value1['is_active']=$isActive;
	    $arr[0]=$value1;
    	//
    	$isActive1=1;$isActive2=1;$isActive3=1;$isActive4=1;$isActive5=1;
    	if ($status1==1000) $isActive1=0;
    	if ($status2==1000) $isActive2=0;
    	if ($status3==1000) $isActive3=0;
    	if ($status4==1000) $isActive4=0;
    	if ($status5==1000) $isActive5=0;
    	//
    	$feedback1=array($status1,$gradeBoundary1,$isActive1);
    	$feedback2=array($status2,$gradeBoundary2,$isActive2);
    	$feedback3=array($status3,$gradeBoundary3,$isActive3);
    	$feedback4=array($status4,$gradeBoundary4,$isActive4);
    	$feedback5=array($status5,$gradeBoundary5,$isActive5);
    	
    	$feedbackDetails=array($feedback1,$feedback2,$feedback3,$feedback4,$feedback5);
    	//check for insert or, update
    	$result=$this->moduleListModel->GetQuizID($moduleID);
    	if(!empty($result)){
    		foreach($result as $key=>$value){
    			$quizID=$value['id'];
    		}
    	}
    	if (isset($_POST['submit'])) {
	    	//update action
	       	if(empty($result)) {
	    		$return=$this->moduleListModel->InsertQuiz($moduleID,$generalDetails);
	    		if ($return==1){
		    		$result=$this->moduleListModel->GetQuizID($moduleID);
	    			if(!empty($result)){
			    		foreach($result as $key=>$value){
			    			$quizID=$value['id'];
			    		}
			    	}
		    		$return1=$this->moduleListModel->InsertQuizFeedback($quizID,$feedbackDetails);
	    		}
	    	}
	    	else {
	    		$return=$this->moduleListModel->UpdateQuiz($quizID,$moduleID,$generalDetails);
	    		$return1=$this->moduleListModel->UpdateQuizFeedback($quizID,$feedbackDetails);
	    	}
    		//Getting module Details when back to the show module screen
			if ($return || $return1){
				//TODO :; Code to display upload quiz screen
				$this->data['HeaderForQuiz'] = array($moduleID,$Modulename,$quizID);
				$this->data['QuestionDetails'] = $this->moduleListModel->GetQuestionDetails($quizID);
				$this->data['QuestionType'] = $this->moduleListModel->GetQuestionType();
    			$this->template->display('addQuiz',$this->data,'module');
			}
			else {
	    		$this->data['message']=$this->moduleListModel->getvalues($fieldNames);
    			//
    			$this->data['HeaderForAss'] = array($moduleID,$Modulename);
 				$this->data['status'] = $this->moduleListModel->getStatus();
 				$this->data['gradingmethod'] = $this->moduleListModel->getGradingMethod();
 				$this->data['gradeboundary'] = $this->moduleListModel->getGradeBoundary();
 				$this->data['attemptsallowed'] = $this->moduleListModel->getAttemptsAllowed();
 				$this->data['questionperpage'] = $this->moduleListModel->getQuestionPerPage();
    			$this->data['quizDetails']=$arr;
    			$this->template->display('addEditAssessment',$this->data,'module');
	    	}
		} 
		else if (isset($_POST['return'])) {
		    //Other action
			if(empty($result)){
	    		$return=$this->moduleListModel->InsertQuiz($moduleID,$generalDetails);
	    		if ($return==1){
		    		$result=$this->moduleListModel->GetQuizID($moduleID);
			    	if(!empty($result)){
			    		foreach($result as $key=>$value){
			    			$quizID=$value['id'];
			    		}
			    	}
		    		$return1=$this->moduleListModel->InsertQuizFeedback($quizID,$feedbackDetails);
	    		}
	    	}
	    	else {
	    		$return=$this->moduleListModel->UpdateQuiz($quizID,$moduleID,$generalDetails);
	    		$return1=$this->moduleListModel->UpdateQuizFeedback($quizID,$feedbackDetails);
	    	}
			//Getting module Details when back to the show module screen
			if ($return){
				$this->data['BASE']=array($knode,$accountid);
		   		$this->data['module'] = $this->moduleListModel->getModules($knode,$accountid);
	       		$this->data['combos'] = array($knode,$accountid);
		  		$this->template->display('manageModule',$this->data,'module');
			}
			else {
	    		$this->data['message']=$this->moduleListModel->getvalues($fieldNames);
    			//
    			$this->data['HeaderForAss'] = array($moduleID,$Modulename);
 				$this->data['status'] = $this->moduleListModel->getStatus();
 				$this->data['gradingmethod'] = $this->moduleListModel->getGradingMethod();
 				$this->data['gradeboundary'] = $this->moduleListModel->getGradeBoundary();
 				$this->data['attemptsallowed'] = $this->moduleListModel->getAttemptsAllowed();
 				$this->data['questionperpage'] = $this->moduleListModel->getQuestionPerPage();
    			$this->data['quizDetails']=$arr;
    			$this->template->display('addEditAssessment',$this->data,'module');
	    	}
		} 
		else {
			//Getting module Details when back to the show module screen
		   	$this->data['BASE']=array($knode,$accountid);
		   	$this->data['module'] = $this->moduleListModel->getModules($knode,$accountid);
	        $this->data['combos'] = array($knode,$accountid);
		  	$this->template->display('manageModule',$this->data,'module');
		}
    } 
    function addEditContentFile($param){
    	$param = explode(',',$param);
		foreach($param as $key=>$value){
			$moduleID = $param[0];
			$moduleName = $param[1];
		}
		$this->data['SaveStatus']=array("Flag"=>0);
    	$this->data['HeaderForContent'] = array($moduleID,$moduleName);
    	$this->data['TableDetails']=$this->moduleListModel->getContentDetails($moduleID);
    	$this->template->display('addEditContentFile',$this->data,'module');
    }
	function EditContentFile($param){
    	$param = explode(',',$param);
		foreach($param as $key=>$value){
			$moduleID = $param[0];
			$moduleName = $param[1];
			$contentID = $param[2];
		}
		$this->data['SaveStatus']=array("Flag"=>0);
		$this->data['EditStatus']=array("Flag"=>1);
    	$this->data['HeaderForContent'] = array($moduleID,$moduleName);
    	$this->data['contentDetails']=$this->moduleListModel->getContents($contentID);
    	$this->data['ContentID']=array("ContentID"=>$contentID);
    	$this->data['TableDetails']=$this->moduleListModel->getContentDetails($moduleID);
    	$this->template->display('addEditContentFile',$this->data,'module');
    }
	function DeleteContentFile($param){
    	$param = explode(',',$param);
		foreach($param as $key=>$value){
			$moduleID = $param[0];
			$moduleName = $param[1];
			$contentID = $param[2];
		}
		$this->data['SaveStatus']=array("Flag"=>1);
    	$this->data['HeaderForContent'] = array($moduleID,$moduleName);
    	$this->moduleListModel->deleteContent($contentID);
    	$this->data['TableDetails']=$this->moduleListModel->getContentDetails($moduleID);
    	$this->template->display('addEditContentFile',$this->data,'module');
    }
   function SaveContentFile($param){
		$param = explode(',',$param);
		foreach($param as $key=>$value){
			$moduleID = $param[0];
			$moduleName = $param[1];
			$contentID = $param[2];
		}
		if (isset($_POST['back'])) {
			$values=array();
    		$values = $this->moduleListModel->getModuleDetails($moduleID);
    		foreach ($values as $key => $value) {
	     		$knode=$value['k_node'];
	    		$accountid=$value['account_id'];
	       	 	$Modulename=$value['module_name'];
    		}
    		$this->data['BASE']=array($knode,$accountid);
		   	$this->data['module'] = $this->moduleListModel->getModules($knode,$accountid);
	        $this->data['combos'] = array($knode,$accountid);
		  	$this->template->display('manageModule',$this->data,'module');
		}
		else {
			$contentName = $_REQUEST["contentName"];
	    	$contentType = $_REQUEST["contentType"];
	    	$url='';
	    	$skillport=0;
	    	if (isset($_POST["url"])){
	    		$url = $_REQUEST["url"];
	    	}
	   		if (isset($_POST["skillport"])){
	    		$skillport = $_REQUEST["skillport"];
	    	}
	    	$contentFile = $_FILES["contentFile"];
	    	$IsActive = $_REQUEST["IsActive"];
	    	if ($IsActive) $IsActive=1;
	    	else  $IsActive=0;
	    	
	    	$fieldValue=array($contentName,$contentType,$url,$skillport,$contentFile,$IsActive);
	    	$return=$this->moduleListModel->SaveContentFile($contentID,$moduleID,$fieldValue);
	    	//
	    	if ($return){
	    		$this->data['TableDetails']=$this->moduleListModel->getContentDetails($moduleID);
	    		$this->data['SaveStatus']=array("Flag"=>1);
	    	}
	    	else {
	    		$fieldNames=array();
	    		$fieldNames['contentName']="";
	    		$fieldNames['contentFile']="";
	    		$fieldNames['url']="";
	    		$fieldNames['fileUpload']="";
	    		//
	    		$this->data['message']=$this->moduleListModel->getvalues($fieldNames);
	    		$arr[0]=array();
				$value1['content_name']=$contentName;
				$value1['content_type']=$contentType;
				$value1['url']=$url;
				$value1['skillport_requried']=$skillport;
				$value1['file_name']=$contentFile;
				$value1['is_active']=$IsActive;
	    		$arr[0]=$value1;
	    		$this->data['contentDetails']=$arr;
	    		$this->data['SaveStatus']=array("Flag"=>0);
	    	}
	    	$this->data['HeaderForContent'] = array($moduleID,$moduleName);
	    	$this->template->display('addEditContentFile',$this->data,'module');
		}
   } 
   
   function ShowFileContent($fileParam){
   		$contentID=$fileParam[0];
   		$mimeType=$fileParam[1].'/'.$fileParam[2];
   		$Values=array();
   		$Values=$this->moduleListModel->getContents($contentID);
   		foreach($Values as $Key => $Val){
   			$fileName=$Val['file_name'];
   			$content=$Val['file_content'];
   		}
   		header('Content-type:'.$mimeType);
   		header('Content-Disposition:attachment;filename="'.$fileName.'"');
   		
		echo $content;
   }
	//QuizUpload
	public function UploadQuestion($param) {
			$param=explode(',',$param);
			$quizID = $param[0];
			$moduleID = $param[1];
			$moduleName = $param[2];
        if (isset($_POST['upload'])) {

            $filepath = __SITE_PATH . "/tmp/";
			
            $filename = $_FILES["importFile"]["name"];
            
            $ext = explode('.', $filename);

            if ($ext[1] == 'xls' || $ext[1] == 'xlsx') {
                $file = $filepath . $filename;
                move_uploaded_file($_FILES['importFile']['tmp_name'], $file);
		       	//
            	$arr_data=array();
            	$inputFileName=$file;
            	$inputFileType = PHPExcel_IOFactory::identify($inputFileName);  
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);  
				$objReader->setReadDataOnly(true); 
				$objPHPExcel = $objReader->load($inputFileName);  
				$total_sheets=$objPHPExcel->getSheetCount();   
				$allSheetName=$objPHPExcel->getSheetNames();   
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);   
				$highestRow = $objWorksheet->getHighestRow();   
				$highestColumn = $objWorksheet->getHighestColumn();   
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);    
				//
				for ($row = 2; $row <= $highestRow; ++$row) {  
				    for ($col = 0; $col <= $highestColumnIndex; ++$col) {  
				    $value=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();  
				        if(is_array($arr_data) ) { $arr_data[$row-1][$col]=$value; }  
				    }  
				}
				//print_r($arr_data);
            	//$answerRows = array('question_id', 'answer', 'fraction', 'is_active');
            	foreach($arr_data as $key=>$value){
            		$Question_datas['quiz_id']=$quizID;
					$Question_datas['serial'] = $value[0];
                    $Question_datas['question_type'] = substr($value[1],0,1);
                    $Question_datas['question_text'] = preg_replace("/'/", '',stripslashes($value[2]));
                    $Question_datas['grade'] = $value[3];
                    $Question_datas['in_quiz']= 0;
                    $Question_datas['isactive'] = 1;
             		$return=$this->moduleListModel->InsertQuestion($Question_datas);
             		if ($return==1){
             			$this->data['HeaderForQuiz'] = array($moduleID,$moduleName,$quizID);
             			$this->data['QuestionDetails'] = $this->moduleListModel->GetQuestionDetails($quizID);
             			$this->data['QuestionType'] = $this->moduleListModel->GetQuestionType();
    					$this->template->display('addQuiz',$this->data,'module');
             		}
				}
            }
        	else {
                echo "Invalid file";
            }
        }
         if (isset($_POST['back'])) {
         	$param="$moduleID,$moduleName";
         	$this->addEditAssessment($param);
         }
        
    }
	//For Quiz Maintenance : End
}

?>
