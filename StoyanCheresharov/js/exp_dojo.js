require(["dojo/dom", "dojo/domReady!"], function(dom){
    dom.byId("myDiv").innerHTML = "Hello New World!";
});

require(["dojo/dom", "dojo/string", "dojo/domReady!"], function(dom, string){
  dom.byId("someNode").innerHTML = string.trim("  I Like Trim Strings ");
});

require(["dojo/dom", "dojo/fx", "dojo/domReady!"], function(dom, fx){
     // The piece we had before...
     var greeting = dom.byId("greeting");
     greeting.innerHTML += " from Dojo!";
     // ...but now, with an animation!
     fx.slideTo({
     top: 100,
     left: 200,
     node: greeting
     }).play();
});