  <?php if (!$page): ?>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
  <?php endif; ?>
  	 <div class="generica">
		<?php
		  // We hide the comments and links now so that we can render them later.
		  hide($content['comments']);
		  hide($content['links']);
			print render($content);
		?>
	<div id="clear"></div>
	</div>
