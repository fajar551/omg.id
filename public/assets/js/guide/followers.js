(function ($) {
    "use strict";

    let tour = setup_guide.tour;
    if (vars.tour) {
        if (
            vars.tour.navsupporter_guide == 1 &&
            vars.tour.following_guide == 0
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
        title: "Kreator diikuti",
        text: "Daftar Kreator yang kamu ikuti.",
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
})(jQuery);
