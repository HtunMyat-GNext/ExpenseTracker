import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin, { Draggable } from "@fullcalendar/interaction";
import googleCalendarPlugin from "@fullcalendar/google-calendar";

document.addEventListener("DOMContentLoaded", function () {
    var containerEl = document.getElementById("external-events");
    var calendarEl = document.getElementById("calendar");

    // Initialize the external events
    new Draggable(containerEl, {
        itemSelector: "#fc-event",
        eventData: function (eventEl) {
            var eventData = JSON.parse(eventEl.getAttribute("data-event"));
            return {
                title: eventData.title,
                color: eventData.color,
            };
        },
    });

    // Initialize the calendar
    var calendar = new Calendar(calendarEl, {
        plugins: [
            dayGridPlugin,
            timeGridPlugin,
            interactionPlugin,
            googleCalendarPlugin,
        ],

        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        // events: fetchEvents, // Fetch events from the server
        eventSources: [
            {
                events: fetchEvents, // Fetch local events from the server
                editable: false,
            },
            {
                googleCalendarId: "gnext.yanmyoaung@gmail.com",
                className: "gcal-event", // an option!
                googleCalendarApiKey: "AIzaSyCnhOppCfntsZgJbt5BcEfXfx-MNHcxju0",
                format: "json",
            },
        ],
        editable: false, // disabled draggable on calendar events
        droppable: true, // Allows things to be dropped onto the calendar

        // Delete if event clicked
        eventClick: function (info) {
            info.jsEvent.preventDefault();

            if (info.event.url == "")
                // Show the delete event modal
                $("#deleteEventModal").removeClass("hidden");

            // Set up event deletion on confirmation
            $("#confirmDeleteBtn").on("click", function () {
                eventDelete(info.event.id);
                $("#deleteEventModal").addClass("hidden");
            });

            // Set up cancel action using jQuery
            $('[data-dismiss="modal"]').on("click", function () {
                $("#deleteEventModal").addClass("hidden");
            });
        },

        // Save data to calendar if event is dropped onto calendar
        eventReceive: function (info) {
            // Event data
            let eventData = JSON.parse(info.draggedEl.dataset.event);
            let eventDate = info.event.startStr;

            // Remove the event immediately after it's dropped
            info.event.remove();

            // AJAX request to save event data
            saveEvent(eventData, eventDate, function () {
                calendar.refetchEvents();
            });
        },
    });

    // Fetch created events from the server
    function fetchEvents(info, successCallback, failureCallback) {
        $.ajax({
            url: calendarUrls.fetchEvents, // Fetch events route
            type: "GET",
            success: function (data) {
                successCallback(data);
            },
            error: function (xhr, status, error) {
                failureCallback(error);
            },
        });
    }

    // Function to save event data
    function saveEvent(eventData, date, refetch) {
        $.ajax({
            url: calendarUrls.storeEvent,
            type: "POST",
            data: {
                _token: calendarUrls.csrfToken,
                event_id: eventData.id,
                date: date,
            },
            success: function (data) {
                console.log("Event saved successfully:", data);
                refetch();
            },
            error: function (xhr, status, error) {
                console.log("AJAX error: " + status + " : " + error);
            },
        });
    }

    // Delete event
    function eventDelete(eventId) {
        var url = calendarUrls.deleteEvent.replace("id", eventId);
        $.ajax({
            url: url,
            type: "DELETE",
            data: {
                _token: calendarUrls.csrfToken,
                id: eventId,
            },
            success: function (data) {
                console.log("Event deleted successfully:", data);
                calendar.refetchEvents();
            },
            error: function (xhr, status, error) {
                console.log("AJAX error: " + status + " : " + error);
            },
        });
    }

    // Render the calendar
    calendar.render();
});
