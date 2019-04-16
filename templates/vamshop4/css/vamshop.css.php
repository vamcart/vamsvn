/* Контейнер */
#container
   {
     display: flex;
     flex-direction: column;
     flex: 1 1 auto;
   }
/* /Контейнер */

/* Обёртка для центра, левой и правой колонки */
#wrapper
   {
     display: flex;
     flex: 0 auto;
   }
/* /Обёртка для центра, левой и правой колонки */

/* Центр */
#content
   {
     flex: 1 auto;
     padding: 0 .5em .5em .5em;
   }
/* /Центр */

/* Левая колонка */
#left
   {
     order: -1;
     flex: 0 0 15%; /* Ширина левой колонки 15% */
     overflow: auto;
     background: transparent;
   }
/* Левая колонка */

/* Правая колонка */
#right
   {
     flex: 0 0 15%; /* Ширина левой колонки 15% */
     overflow: auto;
     background: transparent;
   }
/* /Правая колонка */

/* Шапка */
#header 
	{
	}


#header div.header-left 
	{
		margin: 0; 
		padding: 0; 
	}

#header div.header-center 
	{
		margin: 0; 
		padding: 0; 
	}

#header img 
	{
		margin: 18px 0 0 0;
	}

#header h4,
#header h4 a,
#header h4 a:hover,
#header h4 a:visited
	{
		color: #555;
	}
	
#header div.header-right 
	{
		margin: 0; 
		padding: .3em;
	}
/* /Шапка */

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

/* Навигация */
#navigation 
   {
   }

#navigation span 
   {
   }
   
#navigation a
   {
   }

#navigation a:hover
   {
   }

#navigation a:visited
   {
   }
   
/* /Навигация */
   
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

/*- Меню-закладки сверху */

#menu
	{
	}

#menu ul, #menu ul li 
	{
		list-style: none;
		margin: 0;
		padding: 0;
	}

#menu ul 
	{
		padding: 5px 0 4px;
		text-align: center;
	}

#menu ul li 
	{
		display: inline;
		margin-right: .3em;
	}

#menu ul li.current a
	{
		display: inline;
		color: #fff;
		background: #dd2c00;
		margin-right: .3em;
	}

#menu ul li a 
	{
		color: #000;
		padding: 5px 0;
		text-decoration: none;
	}

#menu ul li a span 
	{
		padding: 5px .5em;
	}

#menu ul li a:hover span 
	{
		color: #fff;
		text-decoration: none;
	}

#menu ul li a:hover 
	{
		color: #69C;
		background: #dd2c00;
		text-decoration: none;
	}

/*\*//*/
#menu ul li a 
	{
		display: inline-block;
		white-space: nowrap;
		width: 1px;
	}

#menu ul 
	{
		padding-bottom: 0;
		margin-bottom: -1px;
	}
/**/

/*\*/
* html #menu ul li a 
	{
		padding: 0;
	}
/**/

/*\*/
* html #menu ul li a 
   {
	  padding: 0;
   }
/**/

/*- /Меню-закладки сверху */

/*- Стили для мобильных устройств */

@media (max-width: 767px) {
#header 
  {
    flex-direction: column;
    justify-content: space-around;
    height: auto;
  }
#header .header-left,
#header .header-center,
#header .header-right 
  {
    text-align: center;
  }
#container 
  {
    flex-direction: column;
  }
#wrapper 
  {
    flex-direction: column;
  }
#left 
  {
    order: 0;
    flex: 0 0 auto;
  }
#right 
  {
    flex: 0 0 auto;
  }

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

/*- Боксы */

/*- Бокс разделы */
#boxCategories
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса разделы */
#boxCategories h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса разделы */

/*- Список разделов */
#categoriesBoxMenu 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
   }

#categoriesBoxMenu #CatNavi, #CatNavi ul, #CatNavi li 
   { 
     margin: 0; 
     padding: 0; 
     list-style-type: none; 
   }

#categoriesBoxMenu #CatNavi li a
   { 
     width: 95%;
     display: block; 
     padding: 0.1em 0;
     color: #000;
     text-indent: 0.4em;
     background-color: transparent; 
     text-decoration: none;
     margin: 0.2em 0; 
   }

#categoriesBoxMenu #CatNavi li a:hover
   { 
     color: #f00; 
     background-color: transparent;
   }

#categoriesBoxMenu #CatNavi .CatLevel0 
   {
     padding-left: 10px;
   }

#categoriesBoxMenu #CatNavi .CatLevel1 
   {
     padding-left: 20px;
   }

#categoriesBoxMenu #CatNavi .CatLevel2 
   {
     padding-left: 30px;
   }

