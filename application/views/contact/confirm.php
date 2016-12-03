  <div class="l-content">
    <div class="post">
      <h3>お問い合わせ 内容確認</h3>
      <p class="confirm_text">
        お問い合わせ内容はこちらでよろしいですか？<br>
        よろしければ「送信する」ボタンを押してください。
      </p>

      <?php echo form_open('contact/confirm') ?>

      <table class="contact_form">
        <tbody>
          <tr class="confirm_tr">
            <th><label for="name">お名前</label></th>
            <td><?php echo set_value('name'); ?></td>
          </tr>
          <tr class="confirm_tr">
            <th><label for="email">メールアドレス</label></th>
            <td><?php echo set_value('email'); ?></td>
          </tr>
          <tr class="confirm_tr">
            <th><label for="text">お問い合わせ内容</label></th>
            <td><?php echo set_value('text'); ?></td>
          </tr>
          <tr>
            <td class="submit_btn" colspan="2">
              <?php echo form_hidden('name', set_value('name')); ?>
              <?php echo form_hidden('email', set_value('email')); ?>
              <?php echo form_hidden('text', set_value('text')); ?>
              <input type="submit" name="return_edit" value="戻る">
              <input type="submit" name="submit" value="送信">
            </td>
          </tr>
        </tbody>
      </table>

      </form>
    </div>
  </div><!--/l-content-->