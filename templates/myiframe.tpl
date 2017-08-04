<style type="text/css">
.fluidMedia {
    position: relative;
    margin: auto;
    padding-bottom: 56.25%; /* proportion value to aspect ratio 16:9 (9 / 16 = 0.5625 or 56.25%) */
    padding-top: 30px;
    height: 0;
    overflow: hidden;
}

.fluidMedia iframe {
    position: absolute;
    top: 0; 
    left: 0;
    width: <{$width}>;
    height: <{$height}>;
</style>
  <{if $frameok}>
	<div class="fluidMedia">
		<iframe longdesc="<{$longdesc}>" width="<{$width}>" height="<{$height}>" align="<{$align}>" frameborder="<{$frameborder}>" marginwidth="<{$marginwidth}>" marginheight="<{$marginheight}>" scrolling="<{$scrolling}>" src="<{$url}>">Your browser is not capable of displaying this frame.</iframe>
	</div>
<{else}>
	<table border="0" cellspacing="1" class="outer">
	<{foreach item=iframe from=$iframes}>
		<tr class="<{cycle values="even,odd"}>">
			<td align='center'><{$iframe.list}></td>
		</tr>
	<{/foreach}>
	</table>
<{/if}>