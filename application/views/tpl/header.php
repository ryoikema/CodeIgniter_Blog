<div class="l-header">
  <div class="logo">
    <a href="<?php echo site_url(); ?>admin">管理画面</a>
    /
    <a href="<?php echo site_url(); ?>">サイトを表示</a>
  </div>
  <nav class="gnav--05">
    <ul>
      <li><a href="<?php echo base_url(); ?>">Home</a></li>
      <li><a href="<?php echo site_url('blog/post_list/') ?>">記事一覧</a></li>
      <li><a href="<?php echo site_url('blog/post_archive/')."?post_date=".date('Y-m') ?>">アーカイブ</a></li>
      <li><a href="<?php echo site_url('contact/') ?>">お問い合わせ</a></li>
      <li><a href="<?php echo site_url(); ?>admin">ログイン</a></li>
    </ul>
  </nav>
  <div class="bread">
    <ol>
      <li>Home</li>
    </ol>
  </div>
</div><!--/l-header-->

