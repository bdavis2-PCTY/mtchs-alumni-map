// Handles all communication with MTCHS web server (talking with database)
function ajaxRequest(a, params, successHandler) {
    var data = {
        a: a
    }

    if (typeof params === "object" && params != null) {
        for (var i in params) {
            data[i] = params[i];
        }
    }

    if (successHandler != null && typeof successHandler === "function") {
        // Async response
        return $.ajax({
            url: "/alumni/ajaxHandler.php",
            method: "POST",
            dataType: "json",
            data: data,
            success: successHandler
        });
    } else {
        // Sync. response
        return $.ajax({
            url: "/alumni/ajaxHandler.php",
            method: "POST",
            dataType: "json",
            async: false,
            data: data
        }).responseText;
    }
}