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
// @date: 3/13/13  10:18 AM                                                             //
// @version: 1.0                                                                        //
// @description:                                                                        //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////

/* The helper class for creating a table*/
class LSCTable
{
    private $rows = array();
    private $tableName = '';
    private $shouldDisplayAddButton = false;
    private $addButtonURL = '';

    public function __construct($tableName, $shouldDisplayAddButton, $addButtonURL)
    {
        $this->tableName = $tableName;
        $this->shouldDisplayAddButton = $shouldDisplayAddButton;
        $this->addButtonURL = $addButtonURL;
    }

    /*Adds a new row to the table.
     * This method takes any number of TableCell
     * arguments to denote that any number
     * of cells can be in a row.
     */
    public function AddRow()
    {
        $cells = func_get_args();
        $this->rows[] = array();
        foreach($cells as $cell)
        {
            $this->rows[count($this->rows) - 1][] = $cell;
        }
    }

    /* This method renders the populated table
     * as HTML.
     */
    public function RenderTable()
    {
        $output = sprintf('<link href="%scontent/css/Table.css" rel="stylesheet" type="text/css" />', WEB_PATH);
        $output .= '<table border="1" borderColor="white" id="box-table">';
        $rowColor = "#f7f7e7";
        $colspan = $this->shouldDisplayAddButton ? count($this->rows[0]) - 1 : count($this->rows[0]);
        $output .= "<tr>";
        $output .= "<th colspan=\"$colspan\">$this->tableName</th>";
        if($this->shouldDisplayAddButton)
        {
            $output .= "<th align=\"center\">";
            $imgUrl = sprintf("%scontent/images/add-icon.png", WEB_PATH);
            $output .= "<a href=\"$this->addButtonURL\"><img src=\"$imgUrl\" /></a>";
            $output .= "</th>";
        }
        $output .= "</tr>";

        foreach($this->rows as $row)
        {
            $output .= "<tr bgcolor=\"$rowColor\">";
            foreach($row as $cell)
            {
                $output .= '<td  align="center">';
                $output .= "<a href=\"$cell->URL\">$cell->text</a>";
                $output .= '</td>';
            }
            $rowColor = ($rowColor == "#f7f7e7") ? "#f9f9f9" : "#f7f7e7";
            $output .= '</tr>';
        }
        $output .= '</table>';
        echo $output;
    }
}

/* An individual table cell entity*/
class TableCell
{
    public $text;
    public $URL;

    public function __construct($text, $URL)
    {
        $this->text = $text;
        $this->URL = $URL;
    }
}

