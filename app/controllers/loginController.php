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

require_once __SITE_PATH . '/app/models/loginModel.php';
require_once __SITE_PATH . '/log4php/Logger.php';

/**
 * Login Controller to process login credentials.
 */
class loginController extends baseController {

    private $userName;
    private $loginModel;
    private $template;
    private $logger;

    /**
     * Default Constructor
     */
    public function __construct() {

        $user_name = htmlentities($_POST['userName']);
        if (isset($user_name)) {
            $this->userName = $user_name;
        }

        $this->loginModel = new loginModel($this->userName);
        $this->template = new Template();
        $this->logger = Logger::getLogger("Login Controller");
    }

    /**
     *
     */
    public function index() {
        //TO DO
    }

    /**
     *
     */
    public function auth() {

        $validate = $this->loginModel->loginValidate();
        $this->logger->debug("loginController: Validate Login: " . $validate);
        if ($validate) {
            $this->logger->debug("Login validation: " . $validate);

            $auth_result = $this->loginModel->authenticate();
            $this->logger->debug("Authentication Result : " . $auth_result);
			$auth_result=1;
            if ($auth_result) {
                $this->template->display('index', '', '');
            } else {
                $this->logout();
            }
        } else {
            $data = $this->loginModel->validationMessage();
            $this->template->display('logout', $data);
        }
    }

    /**
     *
     */
    public function logout() {
        $logout = $this->loginModel->authLogout();
        if ($logout) {
            $this->template->display('logout');
        }
    }

}

?>
