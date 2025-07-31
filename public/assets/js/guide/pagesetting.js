(function ($) {
    "use strict";

    let tour = setup_guide.tour;
    if (vars.tour) {
        if (vars.tour.navbar_guide == 1 && vars.tour.page_guide == 0) {
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
        title: "Edit Profil",
        text: "Atur profil sesuai dengan keinginanmu di sini.",
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
        title: "Edit Cover",
        text: "Atur cover halaman sesuai dengan keinginanmu di sini.",
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
        title: "Social media",
        text: "Sosial media kamu ditampilkan di sini.",
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
        title: "Atur Social media",
        text: "Atur link sosial media kamu di sini.",
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
        title: "Edit Goal",
        text: "Tambahkan goal yang akan kamu tampilkan pada halaman Kreator.",
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
        title: "Summary",
        text: "Tambahkan summary singkat tentang kamu atau tentang channel yang kamu buat untuk menarik supporter!",
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
        title: "Video",
        text: "Tampilkan media share untuk menarik supporter!",
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
                text: "Next",
                action: tour.next,
                classes: "bg-white text-primary",
            },
        ],
    });

    tour.addStep({
        id: "example-step",
        title: "Konten Terbaru",
        text: "Bagian ini menampilkan konten terbaru yang kamu buat untuk ditampilkan di halaman Kreator.",
        attachTo: {
            element: ".step18",
            on: "bottom",
        },
        classes: "step19",
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
        title: "Buat Konten",
        text: "Buat konten baru di sini!",
        attachTo: {
            element: ".step19",
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
