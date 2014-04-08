function formhash(form, password){
	
	var lpass = document.createElement("input")
	
	form.appendChild(lpass);
	lpass.name = "lpass"
	lpass.type = "hidden"
	lpass.value = hex_sha512(password.value);
	password.value = "";
	form.submit();
}

function regformhash(form, user, password, confirm) {
	
	if(
		user.value == '' ||
		password.value == '' ||
		confirm.value == ''
	) {
		alert('Please fill out all of the required details')
		return false;
	}
	
	re = /^\w+$/;
	
	if(!re.test(form.ruser.value)) {
		alert("Usernames can only contain letters, numbers and underscores");
		form.ruser.focus();
		return false;
	}
	
	var rpass = document.createElement("input");
	
	form.appendChild(rpass);
	rpass.name = "rpass";
	rpass.type = "hidden";
	rpass.value = hex_sha512(password.value);
	password.value = "";
	conf.value = "";
	
	form.submit();
	return true;
}