function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

function toggleNavigation() {
    const hamburger = document.getElementById('hamburger');
    hamburger.onclick = () => {

        const nav = document.getElementById('navigation');

        if (nav.classList.contains('navigation--open')) {
            nav.classList.remove('navigation--open');
        } else {
            nav.classList.add('navigation--open');
        }
    }
}

function chooseVideo() {

    function getElementIndex(element) {
        return [...element.parentNode.children].indexOf(element);
    }

    const portfolio = document.getElementById('portfolio');
    if (!portfolio) return;
    const list = portfolio.getElementsByClassName('portfolio-item');

    portfolio.onclick = function (e) {
        let item = e.target.closest('.portfolio-item');
        if (!item) return;

        const pastVideo = document.getElementsByClassName('portfolio-item--playing')[0];
        if (pastVideo) {
            pastVideo.classList.remove('portfolio-item--playing');
            let iframe = pastVideo.getElementsByClassName('portfolio-item__iframe')[0];
            let player = new Vimeo.Player(iframe);
            player.pause();
            player.setCurrentTime(0);

            const index = getElementIndex(pastVideo);
            pastVideo.style.order = index * 2;
        }

        item.classList.add('portfolio-item--playing');
        let iframe = item.getElementsByClassName('portfolio-item__iframe')[0];
        let player = new Vimeo.Player(iframe);
        player.play();

        const index = getElementIndex(item);
        if (index % 2 == 0 && index < list.length) {
            item.style.order = index * 2 + 3;
        } else if (index % 2 == 0 && index == list.length) {
            item.style.order = index * 2 - 3;
        }

    }
}

function buildGrid() {
    const portfolio = document.getElementById('portfolio');
    if (!portfolio) return;
    const list = portfolio.getElementsByClassName('portfolio-item');


    for (let i = 0; i < list.length; i++) {
        const item = list[i];
        item.style.order = (i + 1) * 2;
    }

    if (window.innerWidth >= 600) {
        list[0].classList.add('portfolio-item--playing');
        let iframe = list[0].getElementsByClassName('portfolio-item__iframe')[0];
        let player = new Vimeo.Player(iframe);
        player.play();
    }

}

function openBooking() {
    const anchors = document.getElementsByClassName('plan__book');
    if (anchors.length === 0) return;
    const openingClass = 'booking-modal--opening';
    const visibleClass = 'booking-modal--visible';
    const modal = document.getElementById('booking-modal');
    const closeButton = document.getElementById('booking-modal__close-button');
    const modalChoose = document.getElementsByClassName('booking-modal__choose')[0];
    const modalIncorrect = document.getElementsByClassName('booking-modal__incorrect')[0];
    const form = document.getElementsByClassName('wpbc_structure_form')[0];
    const calendar = document.getElementsByClassName('wpbc_structure_calendar')[0];

    closeButton.onclick = () => closeModal();

    modalChoose.classList.add(visibleClass);

    calendar.addEventListener("click", function (e) {
        const elem = e.target.closest('td');
        if ( !elem ) return;

        if ( elem.classList.contains('date_approved') ) {
            form.classList.remove(visibleClass);
            modalChoose.classList.remove(visibleClass);
            modalIncorrect.classList.add(visibleClass);
            const currentDay = document.getElementsByClassName('datepick-current-day')[0];
            currentDay.classList.remove('datepick-current-day');
        }

        if ( elem.classList.contains('datepick-unselectable') ) return;

        if ( elem.classList.contains('date_available')) {
            form.classList.add(visibleClass);
            modalChoose.classList.remove(visibleClass);
            modalIncorrect.classList.remove(visibleClass);

            const dateInput = document.getElementById('date1');
            const value = document.getElementById('date_booking1').value;
            dateInput.value = value.split('.').join(' / ');
        }
    });



    for(let anchor of anchors) {
        anchor.onclick = function(e) {
            const plan = e.target.closest('.plan');
            setPlanAndPrice(plan);
            openModal();
        };
    }

    function openModal() { modal.classList.add(openingClass); }
    function closeModal() { modal.classList.remove(openingClass); }
    function setPlanAndPrice(plan) {
        const planInput = document.getElementById('plan1');
        const priceInput = document.getElementById('price1');

        const title = plan.getElementsByClassName('plan__title')[0].innerHTML;
        const price = plan.getElementsByClassName('plan__price')[0].innerHTML;

        planInput.value = title;
        priceInput.value = price;
    }
}

docReady(function() {
    toggleNavigation();
    buildGrid();
    chooseVideo();
    openBooking();
});