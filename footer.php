		<section class="footer">
			<footer class="main-container max-width center-block row">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php  if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<?php dynamic_sidebar( 'footer-1' ); ?>			
					<?php endif ?>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php  if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<?php dynamic_sidebar( 'footer-2' ); ?>			
					<?php endif ?>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php  if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<?php dynamic_sidebar( 'footer-3' ); ?>			
					<?php endif ?>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php  if ( is_active_sidebar( 'footer-4' ) ) : ?>
						<?php dynamic_sidebar( 'footer-4' ); ?>			
					<?php endif ?>
				</div>
			</footer>
		</section>

		<section class="footer-info">
			<footer class="main-container max-width center-block">
				<p class="text-center"><?php Majale::show_footer_text() ?></p>
			</footer>
		</section>
	<?php wp_footer() ?>
	</body>
</html>