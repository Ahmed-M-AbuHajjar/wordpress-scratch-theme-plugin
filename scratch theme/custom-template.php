<?php
/*
Template Name: custom Template
*/
?>

<?php get_header(); ?>

<body <?php body_class(); ?>>
    <?php do_action('et_pb_body_classes'); ?> 

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            
            <!-- Header Section -->
            <header class="page-header">
                <h1 class="page-title text-center text-secondary">Welcome to custom Template</h1>
            </header>

            <!-- Team Members Section -->
            <section class="team-members-section">
                <div class="team-members-container container">
                    <h2 class='text-danger'>Team member:</h2>
                    <?php
                    // Query Team Members
                    $args = array(
                        'post_type' => 'team_member', 
                        'posts_per_page' => -1 
                    );

                    $team_members = new WP_Query($args);

                    if ($team_members->have_posts()) :
                        while ($team_members->have_posts()) : $team_members->the_post();
                    ?>
                            <div class="team-member-item">
                                <h2><?php the_title(); ?></h2>
                                <?php
                                ?>
                            </div>
                    <?php
                        endwhile;
                        wp_reset_postdata(); 
                    else :
                        echo '<p>No team members found.</p>';
                    endif;
                    ?>
                </div>
            </section>

        </main>
    </div>

<?php get_footer(); ?>

<?php


function enable_divi_builder_on_custom_template($enabled, $post_id) {
    if (is_page_template('custom-template.php')) {
        return true;
    }
    return $enabled;
}
add_filter('et_builder_is_allowed_post_type', 'enable_divi_builder_on_custom_template', 10, 2);
?>
