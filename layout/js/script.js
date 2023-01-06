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

const round = (n, d) => Number(Math.round(n + "e" + d) + "e-" + d)

$(".cart-product .quantity").change(function(){
    
    
    var productID = $(this).next().next().val();
    var quantity = $(this).val();
    // var productPrice = Number($(this).parent().prev().html().replace('£', ''));
    var productPrice = $(this).next().val();
    var productTotal = round(productPrice * quantity, 2);
    $(this).parent().prev().html("£"+productTotal);

    var subtotal = 0;
    $(".cart-product .price").each(function(){
        subtotal += Number($(this).html().replace('£', ''))
    });
    
    $("#subtotal").html("£"+subtotal);

    var xmlhttp;
    xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "ajax/changequantity.php?product_id="+productID+"&quantity="+quantity, false);
    xmlhttp.send();

})

$(".promocode-btn").click(function(){

    var promocode = $(".promocode").val();
    if(promocode !== "") {
        $(".promocode-success").fadeIn()
        $("#discount").html("15%")
    }else{
        $(".promocode-error").html("Please enter a valid code")
        $(".promocode-error").fadeIn(function(){
            $(this).fadeOut(3000);
        })
    }

});

$(".cart-product .remove-btn").click(function(){

    var productID = $(this).prev().find(".productID").val();
    $(this).parent().parent().parent().fadeOut();
    $(this).parent().parent().parent().next().fadeOut();

    var xmlhttp;
    xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "ajax/removefromcart.php?product_id="+productID, false);
    xmlhttp.send();    

})
