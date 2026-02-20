<!-- app/Views/partials/breadcrumbs.php -->
<nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
        <li><a href="/dashboard">Home</a></li>
        <li class="is-active"><a href="#" aria-current="page"><?php echo $pageTitle ?? 'Dashboard'; ?></a></li>
    </ul>
</nav>