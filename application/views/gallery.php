  <div class="l-content">
    <div class="post">
      <?php if(isset($images) && count($images)): ?>
      <div class="thumb">
        <?php foreach($images as $image): ?>
        <a href="<?php echo $image["url"] ?>" rel="lightbox[plants]">
          <img src="<?php echo $image["thumb_url"] ?>">
        </a>
        <?php endforeach;?>
      </div>
      <?php endif; ?>
    </div>
  </div><!--/l_content-->