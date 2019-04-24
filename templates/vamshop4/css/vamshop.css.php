/* Низ */
#footer
   {
     flex: 0 auto;
     background: transparent;
     border-top: 0px solid #67748B;
     text-align: center;
     color: #000;
   }
   
#footer p
   {
     margin: 0;
     padding: 5px 10px;
   }

footer a,
footer a:hover {

color: white;

}

/* /Низ */

/* Заголовок страницы */
#content h1 
   {
   }

#content h1 a 
   {
   }
/* /Заголовок страницы */

/* Скругленные углы */
.page 
   {
    background: #f8f8f8;
   }

.pageItem 
   {
    background: #f8f8f8;
   }

.page h1, .page p 
   {
   }

.page h1 
   {
   }

.page p 
   {
   }

.pageContent,
.moduleContent 
   {
    background: #f8f8f8;
   }

.pageContentFooter 
   {
     display: block;
     text-align: right;
     background: transparent;
     margin-top: 0.5em;
     margin-bottom: 0.5em;
   }
/* /Скругленные углы */

/*- Стили для мобильных устройств */

@media (max-width: 767px) {
dl.itemLatestNewsDefault, 
dl.itemNewProductsDefault, 
dl.itemNewProducts,
dl.itemFeaturedProducts, 
dl.itemLatestNewsDefault, 
dl.itemLatestNews,
dl.itemSpecials,
dl.itemLastViewed,
dl.ordersAddress,
dl.AddressBook,
dl.AddressBookList, 
dl.Login,
dl.itemCategoriesListing 
  {
    width: 100% !important;  
  }

.ProductInfoLeft, 
.ProductInfoRight 
  {
    float: none !important;
    width: 100% !important;  
    margin: 0 auto !important;
    text-align: center !important;
  }
  
p.CartContentRight
  {
    text-align: center !important;
  }  

#content form#cart_quantity .pagecontent table img 
  {
    display: none;
  }  
   
textarea 
  {
    width: 80%;
  }   
  
}

/*- /Стили для мобильных устройств */

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

/*- Формы */

form 
   {
	  width: 100%;
	  margin: 0;
   }

.form input, textarea,
input[type=text]
   {
		border: 1px solid;
		border-color: #ccc;
		padding: .3em;
		border-top-left-radius: 4px;
		border-top-right-radius: 4px;
		border-bottom-left-radius: 4px;
		border-bottom-right-radius: 4px;
   }

.form textarea 
   {
	  width: 80%;
   }

fieldset.form
	{
		border: 0px;
	}

fieldset.form legend
	{
		font-weight: bold;
		font-weight: bold;
	}

.form p label
	{
		display: inline-block; 
		/*float: left;*/ 
		margin: 5px 0 0; 
		padding: 0 10px 0 10px; 
		border: 0px solid black; 
		color: #545452; 
		font-weight: normal; 
		text-align: right;
	}

.form p
	{
		font-weight: normal;
		margin-bottom: .5em;
		clear: both;
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
		width: auto; 
		margin: 5px 0 0; 
		padding: 0 10px 0 10px;
		border: 0px solid black;
		background: transparent; 
		color: #545452; 
		font-weight: normal; 
		text-align: right;
	}	 

.error
	{
		background: #fcc;
	}
/*- /Подсветка ошибок формы */
   
.form textarea:focus, input:focus, .sffocus, .sffocus 
   {
	  background-color: #ffc;
   }

span.Requirement 
   {
     color: red;
   }

/*- /Формы */

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
	  color: #ff0000;
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
     width: 48%; /* количество колонок, 48% (не 50, иначе в IE всё равно в одну колонку будут) - товар выводится двумя колонками, т.е. два товара в одной строке, 99% - товар выводится одной колонкой, т.е. один товар в одной строке */ 
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
     margin: 0 0 0 0;
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
     margin: 0 0 0 0;
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
     font-weight: bold;
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

div#ajaxQuickFind {
  text-align: left; 
  position: absolute; 
  z-index: 999; 
  top: 50px;
  background-color: #fff;
}

div.ajaxQuickFind 
   {
     text-align: left;
   }

ul.ajaxQuickFind 
   {
     list-style-type: none;
     list-style-image: none;
     padding: 0.5em;
   }

li.ajaxQuickFind 
   {
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
		background: #fff;
	}
	
.itemEven 
	{
		background: #f6f4f4;
	}

#checkout .itemOdd:hover,
#checkout .itemEven:hover, 
#checkout label.shipping.selected,
#checkout label.payment.selected,
.selected
	{
		border: 1px solid #000;
	}

label
	{
		display: block;
		margin-bottom: 0px;
	}
	
.shipping-method,
.payment-method 
	{
		border: 1px solid transparent;
		padding: 1em;
	}

/* Buttons */

.btn.btn-inverse {
  color: #ffffff;
  background-color: #dd2c00;
  margin-top: 5px;
  margin-bottom: 5px;
}
.btn:hover {
    color: #fff;
    background-color: #007bff;
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
    background-color: #007bff;
}

.btn-secondary {
    color: #fff;
    background-color: #363636;
    border-color: #363636;
}

.btn-secondary:hover {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
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
    padding: .300rem .75rem;
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

#load_status_bg
	{
		background: #fff; 
		opacity: 0.9;
		position: fixed;
		z-index: 2300;
		width: 100%;
		height: 100%;
		top: 0px;
		left: 0px;
	}

#load_status_bg .load_status_image 
	{
		background:url(../img/ajax-loader.gif);
		width:100%; 
		margin: 270px auto 0;
		z-index: 2300;
		width: 54px;
		height: 55px;		
	}

#myModal .modal-body
	{
		max-height: 400px;
	}

/* Product Labels */

.label {
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
  
.label.new {
  background-color: #005685;
}

.label.hit {
  background-color: #d91414;
}

.label.sale {
  background-color: #006100;
}

.label.html {
  background-color: transparent;
}  
  
/* /Product Labels */

/* Корзина popup */
.cart_popup
	{
		z-index:5000;
		overflow:hidden;
		background:#fff;
		box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);
		left:50%;
		line-height:18px;
		padding:15px;
		position:fixed;
		top:50%;
		transition:all 0.3s ease-in-out 0s;
		margin-left: -180px;
		margin-top: -70px;
		width: 360px
	}

.cart_popuptext
	{
		font-size:18px;
		padding:0 0 12px;
		text-align:center
	}

.cart_popuplink
	{
		text-align: center;
	}
/* /Корзина popup */
