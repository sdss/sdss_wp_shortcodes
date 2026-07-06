<?php

function show_toc($atts) {
    //echo "<font color='red'>".$atts['side']."</font>";
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );

    $wporg_atts = shortcode_atts(
		array(
			'side' => 'left',
            'headers' => '234',
            'accordion' => 'true',
            'expanded' => 'true'
		), $atts
	);

    if ($wporg_atts['accordion'] == 'true') {
        $wporg_atts['accordion'] = true;
    } else {
        $wporg_atts['accordion'] = false;
    }

    if ((is_plugin_active('accordion-blocks/accordion-blocks.php')) && ($wporg_atts['accordion'])) {
        $wporg_atts['show_accordion'] = true;
    } else {
        $wporg_atts['show_accordion'] = false;
    }

    // expand TOC accordion by default?

    if ($wporg_atts['show_accordion']) { 
        if ($wporg_atts['expanded'] == 'false') {
            $wporg_atts['expand'] = false;
        } else {
            $wporg_atts['expand'] = true;
        }
    }

    // Display which headers in TOC? As specified by user (default h2, h3, h4)
    $headervals = array();
    for($i = 0; $i < strlen($wporg_atts['headers']); ++$i) {// < and not <=, cause the index starts at 0!
        if ((intval($wporg_atts['headers'][$i]) >= 2) && (intval($wporg_atts['headers'][$i]) <= 6)) {
            array_push($headervals, intval($wporg_atts['headers'][$i]));
        }
    }
    $wporg_atts['headers_to_display'] = $headervals;
    
    add_filter('the_content', function ($content) use ($wporg_atts) {

        $regex = "/<h\d.*?>.*?\/h\d>/";

        $thetoc = '';

        if (preg_match_all($regex, $content, $matches)) {
           //echo "<font color='red'>regex = REGEX FOUND</font>";

            $thetoc .= "<div class='toc toc-".$wporg_atts['side']."'>";

            // put TOC inside accordion, if user wanted an accordion and the plugin is active
            //$wporg_atts['show_accordion'] = false;
            if ($wporg_atts['show_accordion']) {
                $accordion_uuid = wp_generate_uuid4();
            
            
                $thetoc .= '<!-- wp:pb/accordion-item {"titleTag":"h2","scroll":true,"uuid":"'.$accordion_uuid.'"} -->';
            
                $thetoc .= '<div class="wp-block-pb-accordion-item c-accordion__item js-accordion-item no-js toc-label" ';
                $thetoc .= 'data-initially-open="'.$wporg_atts['expand'].'" data-click-to-close="true" ';
                $thetoc .= 'data-auto-close="true" data-scroll="false" data-scroll-offset="0" id="div-id-'.$accordion_uuid.'">';

                //$thetoc .= "On this page";

                $thetoc .= '<div id="at-'.$accordion_uuid.'" ';
                $thetoc .= 'class="c-accordion__title js-accordion-controller toc-label-accordion" role="button">';
                $thetoc .= 'On this page';
                $thetoc .= '</div>'; // end class toc-label-accordion

                $thetoc .= '<div id="ac-'.$accordion_uuid.'" class="c-accordion__content">';
            } else {
                $thetoc .= '<div class="toc-label toc-label-inner">On this page</div>'; // if no accordion, style as toc-label-inner
            }

            
            $thetoc .= "<ul>";
            //$thetoc .= "<p style='color:red;'>".htmlentities($regex)."</p>";
            foreach ($matches as $thismatch) {
                foreach ($thismatch as $thistag) {
                    
                    $whatlevel = htmlspecialchars($thistag[2]);

                    if (in_array($whatlevel, $wporg_atts['headers_to_display'])) {  // only show TOC items for headers specified in headers_to_display list
                        $thetoc .= "<li class='forh".$whatlevel."' >";
                    
                        $target_regex = "/id\s*=\s*(\'|\")[a-zA-Z0-9]+(\'|\")/";
                        //echo "<p style='color:green;'>".$target_regex."</p>";

                        if (preg_match($target_regex, $thistag, $idmatch)) {
                            $thetoc .= "<a href='#".substr(trim($idmatch[0]), 4, -1)."'>";
                        }
                        $label_regex = "/>.*<\/h\d>/";
                        if (preg_match($label_regex, $thistag, $labelmatch)) {
                            $thetoc .= substr($labelmatch[0], 1, -5);
                            //$thetoc .= substr($labelmatch[0], 1, -2);
                        }
                        if (preg_match($target_regex, $thistag, $idmatch)) {
                            $thetoc .= "</a>";
                        }
                        $thetoc .= "</li>";
                    }
                    
                //$thetoc .= "<li>".$thistag."</li>";
                }
            }
            $thetoc .= '</ul>';
            
            if ($wporg_atts['show_accordion']) {
                $thetoc .= '</div>';   // end accordion contents
                $thetoc .= '</div>';   // end accordion
                $thetoc .= '<!-- /wp:pb/accordion-item -->';
            }

            $thetoc .= '</div>';   // end TOC div
          
            $content =  $thetoc . $content;
        }
        return $content;
    }, 9999, 1);

    return;
}

?>
