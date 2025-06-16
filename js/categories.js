var cards = document.querySelectorAll('.product-box');

[...cards].forEach((card)=>{
    card.addEventListener('mouseover', function(){
        card.classList.add('is-hover');
    })
    card.addEventListener('mouseleave', function(){
        card.classList.remove('is-hover');
    })
})
// ------------- Filter Product
$(document).ready(function () {
    // Run filter on any dropdown change inside #filterForm
    $("#filterForm select").change(function () {
      filterProducts();
    });

    function filterProducts() {
      // Get selected values
      var type = $("#type").val();
      var category = $("#category").val();
      var shoe_usage = $("#shoe_usage").val();
      var size = $("#size").val();
      var gender = $("#gender").val();
      var priceRange = $("#price").val();

      // Loop through product cards
      $(".product-card").each(function () {
        var product = $(this);
        var show = true;

        // Get product data attributes
        var pType = product.data("type");
        var pCategory = product.data("category");
        var pUsage = product.data("shoe_usage");
        var pSize = product.data("size");
        var pGender = product.data("gender");
        var pPrice = parseFloat(product.data("price"));

        // Check attribute filters
        if (type && pType !== type) show = false;
        if (category && pCategory !== category) show = false;
        if (shoe_usage && pUsage !== shoe_usage) show = false;
        if (size && pSize !== size) show = false;
        if (gender && pGender !== gender) show = false;

        // Price range filtering
        if (priceRange && !isNaN(pPrice)) {
          if (priceRange === "0-1000" && !(pPrice >= 0 && pPrice <= 1000)) show = false;
          if (priceRange === "1000-3000" && !(pPrice > 1000 && pPrice <= 3000)) show = false;
          if (priceRange === "3000-9000" && !(pPrice > 3000 && pPrice <= 9000)) show = false;
          if (priceRange === "9000+" && !(pPrice > 9000)) show = false;
        }

        // Show or hide product
        product.toggle(show);
      });
    }
  });