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
// @Created by Achappan Mahalingam                                                      //
// @date 2012-12-12                                                      	   			//
// @version 1.0								       										//
// @description:                              	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php
//DB Definitions
define("DB_HOST", 'localhost');
define("DB_NAME", 'lsc_rewrite');
define("DB_USER", 'root');
define("DB_PASS", '');

//Table Definitions
define("TBL_USERS", "lsc_users");
define("TBL_SESSIONS", "lsc_session");
define("TBL_ACCOUNTS", "lsc_account");
define("META_DATA", "lsc_metadata ");
define("TBL_ROLES", "lsc_role");
define("TBL_MODULE", "lsc_module");
define("TBL_ROLE_MAP", "lsc_role_user_mapping");
define("TBL_EMAIL_TEMPLATE", "lsc_email_template");
define("TBL_EMAIL_NOTIFY", "lsc_email_notifications");
define("TBL_ROLE_MODULE_MAP", "lsc_role_module_mapping");
define("TBL_LSC_QUESTIONS", "lsc_quiz_question");
?>
