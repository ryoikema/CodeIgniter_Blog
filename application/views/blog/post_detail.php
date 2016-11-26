<div class="l-content">
  <div class="post">
  <h2>記事詳細</h2>
    <ul>
      <li>
        <p class="single_post_title"><?php echo $post['post_title'] ?></p>
        <!--紐づいているカテゴリを表示-->
        <?php
          for($i=0; $i < count($check_cat); $i++){
            if($post['post_id'] == $check_cat[$i]['post_id']){
              $cat_link = site_url('blog/post_category?cat_slug=')."{$check_cat[$i]['cat_slug']}";
              echo "<span class=\"post_cat\"><a href=\"{$cat_link}\">"."{$check_cat[$i]['cat_name']}"."</a></span>";
            }
          }
        ?>
        <p><?php echo $post['post_content']; ?></p>
        <p class="single_post_date"><?php echo $post['post_date'] ?></p>
      </li>
    </ul>
  </div>
</div><!--/l-content-->
