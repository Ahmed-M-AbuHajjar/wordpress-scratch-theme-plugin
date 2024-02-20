<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header(); 
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <section class="error-404 not-found text-center my-5 py-5">
            <header class="page-header py-3">
                <h1 class='text-danger'>404</h1>
                <h2 class="text-center page-title"><?php esc_html_e('Page not found!', 'scratch theme'); ?></h2>
            </header>

           
        </section>
    </main>
</div>

<?php
get_footer(); 