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
        title: "Dashboard",
        text: "Menu untuk memperlihatkan data performa kamu secara umum.",
        attachTo: {
            element: ".step1",
            on: "bottom",
        },
        classes: "step2",
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
        title: "Goal",
        text: "Menu untuk mengatur target support yang ingin kamu dapatkan.",
        attachTo: {
            element: ".step2",
            on: "bottom",
        },
        classes: "step3",
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
        title: "Item",
        text: "Menu untuk mengatur item yang kamu gunakan saat proses support.",
        attachTo: {
            element: ".step3",
            on: "bottom",
        },
        classes: "step4",
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
        title: "Overlay",
        text: "Menu ini dapat digunakan untuk mengatur tampilan overlay yang nantinya digunakan pada software broadcasting yang menggunakan “Browse Source”.",
        attachTo: {
            element: ".step4",
            on: "bottom",
        },
        classes: "step5",
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
        title: "Balance",
        text: "Menu Balance digunakan untuk kamu melakukan pengecekan saldo aktif dan pending. Riwayat transaksi, Support yang sudah kamu berikan ke kreator, pencairan saldo, dan pengaturan payout juga dapat kamu akses pada menu ini.",
        attachTo: {
            element: ".step5",
            on: "bottom",
        },
        classes: "step6",
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
        title: "Integrasi",
        text: "Hubungkan akun Discord maupun Webhook lainnya dapat dilakukan pada menu Integrasi.",
        attachTo: {
            element: ".step6",
            on: "bottom",
        },
        classes: "step7",
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
        title: "Konten",
        text: "Atur dan buat konten pada menu Konten dan dapatkan Supporter lebih banyak lagi!",
        attachTo: {
            element: ".step7",
            on: "bottom",
        },
        classes: "step8",
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
        title: "Pengaturan",
        text: "Atur data profil, halaman dukungan, password, link media sosial, dan pengaturan lainnya pada menu ini.",
        attachTo: {
            element: ".step8",
            on: "bottom",
        },
        classes: "step9",
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
        title: "Notifikasi",
        text: "Semua pemberitahuan dan dukungan dari Supportermu dapat kamu akses di sini!",
        attachTo: {
            element: ".step9",
            on: "bottom",
        },

        classes: "step10",
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
        title: "Profile",
        text: "Informasi akses cepat halaman yang sering kamu kunjungi.",
        attachTo: {
            element: ".step10",
            on: "bottom",
        },
        classes: "step11",
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
        if (vars.tour.navbar_guide == 0) {
            window.setTimeout(function () {
                tour.start();
            }, 3500);
        }
    }

    return { tour };
})(jQuery);
