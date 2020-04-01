<?php
/* --------------------------------------------------------------
   $Id: header.php 1025 2007-05-23 12:09:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(header.php,v 1.19 2002/04/13); www.oscommerce.com 
   (c) 2003     nextcommerce (header.php,v 1.17 2003/08/24); www.nextcommerce.org
   (c) 2004     xt:Commerce (header.php,v 1.17 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  if ($messageStack->size > 0) {
    echo $messageStack->output();
  }

?>

<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'true') { ?>

		<div id="scoop" class="scoop">
			<div class="scoop-overlay-box"></div>
			<div class="scoop-container">  
				<header class="scoop-header">
					<div class="scoop-wrapper"> 
						<div class="scoop-left-header"> 
							<div class="scoop-logo"> 
								<a href="javascript(void);"><span class="logo-icon"><i class="ion-stats-bars"></i></span>
								<span class="logo-text">VamShop<span class="hide-in-smallsize"></span></span></a>
							</div> 
						</div>
						<div class="scoop-right-header"> 
							<div class="sidebar_toggle"><a href="javascript:void(0)"><i class="fa fa-bars"></i></a></div> 
							<div class="scoop-rl-header"> 
								<ul>
									<li class="icons">
										<a href="javascript:void(0)"><i class="fa fa-envelope" aria-hidden="true"></i>
											<span class="scoop-badge badge-success">2</span>
										</a>
									</li>
									<li class="icons">
										<a href="javascript:void(0)"><i class="fa fa-bell" aria-hidden="true"></i>
											<span class="scoop-badge badge-danger">8</span>
										</a>
									</li>
									<li class="icons">
										<a href="javascript:void(0)"><i class="fa fa-tasks" aria-hidden="true"></i>
											<span class="scoop-badge badge-warning">8</span>
										</a>
									</li> 
									<li class="icons hide-small-device">
										<a href="javascript:void(0)">
											<i class="fa fa-rss" aria-hidden="true"></i>
										</a>
									</li>
								</ul>
							</div>
							<div class="scoop-rr-header">
								<ul>
									<li class="icons">
										<a href="javascript:void(0)">
											<i class="fa fa-user" aria-hidden="true"></i>
										</a>
									</li>
									<li class="icons">
										<a href="javascript:void(0)">
											<i class="fa fa-sign-out" aria-hidden="true"></i>
										</a>
									</li> 
								</ul>
							</div>
						</div>
					</div>
				</header>
				<div class="scoop-main-container">
					<div class="scoop-wrapper">
						<nav class="scoop-navbar">  
							<div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
							<div class="scoop-inner-navbar">
								<ul class="scoop-item scoop-left-item">
									<li class="">
										<a href="javascript:void(0)">
											<span class="scoop-micon"><i class="icon-speedometer"></i></span>
											<span class="scoop-mtext">Home</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li class="">
										<a href="javascript:void(0)">
											<span class="scoop-micon"><i class="icon-speedometer"></i></span>
											<span class="scoop-mtext">About US</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li class="">
										<a href="javascript:void(0)">
											<span class="scoop-micon"><i class="icon-speedometer"></i></span>
											<span class="scoop-mtext">Service</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li class="">
										<a href="javascript:void(0)">
											<span class="scoop-micon"><i class="icon-speedometer"></i></span>
											<span class="scoop-mtext">Client</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>
									<li class="">
										<a href="javascript:void(0)">
											<span class="scoop-micon"><i class="icon-speedometer"></i></span>
											<span class="scoop-mtext">Contact</span>
											<span class="scoop-mcaret"></span>
										</a>
									</li>   
								</ul> 
							</div> 
						</nav> 
						<div class="scoop-content"> 
							<div class="scoop-inner-content">
								<div class="row">
									<div class="col-md-12">

<?php } ?>

