  <div class="l-content">
    <div class="post">

    <h3>お問い合わせ 内容確認</h3>
    <p>お問い合わせ内容はこちらでよろしいですか？</p>
    <p>よろしければ「送信する」ボタンを押してください。</p>

      <?php echo validation_errors() ?>
      <?php echo form_open('contact/thank') ?>

      <table class="contact_form">
        <tbody>
          <tr>
            <th><label for="name">お名前</label></th>
            <td><?php echo set_value('name'); ?></td>
          </tr>
          <tr>
            <th><label for="email">メールアドレス</label></th>
            <td><?php echo set_value('email'); ?></td>
          </tr>
          <tr>
            <th><label for="text">お問い合わせ内容</label></th>
            <td><?php echo set_value('text'); ?></td>
          </tr>
          <tr>
            <td class="submit_btn" colspan="2">
              <input type="submit" name="submit" value="送信する">
              <input type="submit" name="return_edit" value="内容を修正" onclick="history.back()">
            </td>
          </tr>
        </tbody>
      </table>

      </form>
    </div>
  </div><!--/l-content-->