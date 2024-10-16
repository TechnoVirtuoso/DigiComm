
$(document).ready(function(){
    $(".submit_btn").click(function(){
        $(".order_form").submit()
        $("input").text("");
    });

customSelect($(".sf-input-select"));

// $(".sf-field-submit input").click(function(){
//     window.setInterval(function(){
//         customSelect($(".sf-input-select"));
//     }, 2000);
// })

});
// $(".sf-field-submit input").click(function(){
//     $(".search-filter-results ,.sf-field-submit input").addClass("active");
    
// });

$('#pdf_btn').click(function () { 
    doc = jsPDF('p', 'pt', 'a4');
    html2canvas(document.querySelector(".woocommerce")).then(( canvas ) => {
        console.log(canvas);
        var a = doc.addImage(canvas.toDataURL('image/png'), 'PNG', 5, 15, 550,250);
        console.log(a);
        doc.save('Order-Details.pdf');
    
    });
});

// $(".sf-field-submit input,.submit_btn").click(function(){
//     $(".woocommerce_cart,#pdf_btn").css("display", "block");
 

// });

$(".submit_btn ").click(function(){
    $(".no_result").css("display", "block");
});




// $(".search_image").click(function(){
//     $(".search_popup").toggleClass("active");
//     $(this).toggleClass("active");
// }) 
$(".sf-field-submit input").click(function(){
   $(".search-filter-results").addClass("active")
   $(".search_popup").removeClass("active");

});

$(".sf-field-submit input").click(function(){
    window.setInterval(function(){
    $input=[];
    $(".select_btn").click(function(){
        let values = $(this).children().val();
        $(this).children().css("opacity", "0.4");
        $(this).children().attr('disabled','disabled');
        $(this).children().text("Selected");
        $(".product_code").append("<p>"+values+","+"</p>");
        let string = $(".product_code").children().text();
        $("#search_select").val(string);
        $(".select_submit_btn").addClass("active");
        
      
    })
}, 1000);
});








// $(".submit_btn").click(function(){
//     $(".search-filter-results").removeClass("active");
//    });
//    $(".add_to_cart_btn").click(function(){
//        let values = $(this).children().val();
//        console.log(values);
//        $(".product_code").append("<p>"+values+","+"</p>");
//        let string = $(".product_code").children().text();
//        $("#product_id input , #search_select ").val(string);
//    });





$(document).ready(function(){
    $(".category_search").children("ul").addClass("ancestors");
    $(".ancestors").children("li").addClass("ancestor");
    $(".category_search").children("ul").children("ul").addClass("parents");
    $(".parents").children("li").addClass("parent");
    $(".category_search").children("ul").children("ul").children("ul").addClass("childrens");
    $(".childrens").children("li").addClass("children");
    $(".ancestor").click(function(){
        $(this).next("ul").toggleClass("active");
        $(".category_search").addClass("active");
    })
    $(".parent").click(function(){
        $(this).next("ul").toggleClass("active");
        $(".category_search").addClass("active");
    })
    $(".childrens").click(function(){
        $(this).next("ul").toggleClass("active");
        $(".category_search").addClass("active");
    })
    if ($("ul").hasClass("products")) {
        $(".products").removeClass("parents");
        $(".products").removeClass("childrens");
    }
   $(".cancel_image").click(function(){
        $(".childrens , .parents , .products ,.category_search").removeClass("active");
   })
   $(".categories_search_btn").click(function(){
    $(".category_search").addClass("active");
   });


});