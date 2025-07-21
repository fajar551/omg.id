/**
* Payment status scripts
* Version: 2.0
*/
(function ($) {
    "use strict";

    const selector = $("#paymentstatus");

    const checkPaymentStatus = () => {
        const orderID = $("#payment-status").data("id");

        $.ajax({
            type: "GET",
            url: `${vars.apiURL}/user/support/detail?order_id=${orderID}`,
            // headers: headers,
            beforeSend: function() {
                $('#refresh').attr({"disabled": true}).html("Loading...");
                selector.html(
                    `<div class="col-12 d-flex justify-content-center align-items-center"> 
                        <div class="loaders"></div>
                    </div>`);
            },
            complete: function() {
                $('#refresh').attr({"disabled": false}).html("Refresh");
            },
            error: function(xhr, status, error) {
                const { message = 'Error!' } = xhr.responseJSON;
                // Toast.fire({ icon: 'error', title: 'An error occured!', text: message});
                selector.html(`<div class="alert alert-danger" role="alert">An error occured! ${message}</div>`);
            },
            success: function (data) {
                if (data.code === 200) {
                    selector.html(buildPaymentStatus(data.data));
                } else {
                    selector.html(`<div class="alert alert-primary" role="alert">${data.message}</div>`);
                }
            },
        });
    };

    const buildPaymentStatus = (data) => {
        if (typeof data == "string") {
            selector.html(`<div class="alert alert-primary" role="alert">${data}</div>`);
            return;
        }

        const { 
            name, 
            creator_email, 
            creator_name, 
            date_paid, 
            due_date, 
            email, 
            items, 
            order_id, 
            order_time, 
            page_url, 
            payment_method, 
            payment_status, 
            status, 
            total,
            content_name,
            start,
            end
        } = data;

        const statusLabel = payment_status == "Success" ? 'is-success' : (payment_status == "Pending" ? 'is-pending' : 'is-failed');
        let dateTitle = '';
        let dateStatus = 'Undefined';

        if (payment_status == "Success") {
            dateTitle = 'Waktu Pembayaran';
            dateStatus = date_paid;
        } else {
            dateTitle = 'Bayar Sebelum';
            dateStatus = due_date;
        }

        let itemsDetails = items.map((value, index) => {
            return `<tr class="bg-transparent">
                        <td class="text-center fw-semibold" scope="row">${++index}</td>
                        <td>
                            <h6 class="mb-0">${value.item}</h6>
                            <small class="mb-0">${value.price} x ${value.qty}</small>
                        </td>
                        <td class="text-center">${value.price}</td>
                        <td class="text-center">${value.total}</td>
                    </tr>`;
        }).join('');

        const html = `
            <div class="row d-flex justify-content-between mb-2">
                <div class="col-lg-4 col-sm-12">
                    <h5 class="fw-semibold"> Dukungan Kepada </h5>
                    <div class="row align-items-center mb-3">
                        <div class="col-12">
                            <h6>${creator_name}</h6>
                        </div>
                        ${content_name ? `
                        <div class="col-6">
                            <h6> Nama Konten </h6>
                        </div>
                        <div class="col-6">
                            <h6>${content_name.length > 35 ? `${content_name.substring(0, 35)}...` : content_name}</h6>
                        </div>
                        <div class="col-6">
                            <h6> Start </h6>
                        </div>
                        <div class="col-6">
                            <h6>${start}</h6>
                        </div>
                        <div class="col-6">
                            <h6> End </h6>
                        </div>
                        <div class="col-6">
                            <h6>${end}</h6>
                        </div>
                        ` : ``}
                    </div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <h5 class="fw-semibold"> Dari </h5>
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h6> Nama </h6>
                        </div>
                        <div class="col-6">
                            <h6>${name}</h6>
                        </div>
                        <div class="col-6">
                            <h6> Email </h6>
                        </div>
                        <div class="col-6">
                            <h6>${email}</h6>
                        </div>
                        <div class="col-6">
                            <h6> Oder ID </h6>
                        </div>
                        <div class="col-6">
                            <h6>${order_id}</h6>
                        </div>
                        <div class="col-6">
                            <h6> Metode Pembayaran </h6>
                        </div>
                        <div class="col-6">
                            <h6 class="text-uppercase">${payment_method}</h6>
                        </div>
                        <div class="col-6">
                            <h6> Waktu Transaksi </h6>
                        </div>
                        <div class="col-6">
                            <h6>${order_time}</h6>
                        </div>
                        <div class="col-6">
                            <h6>${dateTitle}</h6>
                        </div>
                        <div class="col-6">
                            <h6>${dateStatus}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center" >
                <span class="stamp ${statusLabel} d-flex justify-content-center align-items-center">
                    ${payment_status}
                </span>
            </div>
            <div class="payment-summary py-3 table-responsive position-relative">
                <h5 class="h5 fw-semibold" >Detail Transaksi</h5>
                <table class="table">
                    <thead class="odd border-top border-bottom" >
                        <tr>
                            <th class="text-center fw-light" scope="col">No </th>
                            <th class="text-center fw-light" scope="col">Item X Qty</th>
                            <th class="text-center fw-light" scope="col">Harga Satuan</th>
                            <th class="text-center fw-light" scope="col">Harga Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${itemsDetails}
                        <tr>
                            <td></td>
                            <td align="right" colspan="2" ><span class="text-center"> Total</span></td>
                            <td align="center">${total}</td>
                        <tr>
                    </tbody>
                </table>
            </div>`;

        return html;
    }

    $(document).on("click", "#refresh", function () {
        checkPaymentStatus();
    });

    $(() => {
        checkPaymentStatus();
    })

})(jQuery);
