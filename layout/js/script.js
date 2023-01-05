$('.buy').click(function(){

    $(this).parent().parent().addClass("clicked");

    var productID = $(this).next().val();

    var xmlhttp;
    xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "ajax/addtocart.php?product_id="+productID, false);
    xmlhttp.send();

});
  
$('.remove').click(function(){

    $(this).parent().parent().removeClass("clicked");

    var productID = $(this).next().val();

    var xmlhttp;
    xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "ajax/removefromcart.php?product_id="+productID, false);
    xmlhttp.send();

});
