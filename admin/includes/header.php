<?php 
error_reporting(0);
ob_start();
session_start();
//2 hours
$inactive = 7200;
if(isset($_SESSION['timeout']) ) {
$session_life = time() - $_SESSION['timeout'];
if($session_life > $inactive)
{ 
session_destroy(); 
// header("Location:index.php");
}
}
$_SESSION['timeout'] = time();


?><!-- Main CSS-->
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
	<link rel="stylesheet" type="text/css" href="css/tooltip.css"/>
	<!-- Accordion CSS-->
	<link rel="stylesheet" type="text/css" href="css/accordion.css"/>
	<!-- Liquid Slider CSS-->
	<link rel="stylesheet" type="text/css" media="screen" href="css/liquid-slider-1.1.css">
	
	<!-- JS -->
	<script type="text/javascript" src="js/modernizr.custom.29473.js"></script>
	<script type="text/javascript" src="js/util-functions.js"></script>
	<script type="text/javascript" src="js/clear-default-text.js"></script>
	
	<!-- Google Webfont -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>


<script type="text/javascript">
   /************************************************************************************************************ 
   (C) www.dhtmlgoodies.com, October 2005 
    
   This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.    
    
   Terms of use: 
   You are free to use this script as long as the copyright message is kept intact. However, you may not 
   redistribute, sell or repost it without our permission. 
    
   Thank you! 
    
   www.dhtmlgoodies.com 
   Alf Magne Kalleland 
    
   ************************************************************************************************************/    
        
   var dhtmlgoodies_menuObj;   // Reference to the menu div 
   var currentZIndex = 1000; 
   var liIndex = 0; 
   var visibleMenus = new Array(); 
   var activeMenuItem = false; 
   var timeBeforeAutoHide = 1200; // Microseconds from mouse leaves menu to auto hide. 
   var dhtmlgoodies_menu_arrow = 'images/arrow.gif'; 
    
   var MSIE = navigator.userAgent.indexOf('MSIE')>=0?true:false; 
   var isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox')>=0?true:false; 
   var navigatorVersion = navigator.appVersion.replace(/.*?MSIE ([0-9]\.[0-9]).*/g,'$1')/1; 
   var menuBlockArray = new Array(); 
   var menuParentOffsetLeft = false;    


    // {{{ getStyle() 
   /** 
   * Return specific style attribute for an element 
   * 
   * @param Object el = Reference to HTML element 
   * @param String property = Css property 
   * @private 
   */        
   function getStyle(el,property) 
   {        

      if (document.defaultView && document.defaultView.getComputedStyle) { 

         var retVal = null;              
         var comp = document.defaultView.getComputedStyle(el, ''); 
         if (comp){ 
            retVal = comp[property]; 
              
            if(!retVal){ 
               var comp = document.defaultView.getComputedStyle(el, null); 
               retVal = comp.getPropertyCSSValue(property); 
            }          
         }    

         if(retVal==null)retVal=''; 
          
         return el.style[property] || retVal; 
      } 
      if (document.documentElement.currentStyle && MSIE){    
         var value = el.currentStyle ? el.currentStyle[property] : null; 
         return ( el.style[property] || value ); 
                                              
      } 
      return el.style[property];              
   } 
      
   function getTopPos(inputObj) 
   { 
   	var origInputObj = inputObj;
 
     var returnValue = inputObj.offsetTop; 
     if(inputObj.tagName=='LI' && inputObj.parentNode.className=='menuBlock1'){    
        var aTag = inputObj.getElementsByTagName('A')[0]; 
        if(aTag)returnValue += aTag.parentNode.offsetHeight; 
     } 
     var topOfMenuReached = false; 
     while((inputObj = inputObj.offsetParent) != null){ 
        if(inputObj.parentNode.id=='dhtmlgoodies_menu')topOfMenuReached=true; 
        if(topOfMenuReached && !inputObj.className.match(/menuBlock/gi) || (!MSIE && origInputObj.parentNode.className=='menuBlock1')){ 
           var style = getStyle(inputObj,'position'); 
           if(style=='absolute' || style=='relative'){                
              return returnValue;            
           } 
        } 
          
        returnValue += inputObj.offsetTop;          
     } 

     return returnValue; 
   } 
    
   function getLeftPos(inputObj) 
   { 
     var returnValue = inputObj.offsetLeft; 
      
     var topOfMenuReached = false; 
     while((inputObj = inputObj.offsetParent) != null){ 
       if(inputObj.parentNode.id=='dhtmlgoodies_menu')topOfMenuReached=true; 
        if(topOfMenuReached && !inputObj.className.match(/menuBlock/gi)){ 
           var style = getStyle(inputObj,'position'); 
           if(style=='absolute' || style=='relative')return returnValue; 
        } 
      
        returnValue += inputObj.offsetLeft; 
     } 
     return returnValue; 
   } 


    
   function showHideSub() 
   { 

      var attr = this.parentNode.getAttribute('currentDepth'); 
      if(navigator.userAgent.indexOf('Opera')>=0){ 
         attr = this.parentNode.currentDepth; 
      } 
        
      this.className = 'currentDepth' + attr + 'over'; 
        
      if(activeMenuItem && activeMenuItem!=this){ 
         activeMenuItem.className=activeMenuItem.className.replace(/over/,''); 
      } 
      activeMenuItem = this; 
    
      var numericIdThis = this.id.replace(/[^0-9]/g,''); 
      var exceptionArray = new Array(); 
      // Showing sub item of this LI 
      var sub = document.getElementById('subOf' + numericIdThis); 
      if(sub){ 
         visibleMenus.push(sub); 
         sub.style.display=''; 
         sub.parentNode.className = sub.parentNode.className + 'over'; 
         exceptionArray[sub.id] = true; 
      }    
        
      // Showing parent items of this one 
        
      var parent = this.parentNode; 
      while(parent && parent.id && parent.tagName=='UL'){ 
         visibleMenus.push(parent); 
         exceptionArray[parent.id] = true; 
         parent.style.display=''; 
          
         var li = document.getElementById('dhtmlgoodies_listItem' + parent.id.replace(/[^0-9]/g,'')); 
         if(li.className.indexOf('over')<0)li.className = li.className + 'over'; 
         parent = li.parentNode; 
          
      } 

          
      hideMenuItems(exceptionArray); 



   } 

   function hideMenuItems(exceptionArray) 
   { 
      /* 
      Hiding visible menu items 
      */ 
      var newVisibleMenuArray = new Array(); 
      for(var no=0;no<visibleMenus.length;no++){ 
         if(visibleMenus[no].className!='menuBlock1' && visibleMenus[no].id){ 
            if(!exceptionArray[visibleMenus[no].id]){ 
               var el = visibleMenus[no].getElementsByTagName('A')[0]; 
               visibleMenus[no].style.display = 'none'; 
               var li = document.getElementById('dhtmlgoodies_listItem' + visibleMenus[no].id.replace(/[^0-9]/g,'')); 
               if(li.className.indexOf('over')>0)li.className = li.className.replace(/over/,''); 
            }else{              
               newVisibleMenuArray.push(visibleMenus[no]); 
            } 
         } 
      }        
      visibleMenus = newVisibleMenuArray;        
   } 
    
    
    
   var menuActive = true; 
   var hideTimer = 0; 
   function mouseOverMenu() 
   { 
      menuActive = true;        
   } 
    
   function mouseOutMenu() 
   { 
      menuActive = false; 
      timerAutoHide();    
   } 
    
   function timerAutoHide() 
   { 
      if(menuActive){ 
         hideTimer = 0; 
         return; 
      } 
        
      if(hideTimer<timeBeforeAutoHide){ 
         hideTimer+=100; 
         setTimeout('timerAutoHide()',99); 
      }else{ 
         hideTimer = 0; 
         autohideMenuItems();    
      } 
   } 
    
   function autohideMenuItems() 
   { 
      if(!menuActive){ 
         hideMenuItems(new Array());    
         if(activeMenuItem)activeMenuItem.className=activeMenuItem.className.replace(/over/,'');        
      } 
   } 
    
    
   function initSubMenus(inputObj,initOffsetLeft,currentDepth) 
   {    
      var subUl = inputObj.getElementsByTagName('UL'); 
      if(subUl.length>0){ 
         var ul = subUl[0]; 
          
         ul.id = 'subOf' + inputObj.id.replace(/[^0-9]/g,''); 
         ul.setAttribute('currentDepth' ,currentDepth); 
         ul.currentDepth = currentDepth; 
         ul.className='menuBlock' + currentDepth; 
         ul.onmouseover = mouseOverMenu; 
         ul.onmouseout = mouseOutMenu; 
         currentZIndex+=1; 
         ul.style.zIndex = currentZIndex; 
         menuBlockArray.push(ul); 
         ul = dhtmlgoodies_menuObj.appendChild(ul); 
         var topPos = getTopPos(inputObj); 
         var leftPos = getLeftPos(inputObj)/1 + initOffsetLeft/1;          
         
         ul.style.position = 'absolute'; 
         ul.style.left = leftPos + 'px'; 
         ul.style.top = topPos + 'px'; 
         var li = ul.getElementsByTagName('LI')[0]; 
         while(li){ 
            if(li.tagName=='LI'){    
               li.className='currentDepth' + currentDepth;                
               li.id = 'dhtmlgoodies_listItem' + liIndex; 
               liIndex++;              
               var uls = li.getElementsByTagName('UL'); 
               li.onmouseover = showHideSub; 

               if(uls.length>0){ 
                  var offsetToFunction = li.getElementsByTagName('A')[0].offsetWidth+2; 
                  if(navigatorVersion<6 && MSIE)offsetToFunction+=15;   // MSIE 5.x fix 
                  initSubMenus(li,offsetToFunction,(currentDepth+1)); 
               }    
               if(MSIE){ 
                  var a = li.getElementsByTagName('A')[0]; 
                  a.style.width=li.offsetWidth+'px'; 
                  a.style.display='block'; 
               }                
            } 
            li = li.nextSibling; 
         } 
         ul.style.display = 'none';    
         if(!document.all){ 
            //dhtmlgoodies_menuObj.appendChild(ul); 
         } 
      }    
   } 


   function resizeMenu() 
   { 
      var offsetParent = getLeftPos(dhtmlgoodies_menuObj); 
        
      for(var no=0;no<menuBlockArray.length;no++){ 
         var leftPos = menuBlockArray[no].style.left.replace('px','')/1; 
         menuBlockArray[no].style.left = leftPos + offsetParent - menuParentOffsetLeft + 'px'; 
      } 
      menuParentOffsetLeft = offsetParent; 
   } 
    
