  <div class="l-content">
    <div class="post">
      <table class="post_select">
        <thead>
          <tr class="post_select_thead">
            <th>投稿ID</th>
            <th>投稿タイトル</th>
            <th>投稿本文</th>
            <th>カテゴリ</th>
            <th>投稿日時</th>
            <th colspan="2">操作</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($posts as $post){ ?>

          <tr class="post_select_tbody">
            <td><?php echo $post['post_id'] ?></td>
            <td><a href="<?php echo site_url('admin/post_detail/').$post['post_id'] ?>"><?php echo  mb_substr($post['post_title'],0,8)."..." ?></a></td>
            <td><?php echo mb_substr($post['post_content'],0,8)."..." ?></td>
            <td>
              <!--紐づいているカテゴリを表示-->
              <?php
              for($i=0; $i < count($check_cat); $i++){
                if($post['post_id'] == $check_cat[$i]['post_id']){
                  $cat_link = site_url('admin/post_category?cat_slug=')."{$check_cat[$i]['cat_slug']}";
                  echo "<span class=\"post_cat\"><a href=\"{$cat_link}\">"."{$check_cat[$i]['cat_name']}"."</a></span>";
                }
              }
              ?>
            </td>
            <td><?php echo $post['post_date'] ?></td>
            <td><a href="<?php echo site_url('admin/admin_post_edit/').$post['post_id'] ?>">編集</a></td>
            <td><a href="<?php echo site_url('admin/admin_post_delete/').$post['post_id'] ?>" onclick="return alert('削除しますか?');">削除</a></td>
          </tr>

        <?php } ?>
        </tbody>
      </table>
    <div class="pager"><?php echo $this->pagination->create_links(); ?></div>
    </div>
  </div><!--/l-content-->