  <div class="l-content">
    <div class="post">
      <?php echo validation_errors(); ?>
      <?php echo form_open('admin/admin_post_create') ?>

      <label for="category"><p>カテゴリ選択</p></label>
      <?php foreach($category as $cat): ?>
        <?php if(!$cat['cat_id'][0]) :?>
          <input type="checkbox" name="cat_id[]" value="<?php echo $cat['cat_id'] ?>" checked="checked"><?php echo $cat['cat_name'] ?>
        <?php else: ?>
          <input type="checkbox" name="cat_id[]" value="<?php echo $cat['cat_id'] ?>"><?php echo $cat['cat_name'] ?>
        <?php endif; ?>
      <?php endforeach; ?>
      <!--/カテゴリー選択-->
      <label for="post_title"><p>タイトル</p></label>
      <p><input type="input" name="post_title" id="post_title" placeholder="タイトルを入力"></p>
      <label for="post_content">本文</label>
      <p><textarea name="post_content" rows="15" id="post_content" placeholder="本文を入力"></textarea></p>

      <input type="submit" name="submit" value="投稿">
      </form>
    </div>
  </div>