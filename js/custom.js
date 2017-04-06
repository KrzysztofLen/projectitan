$(document).ready(function () {

$("#sending-btn").click(function() {

  $('input').each(function() {
    var value = $(this).val();

    if (value == "") {
      alert('Wypełnij wszystkie pola');
      return false;
    }
  })


})

$("#sending-btn1").click(function() {

  $('input').each(function() {
    var value = $(this).val();

    if (value == "") {
      alert('Wypełnij wszystkie pola');
      return false;
    }
  })


})



$("#clear").click(function() {
 $("input").val('');
})

});
