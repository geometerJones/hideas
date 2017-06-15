/*

combine the two validate functions?

*/
function validateLogIn(f)
{
	if (f.username.value == "")
	{
		alert("You must provide a valid username!");
		return false;
	}
	
	if (f.password.value =="")
	{
		alert("You must provide a valid password!");
		return false;
	}

	return true;
}

function validateSubmission(f)
{
	if (f.submissinBox.value =="")
	{
		alert("You must provide us with the actual content!");
		return false;	
	}
	return true;
}

function logInPlease()
{
	alert("You must log in first!");
	return false;
}

function flowToss()
{
	if (Math.random() > 0.5)
		alert("Congrats. You're feelin the flow.");
	else
		alert("Sorry bro. You're not feelin the flow.");
}

function poopToss()
{
	if (Math.random() > 0.7)
		alert("The poop has been successfully tossed.");
	else
		alert("Poop toss unsuccessful.");
	return false;
}
