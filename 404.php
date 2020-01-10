<?php get_header(); ?>

    <section class="page-404">
        <div class="page-404__num">404</div>

        <?php if (ICL_LANGUAGE_CODE == 'en'): ?>
            <h2 class="section-title page-404__title">This page does not exist.</h2>
            <div class="page-404__go-to">Go to <a href="<?php echo get_home_url(); ?>">Home Page</a> or
                <a href="<?php echo get_permalink( get_page_by_path( 'contact' ) ); ?>">Contact</a> us.</div>
        <?php elseif (ICL_LANGUAGE_CODE == 'ru'): ?>
            <h2 class="section-title page-404__title">Страница не существует.</h2>
            <div class="page-404__go-to">Возвращайтесь на <a href="<?php echo get_home_url(); ?>">Главную Страницу</a>
                или <a href="<?php echo get_permalink( get_page_by_path( 'contact' ) ); ?>">Свяжитесь с Нами</a>.</div>
        <?php else: ?>
            <h2 class="section-title page-404__title">ასეთი გვერდი არ არსებობს.</h2>
            <div class="page-404__go-to">დაბრუნდით <a href="<?php echo get_home_url(); ?>">მთავარ გვეძე</a> ან
                <a href="<?php echo get_permalink( get_page_by_path( 'contact' ) ); ?>">დაგვიკავშირდით</a>.</div>
        <?php endif ?>
    </section>

<?php get_footer(); ?>