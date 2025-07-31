(function ($) {
    "use strict";

    let tour = setup_guide.tour;
    if (vars.tour) {
        if (vars.tour.navbar_guide == 1 && vars.tour.balance_guide == 0) {
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
        title: "Balance",
        text: "Kamu belum mempunyai balance nih. Yuk mulai streaming dan kumpulin dukungan dari para supporter.",
        attachTo: {
            element: ".step11",
            on: "bottom",
        },
        buttons: [
            {
                text: "Close",
                action: tour.cancel,
                classes: "bg-white text-primary shepherd-cancel ms-auto",
            },
        ],
    });
})(jQuery);
