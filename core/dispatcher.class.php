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
// @description:                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php

require_once __SITE_PATH.'/libs/LSCException.php';

class Dispatcher {

 /*
 * @the controller path
 */
 private $path;

 public $file;

 public $controller;

 public $action;

 public $queryString;

 function __construct() {

 }

 /**
 *
 * @set controller directory path
 *
 * @param string $path
 *
 * @return void
 *
 */
 function setPath($path) {

	/* check if path i sa directory */
	if (is_dir($path) == false)
	{
		throw new Exception ('Invalid controller path: `' . $path . '`');
	}
	/* set the path */
 	$this->path = $path;
}


/**
 *
 * @load the controller
 *
 * @access public
 *
 * @return void
 *
 */
 public function loader()
 {
     /* check the dispatcher */
	$this->getController();

        if (is_readable($this->file) == false)
	{
		$this->file = $this->path.'/core/error404.php';
                $this->controller = 'error404';
	}

        if(!file_exists($this->file))
        {

            $this->file = $this->path.'/core/error404.php';
            $this->controller = 'error404';
            echo $this->file;
        }else{
           include $this->file;
        }

        /*** a new controller class instance ***/
	$class = $this->controller . 'Controller';

       try {
            $controller = new $class();
        }
        catch (Exception $e) {
            echo "Caught exception: " . $e->getMessage() . "\n";
        }

	
        /*** check if the action is callable ***/
	if (is_callable(array($controller, $this->action)) == false)
	{
		$action = 'index';
	}
	else
	{
		$action = $this->action;
	}
	/*** run the action ***/
	if(!empty($this->queryString)){
            $controller->$action($this->queryString);
        }else{
            $controller->$action();
        }



 }


 /**
 *
 * @get the controller
 *
 * @access private
 *
 * @return void
 *
 */
private function getController() {

	/*** get the route from the url ***/
	$route = (empty($_GET['load'])) ? '' : $_GET['load'];

	if (empty($route))
	{
		$route = 'index';
	}
	else
	{
		/*** get the parts of the route ***/
		$parts = explode('/', $route);
		$this->controller = $parts[0];
		if(isset( $parts[1]))
		{
			$this->action = $parts[1];
		}
        if(count($parts) == 3)
        {
            $this->queryString = $parts[2];
        }
        else if(count($parts) > 3)
        {
            $queryString = array();
            for($i = 2; $i < count($parts) ; $i++)
            {
                $queryString[] = $parts[$i];
            }
            $this->queryString = $queryString;
        }
	}

	if (empty($this->controller))
	{
		$this->controller = 'index';
	}

	/*** Get action ***/
	if (empty($this->action))
	{
		$this->action = 'index';
	}

	// If the request is not login/auth and the user is not logged in, then show login page
	if(!isset($_SESSION["username"]) && $this->controller != "login" && $this->action != "auth")
	{
		$this->controller = "login";
		$this->action = "logout";
	}
	/*** set the file path ***/
	$this->file = $this->path .'/app/controllers/'. $this->controller . 'Controller.php';

    }


}

?>
