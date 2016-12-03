  <div class="l-content">
    <div class="post">

      <div class="signup_form">
        <?php echo form_open('member/signup_validation'); ?>

        <div class="form_errors">
          <?php echo form_error('email', "<p class='form_error'>","</p>"); ?>
          <?php echo form_error('password', "<p class='form_error'>","</p>"); ?>
          <?php echo form_error('cpassword', "<p class='form_error'>","</p>"); ?>
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
          <label for="email">パスワード確認用</label>
          <input type="password" name="cpassword" class="input">
        </p>

        <p>
          <input type="submit" name="signup_submit" value="会員登録" class="signup_btn">
        </p>

        <?php echo form_close(); ?>

      </div>




    </div>
  </div>