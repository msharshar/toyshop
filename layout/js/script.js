const round = (n, d) => Number(Math.round(n + "e" + d) + "e-" + d)

$('.buy').click(function(){

    $(this).parent().parent().addClass("clicked");

    var productID = $(this).next().val();

    var xmlhttp;
    xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "ajax/addtocart.php?product_id="+productID, false);
    xmlhttp.send();

});
  
$('.remove').click(function(){
    $('.bottom').removeClass("clicked");
});