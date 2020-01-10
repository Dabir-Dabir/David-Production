<?php get_header(); ?>
<?php
query_posts('post_type=personals');
?>

    <section class="portfolio" id="portfolio">
        <h2 class="page-title page-title--hidden">
            <?php if (ICL_LANGUAGE_CODE == 'en') {
                echo 'Personal videos.';
            } elseif (ICL_LANGUAGE_CODE == 'ru') {
                echo 'Персональные видео.';
            } else {
                echo 'პერსონალური ვიდეოები.';
            } ?>

        </h2>

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <article class="portfolio-item">
                <div class="portfolio-item__content">
                    <iframe class="portfolio-item__iframe"
                            src="https://player.vimeo.com/video/<?php echo get_post_meta(get_the_ID(), 'vimeo-id', TRUE); ?>?transparent=false"
                            allowfullscreen></iframe>
                    <img class="portfolio-item__image"
                         src="<?php the_post_thumbnail_url(); ?>"
                         alt="<?php the_title(); ?>">
                    <div class="portfolio-item__overflow"></div>
                    <h4 class="portfolio-item__title"><?php the_title(); ?></h4>
                </div>
            </article>

        <?php endwhile; endif; ?>

    </section>


<?php get_footer(); ?>