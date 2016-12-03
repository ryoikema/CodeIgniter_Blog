<div class="l-header">
  <nav class="gnav--05">
    <ul>
      <li><a href="<?php echo base_url(); ?>">Home</a></li>
      <li><a href="<?php echo site_url('blog/post_list/') ?>">記事一覧</a></li>
      <li><a href="<?php echo site_url('gallery') ?>">ギャラリー</a></li>
      <li><a href="<?php echo site_url('contact/') ?>">お問い合わせ</a></li>
      <li><a href="<?php echo site_url('member/') ?>">ログイン</a></li>
    </ul>
  </nav>

  <?php echo $this->breadcrumbs->show(); ?>
</div><!--/l-header-->

