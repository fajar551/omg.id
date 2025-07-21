(function ($) {
    "use strict";

    let tour = setup_guide.tour;
    if (vars.tour) {
        if (vars.tour.navbar_guide == 1 && vars.tour.goal_guide == 0) {
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
        title: "Navigasi",
        text: "Navigasi ini dipake buat kamu berpindah menu dari menu target aktif ke history target.",
        attachTo: {
            element: ".step11",
            on: "bottom",
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
        title: "Goal Aktif",
        text: "Pada bagian ini, kamu dapat melihat berapa target goal yang ingin kamu dapatkan.",
        attachTo: {
            element: ".step12",
            on: "bottom",
        },
        classes: "step13",
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
        title: "Goal history",
        text: "Pada bagian ini, kamu dapat melihat goal apa saja yang sudah berhasil kamu raih hingga saat ini.",
        attachTo: {
            element: ".step13",
            on: "bottom",
        },
        classes: "step14",
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
        title: "Goal Aktif",
        text: "Pada bagian ini, kamu dapat melihat berapa target goal yang ingin kamu dapatkan.",
        attachTo: {
            element: ".step14",
            on: "top",
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

    // tour.addStep({
    //     id: "example-step",
    //     title: "Buat Goal",
    //     text: "Kamu belum punya goal nih, yuk bikin goal sekarang!",
    //     attachTo: {
    //         element: ".stepempty",
    //         on: "bottom",
    //     },
    //     buttons: [
    //         {
    //             text: "Back",
    //             action: tour.back,
    //             classes: "bg-white text-primary",
    //         },
    //         {
    //             text: "Close",
    //             action: tour.cancel,
    //             classes: "bg-white text-primary",
    //         },
    //     ],
    // });

    // tour.addStep({
    //     id: "example-step",
    //     title: "Goal Aktif",
    //     text: "Pada bagian ini, kamu dapat melihat berapa target goal yang ingin kamu dapatkan.",
    //     attachTo: {
    //         element: ".step13",
    //         on: "bottom",
    //     },
    //     classes: "step14",
    //     buttons: [
    //         {
    //             text: "Back",
    //             action: tour.back,
    //             classes: "bg-white text-primary",
    //         },
    //         {
    //             text: "Next",
    //             action: tour.next,
    //             classes: "bg-white text-primary",
    //         },
    //     ],
    // });

    // tour.addStep({
    //     id: "example-step",
    //     title: "Goal history",
    //     text: "Pada bagian ini, kamu dapat melihat goal apa saja yang sudah berhasil kamu raih hingga saat ini.",
    //     attachTo: {
    //         element: ".step14",
    //         on: "bottom",
    //     },
    //     buttons: [
    //         {
    //             text: "Back",
    //             action: tour.back,
    //             classes: "bg-white text-primary",
    //         },
    //         {
    //             text: "Close",
    //             action: tour.cancel,
    //             classes: "bg-white text-primary",
    //         },
    //     ],
    // });
})(jQuery);
