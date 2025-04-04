<?php require_once('../../../../private/initialize.php');?>
<title>Create New Style | Culinnari</title>
<?php include(SHARED_PATH . '/public_header.php');
require_mgmt_login();

if(is_post_request()){
    $args = $_POST['style'];
    $style = new Style($args);
    $result = $style->save();

    if($result === true){
        $new_id = $style->id;
        $_SESSION['message'] = 'The style was created successfully.';
        redirect_to(url_for('/admin/categories/styles/manage.php?style_id=' . $style->id));
    } else {

    }
    
}
else {
    $style = new Style;
}

?>

<main role="main"  tabindex="-1">
    <div id="adminHero">
        <h2>Management Area : Style</h2>
    </div>
    <div id="wrapper">
        <div class="manageCategoryCard">
            <div>
                &laquo;<a href="<?php echo url_for('/admin/index.php');?>">Back to Admin Management Index</a>
            </div>
            <h2>Create New Style</h2>
            <div class="new">
                <form action="" method="post">
                    <div class="formField">
                        <label for="style_name">Style Name:</label>
                        <input type="text" name="style[style_name]" value="<?php echo h($style->style_name); ?>" required>
                    </div>
                    <div>
                        <input type="submit" name="create" value="Create new style" class="primaryButton">
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>