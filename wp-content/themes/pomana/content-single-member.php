<?php
/**
 * @package Modeltheme
 */

$class = "";
if ( pomana_redux('pomana_single_service_layout') == 'pomana_service_fullwidth' ) {
    $class = "col-md-12";
}elseif ( pomana_redux('pomana_single_service_layout') == 'pomana_service_right_sidebar' or pomana_redux('pomana_single_service_layout') == 'pomana_service_left_sidebar') {
    $class = "col-md-9";
}

$sidebar = pomana_redux('pomana_single_service_sidebar');
$prev_post = get_previous_post();
$next_post = get_next_post();
?>

<div class="clearfix"></div>

<div class="modeltheme-breadcrumbs">
    <div id="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                	<h3 class="page-title"><?php echo get_the_title(); ?></h3>
                </ol>
            </div>
        </div>
    </div>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class('post high-padding'); ?>>
	 <div class="container">
        <div class="row">
			<div class="entry-content">
				<?php the_content(); ?>
				<div class="clearfix"></div>
				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pomana' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->
			<div class="clearfix"></div>
			<?php edit_post_link( esc_html__( 'Edit', 'pomana' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	</div>
</article><!-- #post-## -->