  <div class="l-content">
    <div class="post">
      <?php echo validation_errors(); ?>
      <?php echo form_open('admin/admin_category_edit/'.$cat['cat_id']) ?>

      <label for="cat_name">カテゴリ名</label>
      <p><input type="input" name="cat_name" id="cat_name" placeholder="例： ブログ" value="<?php echo $cat['cat_name'] ?>"></p>

      <label for="cat_slug">スラッグ</label>
      <p><input name="cat_slug" id="cat_slug" placeholder="例： blog" value="<?php echo $cat['cat_slug'] ?>"></input></p>

      <input type="submit" name="submit" value="投稿">
      <?php echo $cat['cat_id'] ?>

      </form>


      <h3>カテゴリー一覧</h3>
      <table class="cat_table">
        <tr>
          <th>カテゴリーID</th>
          <th>名前</th>
          <th>スラッグ</th>
          <th colspan="3">操作</th>
        </tr>
        <?php foreach($category as $cats){ ?>
        <tr>
          <td><?php echo $cats['cat_id'] ?></td>
          <td><?php echo $cats['cat_name'] ?></td>
          <td><?php echo $cats['cat_slug'] ?></td>
          <td><a href="<?php echo site_url('admin/admin_category_edit/').$cats['cat_id'] ?>">編集</a></td>
          <td><a href="<?php echo site_url('admin/admin_category_delete/').$cats['cat_id'] ?>" onclick="return alert('削除しますか？');">削除</a></td>
        </tr>
        <?php } ?>
      </table>

    </div>
  </div><!--/l-content-->
