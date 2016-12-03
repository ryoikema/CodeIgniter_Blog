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
      <?php else: ?>
        <p>画像をアップロードしてください</p>
      <?php endif; ?>

      <div class="upload">
        <?php
          echo form_open_multipart("admin/upload");
          echo form_upload("userfile");
          echo form_submit("upload","画像投稿");
          echo form_close();
        ?>
      </div>
    </div>
  </div><!--/l_content-->