/**
* Notification scripts
* Version: 2.0
*/
(function ($) {
   "use strict";

    let curPage = 0;
    let lastPageReached = false;
    let hasFirstLoad = false;
    let tempNotifyIds = [];

    $(() => {
        Echo.private(`broadcast.user.${vars.uid}`)
            .notification((notification) => {
                // console.log(notification);
                const { type, notify_id = null } = notification;
                if (!notify_id) return; 

                hasFirstLoad = true;

                switch (type) {
                    case 'notify.new_tip':
                    case 'notify.password_reset':
                    case 'notify.payout_account_activation':
                    case 'notify.payout_account_verified':
                    case 'notify.disbursement_request':
                        getNotifications(false, notify_id);
                        break;
                    default:
                        break;
                }
        });

        Echo.connector.pusher.connection.bind("state_change", function(states) {
            console.log(`Socket is ${states.current}`);
        });

        // Notif badge state
        let isNotifBadgeShow = sessionStorage.getItem("isNotifBadgeShow");
        if (isNotifBadgeShow !== null) {
            showHideNotifyBadge(isNotifBadgeShow);
        }

        // Notification bell clicked
        $('#notification-drop').on('click', function(e) {
            // TODO: Check for first load and from notification event
            if (!hasFirstLoad) {
                getNotifications();
                hasFirstLoad = true;
            }

            setTimeout(() => {
                showHideNotifyBadge(false);
            }, 1500);
        });

        // Mark all notification clicked
        $('#mark-all-read').click(function() {
            sendMarkRequest();
        });
    });

    const getNotifications = async (loadmore = false, notify_id = null) => {
        let paramX = '';
        if (notify_id) {
            paramX = `&notify_id=${notify_id}`; 
            loadmore = 'new_notif';
        }

        if (loadmore === false) {
            $('#div-notify').html(`
                <div class="text-center">
                    <a href="#" class=" btn text-primary">Loading...</a>
                </div>
            `);
        }

        if (lastPageReached && loadmore !== 'new_notif') {
            console.log("End of page!");
            return;
        }

        $('#load-more').attr({"disabled": true}).text('Loading...');

        await axios.get(`${vars.apiURL}/notifications/get?page=${loadmore !== 'new_notif' ? ++curPage : 1}${paramX}`)
            .then(function (response) {
                const { data } = response.data;
                // console.log(data);

                if (data.meta_data.pagging.next_page_url == null && loadmore !== 'new_notif') {
                    lastPageReached = true;
                }

                renderNotification(data, loadmore);
            })
            .catch(function (error) {
                console.log(error);
        });

        $('#load-more').attr({"disabled": false}).text('Load More');
    }

    const renderNotification = (data = {}, loadmore = false) => {
        let template = [];
        let { payloads, meta_data } = data;
        payloads = payloads || [];

        if (loadmore === 'new_notif') {
            showHideNotifyBadge(true);
        }

        setNotifyCounter(meta_data.unread_notification);

        if (!payloads.length && loadmore === true) {
            --curPage;
            return;
        }

        if (!payloads.length && loadmore === false) {
            $('#div-notify').html('');
            $('#div-notify-footer').html(`
                <div class="text-center">
                    <a href="#" class=" btn text-primary">There are no notifications</a>
                </div>
            `);

            return;
        }

        $.each(payloads, function(index, value) {
            // Avoid double notification rendered
            if (!tempNotifyIds.includes(value.id)) {
                tempNotifyIds.push(value.id);
                template.push(notifytemplate($('#div-notify').attr('data-template'), value));
            }
        });
        
        template = template.join('')
        if (loadmore === false) {
            $('#div-notify').html(template);
        } else if (loadmore === true) {
            $('#div-notify').append(template);
        } else if (loadmore === 'new_notif') {
            $('#div-notify').prepend(template);
        }

        if (loadmore === false || loadmore === 'new_notif') {
            $('#div-notify-footer').html(`
                <div class="text-center">
                    <a href="javascript:void(0);" class=" btn text-primary" id="load-more">Load More</a>
                </div>
            `);
        }

        if (loadmore !== 'new_notif') {
            scrollSmoothlyToBottom('div-notify');
        }
    }

    const notifytemplate = (type = null, value) => {
        switch (type) {
            case '1':
                return `
                    <div class="${!value.has_read ? 'unread-notification' : ''}">
                        <a href="javascript:void(0)" data-url="${value.details.notify_url || ''}" data-hasreads="${value.has_read}" data-id="${value.id}" id="notify-data">
                            <div class="d-flex align-items-center px-3 py-2 border-bottom link-notification">
                                <div>
                                    <h6 class="mb-2">${value.details.notify_message}</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="mb-0 text-dark text-line-1">${value.created_at}</small>
                                        <small class="float-right font-size-12 text-dark text-line-1">${value.formated_created_at}</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>`;
            default:
                return `
                    <div class="dop-bg p-0 ${!value.has_read ? 'bg-primary-thin' : ''} ">
                        <a href="javascript:void(0)" data-url="${value.details.notify_url || ''}" data-hasreads="${value.has_read}" data-id="${value.id}" id="notify-data" class="iq-sub-card ">
                            <div class="d-flex align-items-center ps-3 pe-3 pt-3 mb-1">
                                <div class="ms-0 w-100 ">
                                    <h6 class="mb-0 text-primary">${value.details.notify_message}</h6>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="mb-0 text-dark">${value.created_at} </span>
                                        <span class="float-right font-size-12 text-primary">${value.formated_created_at}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>`;
        }
    }

    const sendMarkRequest = async (id = null, el = null) => {
        if(!id) {
            let unreadCount = $("#notification-drop").attr('data-unread');
            if (unreadCount == 0) {
                return;
            }

            $('#mark-all-text').text('Loading...');
        }

        if (id) {
            let hasRead = $(el).attr('data-hasreads');
            if (hasRead === 'true') {
                let redirUrl = $(el).attr('data-url');
                if (redirUrl !== '') {
                    location.href = redirUrl;
                }
                return;
            }
        }

        await axios.put(`${vars.apiURL}/notifications/mark-as-read`, { id })
            .then(function (response) {
                const { data } = response.data;

                if (!id) {
                    // Mark all as read
                    $("#div-notify").find('.bg-primary-thin').removeClass('bg-primary-thin');
                    $("#div-notify").find('.unread-notification').removeClass('unread-notification');
                    $("#notification-drop").removeClass('pe-0');
                    $("#notif-badge").hide();
                } else {
                    // Mark single notif as read
                    $(el).removeClass('bg-primary-thin');
                    $(el).removeClass('unread-notification');
                }

                setNotifyCounter(data.unread_notification);
            })
            .catch(function (error) {
                console.log(error);
            });

        if (id) {
            let redirUrl = $(el).attr('data-url');
            if (redirUrl !== '') {
                location.href = redirUrl;
            }

            return;
        } 

        $('#mark-all-text').text('Mark All as Read');
    }

    const setNotifyCounter = (counter) => {
        $("#notif-count").html(counter);
        $("#notification-drop").attr({'data-unread': counter});
    }

    const showHideNotifyBadge = (show) => {
        if (show === true || show === 'true') {
            if (!$("#notification-drop").hasClass("pe-0")) {
                $("#notification-drop").addClass('pe-0');
            }
            $("#notif-badge").show();
            sessionStorage.setItem('isNotifBadgeShow', true);
        } else {
            if ($("#notification-drop").hasClass("pe-0")) {
                $("#notification-drop").removeClass('pe-0');
            }
            $("#notif-badge").hide();
            sessionStorage.setItem('isNotifBadgeShow', false);
        }
    }

    /* Load more comment */
    $(document).on('click', '#load-more', function(e) {
        getNotifications(true);
    });
    
    /* Notify list clicked */
    $(document).on('click', '#notify-data', function(e) {
        sendMarkRequest($(this).attr('data-id'), this);
    });

})(jQuery);
