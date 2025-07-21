(function ($) {
    "use strict";

    let tour = setup_guide.tour;
    if (vars.tour) {
        if (vars.tour.navbar_guide == 1 && vars.tour.overlay_guide == 0) {
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
        title: "Notification",
        text: "Personalisasi overlay Notifikasi sesuai dengan karaktermu yang nanti akan muncul pada halaman streaming-mu.",
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
        title: "Leaderboard",
        text: "Personalisasi overlay Leaderboard Suporter mu sesuai dengan keinginanmu.",
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
        title: "Last supporter",
        text: "Personalisasi overlay Last Supporter untuk mengetahui siapa Suporter mu.",
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
        title: "Target/ Goal",
        text: "Personalisasi overlay Target/ Goal mu dan buat dirimu semakin semangat berkarya.",
        attachTo: {
            element: ".step14",
            on: "bottom",
        },
        classes: "step15",
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
        title: "Running Text",
        text: "Personalisasi overlay Running Text bisa kamu lakukan di sini.",
        attachTo: {
            element: ".step15",
            on: "bottom",
        },
        classes: "step16",
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
        title: "QR Code",
        text: "Personalisasi overlay QR Code untuk mempermudah Supporter dalam memberikan dukungan untukmu.",
        attachTo: {
            element: ".step16",
            on: "bottom",
        },
        classes: "step17",
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
        title: "Media Share",
        text: "Personalisasi overlay Media Share sesuai dengan karaktermu.",
        attachTo: {
            element: ".step17",
            on: "bottom",
        },
        classes: "step18",
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

    //     title: "Aktifkan Media Share",
    //     text: "Aktifkan media share untuk memudahkan suporter mu.",
    //     attachTo: {
    //         element: ".step18",
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
