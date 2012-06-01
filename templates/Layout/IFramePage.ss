<div class="typography">
	<h2>$Title</h2>
	
	$Content
	<% if DynamicHeight %>
		<iframe src="$IFrameUrl" class="iframeautosize" style="width: 100%;">$AlternateContent</iframe>
	<% else %>
		<iframe src="$IFrameUrl" style="width: 100%; height: {$FixedHeight}px;">$AlternateContent</iframe>
	<% end_if %>
	$BottomContent
</div>
