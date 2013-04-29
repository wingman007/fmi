window.onload = function(){
    // var nodeList = document.getElementsByTagName('div');
	// var element = nodeList[0]; 
	// alert('baseUrl = ' + BASE_URL);
    var element = document.getElementById('box3');
	
    var onMouseOver = function(e){ // function literal
        // function onMouseOver(e){ // function statement
        var event = e || window.event;
        var element = event.target || event.srcElement; // currentTarget
		var xmlhttp = null;
		
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new window.XMLHttpRequest();
		}
		else if (window.ActiveXObject)
		{// code for IE6, IE5
		// xmlhttp = new window.ActiveXObject('Msxml2.XMLHTTP');
			xmlhttp=new window.ActiveXObject("Microsoft.XMLHTTP");
		}
		else
		{
			alert('Your browser doesn\'t support XHR');
		}
		alert('baseUrl = ' + BASE_URL);
		xmlhttp.open('GET', BASE_URL + '/fmi-student/service-ajax', true);
		xmlhttp.send();
		// notice instead of direct alert with the xmlhttp.responsetext / XML
		xmlhttp.onreadystatechange = function(){
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) // 404 not founs
			{
				var responseText = xmlhttp.responseText;
				// var element = document.getElementById('myDiv');
				element.innerHTML = responseText;
				
				var responseXML = xmlhttp.responseXML; // documentElement is the root element of the document
				// var object = eval(responseText);
				// alert(responseText);
			}
		};  	
    };
	
	// check which DOM 0, 1, 2 is suported
    if (element.addEventListener)
    { // all others
        element.addEventListener('mouseover', onMouseOver, false); // capture or not
    }
    else if (element.attachEvent)
    { // MS
        element.attachEvent('onmouseover', onMouseOver);
    }
    else
    { // DOM 0
        element.onmouseover = onMouseOver;
    }
	
};