<% require ThemedCSS(IFramePage) %>
<% require javascript(jsparty/jquery/jquery.js) %>
<% require javascript(iframe/javascript/IFramePage.js) %>

<div class="typography">
	<h2>$Title</h2>
	
	$Content
	<iframe id="IFramePageIFrame" src="$IFrameUrl" $Height>
		$AlternateContent
	</iframe>
	$BottomContent
</div>
