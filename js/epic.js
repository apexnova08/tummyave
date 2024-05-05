// # MODAL
var modal = document.getElementById("epicModal");
var span = document.getElementsByClassName("epic-modal-close")[0];

function epicOpenModal() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}