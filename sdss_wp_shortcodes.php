<?php
/**
 * Plugin Name: SDSS Custom Shortcodes
 * Plugin URI: https://www.sdss5.org
 * Description: Functions for sdss.org: parse/display/update JSON content, display VACs, create TOCs
 * Version: 4.5.1
 * Text Domain: sdss_wp_shortcodes
 * Author: Jordan Raddick
 * Author URI: https://www.jordanraddick.com
 * Version updates:
 *** 4.0. New Day Zero for everything on sdss.org
 *** 4.1. Display DR19 VACs on testng site
 *** 4.2. Get tutorials json file
 *** 4.3. Tutorial search function works for Surveys
 *** 4.4. Fixed logic of checking/unchecking boxes in tutorial search
 *** 4.5. CSS-ified tutorial tags for both list and single tutorial display
 *** 4.5.1. Label of filter box changed to "Filter Python Tutorials"
 *** 4.6. Fixed TOC bug with $target_regex = "/id\s*=\s*(\'|\")[a-zA-Z0-9]+(\'|\")/";
 */

require_once('affiliations.php');           // Show affiliations
require_once('coco.php');           // Show CoCo
require_once('ac.php');           // Show advisory council
require_once('publications.php');           // Show publications
require_once('architects.php');           // Show architects
require_once('roles.php');           // Show roles
require_once('vacs.php');          // Show VACs
require_once('tutorials.php');          // Show VACs
require_once('vac-search.php');          // Search and filter controls for VACs
require_once('tutorial-search.php');          // Search and filter controls for tutorials
require_once('sdss_toc.php');          // Show within-page table of contents 
require_once('sdss_to_top.php');          // Button to go to top of page
/*require_once('sdss_readmore.php');          // Read more link for manual excerpts in news and blog posts */
require_once('update_pull_json.php');                   // Make sure JSONs are up to date


add_shortcode( 'show_affiliations', 'show_affiliations');
add_shortcode( 'show_coco', 'show_coco');
add_shortcode( 'show_ac', 'show_ac');
add_shortcode( 'show_publications', 'show_publications');
add_shortcode( 'show_architects', 'show_architects');
add_shortcode( 'show_roles', 'show_roles');
add_shortcode( 'show_vacs', 'show_vacs');
add_shortcode( 'show_tutorials', 'show_tutorials');
add_shortcode( 'show_toc', 'show_toc' );
add_shortcode( 'to_top', 'sdss_to_top' );
add_shortcode( 'vac_search', 'vac_search');
add_shortcode( 'tutorial_search', 'tutorial_search');
//add_shortcode( 'readmore', 'read_more_in_excerpt');
add_shortcode( 'update_pull_json', 'sdss_pull_json' );
add_shortcode( 'update_pull_json_manually', 'show_json_updater' );
?>
