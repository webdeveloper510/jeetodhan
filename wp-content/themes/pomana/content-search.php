<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.WordPress.org/Template_Hierarchy
 *
 */
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'pomana_related_post_pic500x300' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('row single-post'); ?>>

    <div class="col-md-4 post-thumbnail">
        <a href="<?php esc_url(the_permalink()); ?>" class="relative">
            <?php if($thumbnail_src) { ?>
                <img src="<?php echo esc_url($thumbnail_src[0]); ?>" alt="<?php the_title_attribute(); ?>" />
            <?php } ?>
            <div class="thumbnail-overlay absolute">
                <i class="fa fa-plus absolute"></i>
            </div>
        </a>
    </div>
    <div class="col-md-8 post-details">
        <h3 class="post-name row">
            <a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>">
                <span class="post-type">
                    <i class="fa <?php echo esc_attr($post_icon); ?>"></i>
                </span><?php the_title() ?>
            </a>
        </h3>
        <div class="post-category-comment-date row">
            <span class="post-author"><?php echo esc_html__('by ', 'pomana') . get_the_author(); ?></span>   /   
            <span class="post-comments"><a href="<?php the_permalink(); ?>"><?php comments_number( esc_html__('No Comments', 'pomana'), esc_html__('1 Comment', 'pomana'), esc_html__('% Comments', 'pomana') ); ?></a></span>   /   
            <span class="post-date"><?php echo get_the_date(get_option( 'date_format' )); ?></span>
        </div>
        <div class="post-excerpt row">
        <?php
            /* translators: %s: Name of current post */
            the_content( sprintf(
                esc_html__( 'Continue reading ', 'pomana' ) . '%s <span class="meta-nav">&rarr;</span>',
                the_title( '<span class="screen-reader-text">"', '"</span>', false )
            ) );
        ?>
        <?php
            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pomana' ),
                'after'  => '</div>',
            ) );
        ?>
        </div>
    </div>
</article>