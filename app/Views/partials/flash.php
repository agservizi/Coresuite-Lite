<!-- app/Views/partials/flash.php -->
<?php if (isset($_SESSION['flash'])): ?>
<div class="notification is-<?php echo htmlspecialchars($_SESSION['flash']['type'] ?? 'info'); ?> is-light">
    <button class="delete flash-dismiss"></button>
    <?php echo htmlspecialchars($_SESSION['flash']['message'] ?? ''); ?>
</div>
<?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="notification is-danger is-light">
    <button class="delete flash-dismiss"></button>
    <?php echo htmlspecialchars($error); ?>
</div>
<?php endif; ?>

<?php if (isset($message)): ?>
<div class="notification is-success is-light">
    <button class="delete flash-dismiss"></button>
    <?php echo htmlspecialchars($message); ?>
</div>
<?php endif; ?>