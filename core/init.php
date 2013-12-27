<?php

session_start();
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
// @description:                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php


 /*** include the controller class ***/
 include __SITE_PATH . '/core/' . 'BaseController.php';

  /*** include the router class ***/
 include __SITE_PATH . '/core/' . 'Dispatcher.class.php';

 /*** include the template class ***/
 include __SITE_PATH . '/core/' . 'Template.class.php';

 require_once __SITE_PATH.'/log4php/Logger.php';
 Logger::configure(__SITE_PATH . '/config/lscLogConfig.xml');

 $dispatcher = new Dispatcher();
 $dispatcher->setPath(__SITE_PATH);
 $dispatcher->loader();
 ?>