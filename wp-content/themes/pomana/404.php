<?php
/**
 * The template for displaying 404 pages (not found).
 *
 */

get_header(); ?>

	<!-- Breadcrumbs -->
	<div class="modeltheme-breadcrumbs">
        <div id="overlay"></div>
	    <div class="container">
	        <div class="row">
	            <div class="col-md-12">
	                <h1 class="page-title"><?php esc_html_e('404','pomana'); ?></h1>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- Page content -->
	<div id="primary" class="content-area">
	    <main id="main" class="container blog-posts site-main">
	        <div class="col-md-12 main-content">
				<section class="error-404 not-found">
					<header class="page-header-404">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<h1 class="text-center"><?php esc_html_e( '404', 'pomana' ); ?></h1>
									<h2 class="page-title text-center"><?php esc_html_e( 'Sorry, this page does not exist', 'pomana' ); ?></h2>
									<p class="page-title text-center"><?php esc_html_e( 'The link you clicked might be corrupted, or the page may have been removed.', 'pomana' ); ?></p>
									<div class="button_404 text-center">
										<a class="vc_button_404"  href="<?php echo esc_url(get_site_url()); ?>"><?php esc_html_e( 'Back to Home', 'pomana' ); ?></a>
									</div>
								</div>
							</div>
						</div>
					</header>
				</section>
			</div>
		</main>
	</div>

<?php get_footer(); ?>