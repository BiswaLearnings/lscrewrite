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
// @date: 4/10/13  10:57 AM                                                              //
// @version: 1.0                                                                        //
// @description:                                                                        //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////


require_once __SITE_PATH . '/libs/form_handler.php';
include_once __SITE_PATH . '/lang/lang.php';
include_once __SITE_PATH . '/app/views/header.php';
require_once __SITE_PATH . '/libs/Session.php';
?>

<div id="userid"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/access.png" height="15" width="15" style="border: none; padding-right: 5px; padding-top: 5px"/>
    <?php
    $session = new Session();
    $session->welcome();
    ?>
</div>
<hr />
<div class="bigContainer">
    <strong><?php echo $lang['Quiz'];?></strong><hr/>
    <script type="text/javascript">
        function displayControls(control)
        {
            var value = $(control).val();
            hideAllControls();
            switch (value)
            {
                case '1' :
                {
                    $('#TrueOrFalseControls').css('display', 'block');
                    break;
                }
                case '2' :
                {
                    $('#ShortAnswerControls').css('display', 'block');
                    break;
                }
                case '3' :
                {
                    $('#MultipleChoiceControls').css('display', 'block');
                    break;
                }
                case '4' :
                {
                    $('#MatchControls').css('display', 'block');
                    break;
                }
            }
        }

        function hideAllControls()
        {
            $('#TrueOrFalseControls').css('display', 'none');
            $('#ShortAnswerControls').css('display', 'none');
            $('#MultipleChoiceControls').css('display', 'none');
            $('#MatchControls').css('display', 'none');
        }

        function multiply(control)
        {
            var repeater = $(control).closest('tr');
            if(!$(repeater).hasClass('repeater'))
                return;
            $(repeater).removeClass('repeater');
            $(repeater).find('input').css({'filter': 'alpha(opacity=100)', 'opacity' : '1'});
            $(repeater).find('select').css({'filter': 'alpha(opacity=100)', 'opacity' : '1'});
            $(repeater).after('<tr class="repeater">' + $(repeater).html() + '</tr>');
            $('.repeater input, .repeater select').css({'filter': 'alpha(opacity=20)', 'opacity' : '0.2'});
        }

        $(document).ready(function(){
            $( "#Information" ).dialog({autoOpen: false,height: 300,      width: 350,      modal: true });
        });

    </script>
    <?php

    //Open new lsc form
    $form = new lscform();
    $form->openForm(array('method' => 'POST', 'action' => '#', 'id' => 'quizQuestion', 'name' => 'quizQuestion'));

    //Add the Question Type list
    $form->addInline('<div style="position:relative">');
    $form->addLabel('Choose Question Type', array('for' => 'QuestionType'));
    $form->openSelect(array('name' => 'QuestionType', 'id' => 'QuestionType', 'onclick' => 'displayControls(this);'));
    $form->addOption('--Choose--', array('value' => ''));
    $form->addOption('True Or False', array('value' => '1'));
    $form->addOption('Short Answer', array('value' => '2'));
    $form->addOption('Multiple Choice', array('value' => '3'));
    $form->addOption('Matching', array('value' => '4'));
    $form->closeSelect();
    $form->addInline(sprintf('<img src="%s/content/images/CommonImages/Details.png" onclick="$(\'#Information\' ).dialog(\'open\');" width="22" height="22" title="Information" style="position:absolute; cursor:pointer; margin: 20px 0px 0px 7px;"/>', WEB_PATH));
    $form->addInline('</div>');

    //Fields for True or False type questions
    $form->addInline('<div id="TrueOrFalseControls" style="display: none;" >');
    $form->addLabel('Question Text', array('for' => 'TrueOrFalseQuestionText', 'style'=>'display:table-cell; vertical-align: middle;'));
    $form->addTextarea('', array('name' => 'TrueOrFalseQuestionText', 'id' => 'TrueOrFalseQuestionText', 'style'=>'display:table-cell; width: 400px;'));
    $form->addInline('<br />');
    $form->addLabel('Correct Answer', array('for' => 'TrueOrFalseCorrectAnswer'));
    $form->openSelect(array('name' => 'TrueOrFalseCorrectAnswer', 'id' => 'TrueOrFalseCorrectAnswer'));
    $form->addOption('True', array('value' => 'true'));
    $form->addOption('False', array('value' => 'false'));
    $form->closeSelect();
    $form->addLabel('Default Grade', array('for' => 'TrueOrFalseGrade'));
    $form->addInput('text', array('name' => 'TrueOrFalseDefaultGrade', 'id' => 'TrueOrFalseDefaultGrade'));
    $form->addInline('<br />');
    $form->addInput('submit', array('name', 'AddQuestion', 'value' => 'Add Question'));
    $form->addInline('</div>');


    //Fields for Short Answer type questions
    $form->addInline('<div id="ShortAnswerControls" style="display: none;" >');
    $form->addLabel('Question Text', array('for' => 'ShortAnswerQuestionText', 'style'=>'display:table-cell; vertical-align: middle;'));
    $form->addTextarea('', array('name' => 'ShortAnswerQuestionText', 'id' => 'ShortAnswerQuestionText', 'style' => 'display:table-cell; width: 400px;'));
    $form->addLabel('Default Grade', array('for' => 'ShortAnswerDefaultGrade'));
    $form->addInput('text', array('name' => 'ShortAnswerDefaultGrade', 'id' => 'ShortAnswerDefaultGrade'));
    $form->openFieldset(array('style' => 'width:500px'));
    $form->addLegend('Answers');
        $form->addInline('<table><tr><th>Answer</th><th>Grade</th></tr>');
        $form->addInline('<tr class="repeater">');
        $form->addInline('<td>'); $form->addInput('text', array('name' => 'ShortAnswerAnswer[]', 'onfocus' => 'multiply(this);', 'style' => 'margin-left:20px;')); $form->addInline('</td>');
        $form->addInline('<td>');
            $form->openSelect(array('name' => 'ShortAnswerGrade[]', 'onfocus' => 'multiply(this);', 'style' => 'margin-left:20px;'));
            $form->addOption('None', array('value' => ''));
            foreach($data['grades'] as $grade) $form->addOption($grade['meta_text'], array('value' => $grade['meta_value']));
            $form->closeSelect();
        $form->addInline('</td>');
        $form->addInline('</tr></table>');
    $form->closeFieldset();
    $form->addInline('<br />');
    $form->addInput('submit', array('name', 'AddQuestion', 'value' => 'Add Question'));
    $form->addInline('</div>');


    //Fields for Multiple Choice Type questions
    $form->addInline('<div id="MultipleChoiceControls" style="display: none;" >');
    $form->addLabel('Question Text', array('for' => 'MultipleChoiceQuestionText', 'style'=>'display:table-cell; vertical-align: middle;'));
    $form->addTextarea('', array('name' => 'MultipleChoiceQuestionText', 'id' => 'MultipleChoiceQuestionText', 'style' => 'display:table-cell; width: 400px;'));
    $form->addLabel('Default Grade', array('for' => 'MultipleChoiceDefaultGrade'));
    $form->addInput('text', array('name' => 'MultipleChoiceDefaultGrade', 'id' => 'MultipleChoiceDefaultGrade'));
    $form->addInline('<br />');
    $form->addLabel('Allow Multiple Answers', array('for' => 'MultipleChoiceMultipleAnswers', 'style' => 'width:140px'));
    $form->addInput('checkbox', array('name' => 'MultipleChoiceMultipleAnswers', 'id' => 'MultipleChoiceMultipleAnswers'));
    $form->addLabel('Shuffle Choices', array('for' => 'MultipleChoiceShuffleChoice'));
    $form->addInput('checkbox', array('name' => 'MultipleChoiceShuffleChoice', 'id' => 'MultipleChoiceShuffleChoice'));
    $form->openFieldset(array('style' => 'width:500px'));
    $form->addLegend('Choices');
        $form->addInline('<table><tr><th>Answer</th><th>Grade</th></tr>');
        $form->addInline('<tr class="repeater">');
        $form->addInline('<td>'); $form->addInput('text', array('name' => 'MultipleChoiceAnswer[]', 'onfocus' => 'multiply(this);', 'style' => 'margin-left:20px;')); $form->addInline('</td>');
        $form->addInline('<td>');
            $form->openSelect(array('name' => 'MultipleChoiceGrade[]', 'onfocus' => 'multiply(this);', 'style' => 'margin-left:20px;'));
            $form->addOption('None', array('value' => ''));
            foreach($data['grades'] as $grade) $form->addOption($grade['meta_text'], array('value' => $grade['meta_value']));
            $form->closeSelect();
        $form->addInline('</td>');
        $form->addInline('</tr></table>');
    $form->closeFieldset();
    $form->addInline('<br />');
    $form->addInput('submit', array('name', 'AddQuestion', 'value' => 'Add Question'));
    $form->addInline('</div>');


    //Fields for Match type questions
    $form->addInline('<div id="MatchControls" style="display: none;" >');
    $form->addLabel('Question Text', array('for' => 'MatchQuestionText', 'style'=>'display:table-cell; vertical-align: middle;'));
    $form->addTextarea('', array('name' => 'MatchQuestionText', 'id' => 'MatchQuestionText', 'style' => 'display:table-cell; width: 400px;'));
    $form->addLabel('Default Grade', array('for' => 'MatchDefaultGrade'));
    $form->addInput('text', array('name' => 'MatchDefaultGrade', 'id' => 'MatchDefaultGrade'));
    $form->openFieldset(array('style' => 'width:500px'));
    $form->addLegend('Match Questions (LHS/RHS)');
        $form->addInline('<table><tr><th>Question</th><th>Answer</th></tr>');
        $form->addInline('<tr class="repeater">');
        $form->addInline('<td>'); $form->addInput('text', array('name' => 'MatchSubQuestion[]', 'onfocus' => 'multiply(this);', 'style' => 'margin-left:20px;')); $form->addInline('</td>');
        $form->addInline('<td>'); $form->addInput('text', array('name' => 'MatchSubAnswer[]', 'onfocus' => 'multiply(this);', 'style' => 'margin-left:20px;')); $form->addInline('</td>');
        $form->addInline('</tr></table>');
    $form->closeFieldset();
    $form->addInline('<br />');
    $form->addInput('submit', array('name', 'AddQuestion', 'value' => 'Add Question'));
    $form->addInline('</div>');


    $form->closeForm();
    echo $form;
    ?>
