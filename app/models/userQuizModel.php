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
// @Created by: Biswakalyana Mohanty                                                         //
// @date: 4/10/13  12:32 PM                                                   	   		//
// @version: 1.0								       									//
// @description:                                                                	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////

require_once __SITE_PATH . '/libs/DBUtil.php';
require_once __SITE_PATH.'/libs/Form.php';


class userQuizModel
{
	var $dbUtil;
	var $form;
	var $submittedValues = array();
	
	function __construct()
	{
		$this->dbUtil=new DBUtil();
		$this->form = new Form();
	
	}
	
	function get_isConfidential($mod_Id){
		$result = $this->dbUtil->select('lsc_module','module_name, is_confidential','id = '.$mod_Id);
		return $result[0];
	}
	
	function get_moduleContents($mod_Id) {
		$table = "lsc_quiz_assessment_content as cont inner join lsc_module as module on cont.module_id = module.id";
		$rows = "module.module_name, 
				cont.id as content_id, 
				cont.content_name, 
				cont.content_type, 
				cont.file_name, 
				cont.file_type, 
				cont.url, 
				cont.skillport_requried";
		$where = "cont.module_id = ".$mod_Id." and cont.is_active = 1 ";
		$result = $this->dbUtil->select($table,$rows,$where);
		return $result;
	}
	
	function get_isSkillport($mod_Id){
		$table = "lsc_quiz_assessment_content as cont inner join lsc_module as module on cont.module_id = module.id";
		$rows = "module.module_name, cont.id as content_id";
		$where = "cont.module_id = ".$mod_Id." and cont.skillport_requried = 1 and cont.is_active = 1 ";
		$result = $this->dbUtil->select($table,$rows,$where);
		if(!empty($result)){
			return $result[0];
		}
		else return 0;
	}
	
	function save_skillportDetails($skillportValues){
		$valid = 0;
		$valid = $valid + $this->validScore($skillportValues["skillport_score"]);
		$valid = $valid + $this->validCertificate ($skillportValues["skillport_certificate"]);
		if ($valid == 0){
			return "success";
		}
		else{
			return "error";
		}
	}
	function validScore($score){
		if(!empty($score)){
			if (($score >= 0) && ($score <= 100)){
				return 0;
			}
			else{
				$this->form->setValue('skillport_score', 'Enter a Valid score between 0 to 100');
				return  1;
			}
		}
		else{
				$this->form->setValue('skillport_score', 'Enter a Valid score');
				return  1;
			}
	}
	function validCertificate($certificate){
		if($certificate['error'] == 4){
				$this->form->setValue('skillport_certificate', 'Attach your skillport certificate');
				return  1;
		}
		else{
			return 0;
		}
	}
	
	function getMessage($fields) {
		$message = array();
		foreach ($fields as $key => $value){
			$message[$key] = $this->form->value($key);
		}
		return $message;
	}
	
	 
}