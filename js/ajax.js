// JavaScript Document
<!-- 
//Browser Support Code
function send_data(id)
{
	try{
			// Opera 8.0+, Firefox, Safari
			ajaxRequest = new XMLHttpRequest();
		} catch (e){
			// Internet Explorer Browsers
			try{
				ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try{
					ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e){
					// Something went wrong
					alert("Your browser broke! Does not support ajax");
					return false;
				}
			}
		}
		
	if(id=='user_state')
	{
		var ajaxRequest;  // The variable that makes Ajax possible!
		
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4)
			{
				var ajaxDisplay = document.getElementById(id);
				var image;
				if((ajaxRequest.responseText=='ok')&&(document.getElementById('username').value!=''))
				{
					image = "images/yes.png"; 
				}
				else
				{
					image = "images/no.png"; 
				}
				ajaxDisplay.style.background='url('+image+')';
			}
			
		}
		var value = document.getElementById('username').value;
		var name = document.getElementById('username').name;
		var queryString = "?" + name + "=" + value;
		ajaxRequest.open("GET", "include/signup.php" + queryString, true);
		ajaxRequest.send(null); 
	}
	else if(id=='confirm_pass_status')
	{
		
				var ajaxDisplay = document.getElementById(id);
				var image;
				if((document.getElementById('confirm_pass').value==document.getElementById('pass').value)&&(document.getElementById('confirm_pass').value!=''))
				{
					image = "images/yes.png"; 
				}
				else
				{
					image = "images/no.png"; 
				}
				ajaxDisplay.style.background='url('+image+')';
		
	}
	else if(id=='pass_status')
	{
		
				var ajaxDisplay = document.getElementById(id);
				var image;
				if(document.getElementById('pass').value!='')
					image = "images/yes.png"; 
				else
					image = "images/no.png"; 
				
				ajaxDisplay.style.background='url('+image+')';
		
	}
	else if(id=='email_status')
	{
			var ajaxDisplay = document.getElementById(id);
			var image;	
			if (echeck(document.getElementById('email').value)==false)
			{
				image = "images/no.png";
			}
			else
				image = "images/yes.png";	
			
				ajaxDisplay.style.background='url('+image+')';		
	}
	else if(id=='captcha_status')
	{
		var ajaxRequest;  // The variable that makes Ajax possible!
		
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4)
			{
				var ajaxDisplay = document.getElementById(id);
				var image;
				if(ajaxRequest.responseText=='ok')
				{
					image = "images/yes.png"; 
				}
				else
				{
					image = "images/no.png"; 
				}
				ajaxDisplay.style.background='url('+image+')';
			}
			
		}
		var value = document.getElementById('captcha').value;
		var name = document.getElementById('captcha').name;
		var queryString = "?" + name + "=" + value;
		ajaxRequest.open("GET", "include/signup.php" + queryString, true);
		ajaxRequest.send(null); 	
	}
	else if(id=='form_status')
	{
		var ajaxRequest;  // The variable that makes Ajax possible!
		
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4)
			{
				var ajaxDisplay = document.getElementById(id);
				var image;
				ajaxDisplay.style.display='inline';
				ajaxDisplay.innerHTML=ajaxRequest.responseText;
			}
			
		}
		var val_user = document.getElementById('username').value;
		var val_pass = document.getElementById('pass').value;
		var val_confirm_pass = document.getElementById('confirm_pass').value;
		var val_email_id = document.getElementById('email').value;
		var val_captcha = document.getElementById('captcha').value;
		
		
		var name_user = document.getElementById('username').name;
		var name_pass = document.getElementById('pass').name;
		var name_confirm_pass = document.getElementById('confirm_pass').name;
		var name_email_id = document.getElementById('email').name;
		var name_captcha = document.getElementById('captcha').name;
		
		if(echeck(document.getElementById('email').value)==true)
			var email_status='ok';
			
		var queryString = "?form_signup=1&email_status=" + email_status + "&" +  name_user + "=" + val_user + "&" + name_pass + "=" + val_pass + "&" + name_confirm_pass + "=" + val_confirm_pass + "&" +name_email_id + "=" + val_email_id + "&" + name_captcha + "=" + val_captcha;
		ajaxRequest.open("GET", "include/signup.php" + queryString, true);
		ajaxRequest.send(null); 	
	}
	else if(id=='change_pass_status')
	{
		var ajaxRequest;  // The variable that makes Ajax possible!
		
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4)
			{
				var ajaxDisplay = document.getElementById(id);
				var image;
				ajaxDisplay.style.display='block';
				ajaxDisplay.innerHTML=ajaxRequest.responseText;
			}
			
		}
		var val_cur_pass = document.getElementById('current_password').value;
		var val_new_pass = document.getElementById('new_password').value;
		var val_confirm_pass = document.getElementById('confirm_password').value;		
		
		var name__cur_pass = document.getElementById('current_password').name;
		var name_new_pass = document.getElementById('new_password').name;
		var name_confirm_pass = document.getElementById('confirm_password').name;
					
		var queryString = "?form_change_user_password=1&" +  name__cur_pass + "=" + val_cur_pass + "&" + name_new_pass + "=" + val_new_pass + "&" + name_confirm_pass + "=" + val_confirm_pass;
		ajaxRequest.open("GET", "../include/signup.php" + queryString, true);
		ajaxRequest.send(null); 	
	}
	else if(id=='change_email_status')
	{
		var ajaxRequest;  // The variable that makes Ajax possible!
		
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4)
			{
				var ajaxDisplay = document.getElementById(id);
				var image;
				ajaxDisplay.style.display='block';
				ajaxDisplay.innerHTML=ajaxRequest.responseText;
			}
			
		}
		var val_cur_pass = document.getElementById('current_password_email').value;
		var val_new_email = document.getElementById('new_email').value;	
		
		if(echeck(document.getElementById('new_email').value)==true)
			var email_status='ok';
		
		var name__cur_pass = document.getElementById('current_password_email').name;
		var name_new_email = document.getElementById('new_email').name;
					
		var queryString = "?form_change_user_email=1&email_state=" + email_status + "&" + name__cur_pass + "=" + val_cur_pass + "&" + name_new_email + "=" + val_new_email;
		ajaxRequest.open("GET", "../include/signup.php" + queryString, true);
		ajaxRequest.send(null); 	
	}
	else if(id=='account_delete_status')
	{
		var response=confirm("Confirm Account Deletion. All files under your account will be deleted");
		if (response==true)
		{
		
			var ajaxRequest;  // The variable that makes Ajax possible!
			
			
			// Create a function that will receive data sent from the server
			ajaxRequest.onreadystatechange = function(){
				if(ajaxRequest.readyState == 4)
				{
					var ajaxDisplay = document.getElementById(id);
					var image;
					if(ajaxRequest.responseText=='deleted')
					{
						alert("Account Deleted. You are logging out.");
						window.location = '../include/logout.php';					
					}
					else
					{
						ajaxDisplay.style.display='block';
						ajaxDisplay.innerHTML=ajaxRequest.responseText;
					}
				}
				
			}
			var val_cur_pass = document.getElementById('current_password_delete').value;
			
			var name__cur_pass = document.getElementById('current_password_delete').name;
						
			var queryString = "?form_delete_account=1&" + name__cur_pass + "=" + val_cur_pass;
			ajaxRequest.open("GET", "../include/signup.php" + queryString, true);
			ajaxRequest.send(null); 	

		}
	}
	else if(id=='email_details_status')
	{
		var ajaxRequest;  // The variable that makes Ajax possible!
		
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4)
			{
				var ajaxDisplay = document.getElementById(id);
				var image;
				ajaxDisplay.style.display='inline';
				ajaxDisplay.innerHTML=ajaxRequest.responseText;
			}
			
		}
		var val_email = document.getElementById('email').value;		
		
		var name_email = document.getElementById('email').name;
		
		if(echeck(document.getElementById('email').value)==true)
			var email_status='ok';
			
		var queryString = "?form_email=1&email_status=" + email_status + "&" +  name_email + "=" + val_email;
		ajaxRequest.open("GET", "include/signup.php" + queryString, true);
		ajaxRequest.send(null); 	
	}
	
	else if(id=='login_status')
	{
		var ajaxRequest;  // The variable that makes Ajax possible!
		
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4)
			{
				var ajaxDisplay = document.getElementById(id);
				var image;
				if(ajaxRequest.responseText=="logged in")
				{
					window.location="index.php";
				}
				else
				{
					ajaxDisplay.style.display='inline';
					ajaxDisplay.innerHTML=ajaxRequest.responseText;
				}
			}
			
		}
		var val_login_user = document.getElementById('login_user').value;
		var val_login_pass = document.getElementById('login_pass').value;
		
		
		var name_login_user = document.getElementById('login_user').name;
		var name_login_pass = document.getElementById('login_pass').name;
		
			
		var queryString = "?form_login=1&" + name_login_user + "=" + val_login_user + "&" + name_login_pass + "=" + val_login_pass ;
		ajaxRequest.open("GET", "include/signup.php" + queryString, true);
		ajaxRequest.send(null); 	
	}
	else if(id=='login_status')
	{
		var ajaxRequest;  // The variable that makes Ajax possible!
		
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4)
			{
				var ajaxDisplay = document.getElementById(id);
				var image;
				if(ajaxRequest.responseText=="logged in")
				{
					window.location="index.php";
				}
				else
				{
					ajaxDisplay.style.display='inline';
					ajaxDisplay.innerHTML=ajaxRequest.responseText;
				}
			}
			
		}
		var val_login_user = document.getElementById('login_user').value;
		var val_login_pass = document.getElementById('login_pass').value;
		
		
		var name_login_user = document.getElementById('login_user').name;
		var name_login_pass = document.getElementById('login_pass').name;
		
			
		var queryString = "?form_login=1&" + name_login_user + "=" + val_login_user + "&" + name_login_pass + "=" + val_login_pass ;
		ajaxRequest.open("GET", "include/signup.php" + queryString, true);
		ajaxRequest.send(null); 	
	}
	else if(id=='admin_login_status')
	{
		var ajaxRequest;  // The variable that makes Ajax possible!
		
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4)
			{
				var ajaxDisplay = document.getElementById(id);
				var image;
				if(ajaxRequest.responseText=="logged in")
				{
					
					window.location="index.php";
				}
				else
				{
					ajaxDisplay.style.display='block';
				}
			}
			
		}
		var val_admin_user = document.getElementById('admin_user').value;
		var val_admin_pass = document.getElementById('admin_pass').value;
		
		
		var name_admin_user = document.getElementById('admin_user').name;
		var name_admin_pass = document.getElementById('admin_pass').name;
		
		var queryString = "?admin_login=1&" + name_admin_user + "=" + val_admin_user + "&" + name_admin_pass + "=" + val_admin_pass ;
		ajaxRequest.open("GET", "../include/signup.php" + queryString, true);
		ajaxRequest.send(null); 	
	}
	else if(id=='forgot_pass_status')
	{
		var ajaxRequest;  // The variable that makes Ajax possible!
		
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4)
			{
				var ajaxDisplay = document.getElementById(id);
				var image;
					ajaxDisplay.style.display='inline';
					ajaxDisplay.innerHTML=ajaxRequest.responseText;
			}
			
		}
		var val_forogt_user = document.getElementById('forgot_user').value;
		
		
		var name_forogt_user = document.getElementById('forgot_user').name;
		
			
		var queryString = "?form_forgot_password=1&" + name_forogt_user + "=" + val_forogt_user ;
		ajaxRequest.open("GET", "include/signup.php" + queryString, true);
		ajaxRequest.send(null); 	
	}
}

/*email validation function*/

function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    return false
		 }

 		 return true					
	}
