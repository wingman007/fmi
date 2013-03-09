/*
(function(){
    window.onload = function(e){
        var elements, i=0;
        elements = document.getElementsByTagName('h1');
        for (i=0; i < elements.length; i++) {
            alert(elements[i]);
            elements[i].style.color = 'red';
        }
    };
})();
*/

/*
alert(typeof myExample);
alert(myExample instanceof Object);
myExample.prop1 = 'Roperty 1';
console.log(myExample.prop1);
var myGlobalFunction = function(param1){
    return param1;
};

console.log(myGlobalFunction('Stoyan'));

function myNextFunction(param1) {
    return param1;
}

alert(myNextFunction(myGlobalFunction));
*/
(function(){
/*
    function myExample(parm1) {
        var name = 'Stoyan';
        // this.prop1= 'Stoyan';
        alert(name);
        alert(this.prop1);
    }
*/
/*    
    // alert(myExample);
    // alert(myExample());
    // alert(new myExample());
    
    
    function foo() {
        // function body goes here
    }
    
    var f = function(x) { return x*x; }; // function literal
    
    // var myFunction = new Function('arg1', 'arg2', 'return arg1;');
    
    alert(myExample.length);
    
    myExample();
    
    myExample.call({prop1: 'Nikola'},1);
*/ 
/*
    var myObject = {};
    myObject.prop1 = 'Stoyan';
    myObject['prop2'] = 'Cheresharov';
    myObject.method1 = function(arg1, arg2){ alert('Arguments');};
    
    
    // var myObject = new Object('arg1', 'arg2');
    
    alert(myObject.arg1);
    // constructor for a class of objects
    function MyClass(){
        this.prop1 = 'Stoyan';
        this.method1 = function(arg1, arg2){ alert('Arguments');};
    }
*/
/*    
    var obj1 = {};
    obj1.prop1 = 'Stoyan';
    obj1.method1 = function(arg1, arg2){ alert('Arguments');};
    
    var obj2 = {};
    obj2.prop1 = 'Stoyan';
    obj2.method1 = function(arg1, arg2){ alert('Arguments');};
*/   
/*
    var obj1 = new MyClass();
    var obj2 = new MyClass();
    
    alert(obj1.prop1);
    alert(obj2.prop1);
    
    alert(obj1 instanceof MyClass);
*/    
/*
    function MyNewClass(arg1, arg2){
        this.name = 'Stoyan';
        this.family = 'Cheresharov';
        this.method1 = function(){ alert('Do something'); }; // each instance will have a separate copy if this function
    }
    
    MyNewClass.prototype = {
        name: 'Nikola',
        family: 'Cheresharov'
    };
    
    MyNewClass.prototype.constructor = MyNewClass;
    
    // Douglas Crockford prototypel styple
    window.object = function(o){
        var F = function(){};
        F.prototype = o;
        return new F();
    };
    
    var myObject = function(){
        var counter = 1;
        return {'counter': counter}; // there is a closure
    }(); // !!! execute right at the spot to get the object
 
// alert(myExample);
// alert(foo);
*/
})();

(function(){
    
    window.onload = function(e){
       
        // I Objects
/*
        // 1) created as Literal (Expression)
        var myObject = {};
        myObject.prop1 = 'Stoyan';
        myObject['prop2'] = 'Cheresharov';
        myObject.method1 = function(arg1, arg2){ alert('Arguments');};       
       
    };
*/
/*    
        // 2) Created with On eof the Standart Classes Object Class
        var myObject = new Object('arg1', 'arg2');    
*/
/*
        // 3) created with a Constructor taht defines a Class of Objects custom class
        function MyClass(){
            this.prop1 = 'Stoyan';
            this.method1 = function(arg1, arg2){ alert('Arguments');};
        }
    
        MyClass.prototype = {
            'prop1': 'Nikola',
            'prop2': 'Cheresharov' // they are in the shadow of prop1 and prop2 of the object
        };
        
        MyClass.prototype.constructor = MyClass;
        
        // alert(MyClass.prototype.constructor);
        
        var myObject = new MyClass();    
        // alert(myObject.constructor);

        // Universal Properties and methods
        // 1) property
        alert('myObject.constructor: ' + myObject.constructor); // property

        // 2) Methods
        alert( 'myObject.toString(): ' + myObject.toString() ); // method
        
        alert( 'myObject.toLocaleString(): ' + myObject.toLocaleString() ); // method
        alert( 'myObject.valueOf(): ' + myObject.valueOf() ); // method
        alert( 'myObject.hasOwnProperty(prop1): ' + myObject.hasOwnProperty('prop1') ); // method
        alert( 'myObject.propertyIsEnumerable(prop1): ' + myObject.propertyIsEnumerable('prop1') ); // method
        alert( 'Object.isPrototypeOf( myObject ): ' + Object.isPrototypeOf( myObject ) ); // method        
*/        

        // II Functions
/*    
        // 1) Create statement
        function myFunction(arg1, arg2){
            alert('I am here');
        }
*/
/*
        // 2) literal (expression)
        var myFunction = function forCallBack(arg1, arg2){
            for (var i = 0 ; 0 < arguments.length; i++)
            {
                alert(arguments[i]);
            }
            // arguments.callee(); // recursion self reference
        };
*/
/*
        // 3) with the Function class
        var myFunction = new Function('arg1', 'arg2', 'return arg1;');
*/

        // III

        // 1) DOM Manipulation
/*
        var nodeList = document.getElementsByTagName('div');

        for (var i=0; i < nodeList.length; i++)
        {
            alert(nodeList[i]);
        }
        
        var element = document.getElementById('myPi');
        alert(element);
        
        alert( nodeList[0].parentNode );
        alert( nodeList[0].childNodes[0] );
        alert( nodeList[0].firstChild );
        alert( nodeList[0].lastChild );
        alert( nodeList[0].nextSibling );
        alert( nodeList[0].previousSibling );
        alert( nodeList[0].style.background = 'gray' );
        alert( nodeList[0].innerHTML = 'I am dinamic head' );
        alert( nodeList[0].nodeType );
        alert( nodeList[0].nodeValue );
        alert( nodeList[0].nodeName );
        alert( nodeList[0].getAttribute('class') );
        alert( nodeList[0].setAttribute('class', 'content') );        

        var element = document.createElement('div');
        element.setAttribute('class', 'head');
        element.innerHTML = 'I have been added by JS';
        nodeList[0].appendChild(element);
        // nodeList[0].insertBefore(element);
*/

        // 2) Remouting ther e are 8 variants GET, POST / synchronous, asynchronous / text XML
        var xmlhttp;
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
        
        // 2.1)
        xmlhttp.open('GET', 'exp.txt', true);
        xmlhttp.send();
        // notice instead of direct alert with the xmlhttp.responsetext / XML
        xmlhttp.onreadystatechange = function(){
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) // 404 not founs
            {
                var responseText = xmlhttp.responseText;
                var responseXML = xmlhttp.responseXML; // documentElement is the root element of the document
                // var object = eval(responseText);
                alert(responseText);
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
        
        var functionToExecute = function() {
            alert('10000 miliseconds');
        };
        
        var deferer = window.setInterval(functionToExecute, 10000);        
    }
})();

