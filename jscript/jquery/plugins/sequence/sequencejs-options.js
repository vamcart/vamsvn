$(document).ready(function(){
    var options = {
        nextButton: true,
        prevButton: true,
        animateStartingFrameIn: true,
        autoPlay: true,
        autoPlayDelay: 4000,
    };
    
    var mySequence = $("#sequence").sequence(options).data("sequence");
});