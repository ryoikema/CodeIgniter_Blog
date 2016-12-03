  <div class="l-content">
    <div class="post">
      <?php echo validation_errors(); ?>
      <?php echo form_open('admin/admin_post_edit/'.$post['post_id']) ?>

      <label for="category"><p>カテゴリ選択</p></label>
      <?php for($i=0; $i < count($check_cat); $i++): ?>
        <?php if(!empty($check_cat[$i]['post_id'])): ?>
          <input type="checkbox" checked="checked" name="cat_id[]" value="<?php echo $regist_cat[$i]['cat_id'] ?>"><?php echo $check_cat[$i]['cat_name'] ?>
          <input type="hidden" name="post_id" value="<?php echo $check_cat[$i]['post_id'] ?>">
        <?php elseif(empty($check_cat[$i]['post_id'])): ?>
          <input type="checkbox" name="cat_id[]" value="<?php echo $regist_cat[$i]['cat_id'] ?>"><?php echo $check_cat[$i]['cat_name'] ?>
        <?php endif; ?>
      <?php endfor; ?>
      <!--/カテゴリー選択-->

      <label for="post_title"><p>タイトル<p></label>
      <p><input type="input" name="post_title" id="post_title" placeholder="タイトルを入力" value="<?php echo $post['post_title'] ?>"></p>

      <label for="post_content"><p>本文</p></label>
      <p><textarea name="post_content" rows="15" id="post_content" placeholder="本文を入力"><?php echo $post['post_content'] ?></textarea></p>

      <input type="submit" name="submit" value="投稿">

      </form>
    </div>
  </div>