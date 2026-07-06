<?php
function vac_search() {
	$thehtml = "<div class='vac-search-controls'>";
	$thehtml .= "<div class='vac-search-title'>Value Added Catalogs</div>";
	$thehtml .= "<div class='vac-counts'>Showing <span id='vac-count-visible'></span> of <span id='vac-count-all'></span></div>";
	
/*	$thehtml .= "<div class='vac-search-textbox-and-label'>";
	$thehtml .= "<label for='vac-search-box'>Search</label>";
	$thehtml .= "<input type='text' id='vac-search-box' name='vac-search-box'>";
	$thehtml .= "</div>";   // end vac-search-textbox class */


	$thehtml .= "<div class='vac-filter-all-checkboxes'>";

		$thehtml .= "<div class='vac-filter'>";
		$thehtml .= "<span style='color:white;'>Surveys</span>";
			$thehtml .= "<div class='vac-filter-checkbox-list'>";
				$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
					$thehtml .= "<input type='checkbox' id='cb-vac-tag-surveywide' name='cb-vac-tag-surveywide' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-surveywide\");' />";
					$thehtml .= "<label for='cb-vac-tag-surveywide'>Survey-wide</label>";	
				$thehtml .= "</span>";
				$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
					$thehtml .= "<input type='checkbox' id='cb-vac-tag-mwm' name='cb-vac-tag-mwm' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-mwm\");' />";
					$thehtml .= "<label for='cb-vac-tag-mwm' class='tooltip'>MWM<span class='tooltiptext'>Milky Way Mapper</span></label>";
				$thehtml .= "</span>";
				$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
					$thehtml .= "<input type='checkbox' id='cb-vac-tag-bhm' name='cb-vac-tag-bhm' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-bhm\");' />";
					$thehtml .= "<label for='cb-vac-tag-bhm' class='tooltip'>BHM<span class='tooltiptext'>Black Hole Mapper</span></label>";
				$thehtml .= "</span>";
				$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
					$thehtml .= "<input type='checkbox' id='cb-vac-tag-apogee-2' name='cb-vac-tag-apogee-2' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-apogee-2\");' />";
					$thehtml .= "<label for='cb-vac-tag-apogee-2'>APOGEE-2</label>";	
				$thehtml .= "</span>";
				$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
					$thehtml .= "<input type='checkbox' id='cb-vac-tag-eboss' name='cb-vac-tag-eboss' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-eboss\");' />";
					$thehtml .= "<label for='cb-vac-tag-eboss'>eBOSS</label>";
				$thehtml .= "</span>";
				$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
					$thehtml .= "<input type='checkbox' id='cb-vac-tag-manga' name='cb-vac-tag-manga' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-manga\");' />";
					$thehtml .= "<label for='cb-vac-tag-manga'>MaNGA</label>";
				$thehtml .= "</span>";
				$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
					$thehtml .= "<input type='checkbox' id='cb-vac-tag-mastar' name='cb-vac-tag-mastar' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-mastar\");' />";
					$thehtml .= "<label for='cb-vac-tag-mastar'>MaStar</label>";
				$thehtml .= "</span>";
				$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
					$thehtml .= "<input type='checkbox' id='cb-vac-tag-spiders' name='cb-vac-tag-spiders' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-spiders\");' />";
					$thehtml .= "<label for='cb-vac-tag-spiders'>SPIDERS</label>";
				$thehtml .= "</span>";
				$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
					$thehtml .= "<input type='checkbox' id='cb-vac-tag-boss' name='cb-vac-tag-boss' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-boss\");' />";
					$thehtml .= "<label for='cb-vac-tag-boss'>BOSS</label>";
				$thehtml .= "</span>";
				$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
					$thehtml .= "<input type='checkbox' id='cb-vac-tag-segue' name='cb-vac-tag-spiders' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-segue\");' />";
					$thehtml .= "<label for='cb-vac-tag-segue'>SEGUE</label>";
				$thehtml .= "</span>";
				$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
					$thehtml .= "<input type='checkbox' id='cb-vac-tag-legacy' name='cb-vac-tag-legacy' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-legacy\");' />";
					$thehtml .= "<label for='cb-vac-tag-legacy'>Legacy</label>";
				$thehtml .= "</span>";
			$thehtml .= "</div>";  // end vac-filter-checkbox-list class for surveys
		$thehtml .= "</div>";  // end vac-filter class for surveys


	$thehtml .= "<div class='vac-filter'>";
	$thehtml .= "<span style='color:white;'>Object classes</span>";
	$thehtml .= "<div class='vac-filter-checkbox-list'>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-star' name='cb-vac-tag-star' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-star\");' />";
	$thehtml .= "<label for='cb-vac-tag-star'>Star</label>";
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-galaxy' name='cb-vac-tag-galaxy' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-galaxy\");' />";
	$thehtml .= "<label for='cb-vac-tag-galaxy'>Galaxy</label>";
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-qso' name='cb-vac-tag-qso' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-qso\");' />";
	$thehtml .= "<label for='cb-vac-tag-qso'>QSO</label>";
	$thehtml .= "</span>";
	
	$thehtml .= "</div>";  // end vac-filter-checkbox-list class for object classes
	$thehtml .= "</div>";  // end vac-filter class for object classes

	$thehtml .= "<div class='vac-filter'>";
	$thehtml .= "<span style='color:white;'>Available in</span>";
	$thehtml .= "<div class='vac-filter-checkbox-list'>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-cas-yes' name='cb-vac-tag-cas-yes' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-cas-yes\");' />";
	$thehtml .= "<label for='cb-vac-tag-cas-yes'>CAS</label>";
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>";
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-marvin-yes' name='cb-tag-vac-marvin-yes' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-marvin-yes\");' />";
	$thehtml .= "<label for='cb-vac-tag-marvin-yes'>Marvin</label>";
	$thehtml .= "</span>";
	$thehtml .= "</div>";  // end vac-filter-checkbox-list class for CAS/Marvin
	$thehtml .= "</div>";  // end vac-filter class for CAS/Marvin

/*	$thehtml .= "<div class='vac-filter'>";
	$thehtml .= "Data Releases";
	$thehtml .= "<div class='vac-filter-checkbox-list'>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-dr18' name='cb-vac-tag-dr18' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-dr18\");' />";
	$thehtml .= "<label for='cb-vac-tag-dr18'>DR18</label>";
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-dr17' name='cb-vac-tag-dr17' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-dr17\");' />";
	$thehtml .= "<label for='cb-vac-tag-dr17'>DR17</label>";
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-dr16' name='cb-vac-tag-dr16' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-dr16\");' />";
	$thehtml .= "<label for='cb-vac-tag-dr16'>DR16</label>";
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-dr15' name='cb-vac-tag-dr15' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-dr15\");' />";
	$thehtml .= "<label for='cb-vac-tag-dr15'>DR15</label>";
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-dr14' name='cb-vac-tag-dr14' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-dr14\");' />";
	$thehtml .= "<label for='cb-vac-tag-dr14'>DR14</label>";
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-dr13' name='cb-vac-tag-dr13' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-dr13\");' />";
	$thehtml .= "<label for='cb-vac-tag-dr13'>DR13</label>";
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-dr12' name='cb-vac-tag-dr12' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-dr12\");' />";
	$thehtml .= "<label for='cb-vac-tag-dr12'>DR12</label>";
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-dr11' name='cb-vac-tag-dr11' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-dr11\");' />";
	$thehtml .= "<label for='cb-vac-tag-dr11'>DR11</label>";
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-dr10' name='cb-vac-tag-dr10' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-dr10\");' />";
	$thehtml .= "<label for='cb-vac-tag-dr10'>DR10</label>";
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-dr9' name='cb-vac-tag-dr9' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-dr9\");' />";
	$thehtml .= "<label for='cb-vac-tag-dr9'>DR9</label>";	
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-dr8' name='cb-vac-tag-dr8' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-dr8\");' />";
	$thehtml .= "<label for='cb-vac-tag-dr8'>DR8</label>";	
	$thehtml .= "</span>";
	$thehtml .= "<span class='vac-filter-checkbox-with-label'>"; 
	$thehtml .= "<input type='checkbox' id='cb-vac-tag-dr7' name='cb-vac-tag-dr7' checked class='vac-filter-checkbox' onclick='javascript:show_hide_vac(\"vac-tag-dr7\");' />";
	$thehtml .= "<label for='cb-vac-tag-dr7'>DR7</label>";	
	$thehtml .= "</span>";
	$thehtml .= "</div>";  // end vac-filter-checkbox-list class for data releases
	$thehtml .= "</div>";  // end vac-filter class for data releases
	*/
	$thehtml .= "</div>";  // end vac-filter-checkboxes class

	$thehtml .= "<div class='vac-filter-bulk-select'>";
	$thehtml .= "<button class='clear-all-filters'><a href='javascript:clear_all_filters();'>Clear All Filters</a></buttonbu>";
	$thehtml .= "<button class='select-all-catalogs'><a href='javascript:select_all_catalogs();'>Select All Catalogs</a></button>";
	$thehtml .= "</div>";  // end vac-filter-bulk-select class

	$thehtml .= "</div>";   // end vac-search-controls class

	$thehtml .= "<script>window.onload = count_vacs_all();</script>";
	return $thehtml;
}
?>