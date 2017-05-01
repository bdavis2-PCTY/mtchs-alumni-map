// Google Map API key
// Look into it if something stops working
var API_KEY = "AIzaSyB_Dc8-cwVHWI9bG7fmyO5Qkqr7_ZeLXG0";

var map, overlay, studentSelector, studentView, waiting = false, newForm;

$(document).ready(function() {
    // Semantic UI toggles
    $('.ui.uiPopup').popup();
    $('.ui.accordion').accordion();

    // Common page elements
    overlay = $("#overlay");
    studentSelector = $("#popoutStudentSelect");
    studentView = $("#popoutWrapper");
    newForm = $("#newEntryForm");

        $("#formerGraduateButton").click(function() {
			$("#entireNewEntryForm").show();
			$("#successMessage, #errorMessage").hide();
            showPanel(newForm)
        });

	var gradYearHTML = "";	
	var currentYear = new Date().getFullYear();
    for (var i = currentYear; i >= 1999; i--) {
		if ( i === currentYear ){
			var month = new Date().getMonth() + 1;
			if ( month < 5 )
				continue;
		}
		
        gradYearHTML += '<option value=' + i + '>' + i + '</option>';
    }
	$("#newEntryGradYear").html(gradYearHTML);
	

    $('#graduationYearDropdown').dropdown({
        onChange: function() {
            if ($('#graduationYearDropdown').hasClass('active')) {
                $('#graduationYearDropdown .menu').css('display: inline-block');
            } else {
                $('#graduationYearDropdown .menu').css('display: none');
            }
        }
    });

    $('#graduationYearDropdown').dropdown('set selected', '2016');

    $('#testtestet').dropdown();

    setTimeout(function() {
        $('.ui.dropdown').dropdown();
        $('#graduationYearDropdown').dropdown();
        $('#highestEducationDropdown').dropdown();
    }, 1000);

    // Click handler for closing
    overlay.click(function() {
        hidePanel();
    });

    $(window).on('load', function() {
        $("#loadingSpinner").fadeOut();
    });
});


function initMap() {

    // Create the map over the United States
    map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: 40,
            lng: -97
        },
        zoom: 5
    });

    // Create MTCHS marker
    //https://maps.googleapis.com/maps/api/geocode/json?address=Meridian%20Technical%20Charter%20High%20School&key=" + API_KEY
    /*new google.maps.Marker({
        position: {
            lat: 43.6391189,
            lng: -116.3733244
        },
        map: map,
        label: "MTCHS"
    });*/

    loadCityMarkers();

}

// Loads the markers on the map
var cityMarkers = {};

function loadCityMarkers() {

    // Call AJAX to load the locatjions
    var response = ajaxRequest("CityLocations");

    // Add markers from server response to map
    var data = JSON.parse(response);
    for (var i = 0; i < data.length; i++) {
        var a = data[i];

        // Only 1 marker per city (should be handled with SQL query but this is just to ensure)
        if (typeof cityMarkers[a.city] === "undefined") {

            // Create the marker
            cityMarkers[a.city] = new google.maps.Marker({
                position: {
                    lat: parseFloat(a.latitude),
                    lng: parseFloat(a.longitude)
                },
                map: map
            });

            // Add clicking listener to open the student list
            cityMarkers[a.city].addListener("click", function() {
                for (var cityName in cityMarkers) {
                    if (cityMarkers[cityName] == this) {
                        viewStudentsInCity(cityName);
                    }
                }
            });
        }
    }

}

// Opens a panel viewing all students in the given city
function viewStudentsInCity(cityName) {
    try {
        ajaxRequest("StudentsInCity", {
            City: cityName
        }, function(data) {

            // Process all results
            var str = "";
            for (var index in data) {
                var g = data[index];
                str += '<div class="studentBlock waves-effect waves-red" onclick="viewStudentFromId(' + g.id + ')">' +
                    '<div class="name">' + g.name + '</div>' +
                    '<div class="gradYear">' + g.gradYear + '</div>' +
                    '<div class="circle"> </div>' +
                    '<div class="location">' + g.location + '</div>' +
                    '</div>';
            }

            // Show the panel & set data
            showPanel(studentSelector);
            studentSelector.html(str);
        });
    } catch (ex) {
        alert("Error loading students in " + cityName + ": " + ex);
    }
}

// Show a panel
function showPanel(panelSelector) {
    if (!(panelSelector instanceof jQuery)) {
        console.warn("showPanel - type " + typeof panelSelector + " is not a jquery object");
        console.log(panelSelector);
        return;
    }

    waiting = true;

    // Determin ending positition for animation
    var goTo;
    switch (panelSelector) {
        case studentView:
            goTo = studentSelector.width();
            break;
        default:
            goTo = 0;
            break;
    }

    // Show overlay
    overlay.fadeIn();

    var resetData = {
        right: panelSelector.width() * -1,
        opacity: 0
    };

    var toData = {
        right: (goTo + "px"),
        opacity: 1
    };

    // Animate & show panel
    return panelSelector.css(resetData).show().animate(toData, 'slow').promise().then(function() {
        waiting = false;
    });
}

