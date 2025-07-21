const setup_guide = (function ($) {
    "use strict";

    const tour = new Shepherd.Tour({
        useModalOverlay: true,
        defaultStepOptions: {
            cancelIcon: {
                enabled: true,
            },
            classes: "bg-white mt-3",
            scrollTo: { behavior: "smooth", block: "center" },
        },
    });

    tour.addStep({
        id: "example-step",
        title: "Konten",
        text: "List dari konten yang sudah kamu beli.",
        attachTo: {
            element: ".stepnav1",
            on: "bottom",
        },
        classes: "stepnav2",
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
        title: "Dukungan diberikan",
        text: "Dukungan yang sudah kamu berikan kepada Kreator favoritmu.",
        attachTo: {
            element: ".stepnav2",
            on: "bottom",
        },
        classes: "stepnav3",
        buttons: [
            {
                text: "Back",
                action: tour.back,
                classes: "bg-white text-primary",
            },
            {
                text: "Next",
                action: tour.next,
                classes: "bg-white text-primary",
            },
        ],
    });

    tour.addStep({
        id: "example-step",
        title: "Following",
        text: "Kreator favoritmu yang kamu ikuti.",
        attachTo: {
            element: ".stepnav3",
            on: "bottom",
        },
        classes: "step1",
        buttons: [
            {
                text: "Back",
                action: tour.back,
                classes: "bg-white text-primary",
            },
            {
                text: "Next",
                action: tour.next,
                classes: "bg-white text-primary",
            },
        ],
    });

    if (vars.tour) {
        if (vars.tour.navsupporter_guide == 0) {
            window.setTimeout(function () {
                tour.start();
            }, 3500);
        }
    }

    return { tour };
})(jQuery);
