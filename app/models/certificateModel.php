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
// @date 2013-4-4                                                      	   			// 
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
require_once __SITE_PATH.'/libs/db.php';
require_once __SITE_PATH.'/libs/DBUtil.php';
class certificateModel{
	
	var $db;
	public $certificateDetails = array();
	
	
    public function __construct() {
       $this->logger = new Logger("View Certificate"); 
       $this->db = new DBUtil();
    }
    
    /**
     * @author Biswakalyana Mohanty
     * fetch all details of a role that need to be displayed in certificate
     */
    public function getCertificateDetails($roleId){
		
    	$table = "lsc_role as role 
				inner join lsc_account as acc on role.account_id = acc.id 
				inner join lsc_metadata as meta1 on role.orgunit_designation = meta1.meta_code and meta1.meta_type = 'Org Unit Head Designations'
				inner join lsc_metadata as meta2 on role.vertical_head_designation = meta2.meta_code and meta2.meta_type = 'Account Lead Designations'
				inner join lsc_metadata as meta3 on role.pl_manager_designation = meta3.meta_code and meta3.meta_type = 'PL manager designation'";
    	$rows = "acc.account_name,
    			 role.role_name,
    			 meta1.meta_text as orgunit_designation,
    			 role.orgunit_signature,
    			 meta2.meta_text as vertical_head_designation,
    			 role.vertical_head_signature,
    			 meta3.meta_text as pl_manager_designation,
    			 role.pl_manager_signature";
    	$where = "role.id = ".$roleId;
    	$result = $this->db->select($table,$rows,$where);
    	$result[0]['user_name']=$_SESSION['first_name']." ".$_SESSION['last_name'];
    	if($_SESSION['userlevel']==2){
    		$result[0]['valid_untill']=date('d-M-Y',strtotime(date("Y-m-d", time()) . " + 365 day"));
    	}
    	else{
    		$certficationDetails=$this->db->select($table,"role_status, certified_date","role_id =".$roleId." and user_id =".$_SESSION['userid'] );
    		if($certficationDetails[0]["role_status"]=="certified"){
    			$result[0]['valid_untill']=date('d-M-Y',strtotime($certficationDetails[0]["certified_date"] ." + 365 day"));
    		}
    	}
    	return $result[0];
    	
    }
    
}
?>
