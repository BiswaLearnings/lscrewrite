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

/**
 *
 * This is a class used to handle the form processing dynamically through instance.
 **/
class lscform {

    private $eventArr = array('onchange' => '', 'onclick' => '', 'onblur' => '', 'onfocus' => '', 'onkeydown' => '', 'onkeyup' => '');
    private $commonArr = array('id' => '',
        'class' => '',
        'title' => '',
        'style' => '',
        'data-validation' => '');
    private $formArr = array(
        'method' => 'post',
        'action' => '',
        'id' => '',
        'name' => 'mainForm',
        'enctype' => 'multipart/form-data',
        'onsubmit' => '');
    private $inputArr = array('text' => array('value' => '',
            'name' => '',
            'id' => '',
            'alt' => '',
            'readonly' => '',
            'disabled' => '',
            'width' => '',
            'maxlength' => '',
            'size ' => '',
            'value' => '',
    		'style' => '',
    		'tabindex' => ''),
        'button' => array('name' => '',
            'value' => '',
            'alt' => '',
            'disabled' => '',
    		'tabindex' => ''),
        'hidden' => array('name' => '',
            'value' => '',
            'alt' => '',
            'disabled' => '',
            'size ' => ''),
        'password' => array('name' => '',
            'value' => '',
            'alt' => '',
            'readonly' => '',
            'disabled' => '',
            'width' => '',
            'maxlength' => '',
            'size ' => '',
    		'tabindex' => ''),
        'submit' => array('name' => '',
            'value' => '',
            'alt' => '',
            'disabled' => '', 'style' => '','tabindex' => ''),
        'checkbox' => array('name' => '',
            'id' => '',
            'value' => '',
            'alt' => '',
            'disabled' => '',
            'checked' => '',
            'width' => '',
    		'onClick' => '',
    		'tabindex' => ''),
        'radio' => array('name' => '',
            'id' => '',
            'value' => '',
            'alt' => '',
            'disabled' => '',
            'checked' => '',
            'title' => '',
    		'tabindex' => ''),
        'reset' => array('name' => '',
            'class' => '',
            'value' => '',
            'alt' => '',
            'disabled' => '',
            'title' => ''),
        'file' => array('name' => '',
            'id' => '',
            'value' => '',
            'alt' => '',
            'disabled' => '',
            'accept' => '',
            'size ' => '',
    		'tabindex' => ''),
        'image' => array('name' => '',
            'id' => '',
            'value' => '',
            'alt' => '',
            'disabled' => '',
            'src' => '',
    		'tabindex' => '')
    );
    private $fieldsetArr = array();
    private $legendArr = array();
    private $labelArr = array('for' => '', 'style' => '');
    private $textareaArr = array('rows' => '',
        'cols' => '',
        'disabled' => '',
        'readonly' => '',
        'name' => '');
    private $selectArr = array('name' => '', 'id' => '','disabled' => '',
        'multiple' => '',
        'size' => '',
        'tabindex' => '');
    private $optionArr = array('disabled' => '',
        'label' => '',
        'selected' => '',
        'value' => '');
    private $formElements = array();
    private $formElementArr = array();
    private $formAttributeArr = array();

    //Constructor
    public function __construct() {

    }

