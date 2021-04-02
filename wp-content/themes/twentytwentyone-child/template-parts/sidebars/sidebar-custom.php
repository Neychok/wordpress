<aside id="sidebar-custom" class="sidebar">
    <?php if ( is_active_sidebar( 'custom' ) ) : ?>
        <?php dynamic_sidebar( 'custom' ); ?>
    <?php else : ?>
        <!-- Time to add some widgets! -->
    <?php endif; ?>
</aside>