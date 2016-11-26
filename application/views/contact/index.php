  <div class="l-content">
    <div class="post">
      <?php echo validation_errors() ?>
      <?php echo form_open('contact/confirm') ?>

      <table class="contact_form">
        <tbody>
          <tr>
            <th><label for="name">お名前(*)</label></th>
            <td><input type="input" name="name" value="<?php echo set_value('name'); ?>" placeholder="山田 太郎" class="input"></td>
          </tr>
          <tr>
            <th><label for="email">メールアドレス(*)</label></th>
            <td><input type="input" name="email" value="<?php echo set_value('email'); ?>" placeholder="example@email.com" class="input"></td>
          </tr>
          <tr>
            <th><label for="text">お問い合わせ内容(*)</label></th>
            <td><textarea name="text" cols="30" rows="10" class="input"><?php echo set_value('text'); ?></textarea></td>
          </tr>
          <tr>
            <td class="submit_btn" colspan="2"><input type="submit" name="submit" value="内容確認へ"></td>
          </tr>
        </tbody>
      </table>

      </form>
    </div>
  </div><!--/l-content-->