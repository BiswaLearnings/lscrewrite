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
// @date 2013-04-10                                                      	   			// 
// @version 1.0								       										// 
// @description:                              				// 
//                                                                              		// 
////////////////////////////////////////////////////////////////////////////////////////// 
?>
<?php

require_once __SITE_PATH . '/app/models/userQuizModel.php';
require_once __SITE_PATH . '/log4php/Logger.php';

/**
 * 
 */
class userQuizController extends baseController {
	
	public $userQuizModel;
	public $template;
	public $data = array();

	public function __construct(){
		$this->userQuizModel = new userQuizModel();
		$this->template = new Template();
	}
	
	public function index() {
        $this->template->display('home', '');
    }
    
    /*
     * @author: Biswakalyana Mohanty
     * Description: 
     */
	public function showConfidential ($mod_Id){
		
		$data["module_Id"] = $mod_Id;
		$result = $this->userQuizModel->get_isConfidential($mod_Id);
		foreach ($result as $key=>$value){
				$data[$key] = $value;
			}
		if($data["is_confidential"] == 1){
			$this->template->display('view_confidentialMessage',$data,'user/quiz');
		}
		else{
			$this->showSkillportCertificateUpload($mod_Id);
		}
		
	}
	
	public function showModuleContent($mod_Id){
		$result = $this->userQuizModel->get_moduleContents($mod_Id);
		$data["module_Id"] = $mod_Id;
		$data["content_details"]=$result;
		$this->template->display('view_contents',$data,'user/quiz');
	
	}
	
	public function showSkillportCertificateUpload ($mod_Id){
		$data["module_Id"] = $mod_Id;
		$result = $this->userQuizModel->get_isSkillport($mod_Id);
		if ($result == 0) {
			$this->showAttemptHistory($mod_Id);
		}
		else{
			foreach ($result as $key=>$value){
				$data[$key] = $value;
			}
			$this->template->display('showSkillportCertificateUpload',$data,'user/quiz');
		}
	}
	public function saveSkillportDetails ($module = array()){
		$data["mod_Id"]=$module[0];
		$data["module_name"]=$module[1];
		$data['fieldValues']["skillport_score"] = $_REQUEST["skillport_score"];
		$data['fieldValues']["skillport_certificate"] = $_FILES["skillport_certificate"];
		$result = $this->userQuizModel->save_skillportDetails($data['fieldValues']);
		if ($result == 'success') {
			$this->showAttemptHistory($module);
		}
		elseif ($result == 'error'){
			$data['message'] = $this->userQuizModel->getMessage($data['fieldValues']);
			
			$this->template->display('showSkillportCertificateUpload',$data,'user/quiz');
		}
	}
	public function showAttemptHistory ($module){
		echo "no Attempt History";
	}
	public function continueLastAttempt($attempt_Id){
		
	}
	public function newAttempt(){
		
	}
	public function result(){
		
	}
    
    
    
    
    
    
}