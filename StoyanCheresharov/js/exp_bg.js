// alert('hello World');
// I Objects
// 1) created as Literal (Expression)
/*
var myObject = {};

myObject.prop1 = 'Stoyan';

myObject['prop2'] = 'Cheresharov';

myObject.method1 = function(arg1, arg2){ alert('Arguments ' + this.prop1 + this.prop2);};

alert('Hello World ' + myObject.prop1 + myObject['prop2']);

myObject.method1();
*/

// 2) Created with On eof the Standart Classes Object Class
/*
var myObject = new Object('arg1', 'arg2');

myObject.arg1 = 'Stoyan';

alert(myObject.arg1);

*/

// 3) created with a Constructor that defines a Class of Objects. custom class
/*
function MyClass(){
    this.prop1 = 'Stoyan';
    this.method1 = function(arg1, arg2){ alert('Arguments');};
}

MyClass.prototype = {
    'prop1': 'Nikola',
    'prop2': 'Cheresharov'
};

MyClass.prototype.constructor = MyClass;

var myObject = new MyClass();

alert('Hello ' + myObject.prop1);

var myObject2 = new MyClass();
alert('Hello ' + myObject2.prop1);
alert('Hello ' + myObject2.prop2);
alert(MyClass.prototype.constructor);
*/


// II Functions
/*
// 1) Create statement
function myFunction(arg1, arg2){
    alert('I m here');
}
*/
// myFunction();
/*
// 2) literal (expression)
var myFunction = function forCallBack(arg1, arg2){
    for (var i = 0 ; 0 < arguments.length; i++)
    {
     alert(arguments[i]);
    }
// argument.callee(); // recursion self reference
};
*/
// myFunction('Stoyan');

// 3) with the Function class
/*
var myFunction = new Function('arg1', 'arg2', 'return arg1;');

alert(myFunction('Stoyan', 'Cheresharov'));
*/

// III
// 1) DOM Manipulation
/*
var nodeList = document.getElementsByTagName('div');
for (var i=0; i < nodeList.length; i++)
{
    alert(nodeList[i]);
}
*/
window.onload = function(e){
/*    
    var element = document.getElementById('myDiv');
    alert(element);  
*/
/*
    var nodeList = document.getElementsByTagName('div');
    for (var i=0; i < nodeList.length; i++)
    {
        alert(nodeList[i]);
        nodeList[i].style.color = 'green';
    }
    
    alert( nodeList[0].parentNode );
    
    nodeList[0].innerHTML = 'Hello World from JS';
*/    
    // 2) Remouting ther e are 8 variants GET, POST / synchronous, asynchronous / text XML   
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
  
    // 2) asynchronous
    // 2.1)
    xmlhttp.open('GET', 'exp_bg.txt', true);
    xmlhttp.send();
    // notice instead of direct alert with the xmlhttp.responsetext / XML
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) // 404 not founs
        {
            var responseText = xmlhttp.responseText;
            
            var element = document.getElementById('myDiv');
            element.innerHTML = responseText;
            
            var responseXML = xmlhttp.responseXML; // documentElement is the root element of the document
            // var object = eval(responseText);
            // alert(responseText);
        }
    };  
    
    // 3) Dynamic Behaviour
    // 3.1 Get the element
    var nodeList = document.getElementsByTagName('div');
    
    var element = nodeList[0];  
    
    // 3.2 if it is going to be a function literal should be here
    var onMouseOver = function(e){ // function literal
        // function onMouseOver(e){ // function statement
        var event = e || window.event;
        var element = event.target || event.srcElement; // currentTarget
        alert('The mouse was over me: ' + element.innerHTML);
    };    

    // 3.3 check which DOM 0, 1, 2 is suported
    if (element.addEventListener)
    { // all aothers
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

var stoyan = 'Cheresharov';

alert(stoyan);
