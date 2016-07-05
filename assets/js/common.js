
function load(url, callback) {
	var script  = document.createElement('script');
	script.type = "text/javascript";

	if (script.readyState) {  //IE
	    script.onreadystatechange = function() {
	        if (script.readyState == 'loaded' ||
	            script.readyState == 'complete') {
	            script.onreadystatechange = null;
	            callback();
	        }
	    };

	} else {  //Others

		script.onload = function(){
	        callback();
	    };
	}

	script.src = url;
	document.getElementsByTagName('head')[0].appendChild(script);
}

function fbsClick() {
	u=location.href;
	t=document.title;
	window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');
	return false;
}

function setPageTitle(page_title) {
	document.title = page_title;
}

function selectTab(tab) {
	$('body').attr('id', tab);
};

function initFeatureCycle() {
	if ($('#feature')) {
		$('#feature').cycle({
	        fx:     'scrollUp',
	        speed:   700,
	        timeout: 10000,
	        pause:   1,
	        next:   '#feature-next',
	        prev:   '#feature-prev'
	    });
	}

};

function initTweetControl() {
	$('#twitter').hover(
	    function() { $('#twitter-ctrl').fadeIn(); },
	    function() { $('#twitter-ctrl').fadeOut(); }
	);
}

function gridAnimationProjects(item) {
    item.fadeIn("fast", function () {
        if (fitems.length > 0) {
        	gridAnimationProjects(fitems.shift());
        }
    });
}

function gridAnimationSocial(item) {
    item.fadeIn("fast", function () {
        if (gitems.length > 0) {
        	gridAnimationSocial(gitems.shift());
        }
    });
}

function fadeInProjects() {
	// Calculate the height of the area to be filled in
	var cCnt = 5;
  var gH = $(".feature-item").height();
  var gM = 15;
  var nH = 60;

	fitems = new Array();
    $(".feature-item").each(function () {
				fitems.push($(this));
    });
    rCnt = Math.ceil((fitems.length) / cCnt);
    cH = ((gH * rCnt) + (rCnt * gM)) + nH;
    // $('#dev-preview').css({
    //     'height': cH + 'px'
    // });

    gridAnimationProjects(fitems.shift());
}

function fadeInSocial() {
	gitems = new Array();
    $(".soc-item").each(function () {
        gitems.push($(this));
    });

    gridAnimationSocial(gitems.shift());
}

function loadThirdPartyPosts(third_party_id) {
	showLoadingIndicator();

	$.ajax({
	    url: '/rpc/post_builder.php',
	    type: 'GET',
	    data: 'tpid=' + third_party_id,
	    dataType: 'html',
	    success: function(content) {
			$('#soc-intro').html(content);

			var $container = $('#soc-intro');
			showLoadingIndicator();

			$container.imagesLoaded( function(){
			  $container.masonry({
			    itemSelector : '.soc-item'
			  });

			  fadeInSocial();

			  setTimeout('hideLoadingIndicator()', 7000);
			});
	    },
	    error: function(XMLHttpRequest, textStatus, errorThrown) {
	    	alert(textStatus);
	    },
	    complete: function(XMLHttpRequest, textStatus) {

	    }
	});
}

/* navigation */
var current_anchor = null;
var scrolling      = true;

var showLoadingIndicator = function() {
	//var current_pos = $(window).scrollTop();
	//$('#loader2').css('top', current_pos);
	/*
	var d = document;
	 var rootElm = (d.documentelement && d.compatMode == 'CSS1Compat') ? d.documentelement : d.body;
	 var vpw = self.innerWidth ? self.innerWidth : rootElm.clientWidth; // viewport width
	 var vph = self.innerHeight ? self.innerHeight : rootElm.clientHeight; // viewport height
	 var myDiv = d.getelementById('loader2');
	 myDiv.style.position = 'absolute';
	 myDiv.style.left = ((vpw - 100) / 2) + 'px';
	 myDiv.style.top = (rootElm.scrollTop + (vph - 100)/2 ) + 'px';
	*/

	$('#loader2').show();
};

var hideLoadingIndicator = function() {
	$('#loader2').hide();
};

var checkAnchor = function() {

	var hash = document.location.hash.substr(1);
	var isIE_browser = isIE();

	if (hash) {

		// Check to see if we are navigating to an element on the same page or to a different page
		if (hash.charAt(0) != '/') {
			return;
		}

		// Keep it from constantly refreshing the content if it's the same page
		if (current_anchor != hash) {
			current_anchor = hash;

			//$('#progress').show();
			showLoadingIndicator();

			// IE will return distorted content if this is used
			if (!isIE_browser) {
				$('#content').fadeTo('fast', 0.2);
			}

			$.ajax({
			    url: '/rpc/content' + hash,
			    type: 'GET',
			    data: '',
			    cache: false,
			    dataType: 'html',
			    success: function(content) {

					$('#content').html(content);

					if (!isIE_browser) {
						$('#content').fadeTo('fast', 1);
					}

			        // Top navigation temporarily disables scrolling because there is no need to,
			        // 	it causes lag in this case
			        if (scrolling) {
			        	$.scrollTo(0, { duration: 1000 });
			        }
			        else {
			        	enableScrolling();
			        }
			    },
			    error: function(XMLHttpRequest, textStatus, errorThrown) {

			        alert(textStatus);
			    },
			    complete: function(XMLHttpRequest, textStatus) {

			        //$('#progress').hide();
			    	hideLoadingIndicator();
			    }
			});
		}
	}
};

var getPage = function(page_nm, tab, scrolling) {
	if (tab) {
		selectTab(tab);
	}
	if (scrolling == undefined) {
		scrolling = true;
	}
	if (scrolling == false) {
		disableScrolling();
	}

	// IE changes the href value to be a fully qualified url for some reason
	page_nm = page_nm.replace(/http:\/\/www.mikedang.com/i, '');
	page_nm = page_nm.replace(/http:\/\/stg.mikedang.com/i, '');
	page_nm = page_nm.replace(/http:\/\/mikedang.com/i, '');

	window.location = '#' + page_nm;
};

var disableScrolling = function() {
	scrolling = false;
};

var enableScrolling = function() {
	scrolling = true;
};

var isIE = function() {
	return /msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent);
};

var addAjaxRequestHandlers = function() {
	$('.ajax').each(function() {
		$(this).click(function() {
			getPage($(this).attr('href'), $(this).attr('rel'));
			// $('#fullnav .nav li').removeClass('active');
			$('#fullnav li').removeClass('active');
			$(this).parent().addClass('active');

			// If the hamburger menu is showing and it's not closed, click to hide it
			if ($(this).hasClass('nav-link') && !$('.navbar-toggle').filter(':first').hasClass('collapsed')) {
				$('.navbar-toggle').click();
			}
			return false;
		});
	});
};

//$('#logo').click(function() { getPage($(this).attr('href'), 'tab1', false); return false; });

$('.tab1 a').click(function() { getPage($(this).attr('href'), 'tab1', false); return false; });
$('.tab2 a').click(function() { getPage($(this).attr('href'), 'tab2', false); return false; });
$('.tab3 a').click(function() { getPage($(this).attr('href'), 'tab3', false); return false; });
$('.tab4 a').click(function() { getPage($(this).attr('href'), 'tab4', false); return false; });
//$('.tab5 a').click(function() { getPage($(this).attr('href'), 'tab5', false); return false; });

$(function() {
	addAjaxRequestHandlers();
	setInterval('checkAnchor()', 300);
});
