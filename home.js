function openForm(eventName, eventDate, price) {
  // Check if the event date has passed
  const currentDate = new Date();
  const eventDateObj = new Date(eventDate);
  
  if (currentDate > eventDateObj) {
    alert("Sorry, this event has already passed. You cannot buy tickets.");
    return;
  }

  // Update form title dynamically
  document.querySelector("#ticket-form h2").innerText = `Buy Ticket - ${eventName}`;

  // Fill in the form details
  document.getElementById('event-date').value = eventDate;
  document.getElementById('price').value = price + ' Ksh';
  
  // Show the form
  document.getElementById('ticket-form').style.display = 'block';
}

function closeForm() {
  document.getElementById('ticket-form').style.display = 'none';
}