    /*
	 * Create fieldset for the form.
	 */
    public function openFieldset($arrArgs = array()) {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['fieldset'] = array();
        $arrTemp = array_merge($this->eventArr, $this->commonArr, $this->fieldsetArr);
        foreach ($arrTemp as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['fieldset'][$key] = $arrArgs[$key];
            }
        }
        $createFfieldset = '<fieldset ';
        foreach ($this->formElementArr[$cnt]['fieldset'] as $key => $val) {
            $createFfieldset .= $key . '="' . $val . '" ';
        }
        $createFfieldset .= '>';
        $this->formElements['elements'][$cnt] = $createFfieldset;
    }

    /**
	 * Close fieldset for the form.
	 */
    public function closeFieldset() {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['/fieldset'] = array();
        $chaineTemp = '</fieldset>';
        $this->formElements['elements'][$cnt] = $chaineTemp;
    }

    /*
	 * To give a name for field sets.
	 */
    public function addLegend($legend, $arrArgs = array()) {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['legend']['innerHTML'] = $legend;
        $arrTemp = array_merge($this->eventArr, $this->commonArr, $this->legendArr);
        foreach ($arrTemp as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['legend'][$key] = $arrArgs[$key];
            }
        }
        $createLegend = '<legend ';
        foreach ($this->formElementArr[$cnt]['legend'] as $key => $val) {
            if ($key !== 'innerHTML') {
                $createLegend .= $key . '="' . $val . '" ';
            }
        }
        $createLegend .= '>' . $legend . '</legend>';
        $this->formElements['elements'][$cnt] = $createLegend;
    }

    /*
	 * This method is used to create a form with <form> tag
	 */
    public function openForm($arrArgs = array()) {

        foreach ($this->formArr as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formAttributeArr[$key] = $arrArgs[$key];
            } else if (!empty($val)) {
                $this->formAttributeArr[$key] = $val;
            }
        }

        $this->formElements['open'] = '<form ';
        foreach ($this->formAttributeArr as $key => $val) {
            $this->formElements['open'] .= $key . '="' . $val . '" ';
        }
        $this->formElements['open'] .= '>';
    }

	/*
	 * This method is used to create a button.
	 */
    public function addButton($elem, $arrArgs = array()) {

        if (!array_key_exists($elem, $this->inputArr)) {
            throw new Exception($elem . ' n\'Button type is not valid!');
        }

        $cnt = count($this->formElementArr);

        $this->formElementArr[$cnt][$elem] = array();

        $arrTemp = array_merge($this->eventArr, $this->commonArr, $this->inputArr[$elem]);

        foreach ($arrTemp as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt][$elem][$key] = $arrArgs[$key];
            }
        }

        $createButton = '<input type="' . $elem . '" ';
        foreach ($this->formElementArr[$cnt][$elem] as $key => $val) {
            $createButton .= $key . '="' . $val . '" ';
        }
        $createButton .= '/>';
        $this->formElements['elements'][$cnt] = $createButton;
    }

	/*
	 * This method method is used to close the form with </form> tag.
	 */
    public function closeForm() {
        $this->formElements['close'] = '</form>';
    }

	/*
	 * This method is used to create input form elements like text, checkbox, radio, hidden, reset,
	 * submit, button, file, image and password.
	 */
    public function addInput($elem, $arrArgs = array()) {

        if (!array_key_exists($elem, $this->inputArr)) {
            throw new Exception($elem . ' n\'Input type is not valid!');
        }

        $cnt = count($this->formElementArr);

        $this->formElementArr[$cnt][$elem] = array();

        $arrTemp = array_merge($this->eventArr, $this->commonArr, $this->inputArr[$elem]);

        foreach ($arrTemp as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt][$elem][$key] = $arrArgs[$key];
            }
        }

        $createInput = '<input type="' . $elem . '" ';
        foreach ($this->formElementArr[$cnt][$elem] as $key => $val) {
            $createInput .= $key . '="' . $val . '" ';
        }
        $createInput .= '/>';
        $this->formElements['elements'][$cnt] = $createInput;
    }

	/**
 	 * This method is used to create labels for the input form elemente.
 	 */
    public function addLabel($label, $arrArgs = array()) {

        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['label']['innerHTML'] = ".'$label'.";
        $arrTemp = array_merge($this->eventArr, $this->commonArr, $this->labelArr, $this->labelArr);
        foreach ($arrTemp as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['label'][$key] = $arrArgs[$key];
            }
        }

        $createLabel = '<label ';
        foreach ($this->formElementArr[$cnt]['label'] as $key => $val) {
            if ($key !== 'innerHTML') {
                $createLabel .= $key . '="' . $val . '" ';
            }
        }

        $createLabel .= ' style="float: center;text-align: left; ';
        if(array_key_exists('style', $arrArgs))
        {
            $createLabel .= $arrArgs['style'];
        }
        $createLabel .= ' ">' . $label . '</label>';
        $this->formElements['elements'][$cnt] = $createLabel;
    }

   /*
    * This method is used to create empty labels for form elemente.
    */
     public function addCustomLabel($label, $arrArgs = array()) {

        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['label']['innerHTML'] = ".'$label'.";
        $arrTemp = array_merge($this->eventArr, $this->commonArr, $this->labelArr);
        foreach ($arrTemp as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['label'][$key] = $arrArgs[$key];
            }
        }

        $createLabel = '<label ';
        foreach ($this->formElementArr[$cnt]['label'] as $key => $val) {
            if ($key !== 'innerHTML') {
                $createLabel .= $key . '="' . $val . '" ';
            }
        }

        $createLabel .= ' style="padding-left: 1px; text-align: left;">' . $label . '</label>';
        $this->formElements['elements'][$cnt] = $createLabel;
    }

   /*
    * This method is used to creatae Text area.
    */
    public function addTextarea($txt, $arrArgs = array()) {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['textarea']['innerHTML'] = $txt;
		$arrTemp = array_merge($this->eventArr, $this->commonArr, $this->textareaArr); 
        foreach ($arrTemp as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['textarea'][$key] = $arrArgs[$key];
            }
        }

        $createTextArea = '<textarea ';
        foreach ($this->formElementArr[$cnt]['textarea'] as $key => $val) {
            if ($key !== 'innerHTML') {
                $createTextArea .= $key . '="' . $val . '" ';
            }
        }
        $createTextArea .= '>' . $txt . '</textarea>';
        $this->formElements['elements'][$cnt] = $createTextArea;
    }

	public function openTable($arrArgs = array()) {

        $cnt = count($this->formElementArr);

        $this->formElementArr[$cnt]['table'] = array();

        foreach ($arrArgs as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['table'][$key] = $arrArgs[$key];
            }
        }

        $createTable = '<table ';
        foreach ($this->formElementArr[$cnt]['table'] as $key => $val) {
            $createTable .= $key . '="' . $val . '" ';
        }
        $createTable .= '>';
        $this->formElements['elements'][$cnt] = $createTable;
    }

	public function openTableBody($arrArgs = array()) {
         $cnt = count($this->formElementArr);
         $this->formElementArr[$cnt]['tbody'] = array();
		 foreach ($arrArgs as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['tbody'][$key] = $arrArgs[$key];
            }
        }

        $createTableBody = '<tbody ';

        foreach ($this->formElementArr[$cnt]['tbody'] as $key => $val) {
            if ($key !== 'innerHTML') {
                $createTableBody .= $key . '="' . $val . '" ';
            }
        }
        $createTableBody .= '>';
        $this->formElements['elements'][$cnt] = $createTableBody;
    }

	public function closeTableBody() {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['/tbody'] = array();
        $closeTableBody = '</tbody>';
        $this->formElements['elements'][$cnt] = $closeTableBody;
    }

	public function openTableHeader($arrArgs = array()) {
         $cnt = count($this->formElementArr);
         $this->formElementArr[$cnt]['thead'] = array();
		 foreach ($arrArgs as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['thead'][$key] = $arrArgs[$key];
            }
        }

        $createTableHeader = '<thead ';

        foreach ($this->formElementArr[$cnt]['thead'] as $key => $val) {
            if ($key !== 'innerHTML') {
                $createTableHeader .= $key . '="' . $val . '" ';
            }
        }
        $createTableHeader .= '>';
        $this->formElements['elements'][$cnt] = $createTableHeader;
    }

	public function addTableHead($txt,$arrArgs = array()) {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['th']['innerHTML'] = $txt;

       $this->formElementArr[$cnt]['th'] = array();
		 foreach ($arrArgs as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['th'][$key] = $arrArgs[$key];
            }
        }

        $createTableHead = '<th ';
        foreach ($this->formElementArr[$cnt]['th'] as $key => $val) {
            if ($key !== 'innerHTML') {
                $createTableHead .= $key . '="' . $val . '" ';
            }
        }
        $createTableHead .= '>' . $txt . '</th>';
        $this->formElements['elements'][$cnt] = $createTableHead;
    }

	public function closeTableHeader() {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['/thead'] = array();
        $closeTableHeader = '</thead>';
        $this->formElements['elements'][$cnt] = $closeTableHeader;
    }

	public function openTableRow($arrArgs = array()) {
         $cnt = count($this->formElementArr);
         $this->formElementArr[$cnt]['tr'] = array();
		 foreach ($arrArgs as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['tr'][$key] = $arrArgs[$key];
            }
        }

        $createTableRow = '<tr ';

        foreach ($this->formElementArr[$cnt]['tr'] as $key => $val) {
            if ($key !== 'innerHTML') {
                $createTableRow .= $key . '="' . $val . '" ';
            }
        }
        $createTableRow .= '>';
        $this->formElements['elements'][$cnt] = $createTableRow;
    }

	public function closeTableRow() {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['/tr'] = array();
        $closeTable = '</tr>';
        $this->formElements['elements'][$cnt] = $closeTable;
    }


	public function addTableColumn($txt,$arrArgs = array()) {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['td']['innerHTML'] = $txt;

       $this->formElementArr[$cnt]['td'] = array();
		 foreach ($arrArgs as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['td'][$key] = $arrArgs[$key];
            }
        }

        $createTableColumn = '<td ';
        foreach ($this->formElementArr[$cnt]['td'] as $key => $val) {
            if ($key !== 'innerHTML') {
                $createTableColumn .= $key . '="' . $val . '" ';
            }
        }
        $createTableColumn .= '>' . $txt . '</td>';
        $this->formElements['elements'][$cnt] = $createTableColumn;
    }


    public function openTableColumn($arrArgs = array()) {
    	$cnt = count($this->formElementArr);

    	 $this->formElementArr[$cnt]['td'] = array();
		 foreach ($arrArgs as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['td'][$key] = $arrArgs[$key];
            }
        }


    	$openTableColumn = '<td ';
        foreach ($this->formElementArr[$cnt]['td'] as $key => $val) {
            if ($key !== 'innerHTML') {
                $openTableColumn .= $key . '="' . $val . '" ';
            }
        }
        $openTableColumn .= '>';
        $this->formElements['elements'][$cnt] = $openTableColumn;

    } 


    public function closeTableColumn(){
    	    	$cnt = count($this->formElementArr);
    	$cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['/td'] = array();
        $closeTableColumn = '</td>';
        $this->formElements['elements'][$cnt] = $closeTableColumn;

    }

	public function closeTable() {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['/table'] = array();
        $closeTable = '</table>';
        $this->formElements['elements'][$cnt] = $closeTable;
    }

	/*
	 * This method is used to creatae drop down box.
	 */
    public function openSelect($arrArgs = array()) {

        $cnt = count($this->formElementArr);

        $this->formElementArr[$cnt]['select'] = array();

        foreach ($arrArgs as $key => $val) {
                $this->formElementArr[$cnt]['select'][$key] = $arrArgs[$key];

        }

        $createSelect = '<select ';
        foreach ($this->formElementArr[$cnt]['select'] as $key => $val) {
            $createSelect .= $key . '="' . $val . '" ';
        }
        $createSelect .= '>';



        $this->formElements['elements'][$cnt] = $createSelect;
    }

    /*
	 * This is the method to close the drop down box </select> elemente.
	 */
    public function closeSelect() {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['/select'] = array();
        $createSelect = '</select>';
        $this->formElements['elements'][$cnt] = $createSelect;
    }

    /*
	 * This method is used to create option elements for drop down box <select>
	 */
    public function addOption($txt, $arrArgs = array()) {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['option']['innerHTML'] = $txt;
        $arrTemp = array_merge($this->eventArr, $this->commonArr, $this->optionArr);
        foreach ($arrTemp as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['option'][$key] = $arrArgs[$key];
            }
        }
        $createOption = '<option ';
        foreach ($this->formElementArr[$cnt]['option'] as $key => $val) {
            if ($key !== 'innerHTML') {
                $createOption .= $key . '="' . $val . '" ';
            }
        }
        $createOption .= '>' . $txt . '</option>';
        $this->formElements['elements'][$cnt] = $createOption;
    }

    /*
	 * This method is used to creatae UL Lists
	 */
    public function openUList($arrArgs = array()) {

        $cnt = count($this->formElementArr);

        $this->formElementArr[$cnt]['ul'] = array();

        foreach ($arrArgs as $key => $val) {
                $this->formElementArr[$cnt]['ul'][$key] = $arrArgs[$key];

        }

        $createUList = '<ul ';
        foreach ($this->formElementArr[$cnt]['ul'] as $key => $val) {
            $createUList .= $key . '="' . $val . '" ';
        }
        $createUList .= '>';

        $this->formElements['elements'][$cnt] = $createUList;
    }

    /*
	 * This is the method to close the UL elements.
	 */
    public function closeUList() {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['/ul'] = array();
        $closeUList = '</ul>';
        $this->formElements['elements'][$cnt] = $closeUList;
    }

    /*
	 * This method is used to create list elements for UL
	 */
    public function addListTag($txt, $arrArgs = array()) {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['li']['innerHTML'] = $txt;
        $arrTemp = array_merge($this->eventArr, $this->commonArr, $this->optionArr);
        foreach ($arrTemp as $key => $val) {
            if (array_key_exists($key, $arrArgs)) {
                $this->formElementArr[$cnt]['li'][$key] = $arrArgs[$key];
            }
        }
        $createListTag = '<li ';
        foreach ($this->formElementArr[$cnt]['li'] as $key => $val) {
            if ($key !== 'innerHTML') {
                $createListTag .= $key . '="' . $val . '" ';
            }
        }
        $createListTag .= '>' . $txt . '</li>';
        $this->formElements['elements'][$cnt] = $createListTag;
    }

    /*
	 * This method is used to create Inline elements which used to create display tags like <br/>, <div>, <table> elements.
	 */
    /*
    public function addInline($inline) {
        $cnt = count($this->formElementArr);
        $this->formElements['inline'][$cnt] = $inline;
    }
    */
	 public function addInline($inline) {
        $cnt = count($this->formElementArr);
        $this->formElementArr[$cnt]['elements'] = array();
        $this->formElements['elements'][$cnt] = $inline;
    }

    /*
	 * This method is used to show the list of elements which has been created in form.
	 */
    public function showElems() {
        $createElements = '';
        foreach ($this->formElementArr as $key => $val) {
            foreach ($val as $elem => $attrArr) {
                if (strpos($elem, '/') !== false) {
                    $createElements .= '<ul><li style="color: blue;">end ' . substr($elem, 1, strlen($elem)) . '</li></ul>';
                } else {
                    $createElements .= '<ul><li style="color: blue;">' . $elem . '</li><ul>';
                    foreach ($attrArr as $attr => $value) {
                        $createElements .= '<li style="color: red;">' . $attr . ' = <span style="color: green; font-style: italic;">' . $value . '</span></li>';
                    }
                    $createElements .= '</ul></ul>';
                }
            }
        }
        return $createElements;
    }

     /*
	 * This method is used  to reset the form instance when two forms handled sequentially.
	 */
    public function resetForm() {
        $this->formElements = array();
        $this->formElementArr = array();
        $this->formAttributeArr = array();
    }

    /*
	 * This method is used to provide the proper instance details about this form object.
	 */
    public function __toString() {
        $createElements = '';
        if (isset($this->formElements['open']) && isset($this->formElements['close'])) {
            $createElements = $this->formElements['open'];
            if (isset($this->formElements['elements']) && !empty($this->formElements['elements'])) {
                foreach ($this->formElements['elements'] as $key => $val) {
                	/*
                    if (isset($this->formElements['inline'][$key])) {
                        $createElements .= $this->formElements['inline'][$key];
                    }*/
                    $createElements .= $val;
                }
            }
            if(isset($this->formElements['inline'][count($this->formElementArr)]))
            {
            	$createElements .= $this->formElements['inline'][count($this->formElementArr)];
            }
            $createElements .= $this->formElements['close'];
        }
        return $createElements;
    }

	/*
	 * Method used to destroy form object.
	 */
    public function __destruct() {
        unset($this);
    }

}

?>