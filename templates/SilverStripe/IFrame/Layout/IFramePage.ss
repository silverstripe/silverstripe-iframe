<div class="typography">
	<h2>$Title</h2>

	$Content
	<% if $IFrameURL %>
		<span id="Iframepage-loading" style="display: none;">
			<%t SilverStripe\\IFrame\\IFramePage.Loading "Loading content..." %>
		</span>
		<div class="nonvisual-indicator" style="position: absolute; overflow: hidden; clip: rect(0 0 0 0); height: 1px; width: 1px; margin: -1px; padding: 0; border: 0;">
			<%t SilverStripe\\IFrame\\IFramePage.ExternalNote "Please note the following section of content is possibly being delivered from an external source (IFRAME in HTML terms), and may present unusual experiences for screen readers." %>
		</div>
		<iframe id="Iframepage-iframe" style="$Style" src="$IFrameURL" class="$Class" title="$IFrameTitle">$AlternateContent</iframe>
	<% end_if %>
	$BottomContent
</div>
