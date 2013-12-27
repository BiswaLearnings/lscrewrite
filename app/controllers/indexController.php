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
//require_once __SITE_PATH . '/app/models/AccountListModel.php';
require_once __SITE_PATH . '/libs/Session.php';
Class indexController extends baseController {

	private $template;
        private $session;

	public function __construct()
	{
		$this->template = new Template();
                $this->session = new Session();
	}

    public function index() {
        if($this->session->isLoggedIn()){
            $this->template->display('index', '', '');
        }else{
            $this->redirect('?load=login/auth');
        }
    }

    public function redirect($url) {
        parent::redirect($url);
    }

}

?>
