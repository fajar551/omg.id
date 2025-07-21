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
        title: "Saldo Tertunda",
        text: "Saldo ini menunjukkan saldo yang sudah kamu dapatkan dari Suporter namun tidak bisa langsung dicairkan. Membutuhkan waktu 3x24 jam untuk berubah status menjadi saldo aktif.",
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
        title: "Saldo aktif",
        text: "Saldo yang kamu dapatkan dari Suporter mu dan dapat kamu cairkan.",
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
        title: "Akun pencairan",
        text: "Informasi mengenai akun yang akan menerima pencairan dari saldo OMG.",
        attachTo: {
            element: ".step13",
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
        title: "Pencairan saldo",
        text: "Kamu bisa melakukan pencairan saldo aktif dengan mengklik tombol ini dan memasukan jumlah saldo yang ingin dicairkan.",
        attachTo: {
            element: ".step16",
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
        title: "Riwayat Transaksi",
        text: "Informasi riwayat support & pencairan dana.",
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
        title: "Export",
        text: "Kamu dapat meng-export data dari Riwayat Transaksi sesuai dengan rentang tanggal yang diinginkan.",
        attachTo: {
            element: ".step15",
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
