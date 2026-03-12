const form = document.getElementById('complaintForm');

form.addEventListener('submit', function(e) {
    const email = document.getElementById('emailInput').value;
    const message = document.getElementById('textInput').value;

    if (message.length < 10) {
        e.preventDefault(); //
        alert("Votre message est trop court pour être traité par le Maestro.");
    }
});