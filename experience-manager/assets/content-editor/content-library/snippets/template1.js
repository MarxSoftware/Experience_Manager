function exm_ecom_add_to_basket($target, product_id, product_sku) {
     
    var $thisbutton = jQuery($target);
    var data = {
        'product_sku': product_sku,
        'product_id': product_id,
        'quantity': 1
    };
    jQuery(".product[data-exm-product-id=" + product_id + "] .button").toggleClass("loader");
    jQuery(".product[data-exm-product-id=" + product_id + "] .button").toggleClass("disabled");
     
    EXM.WOO.addToBasket(product_id, product_sku, 1, (response) => {
        let notify_class = "success";
        if (response.error) {
            notify_class = "failure";
        }
        jQuery(".product[data-exm-product-id=" + product_id + "] .notify").toggleClass("active");
        jQuery(".product[data-exm-product-id=" + product_id + "] .notify span").toggleClass(notify_class);
        setTimeout(function () {
            jQuery(".product[data-exm-product-id=" + product_id + "] .notify").removeClass("active");
            jQuery(".product[data-exm-product-id=" + product_id + "] .notify span").removeClass(notify_class);
        }, 2000);
        jQuery(".product[data-exm-product-id=" + product_id + "] .button").removeClass("loader");
        jQuery(".product[data-exm-product-id=" + product_id + "] .button").removeClass("disabled");
    });
}