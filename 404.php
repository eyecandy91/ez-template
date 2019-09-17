<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _s
 */

get_header();
?>

<section class="section error-404 not-found">

    <div class="error content">
        <div class="error__wrapper">
            <h1>Error 404</h1>
            <h3><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', '_s' ); ?></h3>
            <p class="is-marginless"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the navigation links', 'oil-baron' ); ?></p>
			<h2 class="spacer">OR</h2>
			<? echo "<a class='is-link button' href=\"javascript:history.go(-1)\">go back</a>";  ?>
        </div>
    </div>

</section><!-- .error-404 -->

<?php
get_footer();
