<?php
require 'ping_test.php';
$host = "localhost";
$username = "root";
$password = "";
$dbname = "shoeswap";

if ($_SESSION["status"] === "active"){

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM shoes WHERE status='Listed'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "
    <div class='container my-4'>
        <h3 class='mb-4'>Most Trending</h3>
        <div id='productContainer'>";

    $count = 0;
    $rowIndex = 0;

    while ($row = $result->fetch_assoc()) {
        $percentageDifference = (($row['purchase_price'] - $row['selling_price']) / $row['purchase_price']) * 100;

        // Start a new row every 4 items
        if ($count % 4 == 0) {
            if ($count != 0) echo "</div>"; // Close previous row
            echo "<div class='row product-row mb-4' data-row-index='$rowIndex' " . ($rowIndex >= 4 ? "style='display:none;'" : "") . ">";
            $rowIndex++;
        }

        echo "
            <div class='col-md-3 mb-4'>
                <div class='card product-card shadow-sm position-relative'>
                    <span class='badge bg-danger position-absolute m-2'>" . round($percentageDifference, 2) . "% Off</span>
                    <a href='product_page.php?id=" . $row["id"] . "' style='text-decoration: none; color: inherit;'>
                        <img src='seller/php/" . $row['image_url'] . "' class='card-img-top product-image' alt='Product Image'>
                        <div class='card-body product-body'>
                            <h6 class='text-muted mb-1'>" . $row["brand"] . "</h6>
                            <h5 class='card-title'>" . $row["type"] . "</h5>
                            <div class='d-flex justify-content-between align-items-center'>
                                <span class='h6 text-primary mb-0'>₹ " . $row["selling_price"] . "</span>
                                <div>
                                    <i class='bi bi-star-fill text-warning'></i>
                                    <i class='bi bi-star-fill text-warning'></i>
                                    <i class='bi bi-star-fill text-warning'></i>
                                    <i class='bi bi-star-fill text-warning'></i>
                                    <i class='bi bi-star-half text-warning'></i>
                                    <small class='text-muted'>(4.5)</small>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class='card-footer d-flex justify-content-between bg-light product-footer'>
                        <form action='php/add_to_order.php' method='post'>
                            <input type='hidden' name='product_id' value='" . $row["id"] . "'>
                            <button type='submit' class='btn btn-primary btn-sm'>Add to Cart</button>
                        </form>
                        <form action='php/add_to_wishlist.php' method='post'>
                            <input type='hidden' name='product_id' value='" . $row["id"] . "'>
                            <button type='submit' class='btn btn-outline-secondary btn-sm'><i class='bi bi-heart'></i></button>
                        </form>
                    </div>
                </div>
            </div>";

        $count++;
    }

    echo "</div>"; // Close the last row

    echo "
        </div> <!-- #productContainer -->

        <div class='text-center mt-4'>
            <button class='btn btn-outline-primary' id='seeMoreBtn'>See More</button>
        </div>
    </div>";
} else {
    echo "
    <p class='text-center mt-5'><strong>Sorry, no products are available right now!</strong>
    </p>
    ";
    }
}
?>

<!-- Style for consistent cards -->
<style>
    .product-card {
        min-height: 22rem;
        max-height: 22rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-image {
        height: 10rem;
        object-fit: cover;
    }

    .product-body {
        height: 10rem;
        overflow: hidden;
    }

    .product-footer {
        height: 4rem;
    }
</style>

<!-- Script to reveal more rows -->
<script>
    let currentVisibleRows = 4;
    document.getElementById('seeMoreBtn').addEventListener('click', function () {
        let rows = document.querySelectorAll('.product-row');
        let shown = 0;
        for (let i = currentVisibleRows; i < rows.length && shown < 2; i++) {
            rows[i].style.display = 'flex';
            shown++;
            currentVisibleRows++;
        }

        if (currentVisibleRows >= rows.length) {
            this.style.display = 'none';
        }
    });
</script>
