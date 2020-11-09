<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Peanut
 */

?>

	<footer id="colophon" class="site-footer inverted">
		
		<p>&copy; 
			<?php bloginfo( 'name' ); ?> <?php echo date("Y"); ?>
		</p>
		
		<p>
			<?php
				printf( esc_html__( '\'Peanut\' %1$s with  %2$s by %3$s', 'peanut' ), '<i class="fa fa-code"></i>', '<i class="fa fa-heart"></i>', '<a href="https://dan.nunan.dev" target="_blank">Dan Nunan</a>' );
			?>
		</p>

		<?php if ( is_active_sidebar( 'footer_widget_1' ) ) : ?>
		<?php dynamic_sidebar( 'footer_widget_1' ); ?>
		<?php endif; ?>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
