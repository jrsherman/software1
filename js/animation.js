/* ***notes***l
    safari and chrome are really picky about getting integers not floats, make sure to round when animating for these browsers.*/
var i = 5; //starting at 5 so as to begin the text size appropriatly
function myFunction() {
    var sinedValue = Math.round((Math.sin(i)*8)+20); //using sine instead of linear incrm. to aid in more organic animation movment
   // document.getElementById("fluxuateSize").style.paddingBottom=sinedValue+"px"; //keeps text from drifting down too much as it expands
    //document.getElementById("fluxuateSize").style.fontSize=sinedValue+"px"; 
    //document.getElementById("contentArea1").style.backgroundColor= "rgb("+(sinedValue*7)+",100,200)"; //shifts color background at start of page
    i+=.04; //helps set animation speed and fluidity
    //alert(sinedValue);
    if(i>=7){
        clearInterval(myVar); //ends animation
        $(".fadeInText1").css('visibility','visible').hide().fadeIn('slow');
        var delayMillis = 500; //1 second
        setTimeout(function() {
            $(".margin.fadeInText2").css('visibility','visible').hide().fadeIn('slow');
}, delayMillis);
        
    }//end if
}
//myFunction();
//var myVar = setInterval(function(){myFunction()}, 10); //calls animation function and the second argument helps sets animation speed and fluidity