function confirmExit()
  {
    var flag=window.confirm("You are closing the window. do you want to continue. Click 'Ok' to close or click 'Cancel' to stay back");
    return flag;
  }

   /* 
   Initializing menu 
   */ 
   function initDhtmlGoodiesMenu() 
   { 
      dhtmlgoodies_menuObj = document.getElementById('dhtmlgoodies_menu'); 
        
        
      var aTags = dhtmlgoodies_menuObj.getElementsByTagName('A'); 
      for(var no=0;no<aTags.length;no++){          

         var subUl = aTags[no].parentNode.getElementsByTagName('UL'); 
         if(subUl.length>0 && aTags[no].parentNode.parentNode.parentNode.id != 'dhtmlgoodies_menu'){ 
            var img = document.createElement('IMG'); 
            img.src = dhtmlgoodies_menu_arrow; 
            aTags[no].appendChild(img);              

         } 

      } 
              
      var mainMenu = dhtmlgoodies_menuObj.getElementsByTagName('UL')[0]; 
      mainMenu.className='menuBlock1'; 
      mainMenu.style.zIndex = currentZIndex; 
      mainMenu.setAttribute('currentDepth' ,1); 
      mainMenu.currentDepth = '1'; 
      mainMenu.onmouseover = mouseOverMenu; 
      mainMenu.onmouseout = mouseOutMenu;        

      var mainMenuItemsArray = new Array(); 
      var mainMenuItem = mainMenu.getElementsByTagName('LI')[0]; 
      mainMenu.style.height = mainMenuItem.offsetHeight + 2 + 'px'; 
      while(mainMenuItem){ 
          
         mainMenuItem.className='currentDepth1'; 
         mainMenuItem.id = 'dhtmlgoodies_listItem' + liIndex; 
         mainMenuItem.onmouseover = showHideSub; 
         liIndex++;              
         if(mainMenuItem.tagName=='LI'){ 
            mainMenuItem.style.cssText = 'float:left;';    
            mainMenuItem.style.styleFloat = 'left'; 
            mainMenuItemsArray[mainMenuItemsArray.length] = mainMenuItem; 
            initSubMenus(mainMenuItem,0,2); 
         }          
          
         mainMenuItem = mainMenuItem.nextSibling; 
          
      } 

      for(var no=0;no<mainMenuItemsArray.length;no++){ 
         initSubMenus(mainMenuItemsArray[no],0,2);          
      } 
        
      menuParentOffsetLeft = getLeftPos(dhtmlgoodies_menuObj);    
      window.onresize = resizeMenu;    
      dhtmlgoodies_menuObj.style.visibility = 'visible';    
	  if(window.location.href.indexOf('wrk_worksheet.php')> 0)
                onLoad();
	  if(window.location.href.indexOf('wrk_worksheet_report.php')> 0)
                //onLoad();
//	tabpage=<?php $_GET['page'];?>;
	//alert(tabpage);
//	if(tabpage!="")
	//switchLinks('page'+tabpage);
	var tabpage = get_url_param('page');
    //if(tabpage!="")
	//switchLinks('page'+tabpage);
   } 
   
	window.onload = initDhtmlGoodiesMenu;
	<?php  if($_GET['a']=="edit" && $_GET['cli_code']=="" && ($_POST['action']!="Update" || $_POST['action']!="Save")) {?>
	//window.onbeforeunload = confirmExit;
	<?php } ?>

	 function get_url_param(name)
{ 
name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]"); 
var regexS = "[\\?&]"+name+"=([^&#]*)"; 
var regex = new RegExp( regexS ); 
var results = regex.exec( window.location.href ); 
if( results == null )    return ""; 
else return results[1];
}
</script><?

