<div class="typography">
	<h2>$Title</h2>
	
	$Content
	<% if IFrameURL %>
		<span id="Iframepage-loading" style="display: none;">External content is loading...</span>
		<iframe id="Iframepage-iframe" style="$Style" src="$IFrameURL" class="$Class">$AlternateContent</iframe>
	<% end_if %>
	$BottomContent
</div>
