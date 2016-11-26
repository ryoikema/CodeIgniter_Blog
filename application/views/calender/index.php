  <div class="l-content">
    <div class="post">
      <ul>
      <?php foreach($calender_post as $post): ?>
        <li>
          <span class="post_date"><?php echo $post['post_date'] ?></span>
          <!--紐づいているカテゴリを表示-->
          <?php
            for($i=0; $i < count($check_cat); $i++){
              if($post['post_id'] == $check_cat[$i]['post_id']){
                $cat_link = site_url('blog/post_category?cat_slug=')."{$check_cat[$i]['cat_slug']}";
                echo "<span class=\"post_cat\"><a href=\"{$cat_link}\">"."{$check_cat[$i]['cat_name']}"."</a></span>";
              }
            }
          ?>
          <p><a href="<?php echo site_url('blog/post_detail/').$post['post_id'] ?>"><?php echo  mb_substr($post['post_title'],0,44) ?></a></p>
        </li>
      <?php endforeach;?>
      </ul>
    </div>
  </div><!--/l-content-->