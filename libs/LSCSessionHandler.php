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
require_once __SITE_PATH . '/libs/db.php';

class LSCSessionHandler {

	public $maxTime;
	public $db;

	public function __construct() {
		$dbconnect = new db();
		$this->db = $dbconnect->getConnection();
		$this->maxTime['last_accessed'] = time();
		$this->maxTime['gc'] = $this->getTimeout();
		session_set_save_handler(array (
			$this,
			'_open'
		), array (
			$this,
			'_close'
		), array (
			$this,
			'_read'
		), array (
			$this,
			'_write'
		), array (
			$this,
			'_destroy'
		), array (
			$this,
			'_clean'
		));
		register_shutdown_function('session_write_close');
	}

	public function _open() {
		return true;
	}

	public function _close() {
		$this->_clean($this->maxTime['gc']);
		return true;
	}

	public function _read($id) {
		try {
			$getData = $this->db->prepare("SELECT data FROM ".TBL_SESSIONS." WHERE id = ?");
			$getData->bindParam(1, $id);
			$getData->execute();
			$allData = $getData->fetch(PDO :: FETCH_ASSOC);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		$totalData = count($allData);
		$hasData = (bool) $totalData >= 1;
		
		return $hasData;
	}

	public function _write($id, $data) {
		try {
			$getData = $this->db->prepare("REPLACE INTO ".TBL_SESSIONS." VALUES (?, ?, ?)");
			$getData->bindParam(1, $id);
			$getData->bindParam(2, $data);
			$getData->bindParam(3, $this->maxTime['last_accessed']);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $getData->execute();
	}

	public function _destroy($id) {
		try {
			$getData = $this->db->prepare("DELETE FROM ".TBL_SESSIONS." WHERE id = ?");
			$getData->bindParam(1, $id);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		return $getData->execute();
	}

	public function _clean($max) {
		$old = ($this->maxTime['last_accessed'] - $max);
		try {
			$getData = $this->db->prepare("DELETE FROM ".TBL_SESSIONS." WHERE last_accessed < ?");
			$getData->bindParam(1, $old);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		return $getData->execute();
	}

	public function getTimeout() {
		return (int) ini_get('session.gc_maxlifetime');
	}

}
?>