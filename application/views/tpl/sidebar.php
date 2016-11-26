<div class="l-sidebar">

  <div class="category_list">
    <h3>カテゴリー</h3>
      <ul>
      <?php foreach($category as $cat): ?>
        <li><a href="<?php echo site_url('blog/post_category?cat_slug=')."{$cat['cat_slug']}" ?>"><?php echo $cat['cat_name'] ?></a></li>
      <?php endforeach;?>
      </ul>
  </div>

  <div class="month_archive">
  <h3>月別</h3>
    <ul>
    <?php foreach($posts_archive as $post): ?>
      <?php $post_date_month = site_url('blog/post_archive?post_date=')."{$post['post_date_month']}"; ?>
      <?php echo "<li><a href=\"{$post_date_month}\">".$post['post_date']."({$post['count']})"."</a></li>"; ?>
    <?php endforeach; ?>
    </ul>
  </div>

  <div class="calender">
    <h3><a href="<?php echo site_url('calender'); ?>">カレンダー</a></h3>
      <?php echo $calender; ?>
  </div>

  <div class="popular_post">
    <h3>人気の記事５件</h3>
  </div>

</div><!--/l-sidebar-->

