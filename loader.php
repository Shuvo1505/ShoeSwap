<?php require 'php/ping_test.php'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <style>
    /* Loader overlay */
    #loader-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255,255,255,0.8);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      display: none;
    }

    /* loader animation */
    .loader {
      width: 50px;
      aspect-ratio: 1;
      border-radius: 50%;
      border: 8px solid #0000;
      border-right-color: rgb(121, 137, 137);
      position: relative;
      animation: l24 1s infinite linear;
    }

    .loader:before,
    .loader:after {
      content: "";
      position: absolute;
      inset: -8px;
      border-radius: 50%;
      border: inherit;
      animation: inherit;
    }

    .loader:before {
      animation-duration: 2s;
    }

    .loader:after {
      animation-duration: 4s;
    }

    @keyframes l24 {
      100% { transform: rotate(1turn) }
    }
  </style>
</head>
<body>

<!-- Loader HTML -->
<div id="loader-overlay">
  <div class="loader"></div>
</div>

<!-- Script function -->
<script>
  function showLoaderThenRedirect(url) {
  document.getElementById('loader-overlay').style.display = 'flex';
  setTimeout(() => {
    window.location.replace(url);
  }, 500);
}

window.onload = function () {
  const registerLink = document.getElementById('register-link');
  const forgotLink = document.getElementById('forgot-link');
  const loginLink = document.getElementById('login-link');
  const payment = document.getElementById('pay_btn');

  if (registerLink) {
    registerLink.addEventListener('click', function(e) {
      e.preventDefault();
      showLoaderThenRedirect('registration.php');
    });
  }

  if (forgotLink) {
    forgotLink.addEventListener('click', function(e) {
      e.preventDefault();
      showLoaderThenRedirect('forgotpass.php');
    });
  }

  if (loginLink) {
    loginLink.addEventListener('click', function(e) {
      e.preventDefault();
      showLoaderThenRedirect('login.php');
    });
  }
};
// Ensure loader is hidden on page show (back/forward cache)
window.addEventListener('pageshow', function () {
  document.getElementById('loader-overlay').style.display = 'none';
});

</script>

</body>
</html>
