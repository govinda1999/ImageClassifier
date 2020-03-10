$(document).ready(function() {
  var fetch_classifier = () =>{
    $.ajax({
      url:'action.php',
      method:'POST',
      data:{fetch_classifier:1},
      success:data =>{
        $('#classifier').html(data);
      }
    });
  }
  fetch_classifier();
});
