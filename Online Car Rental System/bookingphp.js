//Thong Teav 14883251
var xhr = false;

if (window.XMLHttpRequest)
{
	xhr = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
	xhr = new ActiveXObject("Microsoft.XMLHTTP");
}

function getData(){
	if((xhr.readyState == 4) && (xhr.status == 200))
	{
		var serverResponse = xhr.responseText;
		var spantag = document.getElementById("output");
		if(serverResponse != null){
			spantag.innerHTML = serverResponse;			
		}
		else {
			spantag.innerHTML = "";
		}
	}
}

function createBooking(datasource, divID, name, contact, unit_number, street_number, street_address, suburb, dest_suburb, pickup_date, pickup_time){	
	var validated = validate();//validate the input before passing them to the datasource
	if(validated == true){
		if(xhr){			
			var destSuburb = dest_suburb.split(",")[0];
			var requestbody = "namefield="+encodeURIComponent(name)+
			"&contact="+encodeURIComponent(contact)+
			"&unit_number="+encodeURIComponent(unit_number)+
			"&street_number="+encodeURIComponent(street_number)+
			"&street_address="+encodeURIComponent(street_address)+
			"&suburb="+encodeURIComponent(suburb)+
			"&dest_suburb="+encodeURIComponent(destSuburb)+
			"&pickup_date="+encodeURIComponent(pickup_date)+
			"&pickup_time="+encodeURIComponent(pickup_time);
			xhr.open("POST", datasource, true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = getData;
			xhr.send(requestbody);
		}	
	}
}

function validate(){
	var form = document.getElementById("form");

	var input_d = pickup_date.value + " " + pickup_time.value;//get the date
	var d = new Date(input_d);//create a date object using the input
	if(d <= new Date()){//check if the input date is earlier than current date/time
		alert("Pick-up date/time must not be earlier than current date/time");
		pickup_date.focus();
		return false;
	}
	
	if(form.namefield.value==""){
		alert("Please enter your name");
		form.namefield.focus();
		return false;
	} else {
		//validate namefield to allow only letters, spaces, and hyphens(for middle name)
		var regex = new RegExp("^[a-zA-Z -]*$");
		if(!regex.test(form.namefield.value)){
			alert("Please check your name, only letters, spaces, and hyphens are allowed.");
			form.namefield.focus();
			return false;
		}
	}

	if(form.contact.value==""){
		alert("Please enter your contact number");
		form.contact.focus();
		return false;
	} else {
		//validate contact number to allow only numbers and spaces
		var regex = new RegExp("^[0-9 ]*$");
		if(!regex.test(form.contact.value)){
			alert("Please check your contact detail, only numbers and spaces are allowed.");
			form.contact.focus();
		return false;
		}
	}

	//check if the address fields are empty
	if(form.street_number.value=="" || form.street_address.value=="" || form.suburb.value==""){
		alert("Please enter a pick up andress");
		form.autocomplete.focus();
		return false;
	}

	//check if the destination suburb field is empty
	if(form.dest_suburb.value==""){
		alert("Please enter a destination suburb");
		form.dest_suburb.focus();
		return false;
	}

	return true;
}