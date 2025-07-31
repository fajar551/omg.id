(function ($) {
    "use strict";

    let tour = setup_guide.tour;
    if (vars.tour) {
        if (vars.tour.navbar_guide == 1 && vars.tour.content_guide == 0) {
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
        title: "Daftar Konten",
        text: "Halaman ini menunjukkan konten apa saja yang sudah kamu buat untuk selanjutnya dapat kamu kelola visibilitasnya.",
        attachTo: {
            element: ".step11",
            on: "top",
        },
        classes: "step12",
        buttons: [
            {
                text: "Close",
                action: tour.cancel,
                classes: "bg-white text-primary ms-auto shepherd-cancel",
            },
        ],
    });

    tour.addStep({
        id: "example-step",
        title: "Buat konten baru",
        text: "Kamu dapat membuat konten baru pada halaman ini!",
        attachTo: {
            element: ".step12",
            on: "bottom",
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
