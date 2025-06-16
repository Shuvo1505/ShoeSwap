<?php
$host = "www.google.com";
$port = 80;

$fp = @fsockopen($host, $port, $errno, $errstr, 3);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
if (!$fp) {
    echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'No Internet Connection',
            text: 'Please connect to the internet and refresh this page!',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            showConfirmButton: false
        });
    </script>
    ";
}
?>
</body>
</html>
