<?php
/*
* Template Name: Homepage
* description: Homepage template
*/
?>
<!DOCTYPE html>
<?php
    
    get_header();
    
    while(have_posts()) {
        the_post();
?>

        <!-- Main Content -->
        <main class="main-content centre-content">
            <h2 class="heading"><?php echo get_the_title(); ?></h2>
            <?php the_content(); ?>
        </main>

<?php
    }
        get_footer();
?>
    </div>
</body>
</html>