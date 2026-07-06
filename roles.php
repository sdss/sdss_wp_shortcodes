<?php


function show_roles() {

	$sdss_debug = WP_DEBUG;
	$current_dr_number = CURRENT_DR;
	$current_dr = "DR".strval($current_dr_number);

	$requested_page_arr = explode('/',$_SERVER['REQUEST_URI']);   // get page requested (relative to top level)    

    $thehtml = "";
    if (WHICH_PHASE == 'sdss5') {
        if ($sdss_debug == 1) {
            $roles_data_json = @file_get_contents(  PATH_JSON_VACS . 'roles-testng.json' );
        } else {
            $roles_data_json = @file_get_contents(  PATH_JSON . 'roles.json' );
        }
        $roles_data = json_decode( $roles_data_json, true );

        foreach ($roles_data['divisions'] as $division_number => $division) {
            $thehtml .= "<h2>" . $division['title'] . "</h2>";
            $thehtml .= "<ul>";
            foreach ($division['roles'] as $role_in_division_number => $this_role) {
                $thehtml .= "<li>".$this_role['role'].$this_role['mc'].": <strong>".$this_role['leaders']."</strong></li>";
            }
            $thehtml .= "</ul>";
        }
        $thehtml .= "<p>Last modified: " . $roles_data['modified'] . "</p>";
    } elseif (WHICH_PHASE == 'sdss4') {

        $sdss_debug = false;
        $fullname_source = 'members';   // "members" gets fullames from members.json; "roles" gets fullnames from roles.json (per Jordan & Joel); if neither, name is "NAME NOT FOUND"

        $leaders_data_json = @file_get_contents(  PATH_JSON . 'leaders.json' );
        $leaders_data = json_decode( $leaders_data_json, true );

        $roles_data_json = @file_get_contents(  PATH_JSON . 'roles.json' );
        $roles_data = json_decode( $roles_data_json, true );

        $members_data_json = @file_get_contents(  PATH_JSON . 'members.json' );
        $members_data = json_decode( $members_data_json, true );

        $mc_data_json = @file_get_contents(  PATH_JSON . 'mc.json' );
        $mc_data = json_decode( $mc_data_json, true);

        if ($sdss_debug) {
            $thehtml .= "<h2>Current page encoding: ".mb_internal_encoding()."</h2>";
            $thehtml .= "<h2>File encoding before conversion: ".mb_detect_encoding($leaders_data_json)."</h2>";
            $leaders_data_json = mb_convert_encoding($leaders_data_json, 'UTF-8', mb_detect_encoding($leaders_data_json, 'UTF-8, ISO-8859-1', true));
            $thehtml .= "<h2>File encoding after conversion: ".mb_detect_encoding($leaders_data_json)."</h2>";
        }



        #$thehtml .= "<div class='sdss-wrapper'>";

        $listlevel = 0;

        foreach ($roles_data['roles'] as $thisrow) {
            if ($listlevel == 0) {
                $thehtml .= "<ul>";
                if ($sdss_debug) $thehtml .= "<li>UL</li>";
                $listlevel = 1;
            } elseif ($listlevel < $thisrow['level']) {
                $thehtml .= "<ul>";
                if ($sdss_debug) $thehtml .= "<li>UL</li>";
                if ($sdss_debug) print('<li>GOING DOWN...</li>');
                $listlevel = $thisrow['level'];
            } elseif ($listlevel > $thisrow['level']) {
                while ($listlevel > $thisrow['level']) {
                    if ($sdss_debug) $thehtml .= "<li>listlevel = ".$listlevel."; lv = ".$thisrow['level']."; GOING UP...</li>";
                    $thehtml .= "</ul>";
                    if ($sdss_debug) $thehtml .= "<li>/UL</li>";
                    $listlevel = $listlevel - 1;
                }
            }
            $thehtml .= "<li>";
            if ($sdss_debug) $thehtml .= "listlevel = ".$listlevel."; lv = ".$thisrow['level']."; ";
            if ($sdss_debug) {
                for ($i = 0; $i < $thisrow['level']; $i++) {
                    $thehtml .= "&nbsp;&nbsp;li-";
                }
            }
            $thehtml .= $thisrow['role'];
            if ($sdss_debug) $thehtml .= " (role_id = ".$thisrow['role_id'].")";
            $thehtml .= ": <strong>";
            $the_member_ids = searchForRoleID($thisrow['role_id'], $leaders_data['leaders'], $sdss_debug);
            $names_from_roles_array = namesFromRolesArray($thisrow['role_id'], $leaders_data['leaders'], $sdss_debug);

            for ($i = 0; $i <= count($the_member_ids) - 1; $i++) {
                if ($i > 0) $thehtml .= ", ";
                $this_member_id = $the_member_ids[$i];
                $this_name = searchForMemberID($this_member_id, $members_data['members'], $sdss_debug);

                // Special case fixes - see Mike Blanton email of 2019-12-03
                if ($this_member_id == 609) $this_name = "Bruce A. Gillespie"; 
                if ($this_member_id == 108) $this_name = "Ben Harris"; 

                $this_name_from_roles_array = $names_from_roles_array[$i];
                
                if ($fullname_source == 'members') {
                    $thehtml .= $this_name;
                } elseif ($fullname_source == 'roles') {
                    $thehtml .= $this_name_from_roles_array;
                } else {
                    $thehtml .= "NAME NOT FOUND";
                }

                if ($sdss_debug) $thehtml .= " (member_id = ".$this_member_id.")";
                $this_member_is_mc = isMC($this_member_id, $mc_data['mc'], $sdss_debug);
                if ($this_member_is_mc && $this_name <> "VACANT") $thehtml .= "*";
            }
            $thehtml .= "</strong>";

            $thehtml .= "</li>";
        }
        if ($sdss_debug) $thehtml .= "<li>listlevel = ".$listlevel."</li>";
        while ($listlevel > 0) {
            if ($sdss_debug) $thehtml .= "<li>/UL</li>";
            $thehtml .= "</ul>";
            $listlevel = $listlevel - 1;
        }

        $leaders_last_modified = $leaders_data['modified'];
        $roles_last_modified = $roles_data['modified'];
        $members_last_modified = $members_data['modified'];
        $mc_last_modified = $mc_data['modified'];

        if ($sdss_debug) {
            $thehtml .= "Leaders last modified: ".$leaders_last_modified."<br />";
            $thehtml .= "Roles last modified: ".$leaders_last_modified."<br />";
            $thehtml .= "Members last modified: ".$leaders_last_modified."<br />";
            $thehtml .= "MC last modified: ".$leaders_last_modified."<br />";
            $thehtml .= "<p>&nbsp;</p>";
        }

        $thehtml .= "<p>Last modified: ".max($leaders_last_modified, $roles_last_modified, $members_last_modified, $mc_last_modified)."</p>";
        /*
        if ($leaders_last_modified >= $roles_last_modified) {
                $thehtml .= "<p>Leaders last modified: ".$leaders_last_modified."</p>";
            } else {
                $thehtml .= "<p>Roles last modified: ".$roles_last_modified."</p>";
            }*/


    } else {
        $thehtml .= "<h1>Phase not found!</h1>";
    }
    return $thehtml;    
}


