<?php

// Set the folder that you'd like data to be saved to.
define('DATA_FOLDER', 'user_data'); // Default value = 'user_data'

// Update Feeds
$updateFeed = array(
    'release' => array(
        'feed' => 'https://api.github.com/repos/cryptoGlance/cryptoGlance-web-app/branches/master',
        'zip' => 'https://github.com/cryptoGlance/cryptoGlance-web-app/archive/master.zip',
    ),
    'beta' => array(
        'feed' => 'https://api.github.com/repos/cryptoGlance/cryptoGlance-web-app/branches/beta',
        'zip' => 'https://github.com/cryptoGlance/cryptoGlance-web-app/archive/beta.zip',
    ),
    'nightly' => array(
        'feed' => 'https://api.github.com/repos/cryptoGlance/cryptoGlance-web-app/branches/nightly',
        'zip' => 'https://github.com/cryptoGlance/cryptoGlance-web-app/archive/nightly.zip',
    ),
);