#categoriesBoxMenu #CatNavi .CatLevel3
   {
     padding-left: 40px;
   }

#categoriesBoxMenu #CatNavi .CatLevel4
   {
     padding-left: 50px;
   }

#categoriesBoxMenu #CatNavi .CatLevel5
   {
     padding-left: 60px;
   }

#categoriesBoxMenu #CatNavi .CatLevel6
   {
     padding-left: 70px;
   }

#categoriesBoxMenu #CatNavi .CurrentParent a 
   { 
     font-weight: bold; 
   }

#categoriesBoxMenu #CatNavi li a,
#categoriesBoxMenu #CatNavi .Current li a,
#categoriesBoxMenu #CatNavi .CurrentParent li a,
#categoriesBoxMenu #CatNavi .CurrentParent .Current li a 
   { 
     font-weight: normal; 
   }

#categoriesBoxMenu #CatNavi .Current a,
#categoriesBoxMenu #CatNavi .CurrentParent .Current a 
   { 
     font-weight: bold; 
   }
   
/*- /Список разделов */

/*- /Бокс разделы */

/*- Бокс фильтры */
#boxFilters
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса фильтры */
#boxFilters h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса фильтры */

/*- Содержимое бокса фильтры */
#boxFiltersContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: left;
  }

#boxFilters div.close
   {
     width: 100%;
  	  border: 0px solid #67748B;
  	  margin: 0 auto;
  	  padding: 0;
   }

#boxFilters div.close div.content
   {
  	  clear: both;
   }

#boxFilters div.content span.name
   {
     display: block;
  	  border: 0px solid green;
  	  text-align: left;
  	  float: left;
  	  padding: 0;
  	  margin: 0;
   }

#boxFilters div.content span.close
   {
     display: block;
  	  border: 0px solid red;
  	  text-align: right;
  	  padding: 0;
  	  float: right;
  	  margin: 0 auto;
   }

/*- /Содержимое бокса фильтры */

/*- /Бокс фильтры */

/*- Бокс контент */
#boxContent
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса контент */
#boxContent h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса контент */

/*- Содержимое бокса контент */
#boxContentContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: center;
  }

#boxContentContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

#boxContent ul
   {
     list-style-type: none;
     text-align: left;
     padding-left: 1em;
     margin: 0 0 0 0;
   }

#boxContent li 
   {
	  display: block;
     padding: 0; 
   }

/*- /Содержимое бокса контент */

/*- /Бокс контент */

/*- Бокс информация */
#boxInformation
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса информация */
#boxInformation h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса информация */

/*- Содержимое бокса информация */
#boxInformationContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
  }

#boxInformationContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

#boxInformation ul
   {
     list-style-type: none;
     text-align: left;
     padding-left: 1em;
     margin: 0 0 0 0;
   }

#boxInformation li {
	display: block;
   padding: 0; 
}

/*- /Содержимое бокса контент */

/*- /Бокс информация */

/*- Бокс быстрый заказ */
#boxAddQuickie
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса быстрый заказ */
#boxAddQuickie h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса быстрый заказ */

/*- Содержимое бокса быстрый заказ */
#boxAddQuickieContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
  }

#boxAddQuickieContent p 
   {
     margin: 0 0 0 0;
     text-align: left;
  }

/*- /Содержимое бокса быстрый заказ */

/*- Форма быстрый заказ */
.addquickieform input {
	width: 80%;
	font-size: 1em;
	border: 1px solid;
	border-color: #666 #ccc #ccc #666;
	padding: 2px;
   margin-top: 0.2em;
   margin-bottom: 0.4em;
   border-top-left-radius: 4px;
   border-top-right-radius: 4px;
   border-bottom-left-radius: 4px;
   border-bottom-right-radius: 4px;
}

.addquickieform input:focus, .sffocus, .sffocus {
	background-color: #ffc;
}
/*- /Форма быстрый заказ */

/*- /Бокс быстрый заказ */

/*- Бокс авторы */
#boxAuthors
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса авторы */
#boxAuthors h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса авторы */

/*- Содержимое бокса авторы */
#boxAuthorsContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
  }

#boxAuthorsContent p 
   {
     margin: 0 0 0 0;
     text-align: left;
  }

/*- /Содержимое бокса авторы */

/*- /Бокс авторы */

/*- Бокс статьи */
#boxArticles
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса статьи */
#boxArticles h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса статьи */

/*- Содержимое бокса статьи */
#boxArticlesContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
  }

#boxArticlesContent p 
   {
     margin: 0 0 0 0;
     text-align: left;
  }

/*- /Содержимое бокса статьи */

