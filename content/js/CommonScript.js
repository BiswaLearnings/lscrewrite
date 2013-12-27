function redirectToURL(url)
{
	window.location.href = url;
}

function isEmpty(value)
{
    if(value.length > 0) return false;
    else return true;
}

function isAlphaNumeric(value)
{
    var alphaNumericPattern = new RegExp("^[a-zA-Z0-9 ]*$");
    return alphaNumericPattern.test(value);
}
function isNumeric(value)
{
	var numericPattern = new RegExp("^[0-9 ]*$");
    return numericPattern.test(value);
}
function onlyNumeric(event){
	return ( event.ctrlKey || event.altKey 
            || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
            || (95<event.keyCode && event.keyCode<106)
            || (event.keyCode==8) || (event.keyCode==9)
            || (event.keyCode>34 && event.keyCode<40) 
            || (event.keyCode==46) )
}

function isAlphabets(value)
{
    var alphabetsPattern = new RegExp("^[a-zA-Z]*$");
    return alphabetsPattern.test(value);
}

function isEmail(value)
{
    var emailPattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
    return emailPattern.test(value);
}

function alertAndRedirect(alertMessage, successRedirectURL)
{
    var box = confirm(alertMessage);
    if(box == true)
    {
        redirectToURL(successRedirectURL);
    }
}

function validate(control, baseURL)
{
    var validationString = $(control).attr('data-validation');
    var validationOptions = validationString.split(';');
    var error = "";
    var errorDivisionID = $(control).attr('name') + "-error";
    var errorDivision = $("#" + errorDivisionID);
    var value = $(control).val();
    for(i= 0, len = validationOptions.length; i<len; i++ )
    {
        switch (validationOptions[i])
        {
            case 'required' :
            {
                if(isEmpty(value)){error += 'Required Field. ';}
                break;
            }
            case 'alpha-numeric' :
            {
                if(!isAlphaNumeric(value)) {error += 'Should contain only Alpha Numeric Characters. ';}
                break;
            }
            case 'alphabets' :
            {
                if(!isAlphabets(value)) {error += 'Should contain only alphabets. ';}
                break;
            }
            case 'email' :
            {
                if(!isEmail(value)) {error += 'Please enter valid email address. ';}
                break;
            }
        }
    }
    if(error)
    {
        var errorImage = "<img id='error' src='" + baseURL+"/content/images/CommonImages/error.png" + "' height = '15px' width='15px' style='margin-left : 5px;' title='" + error +"'/>";
        if(errorDivision.length > 0)
        {
            errorDivision.html(errorImage);
            $(control).attr('title', error);
        }
        else
        {
            $(control).after("<div id='"+errorDivisionID+"' style='display:inline;'>" + errorImage + "</div>");
        }
    }
    else
    {
        var correctImage = "<img src='" + baseURL+"/content/images/CommonImages/correct.png" + "' height = '15px' width='15px' style='margin-left : 5px;' title='No Error!'/>";
        if(errorDivision.length > 0)
        {
            errorDivision.html(correctImage);
            $(control).attr('title', 'No Error!');
        }
        else
        {
            $(control).after("<div id='"+errorDivisionID+"' style='display:inline;' >" + correctImage + "</div>");
        }
    }
}

function validateAndSubmit(event, formID)
{
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
    if($("#error").length>0)
    {
        alert("There are errors in the form. Please correct and re-submit.");
    }
    else
    {
        $("#"+formID).submit();
    }
}

$(document).ready(function(){
    $(document).tooltip({
        show: {
            effect: "slideDown",
            delay: 250
        }
    });
});