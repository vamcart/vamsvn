<?php 
header('Content-Type: text/css');

include('vamshop.css.php');
?>


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
