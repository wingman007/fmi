/*
var coolcsn = {};
(function(){
    // var jQuery = {};
    // var $ = {};
    var coolcsn = function(parm1, param2){
        
    };
    coolcsn.com = {};
    
    coolcsn.com.myFunction = function(){
        
    };
    
    window.onload = function(){
        var divs = $("div"); 
    };
    
})();
*/
/*
$( document ).ready(function() {
  console.log("ready!");
});
*/

// Shorthand for $( document ).ready()
$(function() {
    
    $("#myDiv").attr("style", "background-color: yellow;");
    
   $("#myDiv").text('I am comming from jQuery');
    
    $("#myDiv").fadeOut().show(300).slideUp().slideToggle();
    
    
  console.log("ready!");
});
