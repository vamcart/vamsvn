<?php 
header('Content-Type: application/javascript');
?>
$(document).ready(function(){
$(".owl-carousel").owlCarousel({
    loop:true,
    margin: 10,
    nav: true,
    dots: false,
    navText: ['<span class="fas fa-chevron-left fa-2x"></span>','<span class="fas fa-chevron-right fa-2x"></span>'],
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        576:{
            items:2,
            nav:false
        },
        768:{
            items:3,
            nav:false
        },
        992:{
            items:4,
            nav:true,
            loop:false
        },
        1200:{
            items:6,
            nav:true,
            loop:false
        }
    }
})
});
