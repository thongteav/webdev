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
		//get the response and update the html
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

function assignTaxi(datasource, divID, ref_num){
	if(xhr){
		//sending the booking reference number via POST method
		var requestbody = "ref_num="+encodeURIComponent(ref_num);
		xhr.open("POST", datasource, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = getData;
		xhr.send(requestbody);
	}
}

function showRequest(){
	if(xhr){
		//using POST method
		xhr.open("POST", "showrequest.php?id=" + Number(new Date), true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");	
		xhr.onreadystatechange = getData;
		xhr.send(null);
	}
}