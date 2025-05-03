import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

Echo.private("App.Models.User." + userId).notification((notification) => {
    // console.log(notification.type);
    toastr.success(notification.msg);

    let $badge = $("#alertsDropdown .badge-counter");
    let notify_count = parseInt($badge.data("count")) || 0;

    notify_count += 1;

    $badge.removeClass("d-none");
    $badge.data("count", notify_count);
    $badge.text(notify_count > 5 ? "5+" : notify_count);
});