</div>
<div id="Information" title="Information">
    <b>True Or False</b>
    <ul style="list-style-type:disc; margin-left: 20px;">
        <li>Enter the Question in <b>Question Text</b> box</li>
        <li>Choose the <b>Correct Answer</b></li>
        <li>Enter the <b>Default grade</b> which will be awarded if the correct answer is chosen</li>
    </ul>
    <b>Short Answer</b>
    <ul style="list-style-type:disc; margin-left: 20px;">
        <li>Enter the Question in <b>Question Text</b> box</li>
        <li>Enter the <b>Default grade</b> for the question</li>
        <li>Any number of possible answers can be added.</li>
        <li>To add an answer, click on the <b>Answer</b> text box</li>
        <li>The <b>Grade</b> control denotes what percentage of the <b>Default grade</b> must be awarded if the corresponding <b>Answer</b> is entered by the user</li>
        <li>Empty <b>Grade</b> and <b>Answer</b> will be neglected.</li>
    </ul>
    <b>Multiple Choice</b>
    <ul style="list-style-type:disc; margin-left: 20px;">
        <li>Enter the Question in <b>Question Text</b> box</li>
        <li>Enter the <b>Default grade</b> for the question</li>
        <li>The <b>Allow Multiple Answers</b> flag denotes that multiple options can be chosen as the answer for the question.</li>
        <li><b>Shuffle Options</b> flag denotes that the options will be shuffled every time it is displayed to the user.</li>
        <li>Any number of <b>Choices</b> can be added.</li>
        <li>To add a choice, click on the <b>Answer</b> text box</li>
        <li>The <b>Grade</b> control denotes what percentage of the <b>Default grade</b> must be awarded if the corresponding <b>Choice</b> is entered by the user</li>
        <li>Empty <b>Grade</b> and <b>Answer</b> will be neglected.</li>
    </ul>
    <b>Matching</b>
    <ul style="list-style-type:disc; margin-left: 20px;">
        <li>Enter the Question in <b>Question Text</b> box</li>
        <li>Enter the <b>Default grade</b> for the question</li>
        <li>Any number of possible <b>Question/Answer</b> pair can be added.</li>
        <li>Empty <b>Grade</b> and <b>Answer</b> will be neglected.</li>
        <li>The <b>Question</b> denotes the LHS of the match and the <b>Answer</b> denotes the correct RHS value</li>
    </ul>
</div>
<?php
include(__SITE_PATH . '/app/views/footer.php');
?>