/*- /Бокс статьи */

/*- Бокс партнёрка */
#boxAffiliate
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса партнёрка */
#boxAffiliate h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса партнёрка */

/*- Содержимое бокса партнёрка */
#boxAffiliateContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
  }

#boxAffiliateContent p 
   {
     margin: 0 0 0 0;
     text-align: left;
  }

/*- /Содержимое бокса партнёрка */

/*- /Бокс партнёрка */

/*- Бокс новые статьи */
#boxArticlesNew
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса новые статьи */
#boxArticlesNew h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса новые статьи */

/*- Содержимое бокса новые статьи */
#boxArticlesNewContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
  }

#boxArticlesNewContent p 
   {
     margin: 0 0 0 0;
     text-align: left;
  }

/*- /Содержимое бокса новые статьи */

/*- /Бокс новые статьи */

/*- Бокс просмотренные товары */
#boxLastViewed
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса просмотренные товары */
#boxLastViewed h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса просмотренные товары */

/*- Содержимое бокса просмотренные товары */
#boxLastViewedContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: center;
  }

#boxLastViewedContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

/*- /Содержимое бокса просмотренные товары */

/*- /Бокс просмотренные товары */

/*- Бокс отзывы */
#boxReviews
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса отзывы */
#boxReviews h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса отзывы */

/*- Содержимое бокса отзывы */
#boxReviewsContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: center;
  }

#boxReviewsContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

/*- /Содержимое бокса отзывы */

/*- /Бокс отзывы */

/*- Бокс поиск */
#boxSearch
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса поиск */
#boxSearch h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }

#boxSearch h5 a
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		text-decoration: none;
   }
/*- /Заголовок бокса поиск */

/*- Содержимое бокса поиск */
#boxSearchContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
  }

#boxSearchContent p 
   {
     margin: 0 0 0 0;
     text-align: left;
  }

/*- /Содержимое бокса поиск */

/*- Форма бокса поиск */
.searchboxform input {
	width: 80%;
	font-size: 1em;
	border: 1px solid;
	border-color: #666 #ccc #ccc #666;
	padding: 2px;
   margin-top: 0.2em;
   margin-bottom: 0.4em;
   border-top-left-radius: 4px;
   border-top-right-radius: 4px;
   border-bottom-left-radius: 4px;
   border-bottom-right-radius: 4px;
}

.searchboxform input:focus, .sffocus, .sffocus {
	background-color: #ffc;
}
/*- /Форма бокса поиск */

/*- /Бокс поиск */

/*- Бокс скидки */
#boxSpecials
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса скидки */
#boxSpecials h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }

#boxSpecials h5 a
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		text-decoration: none;
   }
/*- /Заголовок бокса скидки */

/*- Содержимое бокса скидки */
#boxSpecialsContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: center;
  }

#boxSpecialsContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

/*- /Содержимое бокса скидки */

/*- /Бокс скидки */

/*- Бокс рекомендуемые */
#boxFeatured
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса рекомендуемые */
#boxFeatured h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
  
#boxFeatured h5 a
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		text-decoration: none;
   }
/*- /Заголовок бокса рекомендуемые */

/*- Содержимое бокса рекомендуемые */
#boxFeaturedContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: center;
  }

#boxFeaturedContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

/*- /Содержимое бокса рекомендуемые */

/*- /Бокс рекомендуемые */

/*- Бокс новинки */
#boxWhatsNew
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса новинки */
#boxWhatsNew h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }

#boxWhatsNew h5 a
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		text-decoration: none;
   }
/*- /Заголовок бокса новинки */

/*- Содержимое бокса новинки */
#boxWhatsNewContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: center;
  }

#boxWhatsNewContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

/*- /Содержимое бокса новинки */

/*- /Бокс новинки */

/*- Бокс новости */
#boxNews
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса новости */
#boxNews h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }

#boxNews h5 a
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		text-decoration: none;
   }
/*- /Заголовок бокса новости */

/*- Содержимое бокса новости */
#boxNews .boxNewsContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: left;
  }

#boxNews .boxNewsContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

/*- /Содержимое бокса новости */

/*- /Бокс новости */

/*- Бокс вопросы и ответы */
#boxFaq
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса вопросы и ответы */
#boxFaq h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }

#boxFaq h5 a
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		text-decoration: none;
   }
/*- /Заголовок бокса вопросы и ответы */

/*- Содержимое бокса вопросы и ответы */
#boxFaq .boxFaqContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: left;
  }

#boxFaq .boxFaqContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

/*- /Содержимое бокса вопросы и ответы */

