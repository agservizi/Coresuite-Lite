<?php
$fontAwesomeLocalPath = __DIR__ . '/../../../public/assets/vendor/fontawesome/css/all.min.css';
$fontAwesomeHref = is_file($fontAwesomeLocalPath)
    ? $assetBase . '/vendor/fontawesome/css/all.min.css'
    : 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css';
?>
<link rel="stylesheet" href="<?php echo htmlspecialchars($fontAwesomeHref); ?>">
