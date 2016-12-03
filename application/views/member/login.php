  <div class="l-content">
    <div class="post">

      <div class="login_form">
        <?php
          echo form_open('member/login_validation');
        ?>
        <div class="form_errors">
          <?php echo form_error('email', "<p class='form_error'>","</p>"); ?>
          <?php echo form_error('password', "<p class='form_error'>","</p>"); ?>
        </div>
        <p>
          <label for="email">メールアドレス</label>
          <input type="input" name="email" value="<?php echo set_value('email'); ?>" class="input">
        </p>

        <p>
          <label for="email">パスワード</label>
          <input type="password" name="password" class="input">
        </p>

        <p>
          <input type="submit" name="login_submit" value="ログイン" class="login_btn">
        </p>

        <?php echo form_close(); ?>

        <p><a href="<?php echo site_url('member/signup') ?>">会員登録する</a></p>
      </div>


    </div>
  </div>