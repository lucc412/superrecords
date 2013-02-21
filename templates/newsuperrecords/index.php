<?php

// No direct access.
defined('_JEXEC') or die;
JHtml::_('behavior.framework', true);

// get params
$color			= $this->params->get('templatecolor');
$logo			= $this->params->get('logo');
$navposition	= $this->params->get('navposition');
$app			= JFactory::getApplication();
$doc			= JFactory::getDocument();
$templateparams	= $app->getTemplate(true)->params;

$root_path = "http://".$_SERVER['SERVER_NAME']; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<jdoc:include type="head" />

		<!-- Begin metadata -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" /> 
		<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" /> 

		<!-- Site Specific Data -->
		<title>Super Records | SMSF Administration Services</title>
		<meta name="DC.title" lang="en" content="Super Records | SMSF Administration Services" /> 
		<meta name="description" content="Providing SMSF Administration Services to Professional Firms" />
		<meta name="DC.Description" lang="en" content="Providing SMSF Administration Services to Professional Firms" /> 
		<meta name="keywords" content="keyword, keyword" />

		<meta name="DC.subject" lang="en" content="Super Records" /> 
		<meta name="DC.Rights" content="Copyright (c) 2013 - Super Records | Web Design by Quikclicks www.quikclicks.com.au" />
		<meta name="DC.date" scheme="DCTERMS.W3CDTF" content="2012-08-01" /> 
		<meta name="date_modified" scheme="ISO8601" content="2012-08-10" />

		<!-- metadata cont'd-->
		<meta name="DC.creator" content="Quikclicks Web Design Sydney - http://www.quikclicks.com.au" /> 
		<meta name="DC.publisher" content="Quikclicks Web Design Sydney - http://www.quikclicks.com.au" /> 
		<meta name="DC.type" scheme="DCTERMS.DCMIType" content="Text" /> 
		<meta name="DC.format" scheme="DCTERMS.IMT" content="text/html" />
		<meta name="DC.language" scheme="DCTERMS.RFC1766" content="en-AU" /> 
		<meta name="robots" content="INDEX,FOLLOW" />
		<meta name="revisit-after" content="1 month"/>

		<!-- Favicon-->
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

		<!-- Main CSS-->
		
		<link rel="stylesheet" href="<?php echo $root_path ?>/templates/system/css/system.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/css/accordion.css" type="text/css"  />
		<link rel="stylesheet" href="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/css/stylesheet.css" type="text/css" />

		<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="ie.css" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/css/liquid-slider-1.1.css" type="text/css" media="screen" />

		<!-- JS -->
		<script type="text/javascript" src="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/js/util-functions.js"></script>
		<script type="text/javascript" src="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/js/clear-default-text.js"></script>
		<script type="text/javascript" src="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/js/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/js/jquery-ui-1.8.20.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/js/jquery.liquid-slider-1.1.min.js"></script>

		<!-- This of course is required. The full version (not .min) is also included in the js directory -->

		<script>
		$(function(){
			/* Here is the slider using default settings */
			$('#slider-id').liquidSlider({
				autoHeightMin:200,
				panelTitleSelector: "span.title",
				mobileNavigation:false,
				slideEaseDuration: 1000,
				crossLinks:true,
				autoSlideControls: true,
				autoSlideInterval: 7000,
				autoSlidePauseOnHover:false,
				autoSlideStopWhenClicked:false
				});
			/* If you want to adjust the settings, you set an option
			as follows:
			
			$('#slider-id').liquidSlider({
				autoSlide:false,
				autoHeight:false
				});
			
			Find more options at http://liquidslider.kevinbatdorf.com/
			*/
			
			/* If you need to access the internal property or methods, use this method.
			
			var sliderObject = $.data( $('#slider-id')[0], 'liquidSlider');
			console.log(sliderObject);
			
			*/
			});
		</script> 

		<!-- Google Webfont -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
	</head>

	<body>
		<!--header Start-->
		<div class="header">
			<div class="container">
				<div class="branding">
					<a href="index.php">
						<img src="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/images/header-logo.png"  alt="<?php echo JText::_('Super Records Logo'); ?>" />
					</a>
				</div> <!--branding-->
				<div class="user">
					<li class="contact"><a href="#">Contact Us</a></li>
					<li class="login"><a href="controller/login.php">Practice Login</a></li>
				</div> <!--user-->
				<div class="phone"><img src="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/images/header-phone.png" /></div> <!--phone-->
			</div> <!--container-->
		</div>
		<!--header End-->

		<!--header Menu Start-->
		<div class="nav">
			<div class="container">
				<!-- Top Menu module -->
				<jdoc:include type="modules" name="p1" />	
			</div>
		</div>
		<!--header Menu End-->

		<!-- home slider module Start -->
		<?php if($this->countModules('home-banner') > 0):?>
			<jdoc:include type="modules" name="home-banner" />
		<?php endif; ?>
		<!-- home slider module End -->

		
		<!-- TOP Banner Module Start -->
		<jdoc:include type="modules" name="banner-middle" />	
		<!-- TOP Banner Module End -->
		
		<!-- MIDDLE CONTENT START -->
		<div class="container">
		<?php $isHomePage = $this->countModules('home-banner'); ?>
		
		<?php if($isHomePage > 0): ?>	
			<!--Home page 4 Blocks Start -->
			<div class="content">
				<jdoc:include type="modules" name="about-home" />	
				<jdoc:include type="modules" name="Benefits-home" />	
				<jdoc:include type="modules" name="SMSF-Packages-home" />	
				<jdoc:include type="modules" name="contact-us-home" />	
				<div class="clear"></div> <!--clear float-->     
			</div>
			<!--Home page 4 Blocks End -->
			
		<?php else: ?>	
			
			<!--Inner Pages Start -->
			<div class="contentgeneral">
				<!--contenttext Start Other Page -->
				<jdoc:include type="component" />
    			<!--contenttext End Other Page -->

				<div class="column-right">
				<?php $rightMenu = ($this->countModules('p2-righ') or $this->countModules('p3-right') or $this->countModules('p4-right') or $this->countModules('p5-right')); ?>
				 	<!--rightmenu start--> 
           			<div class="rightmenu">
					   <jdoc:include type="modules" name="p2-right" />
					   <jdoc:include type="modules" name="p3-right" />
					   <jdoc:include type="modules" name="p4-right" />
					   <jdoc:include type="modules" name="p5-right" />
					</div> <!--rightmenu end--> 
            
					<div class="ac-container">
						<jdoc:include type="modules" name="SMSF-packages-right" />
						<jdoc:include type="modules" name="benifits-right" />
					</div> <!--ac-container-->                  
        	
					<!-- contact form for Other page start-->
		        	<div class="contactform">
						<jdoc:include type="modules" name="contact-us-other-page" />
					</div>
					<!--contac form for Other page end-->
				</div> <!--column-right-->
			</div>
			<!--Inner Pages End -->
		<?php endif; ?>
			
			<!-- Clear Div Start -->
			<div class="clear"></div>
			<!-- Clear Div End -->
			
			<!--sponsors Start-->
			<div class="sponsors">
				<span><img src="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/images/logos/cpa.jpg" /></span>
				<span><img src="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/images/logos/bgl.jpg" /></span>
				<span><img src="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/images/logos/banklink.jpg" /></span>
				<span><img src="<?php echo $root_path ?>/templates/<?php echo $this->template; ?>/images/logos/ssa.jpg" /></span>
			</div>
			<!--sponsors End-->
		</div>
		<!-- MIDDLE CONTENT END  -->

		<div class="bottom-menu">
			<div class="container">
				<div class="column-1">
					<h1>About Us</h1>
					<!-- Bottom Menu module -->
					<jdoc:include type="modules" name="p2" />	
				</div> <!--column-->

				<div class="column-2">
					<h1>Case Studies</h1>
					<!-- Bottom Menu module -->
					<jdoc:include type="modules" name="p3" />	
				</div> <!--bottom-menu-column-->

				<div class="column-3">
					<h1>Services</h1>
					<!-- Bottom Menu module -->
					<jdoc:include type="modules" name="p4" />	
				</div> <!--bottom-menu-column-->

				<div class="column-4">
					<h1>
						<!-- Bottom Menu module -->
						<jdoc:include type="modules" name="p5" />	
					</h1>
				</div> <!--bottom-menu-column-->

				<div class="column-5">
					<h1>Contact Us</h1>
					<p>Level 32, 1 Market Street,</p>
					<p>Sydney NSW 2000</p>
					<p>Phone: 1800 278 797</p>
				</div> <!--bottom-menu-column-->
			</div>
		</div>

		<div class="clear"></div> <!--clear float-->        

		<div class="footer">
			<div class="container">
				<ul>
					<li><a href="#">Privacy Policy</a></li>
					<li><a href="#">Terms & Conditions</a></li>
				</ul>
				<span>Copyright Super Records © 2013 | <a title="Website Design Sydney" target="_blank" href="http://www.quikclicks.com.au">Web Design Sydney</a> by <a title="Web Design Company" target="_blank" href="http://www.quikclicks.com.au">Quikclicks</a></span>
			</div>
		</div> 
	</body>
</html>

