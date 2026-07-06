<?php
function tutorial_search() {

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

	$all_tutorial_surveys = $tutorials_data['surveys'];
	$all_tutorial_tags = $tutorials_data['tags'];

	$thehtml = "<div class='tutorial-search-controls'>";
	$thehtml .= "<div class='tutorial-search-title'>Filter Python Tutorials</div>";
	$thehtml .= "<div class='tutorial-counts'>Showing <span id='tutorial-count-visible'></span> of <span id='tutorial-count-all'></span></div>";
	
/*	$thehtml .= "<div class='tutorial-search-textbox-and-label'>";
	$thehtml .= "<label for='tutorial-search-box'>Search</label>";
	$thehtml .= "<input type='text' id='tutorial-search-box' name='tutorial-search-box'>";
	$thehtml .= "</div>";   // end tutorial-search-textbox class */


	$thehtml .= "<div class='tutorial-filter-all-checkboxes'>";

		$thehtml .= "<div class='tutorial-filter'>";
		$thehtml .= "<span style='color:white;'>Surveys</span>";
			$thehtml .= "<div class='tutorial-filter-checkbox-list'>";
				foreach ($all_tutorial_surveys as $this_survey) {
					$thehtml .= "<span class='tutorial-filter-checkbox-with-label'>";
					$thehtml .= "<input type='checkbox' id='cb-tutorial-survey-".strtolower($this_survey)."' class='cb-tutorial-survey' name='cb-tutorial-tag-".strtolower($this_survey)."' checked class='tutorial-filter-checkbox' onclick='javascript:checkAllTutorials();' />";
					$thehtml .= "<label for='cb-tutorial-survey-".strtolower($this_survey)."'>".$this_survey."</label>";
					$thehtml .= "</span>";
				}
				// $thehtml .= "<span class='tutorial-filter-checkbox-with-label'>";
				// 	$thehtml .= "<input type='checkbox' id='cb-tutorial-survey-mwm' name='cb-tutorial-tag-mwm' checked class='tutorial-filter-checkbox' onclick='javascript:checkAllTutorials();' />";
				// 	$thehtml .= "<label for='cb-tutorial-survey-mwm' class='tooltip'>MWM<span class='tooltiptext'>Milky Way Mapper</span></label>";
				// $thehtml .= "</span>";
				// $thehtml .= "<span class='tutorial-filter-checkbox-with-label'>";
				// 	$thehtml .= "<input type='checkbox' id='cb-tutorial-survey-bhm' name='cb-tutorial-tag-bhm' checked class='tutorial-filter-checkbox' onclick='javascript:checkAllTutorials();' />";
				// 	$thehtml .= "<label for='cb-tutorial-survey-bhm' class='tooltip'>BHM<span class='tooltiptext'>Black Hole Mapper</span></label>";
				// $thehtml .= "</span>";
				// $thehtml .= "</span>";
			$thehtml .= "</div>";  // end tutorial-filter-checkbox-list class for surveys
		$thehtml .= "</div>";  // end tutorial-filter class for surveys

	$thehtml .= "<div class='tutorial-filter'>";
	$thehtml .= "<span style='color:white;'>Tags</span>";
	$thehtml .= "<div class='tutorial-filter-checkbox-list'>";

	foreach ($all_tutorial_tags as $this_tag) {
		$thehtml .= "<span class='tutorial-filter-checkbox-with-label'>";
		$thehtml .= "<input type='checkbox' id='cb-tutorial-tag-".strtolower($this_tag)."' class='tutorial-filter-checkbox' name='cb-tutorial-tag-".strtolower($this_tag)."' checked class='tutorial-filter-checkbox' onclick='javascript:checkAllTutorials();' />";
		$thehtml .= "<label for='cb-tutorial-tag-".strtolower($this_tag)."'>".$this_tag."</label>";
		$thehtml .= "</span>";
	}
	
	$thehtml .= "</div>";  // end tutorial-filter-checkbox-list class for tags
	$thehtml .= "</div>";  // end tutorial-filter class for tags


	$thehtml .= "</div>";  // end tutorial-filter-checkboxes class

	$thehtml .= "<div class='tutorial-filter-bulk-select'>";
	$thehtml .= "<button class='clear-all-filters'><a href='javascript:clear_all_tags();'>Clear All Tags</a></buttonbu>";
	$thehtml .= "<button class='select-all-catalogs'><a href='javascript:select_all_tags();'>Select All Tags</a></button>";
	$thehtml .= "</div>";  // end tutorial-filter-bulk-select class

	$thehtml .= "</div>";   // end tutorial-search-controls class

	$thehtml .= "<script>window.onload = count_tutorials_all();</script>";
	return $thehtml;
}
?>