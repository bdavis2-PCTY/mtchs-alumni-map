// Handles all communication with MTCHS web server (talking with database)

// a: the function we want to call on the server 
// params: an object that sends additional parameters to the server 
// successHandler: optional callback function. If a valid function, the request will run async otherwise the request runs sync.
function ajaxRequest(a, params, successHandler) {

	var data = {
        a: a
    }

	// Combine 'params' and 'data' objects
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