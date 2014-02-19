<?php

// Custom session handling!
function rigwatch_session() {
    $session_name = 'rigWatch'; // feel free to rename this!
    
    // Forces use of cookies
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        die('Error: We require that sessions only use cookies. Consult your PHP config to resolve this issue.');
    }
    
    // Gets cookies params
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], false, true);
    

    session_name($session_name);
    session_start();
    session_regenerate_id();
}

?>