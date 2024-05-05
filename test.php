<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
include 'global/customercss.html';
?>
</head>
<body>

<h2>Animated Modal with Header and Footer</h2>

<!-- Trigger/Open The Modal -->
<button onclick="epicOpenModal()">Open Modal</button>

<!-- The Modal -->
<div id="epicModal" class="epic-modal">

  <!-- Modal content -->
  <div class="epic-modal-content">
    <div class="epic-modal-header">
      <span class="epic-modal-close">&times;</span>
      <h2>Modal Header</h2>
    </div>
    <div class="epic-modal-body">
      <p>Some text in the Modal Body</p>
      <p>Some other text...</p>
    </div>
    <div class="epic-modal-footer">
      <h3>Modal Footer</h3>
    </div>
  </div>

</div>

<?php 
include 'global/customerjs.html';
?>

</body>
</html>
