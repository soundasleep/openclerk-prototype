<?php

// should not be accessed via .php

// page render
page_header("Slow CURL", "page_slow_curl");

// emulate curl
\Openclerk\Events::trigger('curl_start', 'http://slow.url');
sleep(2);
\Openclerk\Events::trigger('curl_end', 'http://slow.url');

?>

<a href="index.php">Back home</a>

<?php

page_footer();
