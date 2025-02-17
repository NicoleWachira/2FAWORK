function openCreateEvent() {
    document.getElementById("createEvent").style.display = "block";
}

function openUpdateEvent() {
    document.getElementById("updateEvent").style.display = "block";
}

function openDeleteEvent() {
    document.getElementById("deleteEvent").style.display = "block";
}

function closeCreateEvent() {
    document.getElementById("createEvent").style.display = "none";
}

function closeUpdateEvent() {
    document.getElementById("updateEvent").style.display = "none";
}

function closeDeleteEvent() {
    document.getElementById("deleteEvent").style.display = "none";
}

// Close modal when clicking outside
window.onclick = function(event) {
    let modals = document.querySelectorAll(".modal");
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
};

