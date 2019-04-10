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



/* Remove outline */
button:focus, button:active {
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
.main {
    padding: 1rem 1.2rem;
    display: block;
    background: #f8f8f8;
    border-radius: 0.2rem;
    -webkit-box-shadow: 0 1px 3px rgba(51, 51, 51, 0.2);
    box-shadow: 0 1px 3px rgba(51, 51, 51, 0.2);
}
/* /Main */

/* Product Labels */

.card-product .label {
  top: 7px;
  left: 7px;
  position: absolute;
  display: block;
  z-index: 10;
  padding: 2px 7px;
  font-size: 14px;
  background-color: #dd2c00;
  color: #fff;
  border-radius: 4px;
}
  
.card-product .label.new {
  background-color: #005685;
}

.card-product .label.hit {
  background-color: #d91414;
}

.card-product .label.sale {
  background-color: #006100;
}

.card-product .label.html {
  background-color: transparent;
}  
  
/* /Product Labels */


/* Tables */

table.contentTable
	{
		width: 100%;
		padding: 0 0 0 0;
		margin: 0 0 .2em 0;
		border: 1px solid #97a5b0;
		border-top-left-radius: 4px;
		border-top-right-radius: 4px;
		border-bottom-left-radius: 4px;
		border-bottom-right-radius: 4px;
	}

table.contentTable tr
	{
		padding: 0;
		margin: 0;
	}

table.contentTable tr.contentRowEven
	{
		padding: 0;
		margin: 0;
		background: #f7f7f7;
	}

table.contentTable tr.contentRowOdd
	{
		padding: 0;
		margin: 0;
		background: #fff;
	}

table.contentTable tr.contentRowEvenHover,
table.contentTable tr.contentRowOddHover
	{
		padding: 0;
		margin: 0;
		background: #ffc;
	}

table.contentTable th
	{
		color: #000;
		font-weight: normal;
		padding: .9em;
		margin: 0;
		background-color: #e3eff7;
		border: 1px solid #97a5b0;
		border-top-left-radius: 4px;
		border-top-right-radius: 4px;
		border-bottom-left-radius: 4px;
		border-bottom-right-radius: 4px;
	}

table.contentTable td
	{
		padding: .3em .3em .3em .3em;
		margin: 0;
	}

/* /Tables */

/* Error */

label.error 
  {
    margin-left: 10px;
    width: auto;
    display: inline;
    color: red;
    font-weight: normal;
    background: transparent;
}

.error
   {
    background: #fcc;
   }	

input[type="text"].error, 
input[type="password"].error, 
input[type="email"].error, 
input[type="url"].error, 
input[type="search"].error, 
input[type="tel"].error {
  background-color: #fcc;
}

span.Requirement 
   {
     color: red;
   }
   
/* /Error */

/* Buttons */

.btn.btn-inverse {
  color: #ffffff;
  background-color: #dd2c00;
  margin-top: 5px;
  margin-bottom: 5px;
}
.btn:hover {
    color: #fff;
    background-color: #363636;
}

.btn-add-to-cart {
  color: #ffffff;
  background-color: #dd2c00;
  margin-top: 5px;
  margin-bottom: 5px;
}
.btn-add-to-cart i {
  margin-left: 0;
}
.btn-add-to-cart:hover {
    color: #fff;
    background-color: #363636;
}

.btn-secondary {
    color: #fff;
    background-color: #363636;
    border-color: #363636;
}

.btn-secondary:hover {
    color: #fff;
    background-color: #dd2c00;
    border-color: #dd2c00;
}
	
/* /Buttons */

/* Buttons */

a.button, 
span.button, 
del.button
	{
    display: inline-block;
    font-weight: 400;
    color: #fff;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    background-color: transparent;
    transition: color .1s ease-in-out,background-color .1s ease-in-out,border-color .1s ease-in-out,box-shadow .1s ease-in-out;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
	}

a.button, 
span.button, 
del.button, 
a.button span, 
span.button button, 
span.button input, 
del.button span
	{
		background-color: #363636;
	}

a.button span, 
span.button button, 
span.button input, 
del.button span
	{
    display: inline-block;
    font-weight: 400;
    color: #fff;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    background-color: transparent;
    transition: color .05s ease-in-out,background-color .1s ease-in-out,border-color .1s ease-in-out,box-shadow .1s ease-in-out;
    border: 0;
    padding: 0;
    margin: 0;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0;
	}

del.button span
	{
		cursor: default;
		color: #aaa !important;
	}

span.button button, 
span.button input
	{
		padding: 0;
		margin: 0;
	}

/** optional **/
/*
a.button:visited
	{
		color: #aaa;
	}
*/

/*Hover Style*/

a.button:hover, 
a.button:focus, 
a.dom-button-focus,
span.button:hover, 
span.button:focus,
span.button button:hover, 
span.button button:focus,
span.button-behavior-hover
	{
		background-color: #dd2c00;
		color: #fff;
		text-decoration: none;
	}

a.button:hover span, 
a.button:focus span, 
span.button-behavior-hover button, 
span.button-behavior-hover input
	{
		background-color: #dd2c00;
	}

a.button:active, 
a.button:focus span
	{
		color: #fff;
	}

del.button-behavior-hover, 
del.button:hover
	{
		background-position: 0 -180px;
		/* cursor:not-allowed; */
	}

del.button-behavior-hover span, 
del.button:hover span
	{
		background-position: 100% -180px;
		/* cursor:not-allowed; */
	}

/* /Buttons */









#flyimgcart 
	{
		position:absolute;
		z-index:1000;
	}

.close
	{
		color: red;
		font-size: bold;
	}

p.CartContentRight
	{
		text-align: right;
		padding-right: 0.2em;
	}

p.CartContentCenter
	{
		text-align: center;
	}

div.filter
	{
		float: left;
		padding: 0 .5em;
	}

/* ############ checkout ################## */

.sm_layout_box h2 
	{
		padding: .5em .5em .5em 0;
	}

.sm_layout_box 
	{
		padding-left: 1em;
	}

div.CheckoutError 
	{
		border: 1px solid; 
		border-color: #ff0000; 
		background-color: #FFCCCC; 
		text-align: left; 
		margin-bottom: 0.5em; 
		margin-top: 0.5em;
		padding: 0.5em;
	}
		
#load_status_bg {background: url(img/wind_bg.png) repeat; position: fixed;z-index: 2300;width: 100%;height: 100%;top: 0px;left: 0px;}
#load_status_bg .load_status_image {background:url(img/ajax-loader.gif);width:100%; margin: 270px auto 0;z-index: 2300;width: 54px;height: 55px;}		

/* Страница карточки товара */

p.center
	{
		text-align: center;
	}

div.ProductInfoLeft
	{
		float: left;
		margin-right: 1em;
	}

div.ProductInfoRight
	{
		float: left;
		margin-left: 1em;
		text-align: right;
	}

/* /Страница карточки товара */

/* Ссылки на странице мои данные */

ul.accountLinks 
	{
		list-style-type: none;
		text-align: left;
		padding-left: 1em;
		margin: 0 0 0 0;
	}

li.accountLinks 
	{
		display: block;
		padding: 0; 
	}

/* /Ссылки на странице мои данные */

span.bold 
	{
		font-weight: bold;
	}

/* Ajax quick find */

div.ajaxQuickFind 
	{
		text-align: left;
	}

ul.ajaxQuickFind 
	{
		list-style-type: none;
		list-style-image: none;
		padding-left: 0px;
	}

li.ajaxQuickFind 
	{
		font-size: 80%;
		padding-left: 0px;
	} 

/* /Ajax quick find */

/* Ajax add quickie suggest */

div.ajaxAddQuickie 
	{
		text-align: left;
	}

div.addQuick 
	{
		text-align: left;
		color: #67748B;
		text-decoration: underline;
		cursor: pointer;
	}
	
ul.ajaxAddQuickie 
	{
		list-style-type: none;
		list-style-image: none;
		padding-left: 0px;
	}

li.ajaxAddQuickie 
	{
		font-size: 80%;
		padding-left: 0px;
	} 

/* /Ajax add quickie suggest */

.errorBox 
	{
		background-color: #ffb3b5;
	}

.messageStackError, .messageStackWarning 
	{ 
		background-color: #ffb3b5; 
	}

.messageStackSuccess 
	{ 
		background-color: #99ff00; 
	}

.headerError 
	{
		background-color: #ffb3b5;
		border: 1px solid red;
	}

.messageStack
	{
		background-color: #ffb3b5; 
		padding: 0.5em 0.5em 0.5em 0.5em; 
	}

.itemOdd 
	{
		background: #f4f4f4;
	}
	
.itemEven 
	{
		background: transparent;
	}

#checkout .itemOdd:hover,
#checkout .itemEven:hover, 
#checkout label.shipping.selected,
#checkout label.payment.selected
	{
		border: 1px solid #000;
	}

.shipping-method,
.payment-method 
	{
		border: 1px solid transparent;
		padding: 1em;
	}

div.clear
   {
     clear: both;
   }

div.navigation
   {
     display: block;
     width: 100%;
     padding-top: 1em;
   }

span.right
   {
     float: right;
   }
   
/*- Подсветка ошибок формы */
#errormsg
	{
		border: 2px solid #c00;
		padding: 5px;
		width: 96%;
	}	   

label.error 
	{
		clear: both;
		width: 10%; 
		margin: 5px 0 0; 
		padding: 0 10px 0 10px; 
		border: 0px solid black; 
		color: #545452; 
		font-weight: normal; 
		text-align: right;
}

.error
	{
		background: #fcc;
	}
	
span.Requirement 
   {
     color: red;
   }
   	
/*- /Подсветка ошибок формы */   

/*- Цены */

span.markProductOutOfStock 
   {
     color: #c76170;
     font-weight: bold;
   }

span.productSpecialPrice 
   {
     color: #ff0000;
   }

span.productOldPrice 
   {
	  color: #fff;
	  text-decoration: line-through;
   }

span.errorText 
   {
     color: #ff0000;
   }

/*- /Цены */

/* Ошибка на странице свяжитесь с нами */

div.contacterror 
   {
     border: 1px solid; 
     border-color: #ff0000; 
     background-color: #FFCCCC; 
     text-align: center; 
     margin-bottom: 0.5em; 
     margin-top: 0.5em;
   }

/* /Ошибка на странице свяжитесь с нами */

/* Footer */
footer a,
footer a:hover {

color: white;

}

/* /Footer */

/*- Время парсинга */
div#parseTime
   {
     clear: left;
     background: #6c757d;
     width: 100%;
     text-align: center;
     color: #fff;
     padding-top: 0.5em;
     padding-bottom: 0.5em;
   }
/*- /Время парсинга */

/*- Информация о магазине */
div#copyright
   {
     clear: left;
     background: #6c757d;
     width: 100%;
     text-align: center;
     color: #fff;
     padding-top: 0.5em;
     padding-bottom: 0.5em;
   }

div#copyright a,
div#copyright a:hover,
div#copyright a:visited
   {
     color: #fff;
     text-decoration: underline;
   }

div.copyright
   {
     clear: left;
     background: #6c757d;
     width: 100%;
     text-align: center;
     color: #fff;
     padding-top: 0.5em;
     padding-bottom: 0.5em;
   }
/*- /Информация о магазине */

/* Вывод товаров */

/* Количество колонок с товаром на странице новинки */
dl.itemNewProducts 
   {
     display: block;
     width: 100%; /* количество колонок, 50% - товар выводится двумя колонками, т.е. два товара в одной строке, 100% - товар выводится одной колонкой, т.е. один товар в одной строке */ 
     float: left;
     height: auto; /* высота блока с товаром, нужно устанавливать обязательно, иначе блоки товаров с картинками и без будут "слипаться" */ 
     margin: 0 0 0 0;
     padding: 0 0 0 0;
     background: transparent;
   }
/* /Количество колонок с товаром на странице новинки */

/* Количество колонок с товаром на странице рекомендуемые товары */
dl.itemFeaturedProducts 
   {
     display: block;
     width: 48%; /* количество колонок, 48% - товар выводится двумя колонками, т.е. два товара в одной строке, 99% - товар выводится одной колонкой, т.е. один товар в одной строке */ 
     float: left;
     height: auto; /* высота блока с товаром, нужно устанавливать обязательно, иначе блоки товаров с картинками и без будут "слипаться" */ 
     margin: 0 0 0 0;
     padding: 0 0 0 0;
     border-bottom: 1px #e5e5e5 solid;
   }
/* /Количество колонок с товаром на странице рекомендуемые товары */

/* Количество колонок с товаром в блоке новинки на главной странице */
dl.itemNewProductsDefault 
   {
     display: block;
     width: 48%; /* количество колонок, 48% (не 50, иначе в IE всё равно в одну колонку будут) - товар выводится двумя колонками, т.е. два товара в одной строке, 99% - товар выводится одной колонкой, т.е. один товар в одной строке */ 
     float: left;
     height: auto; /* высота блока с товаром, нужно устанавливать обязательно, иначе блоки товаров с картинками и без будут "слипаться" */ 
     margin: 0 0 0 0;
     padding: 0 0 0 0;
     background: transparent;
   }
/* /Количество колонок с товаром в блоке новинки на главной странице */

/* Количество колонок с новостями на главной странице */
dl.itemLatestNewsDefault 
   {
     display: block;
     width: 98%; /* количество колонок, 48% (не 50, иначе в IE всё равно в одну колонку будут) - товар выводится двумя колонками, т.е. два товара в одной строке, 99% - товар выводится одной колонкой, т.е. один товар в одной строке */ 
     float: left;
     margin: 0.5em 0 0.5em 0;
     padding: 0 0 0 0;
   }
/* /Количество колонок с новостями на главной странице */

/* Количество колонок с новостями на странице новостей */
dl.itemLatestNews 
   {
     display: block;
     width: 98%; /* количество колонок, 48% - товар выводится двумя колонками, т.е. два товара в одной строке, 99% - товар выводится одной колонкой, т.е. один товар в одной строке */ 
     float: left;
     margin: 0.5em 0 0.5em 0;
     padding: 0 0 0 0;
   }
/* /Количество колонок с новостями на странице новостей */

/* Количество колонок с товаром на странице скидки */
dl.itemSpecials 
   {
     display: block;
     width: 48%; /* количество колонок, 48% - товар выводится двумя колонками, т.е. два товара в одной строке, 99% - товар выводится одной колонкой, т.е. один товар в одной строке */ 
     float: left;
     height: auto; /* высота блока с товаром, нужно устанавливать обязательно, иначе блоки товаров с картинками и без будут "слипаться" */ 
     margin: 0 0 0 0;
     padding: 0 0 0 0;
     border-bottom: 1px #e5e5e5 solid;
   }
/* /Количество колонок с товаром на странице скидки */

/* Количество колонок с товаром на странице мои данные */
dl.itemLastViewed 
   {
     display: block;
     width: 98%; /* количество колонок, 48% - товар выводится двумя колонками, т.е. два товара в одной строке, 99% - товар выводится одной колонкой, т.е. один товар в одной строке */ 
     float: left;
     height: auto; /* высота блока с товаром, нужно устанавливать обязательно, иначе блоки товаров с картинками и без будут "слипаться" */ 
     margin: .5em 0 0 0;
     padding: .5em 0 0 0;
     border-bottom: 1px #e5e5e5 solid;
   }

/* /Количество колонок с товаром на странице мои данные */

/* Информация о заказе, адрес клиента и адрес доставки */
dl.ordersAddress 
   {
     display: block;
     width: 49%; /* количество колонок, 48% - товар выводится двумя колонками, т.е. два товара в одной строке, 99% - товар выводится одной колонкой, т.е. один товар в одной строке */ 
     float: left;
     margin: 0 0 0 0;
     padding: 0 0 0 0;
     border-bottom: 1px #e5e5e5 solid;
   }

dt.ordersAddress 
   {
     display: block;
     float: left;
     background: transparent;
     border-right: 0px #f1f1f6 solid;
     margin: 0 0 0 0;
     padding: 0 0 0 0;
     text-align: center;
   }

dd.ordersAddress
   {
     display: block;
     margin: 0 0 0 1em;
     padding: 0 0 0 0;
     line-height: normal;
     background: transparent;
   }

/* /Информация о заказе, адрес клиента и адрес доставки */

/* Адресная книга */
dl.AddressBook 
   {
     display: block;
     width: 49%; /* количество колонок, 48% - товар выводится двумя колонками, т.е. два товара в одной строке, 99% - товар выводится одной колонкой, т.е. один товар в одной строке */ 
     float: left;
     margin: 0 0 0 0;
     padding: 0 0 0 0;
   }

dt.AddressBook 
   {
     display: block;
     float: left;
     width: 90px;
     background: transparent;
     border-right: 0px #f1f1f6 solid;
     margin: 0 0 0 0;
     padding: 0 0 0 0;
     text-align: center;
   }

dd.AddressBook
   {
     display: block;
     margin: 0 0 0 90px;
     padding: 0 0 0 0;
     line-height: normal;
     background: transparent;
   }

dl.AddressBookList 
   {
     display: block;
     width: 49%;
     float: left;
     height: auto;
     margin: 0 0 0 0;
     padding: 0 0 1em 0;
   }

dt.AddressBookList 
   {
     display: block;
     float: left;
     background: transparent;
     border-right: 0px #f1f1f6 solid;
     margin: 0 0 0 0;
     padding: 0 0 0 0;
     text-align: center;
   }

dd.AddressBookList
   {
     display: block;
     margin: 0 0 0 0;
     padding: 0 0 0 0;
     line-height: normal;
     background: transparent;
   }

/* /Адресная книга */

/* Вход */
dl.Login 
   {
     display: block;
     width: 49%;
     float: left;
     margin: 0 0 0 0;
     padding: 0 0 0 0;
   }

dt.Login
   {
     float: left;
     display: block;
     background: transparent;
     margin: 0 0 0 0;
     padding: 0 0 0 0;
     text-align: center;
   }

dd.Login
   {
     display: block;
     margin: 0 0 0 1em;
     padding: 0 0 0 0;
     line-height: normal;
     background: transparent;
   }

/* /Вход */

dt.itemImage 
   {
     float: left;
     display: block;
     background: transparent;
     border-right: 0px #f1f1f6 solid;
     margin: 0 0 0 0;
     padding: 5px 5px 0 5px;
     text-align: center;
   }

dt.itemNews 
   {
     display: none;
     float: left;
     background: transparent;
     border-right: 0px #f1f1f6 solid;
     margin: 0 0 0 0;
     padding: 5px 5px 0 5px;
     text-align: left;
   }

dd.itemDescription
   {
     display: block;
     margin: 0 0 0 0;
     padding: 0 0;
     line-height: normal;
     background: transparent;
   }

dd.itemDescriptionPrice
   {
     display: block;
     margin: 1em 0 0 0;
     padding: 0 0;
     line-height: normal;
     background: transparent;
   }

dd.itemNews
   {
     display: block;
     margin-left: 1em;
     padding: 0 0;
     line-height: normal;
     background: transparent;
   }

div.clear
   {
     clear: both;
   }

div.navigation
   {
     display: block;
     width: 100%;
     padding-top: 1em;
   }

span.right
   {
     float: right;
   }

/* /Вывод товаров */

/* Вывод категорий */

dl.itemCategoriesListing 
   {
     width: 33%; /* количество колонок, 50% - товар выводится двумя колонками, т.е. два товара в одной строке, 100% - товар выводится одной колонкой, т.е. один товар в одной строке */ 
     float: left;
     height: auto; /* высота блока с товаром, нужно устанавливать обязательно, иначе блоки товаров с картинками и без будут "слипаться" */ 
     margin: 0 0 0 0;
     padding: 0 0 0 0;
     background: transparent;
   }

dt.itemCategoriesListing 
   {
     float: left;
     height: auto;
     background: transparent;
     border-right: 0px #f1f1f6 solid;
     margin: 0 0 0 0;
     padding: 5px 5px 0 5px;
     text-align: center;
   }

dd.itemCategoriesListing 
   {
     margin: 0 1em 0 1em;
     padding: 0 0;
     line-height: normal;
     background: transparent;
     text-align: center;
   }

/* /Вывод категорий */

.form textarea 
   {
	  width: 80%;
   }

.controls
	{
		padding: 6px 0 0 0;
	}

#myModal .modal-body {
	max-height: 400px;
}   
