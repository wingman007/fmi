require(["dojo/dom", "dojo/on", "dojo/request/xhr", "dojo/domReady!"], function(dom, on, xhr){
 on(dom.byId("box3"), "click", function(){
  xhr(BASE_URL + '/fmi-student/service-ajax', {
  // handleAs: "json"
  }).then(function(data){
   // Do something with the handled data
   dom.byId("box3").innerHTML = data;
  }, function(err){
   // Handle the error condition
  }, function(evt){
   // Handle a progress event from the request if the
   // browser supports XHR2
  });
  // alert('I have been clicked'); // handle the event
 });
 // dom.byId("box3").innerHTML = "Hello New World!";
});