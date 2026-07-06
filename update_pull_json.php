<?php

// These first few lines decide whether this is a manual update or not

if ($_SERVER["REQUEST_METHOD"] == "POST") {    // check whether form has been submitted
    $name = $_POST['proof'];       
    if (!empty($name)) {
        echo "<h1>Hello world!</h1>";
        echo sdss_pull_json($branch = 'main', $verbose = True);  // verbose = True an html string, verbose = False return nothing
    }
} else {
    // set up wordpress cron to run the function pull_json below
    add_filter( 'cron_schedules', 'add_cron_every_two_minutes' );
    function add_cron_every_two_minutes( $schedules ) { 
        $schedules['every_two_minutes'] = array(
            'interval' => 120,
            'display'  => esc_html__( 'Every Two Minutes' ), );
        return $schedules;
    } 
    add_action( 'sdss_pull_json_hook', 'sdss_pull_json' );
    if ( ! wp_next_scheduled( 'sdss_pull_json_hook' ) ) {
        wp_schedule_event( time(), 'every_two_minutes', 'sdss_pull_json_hook' );
    }
    // to unschedule, comment out the above three lines and uncomment these two lines
    //$timestamp = wp_next_scheduled( 'sdss_pull_json_hook' );
    //wp_unschedule_event( $timestamp, 'sdss_pull_json_hook' );
}

function show_json_updater() {
    $thehtml = "<form action='/wp-content/plugins/sdss_wp_shortcodes/update_pull_json.php' method='post'>";
    $thehtml .= "<input type='hidden' id='proof' name='proof' value=True>";
    $thehtml .= '<div class="clearfix"></div>';
	$thehtml .= "<input type='submit' value='Update JSON files'>";
	$thehtml .= '<div class="clearfix"></div>';
	$thehtml .= "</form>";
	return $thehtml;
}

function sdss_pull_json( $branch = 'main', $verbose = False ) {
    if ($verbose) {
        $thehtml = '';
    }

    if ($verbose) {
        $thehtml .= "<hr />";
    }
    chdir('/files/');
    if (!file_exists('sdss_org_wp_data/')) {
        if ($verbose) {
            $thehtml .= '<p>creating filetree...</p>';
        }
        make_json_filetree();
    }
    $surveys = array("sdss4", "sdss5");
    $jsonfiles = array('affiliations', 'architects', 'coco', 'project', 'publications', 'roles', 'roles-testng', 'vacs', 'vacs-testng', 'leaders', 'members', 'mc', 'sdss5-ac', 'tutorials', 'tutorials-testng');
    chdir('sdss_org_wp_data/');
    foreach ($surveys as $this_survey) {
        if ($verbose) {
            $thehtml .= "<p>Getting json files for ".$this_survey."...</p>";
        }
        chdir($this_survey);
        chdir('json/');
        foreach ($jsonfiles as $this_json_file) {
            $localfilename =  $this_json_file.".json";
            if (file_exists($localfilename)) {
                $local_file_mod_time = new DateTime('@' .filemtime($localfilename));
                if ($verbose) {
                    $thenow = new DateTime("now");
                    $interval = date_diff($local_file_mod_time, $thenow);
                    //$thehtml .= "<p>".$localfilename.":<br />&nbsp;&nbsp;&nbsp;Local file last modified at ".date('Y-m-d h:i:s',$local_file_mod_time)."</p>";
                    $thehtml .= "<p>".$localfilename.":<br />&nbsp;&nbsp;&nbsp;last modified ".$interval->format('%h hours %m minutes %s seconds')." ago<br />";
                }
            } else {
                if ($verbose) {
                    $thehtml .= "<p>Fetching file ".$this_json_file." from server";
                }
            }
            
            $gitlink = 'https://raw.githubusercontent.com/sdss/sdss_org_wp_data/'.$branch.'/'.$this_survey.'/json/'.$this_json_file.'.json';
            $remote_file_contents = file_get_contents($gitlink);
            file_put_contents($localfilename, $remote_file_contents);
            $thehtml .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;replaced!";
        }
//        execThenPrint('pwd');
//        execThenPrint('ls -sal');
        chdir('../../');
        if ($verbose) {
            $thehtml .= "<hr />";
        }
    }
    $thenow = new DateTime("now", new DateTimeZone('America/New_York'));
    $thehtml .= "<p>Done at ".$thenow->format('m/d/Y, H:i:s')."</p>";
    $thehtml .= "<h2><a href='/update-jsons/'>Return to the JSON Updates page</a></h2>";

    if ($verbose) {
        return $thehtml;
    } else {
        return;
    }
}

function make_json_filetree() {
    mkdir('sdss_org_wp_data/');
    chdir('sdss_org_wp_data/');
    $surveydirs = array('sdss4/', 'sdss5/');
    foreach ($surveydirs as $thisdir) {
        mkdir($thisdir);
        chdir($thisdir);
        mkdir('json/');
        chdir('../');
    }
    chdir('../');
    return;
}
?>