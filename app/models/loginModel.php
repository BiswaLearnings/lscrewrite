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

require_once __SITE_PATH . '/libs/Session.php';
require_once __SITE_PATH . '/log4php/Logger.php';
require_once (__SITE_PATH . '/libs/DBUtil.php');

/**
 *
 */
class loginModel {

    private $userName;
    private $session;
    private $form;
    private $logger;

    /**
     *
     * @param type $userName
     */
    public function __construct($user) {
        $this->session = new Session();
        $this->form = new Form();
        $this->logger = new Logger("Login Model");
        $this->userName = $user;
    }

    /**
     *
     */
    public function authenticate() {
        $this->logger->info("Login Model: start authenticate()");
        if (!empty($this->userName)) {
            return $this->authLogin();
        }
    }

    /**
     *
     */
    function authLogin() {
        /* Login attempt */
        $this->logger->info("Login Model: start authLogin()");
        $logged_in = $this->session->login($this->userName);
        $this->logger->debug("Login Success: " . $logged_in);
        /* Login successful */
        if ($logged_in != 0) {
	    $this->session->getUserLogin();
            return true;
        }else{
            return false;
        }
    }

    /**
     *
     */
    function authLogout() {
        $logout_success = $this->session->logout();
        if ($logout_success) {
            return true;
        }
    }

    /**
     *
     */
    function loginValidate() {
        $this->logger->debug("LoginModel: loginValidate");
        $dbUtil = new DBUtil();
        $this->logger->debug("loginValidate username is: $this->userName");
        $user_result = $dbUtil->getUserInfo($this->userName);
        $this->logger->debug("Validate whether user id is exists".$user_result);
        if (isset($user_result['id'])) {
            return true;
        } else {
            $this->form->setError('userName', '<b>Please enter valid username!</b><br><br>');
            return false;
        }
    }

    /*
     *
     */
    public function validationMessage() {
        $vars['user'] = $this->form->error('userName');

        return $vars;
    }

}

?>
