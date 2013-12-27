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

require_once __SITE_PATH . '/log4php/Logger.php';
require_once __SITE_PATH . '/libs/Form.php';
require_once __SITE_PATH . '/libs/DBUtil.php';
require_once __SITE_PATH . '/libs/LSCSessionHandler.php';
require_once __SITE_PATH . '/libs/db.php';

/**
 *
 * @author amahalingam
 *
 */
class Session
{

    private $username;
    private $userid;
    private $userlevel;
    private $time;
    private $logged_in;
    private $userinfo = array();
    private $url;
    private $today;
    private $dbUtil;
    private $logger;
    private $session_handler;

    /* Class constructor */

    function __construct() {
        $this->time = time();
        $this->today = date("l, jS F Y h:i a");
        $this->dbUtil = new DBUtil();
        $this->logger = Logger::getLogger("Session Management");
        $this->session_handler = new LSCSessionHandler();
    }

    function startSession($user) {
        $this->logger->info("$this->today: Session - startSession()");
        /* Determine if user is logged in */
        if ($this->getUserLogin()) {
            /* Update users last active timestamp */
            $s_id = session_id();
            $this->session_handler->_write($s_id, $user);
            $this->logged_in = TRUE;
            $this->logger->info("$this->today: startSession() -  Updated users last active timestamp");
        }
    }

    function getUserLogin() {

        $this->logger->info("$this->today: Class: Session > getUserLogin() ");
        $flag = FALSE;
        if (!isset($_SESSION['username']) && !isset($_SESSION['userid'])) {

            /* Username correct, set it into session variables */
            $this->userinfo = $this->dbUtil->getUserInfo($this->userName);

            if ($this->userinfo != $flag) {
                $_SESSION['username'] = $this->userinfo['user_name'];
                $_SESSION['userid'] = $this->userinfo['id'];
                $_SESSION['first_name'] = $this->userinfo['first_name'];
                $_SESSION['last_name'] = $this->userinfo['last_name'];
                $_SESSION['userlevel'] = $this->userinfo['role'];
                $flag = TRUE;
            }
           $this->logger->info("End getUserLogin(): Username: " . $_SESSION['username'] . " - Userid: " . $_SESSION['userid'] . " ");
        }

       return $flag;
    }

    function login($user) {
        $this->userName = $user;
        /* Start Session */
        $this->startSession($this->userName);
        $this->logger->debug("login() - Username:  $this->userName");

        /* Login completed successfully */
        return true;
    }

    function logout() {
        unset($_SESSION['username']);
        unset($_SESSION['userid']);
        unset($_SESSION['userlevel']);
        session_destroy();
        $this->logged_in = FALSE;
        $this->logger->debug(" logged out successfully!");
        return true;
    }

    /**
     * isAdmin - Returns true if currently logged in user is
     * an administrator, false otherwise.
     */
    function isAdmin() {
        $flag = FALSE;
        if($_SESSION['userlevel'] == ADMIN_LEVEL || $_SESSION['username'] == ADMIN_NAME){
            $flag = TRUE;
        }
        return $flag;
    }

     function isLoggedIn(){
        if(isset($_SESSION['username'])){
            return true;
        }else{
            return false;
        }
    }

    function welcome() {

        $welcome = "Welcome ";
        if (isset($_SESSION['username'])) {

            $welcome .= "<a href='?load=resource/resourceProfile/" . $_SESSION['userid'] . "'><b>" . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "</b></a>";
        }
        $welcome .= " |  <a href='?load=login/logout'>Logout</a>";

        echo $welcome;
    }
    
    public function getUserName()
    {
    	return $_SESSION['username'];
    }
    
    public function getUserId()
    {
    	return $_SESSION['userid'];
    }
    
    public function getUserLevel()
    {
    	return $_SESSION['userlevel'];
    }    
}

?>