// Functions needed for sdss4 display
function searchForRoleID($id, $array, $sdss_debug_in_fcn) {
    $returnArray = Array();
    foreach ($array as $thisrow) {
        if ($thisrow['role_id'] === $id && $thisrow['current'] == 1) {
            array_push($returnArray, $thisrow['member_id']); //$thisrow['fullname']);
        }
    }
    if (count($returnArray) == 0) {
        if ($sdss_debug_in_fcn) {
            array_push($returnArray, "NOT FOUND!!!!");
        } else {
            array_push($returnArray, "");
        }
    }
    return $returnArray;
}

function searchForMemberID($id, $array, $sdss_debug_in_fcn) {
    foreach ($array as $thisrow) {
        if ($thisrow['member_id'] == $id) {
            return $thisrow['fullname'];
        }
    }
    return "";//"VACANT";
}

function namesFromRolesArray($id, $array, $sdss_debug_in_fcn) {
    $returnArray = Array();
    foreach ($array as $thisrow) {
        if ($thisrow['role_id'] === $id && $thisrow['current'] == 1) {
            array_push($returnArray, $thisrow['fullname']);
        }
    }
    if (count($returnArray) == 0) {
        if ($sdss_debug_in_fcn) {
            array_push($returnArray, "NOT FOUND!!!!");
        } else {
            array_push($returnArray, "");
        }
    }
    return $returnArray;
}

function isMC($id, $array, $sdss_debug_in_fcn) {
    foreach ($array as $thisrow) {
        if ($thisrow['member_id'] == $id) {
            return true;
        }
    }
    return false;
}




?>