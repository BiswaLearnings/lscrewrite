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
// @Created by Prasanna B                                                    //
// @date 2012-12-12                                                      	   			//
// @version 1.0								       										//
// @description:                              	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php

/**
 *
 */
require_once __SITE_PATH . '/log4php/Logger.php';
require_once __SITE_PATH . '/config/db_config.php';
require_once __SITE_PATH . '/libs/db.php';
require_once __SITE_PATH . '/libs/DBUtil.php';
require_once __SITE_PATH . '/libs/Form.php';

/**
 *
 *
 */
class settingsModel {

    private $form;

    public function __construct() {
        $this->logger = Logger::getLogger("Metadata model");
        $this->dbUtil = new DBUtil();
        $this->form = new form();
    }

    public function savecombovalue($fields) {
        $validResult = $this->validate($fields);
        if ($validResult == 0) {
            $result = $this->dbUtil->select('lsc_metadata_combo', 'id , type', 'id=' . $fields[combotype] . ' ', 'type');
            foreach ($result as $value) {
                $type = $value['type'];
            }

            $rows[1] = 'meta_code';
            $rows[2] = 'meta_text';
            $rows[3] = 'is_active';
            $rows[4] = 'meta_type';
            array_push($fields, $type);

            $this->dbUtil->insert(META_DATA, $fields, $rows);
        } else {
            $this->form->setError('success', 'combo value  creation failed.');
        }
        return $validResult;
    }

    public function populatetypeValues() {
        $result = $this->dbUtil->select('lsc_metadata_combo', 'id , type', '', 'type');
        return $result;
    }

    public function validate($fields) {
        $validResult = 0;

        $validResult = $validResult + $this->validatetype($fields['combotype']);
        $validResult = $validResult + $this->validatevalue($fields['Combovalue'], $fields['id']);

        return $validResult;
    }

    public function validatetype($type) {

        if (empty($type)) {
            $this->form->setError('combotype', 'Please select the value type.');
            return 1;
        }
    }

    public function validatevalue($value, $id) {

        if (empty($id)) {

            $where = "meta_text='" . $value . "'";
            $where .= ' and is_active= 1';

            $result = $this->dbUtil->select(
                    META_DATA, "id , meta_type , meta_code, meta_text, is_active",
                    $where, 'meta_text'
                    );

            if (!empty($result)) {
                $this->form->setError('combovalue', 'combovalue  already exist in the application.');
                return 2;
            }
        }

        if ($value == null) {
            $this->form->setError('combovalue', 'Combo value cannot be blank.');
            return 1;
        } else {
            $length = strlen($value);
            if ($length < 40) {
                $nameArray = str_split($value);
            } else {
                $this->form->setError('combovalue', 'combovalue  should not contain more than 40 characters.');
                return 3;
            }
        }
    }

    public function getValues() {

        $vars['combotype'] = $this->form->value('combotype');
        $vars['combovalue'] = $this->form->value('combovalue');
        $vars['timedetails'] = $this->form->value('timedetails');
        $vars['isactive'] = $this->form->value('isactive');
        return $vars;
    }

    public function geterror() {

        $vars['combotype'] = $this->form->error('combotype');
        $vars['combovalue'] = $this->form->error('combovalue');
        $vars['isactive'] = $this->form->error('isactive');
        return $vars;
    }

    public function getcombotypevalues($fields) {
        $result = $this->dbUtil->select('lsc_metadata_combo', 'type', 'id="' . $fields . '"');
        return $result;
    }

    public function getcombovalues($id) {
        $result = $this->dbUtil->select(
                META_DATA, "id , meta_type , meta_code, meta_text, is_active", 'id="' . $id . '"'
                );

        return $result;
    }

    public function displaysettings($fields) {

        $result = $this->dbUtil->select(
                META_DATA, "id , meta_type ,meta_code, meta_text, case
                when is_active = 1 then '1' else '0' end  as is_active ",
                'meta_type="' . $fields . '"'
                );
        return $result;
    }

    public function updatecombovalue($fields) {
        $validResult = $this->validate($fields);

        if ($validResult == 0) {
            $rows[1] = 'id';
            $rows[2] = 'meta_type';
            $rows[3] = 'meta_code';
            $rows[4] = 'meta_text';
            $rows[5] = 'is_active';
            /*if (empty($fields['timedetails'])) {
                $fields['timedetails'] = 0;
            }*/
            $set = array(
                "meta_type = '" . $fields['combotype'] . "', meta_text = '" . $fields['Combovalue'] . "',
                is_active = " . $fields['isactive'] . ",meta_code = " . $fields['meta_code']
                );
            $where = ' id = ' . $fields['id'];

            $this->dbUtil->update(META_DATA, $set, $where);
        } else {
            $this->form->setError('success', 'combo value  creation failed.');
        }
        return $validResult;
    }
}

?>
