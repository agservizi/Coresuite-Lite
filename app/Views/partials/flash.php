<!-- app/Views/partials/flash.php -->
<?php if (isset($_SESSION['flash'])): ?>
<?php
    $type = $_SESSION['flash']['type'] ?? 'info';
    $msg = htmlspecialchars($_SESSION['flash']['message'] ?? '');
    switch ($type) {
        case 'success': $cls = 'bg-green-50 border-green-200 text-green-800'; break;
        case 'danger': $cls = 'bg-red-50 border-red-200 text-red-800'; break;
        case 'warning': $cls = 'bg-yellow-50 border-yellow-200 text-yellow-800'; break;
        default: $cls = 'bg-blue-50 border-blue-200 text-blue-800';
    }
?>
<div class="border px-4 py-3 rounded mb-4 <?php echo $cls; ?>">
    <div class="flex justify-between items-start">
        <div><?php echo $msg; ?></div>
        <button class="ml-4 text-gray-500 flash-dismiss">&times;</button>
    </div>
</div>
<?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="border px-4 py-3 rounded mb-4 bg-red-50 border-red-200 text-red-800">
    <div class="flex justify-between items-start">
        <div><?php echo htmlspecialchars($error); ?></div>
        <button class="ml-4 text-gray-500 flash-dismiss">&times;</button>
    </div>
</div>
<?php endif; ?>

<?php if (isset($message)): ?>
<div class="border px-4 py-3 rounded mb-4 bg-green-50 border-green-200 text-green-800">
    <div class="flex justify-between items-start">
        <div><?php echo htmlspecialchars($message); ?></div>
        <button class="ml-4 text-gray-500 flash-dismiss">&times;</button>
    </div>
</div>
<?php endif; ?>