(function ($) {
    "use strict";

    let tour = setup_guide.tour;
    if (vars.tour) {
        if (
            vars.tour.navsupporter_guide == 1 &&
            vars.tour.contentsubs_guide == 0
        ) {
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
        title: "Konten dibeli",
        text: "List konten yang sudah kamu beli.",
        attachTo: {
            element: ".step1",
            on: "top",
        },
        classes: "step2",
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
        title: "Lihat",
        text: "Klik untuk melihat konten yang sudah kamu beli.",
        attachTo: {
            element: ".step2",
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