// Hides any panel that is being displayed
function hidePanel(panelSelector, hideOverlay) {
    if (panelSelector != null && (!panelSelector instanceof jQuery)) {
        console.warn("hidePanel - type " + typeof panelSelector + " is not a jquery object");
        console.log(panelSelector);
        return;
    }

    // Automatically select the top one if none were passed as a paramater
    if (panelSelector == null) {
        if (studentView.is(":visible"))
            return hidePanel(studentView, false);
        else if (studentSelector.is(":visible"))
            return hidePanel(studentSelector);
        else if (newForm.is(":visible"))
            return hidePanel(newForm);
        else
            return false;
    }

	waiting = true;
	
    // If the panel isn't visible, just finish
    if (!panelSelector.is(":visible")) {
        waiting = false;
        return panelSelector.animate({}).promise();
    }

    // Hide the overlay if none
    if ((hideOverlay == null || typeof hideOverlay === "undefined" || hideOverlay == true) && hideOverlay != false)
        overlay.fadeOut();

    // Calculate goTo position
    var goTo = 0;
    switch (panelSelector) {
        case studentView:
            goTo = 0;
            break;
        default:
            goTo = (pixelToInt(panelSelector.css("width")) * -1) + "px";
            break;
    }

    var toData = {
        right: goTo,
        opacity: 0,
        easing: "linear"
    };

    // Animate and hide panel
    return panelSelector.animate(toData, 'slow').promise().then(function() {
        waiting = false;
        panelSelector.hide();
    });
}

// Gets data from the server then populates & opens student view form
function viewStudentFromId(id) {
    if (waiting)
        return;

    if (studentView.is(":visible")) {
        return hidePanel(studentView, false).then(function() {
            viewStudentFromId(id);
        });
    } else {
        ajaxRequest("StudentFromId", {
            Id: id
        }, populateStudentView);
        showPanel(studentView);
    }
}

// Populates the student viewing form with db response
function populateStudentView(student) {
    $(".employed").show();
    $("#dataName").html(student.name);
    $("#dataGradYear").html(student.gradYear);
    $("#dataLivesIn").html(student.location);
    $("#dataEducation").html(student.highestEducation);

    if (student.job == null || student.job === "")
        $(".employed").hide();
    else
        $("#dataJob").html(student.job);
}


// Converts jQuery .width() or .height() to single int
// (Eg. convert 120px to 120)
function pixelToInt(pixel) {
    var pixel = (pixel + "");
    if (!pixel.endsWith("px")) {
        try {
            return parseInt(pixel);
        } catch (e) {
            return pixel;
        }
    }

    return parseInt(pixel.substring(0, pixel.length - 2));
}


function onNewEntrySubmit(){
	$("#successMessage, #errorMessage").hide();
	
	var errors = [];
	var name = ($("#newEntryName").val()+"");
	var city = ($("#newEntryCity").val()+"");
	var state = ($("#newEntryState").val()+"");
	var job = ($("#newEntryJobTitle").val()+"");
	var salary = ($("#newEntrySalary").val()+"");
	var education = ($("#newEntryEducation").val()+"");
	var gradYear = ($("#newEntryGradYear").val()+"");
	var errorMessage;
	
	if ( name.trim() === "")
		errors.push("Name is a required field");
	
	if ( city.trim() === "")
		errors.push("City is a required field");
	
	if ( state.trim() === "")
		errors.push("State is a required field");
	
	if ( gradYear.trim() === "")
		errors.push("Graduation year is a required field");
	
	if ( education.trim() === "")
		errors.push("Education is a required field");
	
	if ( errors.length > 0 ) {
		var str = "";
		
		for ( var i in errors ) {
			str += "<li>" + errors[i] + "</li>";
		}
		
		$("#errorMessage").show().find("p").first().html("<ul>" + str + "</ul>");
		errorMessage = null;
		return false;
	}
	
	var data = { 
		Name: name, 
		City: city,
		State: state,
		Job: job,
		GradYear: gradYear,
		Education: education,
		Salary: salary
	};
	
	var callback = function(response){
		$("#successMessage").show();
		$("#entireNewEntryForm").hide();
		resetNewEntryForm();
	}
	
	ajaxRequest("New", data, callback);
}

function resetNewEntryForm(){
	$("#newEntryName, #newEntryCity, #newEntryState, #newEntryJobTitle, #newEntrySalary").val("");
}