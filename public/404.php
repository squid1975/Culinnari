<?php
require_once('../private/initialize.php');
$title = '404 Not Found'; 
include SHARED_PATH . '/public_header.php'; 
http_response_code(404);

?>
<main role="main" tabindex="-1">
    <div class="wrapper">
        <div id="error404">
            <h2>Oops. There's nothing here..</h2>
            <p>Sorry, but the page you are looking for does not exist. It may have been moved, renamed, or deleted.</p>
            <div id="error404Links">
                <a href="<?php echo url_for('/index.php');?>">Return Home</a>
                <a href="mailto:hello@culinnari.com">Contact Support</a>
            </div>
        </div>
    </div>
</main>

<?php include SHARED_PATH . '/public_footer.php'; ?>