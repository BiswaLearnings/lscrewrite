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
// @date: 4/8/13  6:32 PM                                                              //
// @version: 1.0                                                                        //
// @description:                                                                        //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////
?>
<script>
    $(document).ready(function() {
        $( "#quiz-questions, #question-bank-questions" ).sortable({
            placeholder: "ui-state-highlight",
            connectWith: ".questions",
            revert: true
        }).disableSelection();
    });

    function processQuestions()
    {
        // Find out the questions added to quiz from question bank.
        var temp = '';
        $('#quiz-questions li').each(function(){
            if($(this).attr('data-from') == 'bank')
            {
                temp += $(this).attr('id') + ',';
            }
        });
        var questionsAddedFromBank = '<input type="hidden" name="questionsAddedFromBank" value="'+ temp +'" />';

        //Find out the questions removed from Quiz and added back to Bank.
        temp = '';
        $('#question-bank-questions li').each(function(){
            if($(this).attr('data-from') == 'quiz')
            {
                temp += $(this).attr('id') + ',';
            }
        });
        var questionsRemovedFromQuiz = '<input type="hidden" name="questionsRemovedFromQuiz" value="'+ temp +'" />';

        //Calculate the new order for the rearranged questions
        temp = '';
        var i = 1;
        $('#quiz-questions li').each(function(){
            temp += $(this).attr('id') + ':' + i++ + ',';
        });
        var questionOrder = '<input type="hidden" name="questionOrder" value="'+ temp +'" />';

        //Add all these hidden fields to the form
        $('#quizDetails').append(questionsAddedFromBank);
        $('#quizDetails').append(questionsRemovedFromQuiz);
        $('#quizDetails').append(questionOrder);

        //Finally submit the form
        $('#quizDetails').submit();
    }
</script>
<style type="text/css">
    .questions { list-style-type: none; margin: 0; padding: 0; width: 100%; min-height: 1.2em;}
    .questions li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1em; height: 1em; }
    .questions li span { position: absolute; margin-left: -1.3em; }
    .questions li:hover {cursor:move;}
    .ui-state-highlight { height: 1em; line-height: 0.8em; }
</style>
<?php

//Open form
$form = new lscform();
$form->openForm(array('method' => 'POST', 'action' => WEB_PATH.'/?load=quiz/processQuizDetails/'.$data['quizID'], 'id' => 'quizDetails', 'name' => 'quizDetails'));

//Open table layout in form
$form->openTable();
$form->openTableRow();
$form->openTableColumn(array('width' => '400px'));

//Render the questions in Quiz
$form->openFieldset('QuizQuestions');
$form->addLegend('Questions in Quiz');
$form->addInline('<div style="position:relative; color: #b0b0b0; width:160px; margin: 10px 0px 10px 0px; left: 50%; margin-left: -80px;">--Click and drag to reorder--</div><ul id="quiz-questions" class="questions">');
$moveImg = '<span class="ui-icon ui-icon-carat-2-n-s"></span>';
foreach($data['questions'] as $question)
{
    if($question['in_quiz'] == 1)
    {
        $viewImg = sprintf('<img src="%s/content/images/CommonImages/view.png" width="16" height="16" title="View this question" style="float:right; border:none;"/>', WEB_PATH);
        $updateImg = sprintf('<img src="%s/content/images/CommonImages/pencil.png" width="16" height="16" title="Update this question" style="float:right; margin-right: 5px; border:none;"/>', WEB_PATH);
        $form->addInline('<li class="ui-state-default" id="'.$question['id'].'" data-dbOrder="'.$question['serial'].'" data-from="quiz">' . $moveImg . $question["question_text"] . '<a href="#" style="float:right;">' . $viewImg . '</a><a href="#" style="float:right;">' . $updateImg . '</a></li>');
    }
}
$form->addInline('</ul>');
$form->closeFieldset();

$form->closeTableColumn();
$form->openTableColumn(array('width' => '100px'));
$form->addInline('<div style="position:relative; color: #b0b0b0; text-align: center; ">Click and drag to and from Question Bank</div><br />');
$form->addInput('button', array('value' => '<< Move All', 'onclick' => sprintf('redirectToURL(\'%s/?load=quiz/allToQuiz/%s\');', WEB_PATH, $data['quizID'])));
$form->addInput('button', array('value' => 'Move All >>', 'onclick' => sprintf('redirectToURL(\'%s/?load=quiz/allToBank/%s\');', WEB_PATH, $data['quizID'])));
$form->closeTableColumn();
$form->openTableColumn(array('width' => '400px'));

//Render the questions in Question Bank
$form->openFieldset('QuestionBankQuestions');
$form->addLegend('Questions in Question Bank');
$form->addInline('<div style="position:relative; color: #b0b0b0; width:160px; margin: 10px 0px 10px 0px; left: 50%; margin-left: -80px;">--Click and drag to reorder--</div><ul id="question-bank-questions" class="questions">');
foreach($data['questions'] as $question)
{
    if($question['in_quiz'] != 1)
    {
        $viewImg = sprintf('<img src="%s/content/images/CommonImages/view.png" width="16" height="16" title="View this question" style="float:right; border:none;"/>', WEB_PATH);
        $updateImg = sprintf('<img src="%s/content/images/CommonImages/pencil.png" width="16" height="16" title="Update this question" style="float:right; margin-right: 5px; border:none;"/>', WEB_PATH);
        $form->addInline('<li class="ui-state-default" id="'.$question['id'].'" data-dbOrder="'.$question['serial'].'" data-from="bank">' . $moveImg . $question["question_text"] . '<a href="#" style="float:right;">' . $viewImg . '</a><a href="#" style="float:right;">' . $updateImg . '</a></li>');
    }
}
$form->addInline('</ul>');
$form->closeFieldset();
$form->closeTableColumn();

$form->closeTableRow();
$form->closeTable();
$form->addInput('button', array('value' => 'Save Changes', 'onclick' => 'processQuestions();'));
$form->closeForm();
echo $form;
?>