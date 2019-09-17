<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

$google      = myprefix_get_theme_option('ga');

?>
<!doctype html>
<html <?php language_attributes();?>>

    <head>
        <meta charset="<?php bloginfo('charset');?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="https://gmpg.org/xfn/11">
        <?php wp_head();?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
            integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <link rel="preload" href="<?php echo get_stylesheet_uri() ?>" as="style"
            onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link rel="stylesheet" href="<?php echo get_stylesheet_uri() ?>"></noscript>
        <link rel="preload" href="<?php echo get_template_directory_uri() ?>/css/font.css" as="style"
            onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/font.css"></noscript>
        <?php if (isset($google)) { ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $google ?>"></script>
        <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "<?php echo $google ?>");
        </script>
        <?php } ?>
        <script>
        /*! loadCSS. [c]2017 Filament Group, Inc. MIT License */
        /* This file is meant as a standalone workflow for
        - testing support for link[rel=preload]
        - enabling async CSS loading in browsers that do not support rel=preload
        - applying rel preload css once loaded, whether supported or not.
        */
        (function(w) {
            "use strict";
            // rel=preload support test
            if (!w.loadCSS) {
                w.loadCSS = function() {};
            }
            // define on the loadCSS obj
            var rp = loadCSS.relpreload = {};
            // rel=preload feature support test
            // runs once and returns a function for compat purposes
            rp.support = (function() {
                var ret;
                try {
                    ret = w.document.createElement("link").relList.supports("preload");
                } catch (e) {
                    ret = false;
                }
                return function() {
                    return ret;
                };
            })();

            // if preload isn't supported, get an asynchronous load by using a non-matching media attribute
            // then change that media back to its intended value on load
            rp.bindMediaToggle = function(link) {
                // remember existing media attr for ultimate state, or default to 'all'
                var finalMedia = link.media || "all";

                function enableStylesheet() {
                    link.media = finalMedia;
                }

                // bind load handlers to enable media
                if (link.addEventListener) {
                    link.addEventListener("load", enableStylesheet);
                } else if (link.attachEvent) {
                    link.attachEvent("onload", enableStylesheet);
                }

                // Set rel and non-applicable media type to start an async request
                // note: timeout allows this to happen async to let rendering continue in IE
                setTimeout(function() {
                    link.rel = "stylesheet";
                    link.media = "only x";
                });
                // also enable media after 3 seconds,
                // which will catch very old browsers (android 2.x, old firefox) that don't support onload on link
                setTimeout(enableStylesheet, 3000);
            };

            // loop through link elements in DOM
            rp.poly = function() {
                // double check this to prevent external calls from running
                if (rp.support()) {
                    return;
                }
                var links = w.document.getElementsByTagName("link");
                for (var i = 0; i < links.length; i++) {
                    var link = links[i];
                    // qualify links to those with rel=preload and as=style attrs
                    if (link.rel === "preload" && link.getAttribute("as") === "style" && !link.getAttribute(
                            "data-loadcss")) {
                        // prevent rerunning on link
                        link.setAttribute("data-loadcss", true);
                        // bind listeners to toggle media back
                        rp.bindMediaToggle(link);
                    }
                }
            };

            // if unsupported, run the polyfill
            if (!rp.support()) {
                // run once at least
                rp.poly();

                // rerun poly on an interval until onload
                var run = w.setInterval(rp.poly, 500);
                if (w.addEventListener) {
                    w.addEventListener("load", function() {
                        rp.poly();
                        w.clearInterval(run);
                    });
                } else if (w.attachEvent) {
                    w.attachEvent("onload", function() {
                        rp.poly();
                        w.clearInterval(run);
                    });
                }
            }


            // commonjs
            if (typeof exports !== "undefined") {
                exports.loadCSS = loadCSS;
            } else {
                w.loadCSS = loadCSS;
            }
        }(typeof global !== "undefined" ? global : this));
        </script>
        <script></script>
        <!-- here to ensure a non-blocking load still occurs in IE and Edge, even if scripts follow loadCSS in head -->
    </head>

    <body <?php body_class();?>>
        <div class="site">

            <div class="container">
                <?php get_template_part('template-parts/nav');?>

                <section class="section">