<?php 
header('Content-Type: text/css');

include('vamshop.css.php');
?>

.sn_menu_open {cursor:pointer;margin:0;} 
#sn_menu_icon .sn_menu_close {display:block; ;color:#333;background:transparent; position:absolute; right:20px; top:20px; z-index:100020;}

#sn_menu_panel {width:100%; height:100%; position:fixed; left:-100%; top:0; z-index:100010; transition:0.5s 0.1s; 
  display:flex; flex-direction:row; flex-wrap:wrap; justify-content:space-between;
}
#sn_menu_panel #sn_menu_left {width:50%; height:100%; background:#f8f9fa; position:relative; overflow:auto;
  display:flex; flex-direction:column; flex-wrap:nowrap; justify-content:center;
}
#sn_menu_panel #sn_menu_left h1 {padding:0; margin:0; text-align:center; color:#790; text-shadow:0 0 3px #fff;}
#sn_menu_panel #sn_menu_left #social {text-align:center; width:100%;}
#sn_menu_panel #sn_menu_left .social {color:#555; display:inline-block; font-size:20px; margin:5px; transition:0.2s;}
#sn_menu_panel #sn_menu_left .social:hover {color:#000;}
#sn_menu_panel #sn_menu_left p {color:#333; text-align:center;}

#sn_menu_panel #sn_menu_right {order:2; width:50%; height:100%; background:#fff; color:#aaa; overflow-y:auto; -webkit-overflow-scrolling: touch;
  display:flex; flex-direction:column; flex-wrap:nowrap; justify-content:center;
}

#sn_menu_right #sn_menu p {position:relative; padding:0; margin:0;}
#sn_menu_right #sn_menu p label {display:block; line-height:40px; text-transform:uppercase;}
#sn_menu_right #sn_menu p label::after {content:""; display:block; width:6px; height:6px; border:2px solid #aaa; border-width:0 2px 2px 0; position:absolute; right:20px; top:15px; transform:rotate(-45deg); transition:0.3s;}
#sn_menu_right #sn_menu p label:hover {color:#790;}
#sn_menu_right #sn_menu p label:hover::after {border-color:#790;}
#sn_menu_right #sn_menu p label:last-child {display:none; position:absolute; left:0; top:0; width:100%; height:40px; background:rgba(0,0,0,0);}

#sn_menu_right #sn_menu p a {line-height:40px; color:#666; text-decoration:none;}
#sn_menu_right #sn_menu p a:hover {color:#000;}

#sn_menu_right #sn_menu div p {height:0; overflow:hidden; opacity:0; transition:0.75s; position:relative;}

#sn_menu_right div {padding:0; margin:0; list-style:none;}

#sn_menu_right #sn_menu {width:calc(100% - 100px); max-width:400px; min-width:300px; margin:0 auto; max-height:100%;}
#sn_menu_right #sn_menu > p {text-indent:0;}
#sn_menu_right #sn_menu div {position:relative;}
#sn_menu_right #sn_menu div::before {content:""; display:block; width:1px; height:calc(100% - 20px); background:#790; position:absolute; left:5px; top:0;}
#sn_menu_right #sn_menu div p {text-indent:15px; position:relative;}
#sn_menu_right #sn_menu div p::before {content:""; display:block; width:8px; height:1px; background:#790; position:absolute; left:5px; top:19px;}
#sn_menu_right #sn_menu div div::before {left:20px;}
#sn_menu_right #sn_menu div div p {text-indent:30px;}
#sn_menu_right #sn_menu div div p::before {left:20px;}
#sn_menu_right #sn_menu div div div::before {left:35px;}
#sn_menu_right #sn_menu div div div p {text-indent:45px;}
#sn_menu_right #sn_menu div div div p::before {left:35px;}

input[id*="sn_menu"] {display:none;}

input[class*="ip00"]:checked ~ #wrapper {overflow:hidden;}
input[class*="ip00"]:checked ~ #sn_menu_icon {position:fixed;}
input[class*="ip00"]:checked ~ #sn_menu_icon .sn_menu_close {display:block;}

input[class*="ip00"]:checked ~ #sn_menu_panel {left:0; transition:0.5s;}

