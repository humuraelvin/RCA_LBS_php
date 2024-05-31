{php}
if (isset($iframe_url) && !empty($iframe_url)) {
    include "content/dark-theme/view/dark_header.php";
    echo '<section id="main" class="backgroundsize">
    <div style="width: 100%; height: 720px; overflow: hidden;">
        <iframe src="' . $iframe_url . '"
                style="width: 100%; height: 720px; border: none;">
        </iframe>
    </div>
</section>';
} else {
    header("Location: signin");
    exit;
}
{/php}

{php} include "content/dark-theme/view/dark_footer.php";{/php}
