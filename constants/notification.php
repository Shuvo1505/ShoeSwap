<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div aria-live="polite" aria-atomic="true">
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="toast align-items-center text-bg-<?php echo $_SESSION['message']['type']; ?> border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $_SESSION['message']['text']; ?>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>

            <?php unset($_SESSION['message']); ?> <!-- Remove message after displaying -->
        <?php endif; ?>

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastElement = document.querySelector('.toast');
        if (toastElement) {
            var toast = new bootstrap.Toast(toastElement, {
                delay: 4000 // Show toast for 4 seconds
            });
            toast.show();
        }
    }); 
</script>