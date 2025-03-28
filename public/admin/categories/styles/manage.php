<?php require_once('../../../../private/initialize.php');?>
<title>Manage Style</title>
<?php include(SHARED_PATH . '/public_header.php');

$styleId = $_GET['style_id'] ?? '1';
$style = Style::find_by_id($styleId);
if($style === false){
    redirect_to(url_for('/admin/index.php'));
}

if(is_post_request()){
    if(isset($_POST['update'])){
        $args = $_POST['style'];
        $style->merge_attributes($args);
        $result = $style->save();
        if($result === true){
            $_SESSION['message'] = 'The style was updated successfully.';
            redirect_to(url_for('/admin/categories/styles/manage.php?style_id=' . $styleId));
        }
    }
    if(isset($_POST['delete'])){
        $result = $style->delete();
        if($result === true){
            $_SESSION['message'] = 'The style was deleted successfully.';
            redirect_to(url_for('/admin/index.php'));
        }
        else {
            
        }
    }

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
            <h2>Manage Style: <?php echo h($style->style_name); ?> </h2>
            <div class="edit">
                <h3>Edit Style</h3>
                <form action="" method="post">
                    <div>
                        <label for="style_name">Style Name</label>
                        <input type="text" name="style['style_name']" value="<?php echo h($style->style_name); ?>">
                    </div>
                    <div>
                        <input type="submit" name="update" value="Update Style">
                    </div>
                </form>
            </div>
            <div class="delete">
                <h3>Delete Style</h3>
                <p>Are you sure you want to delete this style?<strong>This cannot be undone.</strong></p>
                <form action="" method="post">
                    <div>
                        <input type="submit" name="delete" value="Delete Style">
                    </div>
                </form>
        </div>
        </div>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>