dl.itemFaqDefault 
   {
     width: 48%;
     float: left;
     margin: 0.5em 0 0.5em 0;
     padding: 0 0 0 0;
   }

dl.itemFaq 
   {
     width: 98%;
     float: left;
     margin: 0.5em 0 0.5em 0;
     padding: 0 0 0 0;
   }

dt.itemFaq 
   {
     display: none;
     float: left;
     background: transparent;
     border-right: 0px #f1f1f6 solid;
     margin: 0 0 0 0;
     padding: 5px 5px 0 5px;
     text-align: left;
   }

dd.itemFaq
   {
     margin-left: 1em;
     padding: 0 0;
     line-height: normal;
     background: transparent;
   }

/*- /Бокс вопросы и ответы */

/*- Бокс корзина */

/* Оформление */
#boxCart 
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

#boxCart .top, #boxCart .bottom 
   {
     display: none;
     background: transparent; 
     font-size: 1px;
   }

#boxCart .boxheader 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
   }

#boxCart .boxcontent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
   }

#boxCart .boxcontent  span 
   {
     font-weight: bold;
   }

#boxCart .boxheader p 
   {
     padding: 0;
     margin: 0;
   }

#boxCart .boxcontent p 
   {
     padding-top: 0.1em;
     padding-bottom: 0.1em;
     padding-left: 0.5em;
     margin-top: 0;
     margin-bottom: 0;
     margin-left: 0;
     margin-right: 0;
   }
/* /Оформление */

/* Ссылки в заголовке бокса */
#boxCart .boxheader a 
   {
     color: #dd2c00;
     text-decoration: none;
   }

#boxCart .boxheader a:hover 
   {
     color: #dd2c00;
     text-decoration: none;
   }
/* /Ссылки в заголовке бокса */

p.CartContentRight
   {
     text-align: right;
     padding-right: 0.2em;
   }

p.CartContentCenter
   {
     text-align: center;
   }

/*- /Бокс корзина */

/*- Бокс вход/админ */

/* Оформление */
#boxLogin 
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

#boxLogin .top, #boxLogin .bottom 
   {
     display: none;
     background: transparent; 
     font-size: 1px;
   }

#boxLogin .boxheader 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
   }

#boxLogin .boxcontent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
   }

#boxLogin .boxcontent  span 
   {
     font-weight: bold;
   }

#boxLogin .boxheader p 
   {
     padding: 0;
     margin: 0;
   }

#boxLogin .boxcontent p 
   {
     padding-top: 0.1em;
     padding-bottom: 0.1em;
     padding-left: 0.2em;
     margin-top: 0;
     margin-bottom: 0;
     margin-left: 0;
     margin-right: 0;
   }
/* /Оформление */

/*- Форма входа */
.loginform input {
	width: 70%;
	font-size: 1em;
	border: 1px solid;
	border-color: #666 #ccc #ccc #666;
	padding: 2px;
   margin-top: 0.2em;
   margin-bottom: 0.4em;
   border-top-left-radius: 4px;
   border-top-right-radius: 4px;
   border-bottom-left-radius: 4px;
   border-bottom-right-radius: 4px;
}

.loginform input:focus, .sffocus, .sffocus {
	background-color: #ffc;
}
/*- /Форма входа */

p.LoginContentCenter
   {
     text-align: center;
   }

p.LoginContentLeft
   {
     text-align: left;
   }

/*- /Бокс вход/админ */

/*- Бокс мои загрузки */
#boxDownloads
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса мои загрузки */
#boxDownloads h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса мои загрузки */

/*- Содержимое бокса мои загрузки */
#boxDownloadsContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: left;
  }

#boxDownloadsContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

/*- /Содержимое бокса мои загрузки */

/*- /Бокс мои загрузки */

/*- Бокс рассылка */
#boxNewsletter
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса рассылка */
#boxNewsletter h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса рассылка */

/*- Содержимое бокса рассылка */
#boxNewsletterContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
  }

#boxNewsletterContent p 
   {
     margin: 0 0 0 0;
     text-align: left;
  }

/*- /Содержимое бокса рассылка */

/*- Форма рассылка */
.newsletterform input {
	width: 70%;
	font-size: 1em;
	border: 1px solid;
	border-color: #666 #ccc #ccc #666;
	padding: 2px;
   margin-top: 0.2em;
   margin-bottom: 0.4em;
   border-top-left-radius: 4px;
   border-top-right-radius: 4px;
   border-bottom-left-radius: 4px;
   border-bottom-right-radius: 4px;
}

.newsletterform input:focus, .sffocus, .sffocus {
	background-color: #ffc;
}
/*- /Форма рассылка */

/*- /Бокс рассылка */