if($_SESSION['validUser']) {
	?></br>
	<div class="header">
		<div class="container">
			<div id="logo"  >
				<a href="index.php"><img  border="0" src="images/header-logo.png"></a>
			</div>

			<div class="user">        	
				<span style="color:#074263">Welcome,</span> <span><?echo strtoupper($_SESSION['user']);?></span>
			</div> <!--user-->

			<div class="phone">
				<a href="logout.php"><button class="logoutbtn" type="submit" value="Submit">Logout</button></a>
			</div> <!--phone-->
		</div>
	</div><?
							
	if (strpos($_SERVER['PHP_SELF'], 'index2' )) { 
		?><div id="dhtmlgoodies_menu" style="margin-left: 0px; *margin-top:-2px;*position:relative"><?
	} 
	else { 
		?><div id="dhtmlgoodies_menu" style="margin-left: 0px; *margin-top:-2px;"><?
	} 
	 
		?><div class="nav">
			<div class="container">
				<ul></ul>
				<ul><?

					// System Setup Menu (check access by passing $_SESSION of staff code and form code)
					$formcode_sys="2,75";
					$access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'],$formcode_sys);

					if($access_menu_level=="true") {   
						?><li class="dropdown"><a href="#">System Setup</a>      
							<ul class="sub"><?

								// Case Status Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],2,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="cas_casestatus.php?a=reset">Case Status</a></li><?
									}
								} 

								// Lead Closure Reason Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],75,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="lcr_leadclosurereason.php?a=reset">Lead Closure Reason</a></li><?
									}
								} 
						
							?></ul>
						</li><?
					}

					// Lead Menu (check access by passing $_SESSION of staff code and form code)
					$formcode_sys="78,79,80,81,82,83";
					$access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'],$formcode_sys);

					if($access_menu_level=="true") {   
						?><li class="dropdown"><a href="#">Lead</a>      
							<ul class="sub"><?

								// Manage Lead Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],78,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="lead.php">Manage Lead</a></li><?
									}
								} 

								// Lead Type Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],79,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="lead_type.php">Lead Type</a></li><?
									}
								} 

								// Lead Industry Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],80,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="lead_industry.php">Lead Industry</a></li><?
									}
								} 

								// Lead Status Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],81,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="lead_status.php">Lead Status</a></li><?
									}
								} 

								// Lead Stage Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],82,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="lead_stage.php">Lead Stage</a></li><?
									}
								} 

								// Lead Source Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],83,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="lead_source.php">Lead Source</a></li><?
									}
								} 
						
							?></ul>
						</li><?
					}

					// Referrer Partner Menu (check access by passing $_SESSION of staff code and form code)
					$formcode_sys="84,85,86,87";
					$access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'],$formcode_sys);

					if($access_menu_level=="true") {   
						?><li class="dropdown"><a href="#">Referrer Partner</a>      
							<ul class="sub"><?

								// Manage Referrer Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],84,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="rf_referrer.php">Manage Referrer</a></li><?
									}
								} 

								// Referrer Type Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],85,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="rf_type.php">Referrer Type</a></li><?
									}
								} 

								// Referrer Services Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],86,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="rf_services.php">Referrer Services</a></li><?
									}
								} 

								// Referrer Items List Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],87,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="rf_tasklist.php">Referrer Items List</a></li><?
									}
								} 
						
							?></ul>
						</li><?
					}

					// Practice Menu (check access by passing $_SESSION of staff code and form code)
					$formcode_sys="88,89,90,91";
					$access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'],$formcode_sys);

					if($access_menu_level=="true") {   
						?><li class="dropdown"><a href="#">Practice</a>      
							<ul class="sub"><?

								// Manage Practice Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],88,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="pr_practice.php">Manage Practice</a></li><?
									}
								} 

								// Practice Type Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],89,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="pr_type.php">Practice Type</a></li><?
									}
								} 

								// Practice Services Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],90,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="pr_services.php">Practice Services</a></li><?
									}
								} 

								// Practice Items List Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],91,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="pr_tasklist.php">Practice Items List</a></li><?
									}
								} 
						
							?></ul>
						</li><?
					}

					// Client Menu (check access by passing $_SESSION of staff code and form code)
					$formcode_sys="92,93,94";
					$access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'],$formcode_sys);

					if($access_menu_level=="true") {   
						?><li class="dropdown"><a href="#">Client</a>      
							<ul class="sub"><?

								// Manage Client Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],92,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="cli_client.php">Manage Client</a></li><?
									}
								}

								// Entity Type Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],93,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="cli_type.php?a=reset">Entity Type</a></li><?
									}
								} 

								// Client Steps Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],94,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="cli_stepsdone.php?a=reset">Client Steps</a></li><?
									}
								} 
						
							?></ul>
						</li><?
					}

					// Job Menu (check access by passing $_SESSION of staff code and form code)
					$formcode_sys="95,96,97,7,8,11,12,100";
					$access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'],$formcode_sys);

					if($access_menu_level=="true") {
						?><li class="dropdown"><a href="#">Job</a>      
							<ul class="sub"><?

								// Job List Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],95,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="job.php">Job List</a></li><?
									}
								}

								// Task Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],96,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="tsk_task.php?a=reset">Task</a></li><?
									}
								} 

								// Task Status Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],97,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="task_status.php?a=reset">Task Status</a></li><?
									}
								} 

								// Process Cycle Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],7,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="prc_processcycle.php?a=reset">Process Cycle</a></li><?
									}
								} 

								// Priority Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],8,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="pri_priority.php?a=reset">Priority</a></li><?
									}
								} 

								// Master Activity Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],11,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="mas_masteractivity.php?a=reset">Master Activity</a></li><?
									}
								} 

								// Sub Activity Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],12,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="sub_subactivity.php?a=reset">Sub Activity</a></li><?
									}
								} 

								// Job Status Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],100,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="job_status.php?a=reset">Job Status</a></li><?
									}
								} 
						
							?></ul>
						</li><?
					}

					// Administration Menu (check access by passing staff code and form code)
					$formcode_sys="50,4,43,76,57,99";
					$access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'],$formcode_sys);

					if($access_menu_level=="true") {
						?><li class="dropdown"><a href="#">Administration</a>      
							<ul class="sub"><?

								// Users Submenu (show only to administrator) 
								if($_SESSION['usertype'] == 'Administrator') {
									?><li><a href="stf_staff.php?a=reset">Users</a></li><?
								}

								// Employees Submenu (Check access by passing staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],50,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="con_empcontact.php?a=reset">Employees</a></li><?
									}
								} 

								// Task Status Submenu (Check access by passing staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],4,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="dsg_designation.php?a=reset">Designations</a></li><?
									}
								} 

								// Tickets Submenu (Check access by passing staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],43,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="cas_cases.php?a=reset">Tickets</a></li><?
									}
								} 

								// Cross Sales Opp Submenu (Check access by passing staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],76,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><!--<li><a href="cso_cross_sales_opportunity.php?a=reset">Cross Sales Opp</a></li>--><?
									}
								}

								// IP Address Submenu (Check access by passing staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],57,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="stf_ipaddress.php?a=reset">IP Address</a></li><?
									}
								} 

								// Default Landing URL Submenu 
								if($_SESSION['usertype'] == 'Administrator') {
									?><li><a href="landing_page.php">Default Landing URL</a></li><?
								}

								// Manage Emails Submenu
								if($_SESSION['usertype'] == 'Administrator') {
									?><li><a href="manage_emails.php">Manage Emails</a></li><?
								}
								else {
									$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],99,1);
									if(is_array($access_submenu_level)==1) {
										if(in_array("Y",$access_submenu_level)) { 
											?><li><a href="manage_emails.php">Manage Emails</a></li><?
										}
									}
								}
						
							?></ul>
						</li><?
					}

					// Reports Menu (check access by passing $_SESSION of staff code and form code)
					$formcode_sys="45,53,65,73,74,77";
					$access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'],$formcode_sys);

					if($access_menu_level=="true") {   
						?><!--<li class="dropdown"><a href="#">Reports</a>      
							<ul class="sub"><?

								// Worksheet Report Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],45,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="wrk_worksheet_report.php?a=reset">Worksheet Report</a></li><?
									}
								}

								// Sales Report Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],53,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="cli_client_report.php?a=reset">Sales Report</a></li><?
									}
								}

								// Custom Sales Report Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],65,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="sales_report.php?a=reset">Custom Sales Report</a></li><?
									}
								}

								// Custom Worksheet Report Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],73,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="custom_worksheet_report.php">Custom Worksheet Report</a></li><?
									}
								}

								// Custom Tickets Report Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],74,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="custom_cases_report.php">Custom Tickets Report</a></li><?
									}
								} 

								// Custom Cross Sales Opp Report Report Submenu (Check access by passing $_SESSION of staff code and form code)
								$access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'],77,1);
								if(is_array($access_submenu_level)==1) {
									if(in_array("Y",$access_submenu_level)) {   
										?><li><a href="sales_opportunity_report.php?a=reset">Custom Cross Sales Opp Report</a></li><?
									}
								} 
						
							?></ul>
						</li>--><?
					}

					if($_SESSION['usertype'] == "Administrator" || $_SESSION['staffcode'] == "69") {
						?><li><a href="../administrator/index.php">CMS Admin</a></li><?
                    }
				 ?></ul>
			</div> 
		</div> 
	 </div>

	 <!-- <div style="margin-top:-32px; color:yellow; font-family:Arial, Helvetica, sans-serif ; font-weight:bold; font-size:13px;   text-align:right;*margin-top:-42px;" >Logged in as <i><?php echo strtoupper($_SESSION['user']) ?></i> | <a href="logout.php" style="color:orange;text-decoration:underline;font-family:Arial, Helvetica, sans-serif ; font-weight:bold; font-size:13px;">Logout</a></div>-->
	 
		<div class="pagebackground">
			<div class="container"><?
}  
else
{
	header("Location:index.php");
}
?>