input[class*="ip01"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu01 + div > p,
input[class*="ip02"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu02 + div > p,
input[class*="ip03"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu03 + div > p,
input[class*="ip04"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu04 + div > p,
input[class*="ip05"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu05 + div > p,
input[class*="ip06"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu06 + div > p,
input[class*="ip07"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu07 + div > p,
input[class*="ip08"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu08 + div > p,
input[class*="ip09"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu09 + div > p,
input[class*="ip10"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu10 + div > p,
input[class*="ip11"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu11 + div > p {height:40px; opacity:1;}

#sn_menu01:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu01 > label:last-child,
#sn_menu02:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu02 > label:last-child,
#sn_menu03:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu03 > label:last-child,
#sn_menu04:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu04 > label:last-child,
#sn_menu05:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu05 > label:last-child,
#sn_menu06:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu06 > label:last-child,
#sn_menu07:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu07 > label:last-child,
#sn_menu08:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu08 > label:last-child,
#sn_menu09:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu09 > label:last-child,
#sn_menu10:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu10 > label:last-child,
#sn_menu11:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu11 > label:last-child {display:block;}

input[class*="ip01"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu01 > label,
input[class*="ip02"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu02 > label,
input[class*="ip03"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu03 > label,
input[class*="ip04"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu04 > label,
input[class*="ip05"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu05 > label,
input[class*="ip06"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu06 > label,
input[class*="ip07"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu07 > label,
input[class*="ip08"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu08 > label,
input[class*="ip09"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu09 > label,
input[class*="ip10"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu10 > label,
input[class*="ip11"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu11 > label {color:#790;}

input[class*="ip01"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu01 > label::after,
input[class*="ip02"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu02 > label::after,
input[class*="ip03"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu03 > label::after,
input[class*="ip04"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu04 > label::after,
input[class*="ip05"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu05 > label::after,
input[class*="ip06"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu06 > label::after,
input[class*="ip07"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu07 > label::after,
input[class*="ip08"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu08 > label::after,
input[class*="ip09"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu09 > label::after,
input[class*="ip10"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu10 > label::after,
input[class*="ip11"]:checked ~ #sn_menu_panel #sn_menu_right #sn_menu .sn_menu11 > label::after {transform:rotate(45deg); border-color:#790;}

@media only screen and (max-width: 640px) {
#header #sn_menu_icon {right:15px;}
#sn_menu_right #sn_menu {min-width:260px; margin:0 auto;}
#sn_menu_panel #sn_menu_left {width:0; display:none;}
#sn_menu_panel #sn_menu_right {width:100%; min-width:320px;}
}
@media only screen and (max-width: 480px) {
#sn_menu_right #sn_menu {margin:0 0 0 10px;}
}




body {
  background: linear-gradient(-183deg, #6c757d 234px, #fff 235px) no-repeat;

}



/* Remove outline */
button:focus, button:active, a, a:hover {
   outline: none;
}
/* /Remove outline */

/* Owl Nav */
.owl-prev, .owl-next {
  z-index: 9;
  top: 50%;
  -webkit-transform: translateY(-50%);
          transform: translateY(-50%);
  position: absolute; }

.owl-prev {
  left: 0px;
  }

.owl-next {
  right: 0px;
  }
/* /Owl Nav */

/* Owl Slides Equal Height */
.owl-stage {
  display: flex;
  flex-wrap: wrap;
}

.owl-item{
  display: flex;
  height: auto !important;
}

.owl-item img {
  margin: 0 auto !important;
  width: auto !important;
}	

.card-product {
  width: 100%;
}
/* /Owl Slides Equal Height */


/* Main */
.mainWrapper {
    padding: 1rem 1.2rem;
    display: block;
    background: #f8f8f8;
    border-radius: 0.2rem;
    -webkit-box-shadow: 0 1px 3px rgba(51, 51, 51, 0.2);
    box-shadow: 0 1px 3px rgba(51, 51, 51, 0.2);
}
/* /Main */


/* Star Rating */
.rating {
  background-color: transparent;
  color: orange;
  right: 0;
  padding: 0 1px 0 0;
  font-size: 14px;
  text-align: center;
}
/* /Star Rating */


/* Scroll To Top */
a#scrollup {
  bottom: 20px;
  right: 30px;
  padding: 5px 10px;
  background: #dd2c00;
  color: #fff;
}

a#scrollup i{
  font-size: 16px;
}

a#scrollup:hover {
  background: #d50000;
}	

/* /Scroll To Top */

.dropdown-menu.cart {
  min-width: 300px; 
  position: absolute; 
  transform: translate3d(-90px, 42px, 0px); 
  top: 0px; 
  left: 0px; 
  will-change: transform;
}

.btn-group-xs > .btn, .btn-xs {
    padding  : .25rem .4rem;
    font-size  : .875rem;
    line-height  : .5;
    border-radius : .75rem;
}

/* Products Gallery */
.gallery-wrap .img-small-wrap .item-gallery {
  border: 0px !important;
}

.card-product .img-wrap {
  height: auto;
}
/* /Products Gallery */


/* Products Filter Collapse On Mobile */
@media (min-width: 768px) {
  .collapse.dont-collapse-sm {
    display: block;
    height: auto !important;
    visibility: visible;
  }
}
/* /Products Filter Collapse On Mobile */
