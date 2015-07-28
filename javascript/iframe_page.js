if (typeof jQuery!=='undefined') {
	(function($) {
		var iframe = $('#Iframepage-iframe');
		var loading = $('#Iframepage-loading');

		// Add not-ready marker for third party use.
		iframe.addClass('iframepage-not-ready');
		// Show loading message
		iframe.hide();
		loading.show();

		$(function() {
			$( window ).load(function() {
				// Iframe content has been loaded
				loading.hide();
				iframe.show();

				if (iframe.hasClass('iframepage-height-auto')===true) {
					// Try to set the height to the height of the iframe content (only possible if it is the same domain)
					try {
						var iframeInsideSize = $(iframe[0].contentWindow.document.body).height();
						iframe.css('height', (parseInt(iframeInsideSize)+100)+'px');
					}
					catch(e) {
						// Failed to set the height, we fall back to default css height.
					}
				}

				// Finally, remove the marker
				iframe.removeClass('iframepage-not-ready');
			});
		});
	})(jQuery);
}
