
function twitter_search(query, limit, callback) { 
    
    var twitterJSON = document.createElement('script'); 
    
    twitterJSON.type = 'text/javascript'; 
    twitterJSON.src  = 'http://search.twitter.com/search.json?callback=' + callback + '&q=' + encodeURIComponent(query) + '&rpp=' + limit + '&lang=en';
    
    document.getElementsByTagName('head')[0].appendChild(twitterJSON);
    
    return false;
}

function refresh_timestamps() {
	$('.tmsp').humane_dates();
}
    
function init_tweets(obj) {
    
    var user, bgcolor, tweet, postedAt, icon, userURL;  
    var appendhtml = '';
    
    for (i=0; i<obj.results.length; i++) {    
        
        icon     = obj.results[i].profile_image_url;
        user     = obj.results[i].from_user;
        loc      = obj.results[i].source;
        userURL  = 'http://twitter.com/' + user;
        tweet    = obj.results[i].text;
        tmsp     = obj.results[i].created_at;
        postedAt = humane_date(obj.results[i].created_at);

        loc = loc.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
        
        appendhtml += '<div class="tweet clearfix">';

		if (icon) {
			appendhtml += '<div class="tweet-pic clearfix"><a href="' + userURL + '" target="_blank"><img src="' + icon + '" width="48" height="48" alt="" /></a></div>';
		}
        
        appendhtml += '<div class="tweet-msg clearfix">';
        appendhtml += '     <p>' + tweet.replace(/dang/gi, '<strong>DANG</strong>') + '</p>';
        appendhtml += '     <span><a href="' + userURL + '" target="_blank">' + user + '</a> - </span> <span class="tmsp" title="' + tmsp + '">' + postedAt + '</span>';

		if (loc) {
			//appendhtml += ' <span>via ' + loc + '</span>';
		}

		appendhtml += ' </div>';
		appendhtml += '</div>';
    }   
    
    $('#tweets').append(appendhtml);
    
    $('#tweets').cycle({
        fx:     'blindX',
        speed:   400,
        timeout: 9000,
        pause:   1,
        easing: 'easeInOutQuad',
        next:   '#twitter-next',
        prev:   '#twitter-prev'
    });
}



/*
 * Javascript Humane Dates
 * Copyright (c) 2008 Dean Landolt (deanlandolt.com)
 * Re-write by Zach Leatherman (zachleat.com)
 * 
 * Adopted from the John Resig's pretty.js
 * at http://ejohn.org/blog/javascript-pretty-date
 * and henrah's proposed modification 
 * at http://ejohn.org/blog/javascript-pretty-date/#comment-297458
 * 
 * Licensed under the MIT license.
 */

 /**
  * @param {String or Date} date_str either an ISO8601 date string or a Date object.
  *          Note: ISO8601 dates are always formatted using UTC/GMT timezone.
  *          Example: 2009-06-03T20:06:44Z
  */
function humane_date(date_str){
 var time_formats = [
  [1, 'a second'],
  [60, 'seconds', 1],
  [90, 'a minute'], // 60*1.5
  [3600, 'minutes', 60], // 60*60, 60
  [5400, 'an hour'], // 60*60*1.5
  [86400, 'hours', 3600], // 60*60*24, 60*60
  [129600, 'a day'], // 60*60*24*1.5
  [604800, 'days', 86400], // 60*60*24*7, 60*60*24
  [907200, 'a week'], // 60*60*24*7*1.5
  [2628000, 'weeks', 604800], // 60*60*24*(365/12), 60*60*24*7
  [3942000, 'a month'], // 60*60*24*(365/12)*1.5
  [31536000, 'months', 2628000], // 60*60*24*365, 60*60*24*(365/12)
  [47304000, 'a year'], // 60*60*24*365*1.5
  [3153600000, 'years', 31536000], // 60*60*24*365*100, 60*60*24*365
  [4730400000, 'a century'], // 60*60*24*365*100*1.5
 ];

 //var time = ('' + date_str).replace(/-/g,"/").replace(/[TZ]/g," "),
 var time = date_str,
  dt = new Date,
  
  //seconds = (date_str instanceof Date ? (dt - date_str)
  //            : (dt - new Date(time) + (dt.getTimezoneOffset() * 60000))) / 1000,
  //seconds = (date_str instanceof Date ? (dt - date_str)
  //        : (dt - new Date(time) + (60 * 60000))) / 1000,
  seconds = (date_str instanceof Date ? (dt - date_str)
          : (dt - new Date(time) + (dt.getTimezoneOffset() * 60))) / 1000,
  
  token = ' ago',
  i = 0,
  format;

 if (seconds < 0) {
  seconds = Math.abs(seconds);
  //token = ' from now';
 }

 while (format = time_formats[i++]) {
  if (seconds < format[0]) {
   if (format.length == 2) {
    return format[1] + token
   } else {
    return Math.round(seconds / format[2]) + ' ' + format[1] + token;
   }
  }
 }

 // overflow for centuries
 if(seconds > 4730400000)
  return Math.round(seconds / 4730400000) + ' centuries' + token;

 return date_str;
};

if(typeof jQuery != 'undefined') {
 jQuery.fn.humane_dates = function(){
  return this.each(function(){
   var date = humane_date(this.title);
   if(date && jQuery(this).text() != date) // don't modify the dom if we don't have to
    jQuery(this).text(date);
  });
 };
}