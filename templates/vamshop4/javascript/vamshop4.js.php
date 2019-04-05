<?php 
header('Content-Type: application/javascript');
?>
$(document).ready(function(){
$(".owl-carousel").owlCarousel({
    margin: 10,
    nav: true,
    loop:false,
    dots: false,
    navText: ['<span class="fas fa-chevron-left fa-2x"></span>','<span class="fas fa-chevron-right fa-2x"></span>'],
    responsive:{
        0:{
            items:1,
            nav:true
        },
        576:{
            items:2,
            nav:true
        },
        768:{
            items:3,
            nav:true
        },
        992:{
            items:3,
            nav:true,
            loop:false
        },
        1200:{
            items:4,
            nav:true,
            loop:false
        }
    }
})
});
