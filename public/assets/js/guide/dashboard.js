(function ($) {
    "use strict";

    let tour = setup_guide.tour;
    if (vars.tour) {
        if (vars.tour.navbar_guide == 1 && vars.tour.dashboard_guide == 0) {
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
        title: "Balance total",
        text: "Total saldo yang sudah kamu dapatkan dari dukungan supportermu.",
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
        title: "Total dukungan",
        text: "Total dukungan yang berhasil kamu dapatkan bulan ini.",
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
        title: "Times supported",
        text: "Menunjukkan berapa kali supporter sudah mendukungmu.",
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
        title: "Disbursement",
        text: "Total saldo yang sudah berhasil kamu cairkan.",
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
        title: "Grafik dukungan",
        text: "Grafik ini menunjukkan hasil support yang sudah berhasil kamu dapatkan. Kamu juga bisa melakukan filter berdasarkan kapan dukungan tersebut berhasil kamu dapatkan.",
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
        title: "Grafik pencairan",
        text: "Grafik ini menunjukkan total saldo yang sudah berhasil kamu cairkan. Kamu juga bisa melakukan filter berdasarkan kapan dukungan tersebut berhasil kamu dapatkan.",
        attachTo: {
            element: ".step16",
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
