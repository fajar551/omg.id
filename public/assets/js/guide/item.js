(function ($) {
    "use strict";

    let tour = setup_guide.tour;
    if (vars.tour) {
        if (vars.tour.navbar_guide == 1 && vars.tour.item_guide == 0) {
            tour = new Shepherd.Tour({
                useModalOverlay: true,
                defaultStepOptions: {
                    cancelIcon: {
                        enabled: true,
                    },
                    classes: "bg-white mt-3",
                    scrollTo: { behavior: "smooth", block: "center" },
                },
            });
            window.setTimeout(function () {
                tour.start();
            }, 3500);
        }
    }

    tour.addStep({
        id: "example-step",
        title: "Daftar item",
        text: "Halaman ini menunjukkan item apa saja yang kamu punya. Kamu juga bisa memilih item mana yang mau kamu aktifkan, maupun menambah item baru.",
        attachTo: {
            element: ".step11",
            on: "top",
        },
        classes: "step12",
        buttons: [
            {
                text: "Next",
                action: tour.next,
                classes: "bg-white text-primary ms-auto",
            },
        ],
    });

    tour.addStep({
        id: "example-step",
        title: "Buat item baru",
        text: "Yuk buat item barumu sekarang!",
        attachTo: {
            element: ".step12",
            on: "right",
        },
        buttons: [
            {
                text: "Back",
                action: tour.back,
                classes: "bg-white text-primary",
            },
            {
                text: "Close",
                action: tour.cancel,
                classes: "bg-white text-primary shepherd-cancel",
            },
        ],
    });
})(jQuery);
