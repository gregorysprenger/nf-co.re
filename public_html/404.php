<?php
if (isset($suggestion_404_urls)) {
    // Check that suggestion URLs exist
    foreach ($suggestion_404_urls as $idx => $url) {
        $headers = get_headers($url);
        $http_code = @substr($headers[0], 9, 3);
        if ($http_code != 200 && $http_code !== false) {
            unset($suggestion_404_urls[$idx]);
        } else {
            // Redirect to GitHub if is a suggestion URL and exists
            if (substr($url, 0, 27) == 'https://github.com/nf-core/') {
                header("Location: $url");
                exit();
            }
        }
    }
}

header('HTTP/1.1 404 Not Found');

$title = 'Error 404';
$subtitle = 'Page not found';
$request_url = 'that page';
if ($_SERVER['REQUEST_URI'] != '/404') {
    $protocol = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $request_url = '<code>' . $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '</code>';
}
include '../includes/header.php';
?>
<h1>Sorry, that page could not be found.</h1>
<p>It looks like <?php echo $request_url; ?> doesn't exist. </p>
<p>Please let us know by <a href="https://github.com/nf-core/nf-co.re" target="_blank">creating an issue on GitHub</a>.</p>

<?php
if (isset($suggestion_404_urls) && count($suggestion_404_urls) > 0) {
    echo '<p>Maybe these are the links that you are looking for?</p><ul>';
    foreach ($suggestion_404_urls as $url) {
        echo '<li><a href="' . $url . '">' . $url . '</a></li>';
    }
    echo '</ul>';
    echo '<img src="/assets/img/thesearenotthedroidsyourelookingfor.gif" class="w-50">';
}

include '../includes/footer.php';


?>
