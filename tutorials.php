<?php

function show_tutorials( $thearguments ) {

    $sdss_debug = WP_DEBUG;
	$current_dr_number = CURRENT_DR;
	$current_dr = "DR".strval($current_dr_number);

	$requested_page_arr = explode('/',$_SERVER['REQUEST_URI']);   // get page requested (relative to top level)

	if (($sdss_debug == 1) & (strtoupper(($requested_page_arr[1])) == $current_dr)) {
		$tutorials_data_json = @file_get_contents(  PATH_JSON_VACS . 'tutorials-testng.json' );
	} else {
		$tutorials_data_json = @file_get_contents(  PATH_JSON_VACS . 'tutorials.json' );
	}
	$tutorials_data = json_decode( $tutorials_data_json, true );

	if ((strpos($_SERVER['REQUEST_URI'], 'id')) > 0) {
		$single_id = get_single_tutorial_id_from_url($_SERVER['REQUEST_URI']);
	} else {
		$single_id = "";
	}

	$all_tutorials = array();
	foreach ($tutorials_data['tutorials'] as $this_tutorial) {
		$all_tutorials[$this_tutorial['identifier']] = $this_tutorial;
	}
//	ksort($all_tutorials);

	$ntutorials = count($all_tutorials);
	
	if ( $single_id == "" ) {
		$thehtml = show_all_tutorials($all_tutorials, $tutorials_data['modified'], $current_dr, $sdss_debug);
	} else {
		if (!in_array($single_id, array_keys($all_tutorials))) {
			$thehtml = "<p>Tutorial ".$single_id." not found!</p>";
		} else {
			$thehtml = show_single_tutorial($all_tutorials[$single_id], $sdss_debug);
		}
	} 
	
	/*
	$thehtml .= "<pre>";
    $thehtml .= $tutorials_data_json;
    $thehtml .= "</pre>";
	*/

    return $thehtml;
}

function get_single_tutorial_id_from_url($theuri) {
	$theuri = $_SERVER['REQUEST_URI'];
	$exploded_uri_array = explode('/', $theuri);
	$id_as_url = end($exploded_uri_array);
	$exploded_id_url = explode('=', $id_as_url);
	
	$single_id = end($exploded_id_url);

	return $single_id;
}


function show_all_tutorials($all_tutorials, $last_modified, $current_dr, $sdss_debug) {

    $thehtml = "";

	$thehtml .= "<div class='tutoriallist'>";

	foreach ($all_tutorials as $id => $this_tutorial) {

		$this_tutorial_tags = get_tutorial_tags($this_tutorial);

		$thehtml .= "<div class='tutorial ";
		foreach ($this_tutorial_tags as $tagi) {
			$thehtml .= $tagi ." ";
		}
		$thehtml .= "'>";


		// link to this page with ?id={identifer}

		$thehtml .= "<a href='".$_SERVER['REQUEST_URI']."?id=".$this_tutorial['identifier']."'";
		$thehtml .= "<h2>";
		$thehtml .= $this_tutorial['title'];	
		$thehtml .= "</h2>";
		$thehtml .= "</a>";

		// TAGS
		$thehtml .= "<div class='tutorial-tags'>";   
		
		foreach ($this_tutorial['tags'] as $this_tag) {
			$thehtml .= "<div class='tutorial-tag tutorial-tag-tag'>".$this_tag."</div>";
		}

		// SURVEYS
		foreach ($this_tutorial['survey'] as $this_survey) {
			$thehtml .= "<div class='tutorial-tag tutorial-survey'>".$this_survey."</div>";
		}

		// DATA RELEASES
		foreach ($this_tutorial['data_releases'] as $this_dr) {
			$thehtml .= "<div class='tutorial-tag tutorial-dr'>".$this_dr."</div>";
		}
		$thehtml .= "</div>";   // close tutorial-tags
		
		// DESCRIPTION
		$thehtml .= "<p>".$this_tutorial['description']."</p>";

		// AUTHORS
		if (count($this_tutorial['authors']) > 1) {
			$thehtml .= "<p>Authors: ";
			for ($x = 0; $x < count($this_tutorial['authors'])-1; $x++) {
				//$thehtml .= $x;
				$thehtml .= $this_tutorial['authors'][$x].", ";
			}
			$thehtml .= end($this_tutorial['authors']);
			$thehtml .= "</p>";
		} else {
			$thehtml .= "<p>Author: ";
			$thehtml .= end($this_tutorial['authors']);
			$thehtml .= "</p>";
		}

		// TUTORIAL LAST MODIFIED
		$thehtml .= "<p><em>Last modified: ".$this_tutorial['modified']."</em></p>";

		$thehtml .= "</div>";  // close class tutorial (single tutorial info display)
	}

	$thehtml .= "</div >";  // close class tutoriallist

    $thehtml .= "<div class='clearfix'></div><p>Tutorials last modified: ".$last_modified."</p>";

    return $thehtml;

}

