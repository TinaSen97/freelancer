/*
 * First Visit Popup jQuery Plugin version 1.2 (Revised)
 * Chris Cook - chris@chris-cook.co.uk
 */

(function ($) {
	'use strict';
  
	$.fn.firstVisitPopup = function (options) {
	  // Define default settings
	  var settings = $.extend(
		{
		  cookieName: 'default',          // provide a default cookie name if not specified
		  showAgainSelector: '.show-popup' // default selector for triggering the popup
		},
		options
	  );
  
	  var $body = $('body');
	  var $dialog = $(this);
	  var $blackout;
  
	  // Set cookie to expire in 1 year (31,536,000,000 ms)
	  var setCookie = function (name, value) {
		var date = new Date(),
		  expires = 'expires=';
		date.setTime(date.getTime() + 31536000000);
		expires += date.toGMTString();
		document.cookie = name + '=' + value + '; ' + expires + '; path=/';
		console.log('Cookie set:', name, value);
	  };
  
	  var getCookie = function (name) {
		var allCookies = document.cookie.split(';'),
		  cookieCounter = 0,
		  currentCookie = '';
		for (cookieCounter = 0; cookieCounter < allCookies.length; cookieCounter++) {
		  currentCookie = allCookies[cookieCounter];
		  while (currentCookie.charAt(0) === ' ') {
			currentCookie = currentCookie.substring(1);
		  }
		  if (currentCookie.indexOf(name + '=') === 0) {
			return currentCookie.substring(name.length + 1);
		  }
		}
		return false;
	  };
  
	  var showMessage = function () {
		console.log('Showing popup');
		$blackout.show();
		$dialog.show();
	  };
  
	  var hideMessage = function () {
		console.log('Hiding popup');
		$blackout.hide();
		$dialog.hide();
		setCookie('fvpp' + settings.cookieName, 'true');
	  };
  
	  // Append the blackout overlay to the body if it doesn't already exist
	  if ($('#fvpp-blackout').length === 0) {
		$body.append('<div id="fvpp-blackout" style="display:none;"></div>');
	  }
	  $blackout = $('#fvpp-blackout');
  
	  // Append the close button to the dialog if it doesn't already exist
	  if ($dialog.find('#fvpp-close').length === 0) {
		$dialog.append('<a id="fvpp-close" href="javascript:void(0);" style="cursor:pointer;">&#10006;</a>');
	  }
  
	  // If the cookie exists, do not show the popup (or hide it immediately)
	  if (getCookie('fvpp' + settings.cookieName)) {
		hideMessage();
	  } else {
		showMessage();
	  }
  
	  // Bind click events for showing and hiding the popup
	  $(settings.showAgainSelector).on('click', function (e) {
		e.preventDefault();
		showMessage();
	  });
  
	  $body.on('click', '#fvpp-blackout, #fvpp-close', function (e) {
		e.preventDefault();
		hideMessage();
	  });
  
	  // Optional: Prevent clicks inside the dialog from closing the popup
	  $dialog.on('click', function (e) {
		e.stopPropagation();
	  });
  
	  return this;
	};
  })(jQuery);
  
  // Global handler for the "Allow Cookies" button
  // When the button is clicked, it will also simulate a click on the blackout layer,
  // which triggers the hideMessage() function to close the popup and set the cookie.
  $(document).ready(function () {
	$('.acceptcookies').on('click', function (e) {
	  e.preventDefault();
	  $('#fvpp-blackout').trigger('click');
	});
  });
  