/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function validatename(field) {
	if (field == "") return "No name was entered.\\n"
	else if (/[^a-zA-Z]/.test(field))
		return "Only a-z,and A-Z are allowed in names.\\n"
	return ""
}

function validateEmail(field) {
	if (field == "") return "Please Fill all the compulsory feilds."
		else if (!((field.indexOf(".") > 0) &&
			     (field.indexOf("@") > 0)) ||
			    /[^a-zA-Z0-9.@_-]/.test(field))
		return "The Email address is invalid.\\n"
	return ""
}

function validatenumber(field) {
	if (field == "") return "No Age was entered.\\n"
	else if (isNaN(field)) return "Please enter only numbers\\n"
	return ""
}
function O(obj)
{
    if (typeof obj == 'object') return obj
    else return document.getElementById(obj)
}

function S(obj)
{
    return O(obj).style
}

function C(name)
{
  var elements = document.getElementsByTagName('*')
  var objects  = []

  for (var i = 0 ; i < elements.length ; ++i)
    if (elements[i].className == name)
      objects.push(elements[i])

  return objects
}
