<?php 
header('Content-Type: text/css');
?>

.sn_menu_open {cursor:pointer;margin:0;} 
#sn_menu_icon {display:block; width:30px; height:30px; background:#000; position:absolute; right:20px; top:20px; z-index:100020;}
#sn_menu_panel {width:100%; height:100%; position:fixed; left:-100%; top:0; z-index:100010; transition:0.5s 0.1s; 
  display:flex; flex-direction:row; flex-wrap:wrap; justify-content:space-between;
}
#sn_menu_panel #sn_menu_left {width:50%; height:100%; background:#f8f9fa; background-size:cover;
  display:flex; flex-direction:column; flex-wrap:nowrap; justify-content:center;
}
#sn_menu_panel #sn_menu_left h1 {text-align:center; font:800 100px/130px 'Open Sans', sans-serif; color:#007bff;}
#sn_menu_panel #sn_menu_left #social {text-align:center; width:100%;}
#sn_menu_panel #sn_menu_left .social {color:#aaa; display:inline-block; font-size:20px; margin:5px; transition:0.2s;}
#sn_menu_panel #sn_menu_left .social:hover {color:#666;}
#sn_menu_panel #sn_menu_left p {font:300 14px/25px 'Open Sans', sans-serif; color:#999; text-align:center;}

#sn_menu_panel #sn_menu_right {order:2; width:50%; height:100%; background:#fff; font:400 18px/40px 'Open Sans', sans-serif; color:#aaa; overflow-y:auto; -webkit-overflow-scrolling: touch;
  display:flex; flex-direction:column; flex-wrap:nowrap; justify-content:center;
}
#sn_menu_panel #sn_menu_right .social {color:#aaa; display:inline-block; font-size:20px; margin:5px; width:25px; text-align:left;}

input[id*="sn_menu"] {display:none;}
#sn_menu_panel #sn_menu_right .menubox {width:98%; max-width:300px; margin:0 auto;}
#sn_menu_panel #sn_menu_right .menubox p {padding:0 0 0 40px; margin:0; height:0; overflow:hidden; font:300 20px/40px 'Open Sans', sans-serif; transition:0.5s;}
#sn_menu_panel #sn_menu_right .menubox p.back {padding:0;}
#sn_menu_panel #sn_menu_right .menubox p label {color:#007bff;}
#sn_menu_panel #sn_menu_right .menubox p.back label {color:#c00;}
#sn_menu_panel #sn_menu_right .menubox p a {text-decoration:none; color:#999;}
#sn_menu_panel #sn_menu_right .menubox p a:hover {color:#000;}

input[class*="ip01"]:checked ~ #wrapper {height:100%; overflow:hidden; transition:0s;}
input[class*="ip01"]:checked ~ #sn_menu_icon {position:fixed;}
input[class*="ip01"]:checked ~ #sn_menu_icon .sn_menu_open .bar {background:transparent; transition:0s;}
input[class*="ip01"]:checked ~ #sn_menu_icon .sn_menu_open .bar::before {transform: rotate(45deg); width:18px; left:3px;}
input[class*="ip01"]:checked ~ #sn_menu_icon .sn_menu_open .bar::after {transform: rotate(-45deg); width:18px; left:3px;}
input[class*="ip01"]:checked ~ #sn_menu_icon .sn_menu_close {display:block;}
input[class*="ip01"]:checked ~ #sn_menu_panel {left:0; transition:0.5s;}

input[class*="ipXX"]:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_0 p,
input[class*="ip00"]:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_0 p {height:40px;}

input#sn_menu_0:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_0 p,
input#sn_menu_1:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_1 p,
input#sn_menu_2:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_2 p,
input#sn_menu_3:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_3 p,
input#sn_menu_4:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_4 p,
input#sn_menu_2_1:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_2_1 p,
input#sn_menu_2_2:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_2_2 p,
input#sn_menu_2_3:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_2_3 p,
input#sn_menu_2_1_1:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_2_1_1 p,
input#sn_menu_4_1:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_4_1 p,
input#sn_menu_4_2:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_4_2 p,
input#sn_menu_4_1_1:checked ~ #sn_menu_panel #sn_menu_right .sn_menu_4_1_1 p {height:40px;}

@media only screen and (max-width: 640px) {
#header #sn_menu_icon {right:15px;}
#sn_menu_panel #sn_menu_left {width:0; display:none;}
#sn_menu_panel #sn_menu_right {width:100%; min-width:320px;}
}


label.modal-close {display:block; width:30px; height:30px; color:#fff; left:0; right:0; top:0; bottom:0; cursor:pointer;}
label.modal-close:before {display:block; content:""; width:100%; height:4px; background:#fff; position:absolute; left:0; top:50%; margin-top:-2px; 
-webkit-transform:rotate(45deg);
transform:rotate(45deg);
}
label.modal-close:after {display:block; content:""; width:100%; height:4px; background:#fff; position:absolute; left:0; top:50%; margin-top:-2px; 
-webkit-transform:rotate(-45deg);
transform:rotate(-45deg);
}





body {
  background: linear-gradient(-183deg, #6c757d 234px, #fff 235px) no-repeat;

}




.owl-carousel .item {
    height: 10rem;
    background: #4DC7A0;
    padding: 1rem;
}


/* owl nav */
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

/* removing blue outline from buttons */
button:focus, button:active {
   outline: none;
}


/*
.card {

  border: 0px;

}
*/


.main {
    padding: 1rem 1.2rem;
    display: block;
    background: #f8f8f8;
    border-radius: 0.2rem;
    -webkit-box-shadow: 0 1px 3px rgba(51, 51, 51, 0.2);
    box-shadow: 0 1px 3px rgba(51, 51, 51, 0.2);
}

footer a,
footer a:hover {

color: white;

}
