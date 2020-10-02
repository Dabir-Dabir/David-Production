<?php get_header(); ?>

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <?php the_content(); ?>
            <section id="booking-modal" class="booking-modal">
                <div class="booking-modal__wrap">
                    <div id="booking-modal__close-button" class="booking-modal__close-button">
                        <svg class="booking-modal__close-img" xmlns="http://www.w3.org/2000/svg" width="43.841"
                             height="43.841" viewBox="0 0 43.841 43.841">
                            <g id="Group_9" data-name="Group 9" transform="translate(-1441.58 -172.58)">
                                <line id="Line_3" data-name="Line 3" x2="50"
                                      transform="translate(1445.822 212.178) rotate(-45)" fill="none" stroke="#707070"
                                      stroke-linecap="round" stroke-width="6"/>
                                <line id="Line_4" data-name="Line 4" x2="50"
                                      transform="translate(1445.822 176.822) rotate(45)" fill="none" stroke="#707070"
                                      stroke-linecap="round" stroke-width="6"/>
                            </g>
                        </svg>
                    </div>

                    <?php if (ICL_LANGUAGE_CODE == 'en'): ?>
                        <h2 class="booking-modal__title">Booking Form</h2>
                        <div class="booking-modal__form"><?= do_shortcode('[booking]'); ?></div>
                        <span class="booking-modal__choose">Select a date on the calendar.</span>
                        <span class="booking-modal__incorrect">Sorry, this date is already taken.</span>

                    <?php elseif (ICL_LANGUAGE_CODE == 'ru'): ?>
                        <h2 class="booking-modal__title">Форма Заказа</h2>
                        <div class="booking-modal__form"><?= do_shortcode('[booking]'); ?></div>
                        <span class="booking-modal__choose">Выберите дату на календаре.</span>
                        <span class="booking-modal__incorrect">К сожалению, эта дата уже занята.</span>

                    <?php else: ?>
                        <h2 class="booking-modal__title">დაჯავშნის ფორმა</h2>
                        <div class="booking-modal__form"><?= do_shortcode('[booking]'); ?></div>
                        <span class="booking-modal__choose">აირჩიეთ თარიღი კალენდარზე.</span>
                        <span class="booking-modal__incorrect">სამწუხაროდ ეს თარიღი უკვე დაკავებულია.</span>
                    <?php endif; ?>
                </div>
            </section>


        <?php endwhile; endif; ?>


<?php get_footer(); ?>