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
// @Created by: Venkatakrishnan                                                         //
// @date: 3/7/13  12:32 PM                                                   	   		//
// @version: 1.0								       									//
// @description:                                                                	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////

require_once (__SITE_PATH . '/libs/DBUtil.php');

class manageAccountModel
{
	var $dbUtil;
	
	function __construct()
	{
		$this->dbUtil=new DBUtil();
	}
	function getAccountList()
	{
		$rows = 'id,account_name as accountname';
		$where = 'is_active = 1';
		$order = 'accountname';
		$result = $this->dbUtil->select(TBL_ACCOUNTS,$rows,$where,$order);
		return $result;
	}
	function getAccountDetails($accountId)
	{
		$rows= "lsc_account.id, 
				lsc_account.account_name as accountname, 
				lsc_account.account_shortname as accountshortname, 
				lsc_account.account_description as accountdescription, 
				lsc_account.region_id as regionid, 
				lsc_account.global_account as globalaccount, 
				lsc_account.account_verticalid as accountverticalid, 
				lsc_account.primary_scope as primaryengagmentscope, 
				lsc_account.account_statusid as accountstatusid, 
				lsc_account.supported_india as supportedinindia, 
				lsc_account.orgunit_designation as orgunitdesignation, 
				lsc_account.orgunit_signature as orgunitsignature, 
				lsc_account.account_designation as Accountdesignation, 
				lsc_account.account_signature as accountsignature, 
				lsc_account.account_logo as accountlogo, 
				acce.user_name as Accountexecutiveglobalid, 
				org_user.user_name as orgunithead, 
				lead_india.user_name as accountleadinindia, 
				lead_user.user_name as accountleadid, 
				lsc_admin.user_name as LSCadmin";
		$table = "lsc_account 
				left join lsc_users as acce 
					on lsc_account.account_executive_globalid=acce.id and acce.is_active = 1 
				left join lsc_users as org_user 
					on lsc_account.orgunit_headid=org_user.id and org_user.is_active = 1 
				left join lsc_users as lead_india 
					on lsc_account.account_lead_india=lead_india.id and lead_india.is_active = 1 
				left join lsc_users as lead_user 
					on lsc_account.account_leadid=lead_user.id and lead_user.is_active = 1 
				left join lsc_users as lsc_admin 
					on lsc_account.lsc_admin=lsc_admin.id and lsc_admin.is_active = 1";
		$where = "lsc_account.id=".$accountId;
		$result = $this->dbUtil->select($table,$rows,$where);
		return $result[0];
	}
}
