<?php
if (isset($files) && count($files)) {
    ?>
    <ul>
        <?php
        foreach ($files as $file) {
            ?>
            <li class="image_wrap">
                <a href="#" class="delete_file_link" data-file_id="<?php echo $file->id ?>">Delete</a>
                <strong><?php echo $file->title ?></strong>
                <br />
        <?php echo $file->filename ?>
            </li>
                <?php
            }
            ?>
    </ul>
    </form>
    <?php
} else {
    ?>
    <p>No Files Uploaded</p>
    <?php
}
?>