function show_single_tutorial($this_tutorial, $sdss_debug) {
    $thehtml = "";
	$thehtml .= "<h2>".$this_tutorial['title']."</h2>";
		// TAGS
		$thehtml .= "<div class='tutorial-tags'>";
		foreach ($this_tutorial['tags'] as $this_tag) {
			$thehtml .= "<div class='tutorial-tag tutorial-tag-tag'>".$this_tag."</div>";
		}

		// SURVEYS
		foreach ($this_tutorial['survey'] as $this_survey) {
			$thehtml .= "<div class='tutorial-tag tutorial-survey'>".$this_survey."</div>";
		}

		// DATA RELEASES
		foreach ($this_tutorial['data_releases'] as $this_dr) {
			$thehtml .= "<div class='tutorial-tag tutorial-dr'>".$this_dr."</div>";
		}
		$thehtml .= "</div>";  // close tutorial-tags class
		
		// DESCRIPTION
		$thehtml .= "<p>".$this_tutorial['description']."</p>";

		$thehtml .= "<hr />";

		// Boilerplate on how to run notebook in SciServer
		$thehtml .= "<!-- wp:paragraph -->";
		$thehtml .= "<p>This tutorial consists of an interactive Python notebook. The results are displayed here to show you what it does, ";
		$thehtml .= "but you can run it yourself if you have an account on the <a href='https://www.sciserver.org' target='_blank' rel='noopener'>SciServer</a> science platform.</p>";
		$thehtml .= "<!-- /wp:paragraph -->";

		$thehtml .= "<!-- wp:paragraph -->";
		$thehtml .= "<p>This and other tutorials are available in the SciServer <strong>SDSS SAS</strong> Data Volume in the <code>/home/idies/workspace/sdss_sas/dr20/dr20_tutorials</code> directory. See the directions in the expandable section below.</p>";
		$thehtml .= "<!-- /wp:paragraph -->";

		// Link to GitHub blob for download

		$thehtml .= "<!-- wp:paragraph -->";
		$thehtml .= "<p>Alternatively, you can ";
		$thehtml .= "<a href='".$this_tutorial['github']."' target='_blank' rel='noopener'>download this tutorial notebook from GitHub</a>, if you are logged in.</p>";
		$thehtml .= "<!-- /wp:paragraph -->";

		// Expandable instructions section

		$thehtml .= "<!-- wp:pb/accordion-item -->";
		$thehtml .= '<div class="wp-block-pb-accordion-item c-accordion__item js-accordion-item no-js" data-initially-open="false" data-click-to-close="true" data-auto-close="true" data-scroll="false" data-scroll-offset="0"><h2 id="at-103241" class="c-accordion__title js-accordion-controller" role="button">How to run this tutorial on SciServer</h2><div id="ac-103241" class="c-accordion__content"><!-- wp:paragraph -->';
		$thehtml .= '<p>A specific image is available for working with SDSS data. In order to access both SDSS data and the suite of software tools you will need, create an account then when you create a new container follow these steps:</p>';
		$thehtml .= '<!-- /wp:paragraph -->';
		$thehtml .= '<!-- wp:list -->';
		$thehtml .= '<ul class="wp-block-list"><!-- wp:list-item -->';
		$thehtml .= '<li id="education">Choose the&nbsp;<code>SDSS</code>&nbsp;Docker image. This image contains the&nbsp;<code>sdss_access</code>&nbsp;python package, as well as&nbsp;<code>astropy</code>,&nbsp;<code>astroquery</code>,&nbsp;<code>specutils</code>&nbsp;and other useful libraries.</li>';
		$thehtml .= '<!-- /wp:list-item -->';
		$thehtml .= '<!-- wp:list-item -->';
		$thehtml .= '<li>Include the&nbsp;<code>SDSS SAS</code>&nbsp;data volume. It will be mounted in the Jupyter session under&nbsp;<code>/home/idies/workspace/sdss_sas/</code>.</li>';
		$thehtml .= '<!-- /wp:list-item -->';
		$thehtml .= '<!-- wp:list-item -->';
		$thehtml .= '<li>Once in a notebook, make sure the&nbsp;<code>py312</code>&nbsp;python kernel is selected.</li>';
		$thehtml .= '<!-- /wp:list-item --></ul>';
		$thehtml .= '<!-- /wp:list --></div></div>';
		$thehtml .= '<!-- /wp:pb/accordion-item -->';

		// iframe

		$thehtml .= '<!-- wp:html -->';
		$thehtml .= '<iframe src="'.$this_tutorial['src'].'" width="100%" height="'.$this_tutorial['iframe_height'].'"></iframe>';
		$thehtml .= '<!-- /wp:html -->';

		// AUTHORS
		if (count($this_tutorial['authors']) > 1) {
			$thehtml .= "<p>Authors: ";
			for ($x = 0; $x < count($this_tutorial['authors'])-1; $x++) {
				//$thehtml .= $x;
				$thehtml .= $this_tutorial['authors'][$x].", ";
			}
			$thehtml .= end($this_tutorial['authors']);
			$thehtml .= "</p>";
		} else {
			$thehtml .= "<p>Author: ";
			$thehtml .= end($this_tutorial['authors']);
			$thehtml .= "</p>";
		}

		// TUTORIAL LAST MODIFIED
		$thehtml .= "<p><em>Last modified: ".$this_tutorial['modified']."</em></p>";

		// back link to list of tutorials
		$thehtml .= "<p><a href='/dr20/tutorials/python/'>Back to list of Python tutorials</a></p>";

    
    return $thehtml;
}


function get_tutorial_tags($this_tutorial) {

	$thetags = array();
	
	foreach ($this_tutorial['tags'] as $this_tag) {
		array_push($thetags, 'tutorial-tag-'.strtolower($this_tag));
	}

	foreach ($this_tutorial['survey'] as $this_tutorial_survey_i) {
		array_push($thetags, 'tutorial-survey-'.strtolower($this_tutorial_survey_i));
	}

//	foreach ($thisvac['object_classes'] as $this_vac_obj_i) {
//		array_push($thetags, 'vac-tag-'.strtolower($this_vac_obj_i));
//	}
	return $thetags;
}