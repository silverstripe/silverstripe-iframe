if (typeof jQuery!=='undefined') {
	(function($) {
		var iframe = $('#Iframepage-iframe');
		var loading = $('#Iframepage-loading');

		// Add not-ready marker for third party use.
		iframe.addClass('iframepage-not-ready');
		// Show loading message
		iframe.hide();
		loading.show();

		$( iframe ).on('load', function() {
			// Iframe content has been loaded
			loading.hide();
			iframe.show();

			if (iframe.hasClass('iframepage-height-auto')===true) {
				// Try to set the height to the height of the iframe content (only possible if it is the same domain)
				try {
					// Use plain JS to get iframe size. There is some timing issue with jQuery
					// which causes the iframe size to be 0 even after iframe.show().
					const domframe = document.querySelector('#Iframepage-iframe');
					var iframeInsideSize = domframe.contentWindow.document.body.offsetHeight;
					iframe.css('height', (parseInt(iframeInsideSize)+100)+'px');
				}
				catch(e) {
					// Failed to set the height, we fall back to default css height.
				}
			}

			// Finally, remove the marker
			iframe.removeClass('iframepage-not-ready');
		});
	})(jQuery);
}