/*- Бокс лучшие товары */
#boxBestsellers
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса лучшие товары */
#boxBestsellers h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса лучшие товары */

/*- Содержимое бокса лучшие товары */
#boxBestsellersContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
  }

#boxBestsellersContent p 
   {
     margin: 0 0 0 0;
     text-align: left;
  }

/*- /Содержимое бокса лучшие товары */

#boxBestsellersContent p.BestsellersContentRight
   {
     text-align: right;
     padding-right: 0.2em;
     padding-bottom: 0.3em;
   }

#boxBestsellersContent  span 
   {
     font-weight: bold;
   }
   
/*- /Бокс лучшие товары */

/*- Бокс информация о группе */
#boxGroupInfo
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса информация о группе */
#boxGroupInfo h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса информация о группе */

/*- Содержимое бокса информация о группе */
#boxGroupInfoContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: center;
  }

#boxGroupInfoContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

#boxGroupInfoContent  span 
   {
     font-weight: bold;
   }

/*- /Содержимое бокса информация о группе */

/*- /Бокс информация о группе */

/*- Бокс валюты */
#boxCurrencies
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса валюты */
#boxCurrencies h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса валюты */

/*- Содержимое бокса валюты */
#boxCurrenciesContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: center;
  }

#boxCurrenciesContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

/*- /Содержимое бокса валюты */

/*- Форма выбора валюты */
#boxCurrenciesContent select {
	width: 70%;
	font-size: 1em;
	border: 1px solid;
	border-color: #666 #ccc #ccc #666;
	padding: 2px;
   margin-top: 0.2em;
   margin-bottom: 0.4em;
}
/*- /Форма выбора валюты */

/*- /Бокс валюты */

/*- Бокс языки */
#boxLanguages
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса языки */
#boxLanguages h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса языки */

/*- Содержимое бокса языки */
#boxLanguagesContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: center;
  }

#boxLanguagesContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

/*- /Содержимое бокса языки */

/*- /Бокс языки */

/*- Бокс производители */
#boxManufacturers
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса производители */
#boxManufacturers h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса производители */

/*- Содержимое бокса производители */
#boxManufacturersContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: center;
  }

#boxManufacturersContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

/*- /Содержимое бокса производители */

/*- Форма выбора производителя */
#boxManufacturersContent select {
	width: 70%;
	font-size: 1em;
	border: 1px solid;
	border-color: #666 #ccc #ccc #666;
	padding: 2px;
   margin-top: 0.2em;
   margin-bottom: 0.4em;
}
/*- /Форма выбора производителя */

/*- /Бокс производители */

/*- Бокс информация о производителе */
#boxManufacturersInfo
   {
		margin: 0 .5em .5em .5em;
		padding: 0;
   }

/*- Заголовок бокса информация о производителе */
#boxManufacturersInfo h5 
   {
		color: #dd2c00;
		font-weight: bold;
		font-size: 12pt;
		margin: 0;
		padding: 7px 0 7px 10px;
		background-color: #f4f4f4;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -135px;
		background-repeat: repeat-x; 
		border-top: 1px solid #c0c1c2;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		vertical-align: middle;
  }
/*- /Заголовок бокса информация о производителе */

/*- Содержимое бокса информация о производителе */
#boxManufacturersInfoContent 
   {
		margin: 0;
		padding: .5em;
		background-color: #fff;
		background-image: url(../img/vamcart/bg.png);
		background-position: 0 -602px;
		background-repeat: repeat-x; 
		border-top: 0px;
		border-left: 1px solid #c0c1c2;
		border-right: 1px solid #c0c1c2;
		border-bottom: 1px solid #c0c1c2;
		border-bottom-left-radius: 8px;
		border-bottom-right-radius: 8px;
     text-align: center;
  }

#boxManufacturersInfoContent p 
   {
     margin: 0 0 0 0;
     padding-bottom: 0.2em;
  }

/*- /Содержимое бокса информация о производителе */

/*- /Бокс информация о производителе */

/*- /Боксы */

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
		
		font: 12pt arial,sans-serif;
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
		font: 12pt arial,sans-serif;
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
		margin-bottom: 5px;
	}
	
.shipping-method,
.payment-method 
	{
		border: 1px solid transparent;
		padding: 1em;
	}

#slide-featured 
	{
		width:80%;
		margin:0 auto;
	}

#slide-featured li
	{
		list-style: none;
		padding: 0;
		margin: 0;
	}

#slide-featured ul
	{
		list-style: none;
		padding: 0;
		margin: 0;
	}

#slide-new 
	{
		width:90%;
		margin:0 auto;
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
