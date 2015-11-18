<?php
/**
 * The template for displaying featured posts on the front page
 *
 */
?>

<div class="
<?php 
/**
 * Call feature posts css class
 * 
 * @hook backend/majale@feature_posts_html
 */
do_action('majale_feature_posts') ?>
">

<?php
	/**
	 * determine show feature posts or not.
	 *
	 * @hook backend/majale@show_feature_posts_on
	 */
	do_action('show_feature_posts_on');

	if ( Majale::show_feature_posts() ) :

		/**
		 * @function majale_sticky_post_count get sticky posts count.
		 * @method feature_posts_count get number of feature posts to show. set in admin panel.
		 * @var number
		 */
		$majale_sticky_post_count = min(majale_sticky_post_count(), Majale::feature_posts_count())
		?>

		<?php query_posts( array( 'post__in' => get_option('sticky_posts') ) ) ?>
			<!-- Featured Posts -->
		<?php if($majale_sticky_post_count != 0) : ?>
			<?php if($majale_sticky_post_count == 1) : ?>
				<div class="row featured-container sticky">
					<?php for($i = 0; have_posts() && $i < 1; $i++) : the_post(); ?>
					<a href="<?php the_permalink() ?>">
						<div class="col-lg-12 col-sm-12 zone large-zone" style="<?php majale_thumbnail('full') ?>">
							<h2 class="caption"><?php the_title() ?></h2>
						</div>
					</a>
					<?php endfor ?>
				</div>
			<?php elseif($majale_sticky_post_count == 2) : ?>
				<div class="row featured-container sticky">
					<?php for($i = 0; have_posts() && $i < 2; $i++) : the_post(); ?>
					<a href="<?php the_permalink() ?>">
						<div class="col-lg-6 col-sm-12 zone large-zone" style="<?php majale_thumbnail('large') ?>">
							<h2 class="caption"><?php the_title() ?></h2>
						</div>
					</a>
					<?php endfor ?>
				</div>
			<?php elseif($majale_sticky_post_count == 3) : ?>
				<div class="row featured-container sticky">
					<?php for($i = 0; have_posts() && $i < 3; $i++) : the_post(); ?>
					<a href="<?php the_permalink() ?>">
						<div class="col-lg-4 col-sm-12 zone large-zone" style="<?php majale_thumbnail('large') ?>">
							<h2 class="caption"><?php the_title() ?></h2>
						</div>
					</a>
					<?php endfor ?>				
				</div>
			<?php elseif($majale_sticky_post_count == 4) : ?>
				<div class="row featured-container sticky">
					<?php for($i = 0; have_posts() && $i < 4; $i++) : the_post(); ?>
					<a href="<?php the_permalink() ?>">
						<div class="col-lg-3 col-sm-12 zone large-zone" style="<?php majale_thumbnail('medium') ?>">
							<h2 class="caption"><?php the_title() ?></h2>
						</div>
					</a>
					<?php endfor ?>				
				</div>
			<?php elseif($majale_sticky_post_count == 5) : ?>
				<div class="row featured-container sticky">
					<?php for($i = 0; have_posts() && $i < 4; $i++) : the_post() ?>
						<?php if($i != 3) : ?>
						<a href="<?php the_permalink() ?>">
							<div class="col-lg-3 col-sm-12 zone large-zone" style="<?php majale_thumbnail('medium') ?>">
								<h2 class="caption"><?php the_title() ?></h2>
							</div>
						</a>
						<?php else : ?>
						<div class="col-lg-3 col-sm-12">
							<div class="row">
								<a href="<?php the_permalink() ?>">
									<div class="col-lg-12 zone med-zone" style="<?php majale_thumbnail('medium') ?>">
										<h3 class="caption"><?php the_title() ?></h3>
									</div>
								</a>
								<?php the_post() ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-lg-12 zone med-zone" style="<?php majale_thumbnail('medium') ?>">
										<h3 class="caption"><?php the_title() ?></h3>
									</div>
								</a>
							</div>
						</div>
						<?php endif ?>
					<?php endfor ?>
				</div>
			<?php elseif($majale_sticky_post_count == 6) : ?>
				<div class="row featured-container sticky">
					<?php for($i = 0; have_posts() && $i < 3; $i++) : the_post() ?>
						<?php if($i != 2) : ?>
						<a href="<?php the_permalink() ?>">
							<div class="col-lg-3 col-sm-12 zone large-zone" style="<?php majale_thumbnail('medium') ?>">
								<h2 class="caption"><?php the_title() ?></h2>
							</div>
						</a>
						<?php else : ?>
						<div class="col-lg-3 col-sm-12">
							<div class="row">
								<a href="<?php the_permalink() ?>">
									<div class="col-lg-12 zone med-zone" style="<?php majale_thumbnail('medium') ?>">
										<h3 class="caption"><?php the_title() ?></h3>
									</div>
								</a>
								<?php the_post() ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-lg-12 zone med-zone" style="<?php majale_thumbnail('medium') ?>">
										<h3 class="caption"><?php the_title() ?></h3>
									</div>
								</a>
							</div>
						</div>
						<div class="col-lg-3 col-sm-12">
							<div class="row">
								<?php the_post() ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-lg-12 zone med-zone" style="<?php majale_thumbnail('medium') ?>">
										<h3 class="caption"><?php the_title() ?></h3>
									</div>
								</a>
								<?php the_post() ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-lg-12 zone med-zone" style="<?php majale_thumbnail('medium') ?>">
										<h3 class="caption"><?php the_title() ?></h3>
									</div>
								</a>
							</div>
						</div>
						<?php endif ?>
					<?php endfor ?>
				</div>
			<?php elseif($majale_sticky_post_count == 7) : ?>
				<div class="row featured-container sticky">
					<?php for($i = 0; have_posts() && $i < 4; $i++) : the_post() ?>
						<?php if($i < 3) : ?>
						<a href="<?php the_permalink() ?>">
							<div class="col-lg-3 col-sm-6 zone large-zone" style="<?php majale_thumbnail('medium') ?>">
								<h2 class="caption"><?php the_title() ?></h2>
							</div>
						</a>
						<?php else : ?>
						<div class="col-lg-3 col-sm-6">
							<div class="row">
								<a href="<?php the_permalink() ?>">
									<div class="col-xs-6 zone small-zone" style="<?php majale_thumbnail('thumbnail') ?>">
										<h4 class="caption"><?php the_title() ?></h4>
									</div>
								</a>

								<?php the_post() ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-xs-6 zone small-zone" style="<?php majale_thumbnail('thumbnail') ?>">
										<h4 class="caption"><?php the_title() ?></h4>
									</div>
								</a>
							</div>

							<div class="row">
								<?php the_post() ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-xs-6 zone small-zone" style="<?php majale_thumbnail('thumbnail') ?>">
										<h4 class="caption"><?php the_title() ?></h4>
									</div>
								</a>

								<?php the_post() ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-xs-6 zone small-zone" style="<?php majale_thumbnail('thumbnail') ?>">
										<h4 class="caption"><?php the_title() ?></h4>
									</div>
								</a>
							</div>
						</div>
						<?php endif ?>
					<?php endfor ?>
				</div>
			<?php elseif($majale_sticky_post_count >= 8) : $i = 0 ?>
				<div class="row featured-container sticky">
					<?php while( have_posts() AND $i < 8 ) : ?>
						<?php the_post(); $i++ ?>
						<a href="<?php the_permalink() ?>">
							<div class="col-lg-3 col-sm-6 zone large-zone" style="<?php majale_thumbnail('medium') ?>">
								<h2 class="caption"><?php the_title() ?></h2>
							</div>
						</a>

						<?php the_post(); $i++ ?>
						<a href="<?php the_permalink() ?>">
							<div class="col-lg-3 col-sm-6 zone large-zone" style="<?php majale_thumbnail('medium') ?>">
								<h2 class="caption"><?php the_title() ?></h2>
							</div>
						</a>
						
						<div class="col-lg-3 col-sm-6">
							<div class="row">
								<?php the_post(); $i++ ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-lg-12 zone med-zone" style="<?php majale_thumbnail('medium') ?>">
										<h3 class="caption"><?php the_title() ?></h3>
									</div>
								</a>

								<?php the_post(); $i++ ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-lg-12 zone med-zone" style="<?php majale_thumbnail('medium') ?>">
										<h3 class="caption"><?php the_title() ?></h3>
									</div>
								</a>
							</div>
						</div>

						<div class="col-lg-3 col-sm-6">
							<div class="row">
								<?php the_post(); $i++ ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-xs-6 zone small-zone" style="<?php majale_thumbnail('thumbnail') ?>">
										<h4 class="caption"><?php the_title() ?></h4>
									</div>
								</a>

								<?php the_post(); $i++ ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-xs-6 zone small-zone" style="<?php majale_thumbnail('thumbnail') ?>">
										<h4 class="caption"><?php the_title() ?></h4>
									</div>
								</a>
							</div>

							<div class="row">
								<?php the_post(); $i++ ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-xs-6 zone small-zone" style="<?php majale_thumbnail('thumbnail') ?>">
										<h4 class="caption"><?php the_title() ?></h4>
									</div>
								</a>

								<?php the_post(); $i++ ?>
								<a href="<?php the_permalink() ?>">
									<div class="col-xs-6 zone small-zone" style="<?php majale_thumbnail('thumbnail') ?>">
										<h4 class="caption"><?php the_title() ?></h4>
									</div>
								</a>
							</div>
						</div>
					<?php endwhile ?>
				</div><!-- featured posts -->
			<?php endif; ?>
		<?php endif; // if($majale_sticky_post_count != 0)
		wp_reset_query();
	endif; //if ( Majale::show_feature_posts() )
	?>
</div>