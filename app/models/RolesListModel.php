<?php
//////////////////////////////////////////////////////////////////////////////////////////
//                                                                                      //
// NOTICE OF COPYRIGHT                                                                  //
//                                                                                      //
//                                                                                      //
//Copyright (C) 2010 onwards  Computer Sciences Corporation  http://www.csc.com         //
//                                                                                      //
// This program is free software: you can redistribute it and/or modify                 //
// it under the terms of the GNU General Public License as published by                 //
// the Free Software Foundation, either version 3 of the License, or                    //
// (at your option) any later version.                                                  //
//                                                                                      //
// This program is distributed in the hope that it will be useful,                      //
// but WITHOUT ANY WARRANTY; without even the implied warranty of                       //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                        //
// GNU General Public License for more details.                                         //
//                                                                                      //
//  You should have received a copy of the GNU General Public License                   //
//  along with this program.If not, see <http://www.gnu.org/licenses/>.                 //
//                                                                                      //
// @Created by: Venkatakrishnan                                                         //
// @date: 3/13/13  9:55 AM                                                              //
// @version: 1.0                                                                        //
// @description:                                                                        //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////

require_once (__SITE_PATH . '/libs/DBUtil.php');

/* The model used for Roles listing page */
class RolesListModel
{
    /* Returns the roles list based on the
     * account ID passed to it.
     */
    function getRolesData($accountID)
    {
        $dbUtil = new DBUtil();
        $result = $dbUtil->select(TBL_ROLES, '*', "account_id= $accountID && is_active = 1");
        return $result;
    }

    /* Deletes the role with the given ID*/
    function deleteRole($roleId)
    {
        $dbUtil = new DBUtil();
        $set = array('is_active = 0');
        $where = "id = $roleId";
        $dbUtil->update(TBL_ROLES, $set, $where);
    }

}
