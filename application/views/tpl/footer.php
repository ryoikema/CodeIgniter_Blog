<div class="l-footer">
  <div class="footer__box--01">
    <ul>
      <li class="item">
        <h3 class="head">メニュー1<span class="small"> 小文字</span></h3>
        <ul class="list">
          <li><a href="">メニュー</a></li>
          <li><a href="">メニュー</a></li>
          <li><a href="">メニュー</a></li>
          <li><a href="">メニュー</a></li>
        </ul>
      </li>
      <li class="item">
        <h3 class="head">メニュー2</h3>
        <ul class="list">
          <li><a href="">メニュー</a></li>
          <li><a href="">メニュー</a></li>
          <li><a href="">メニュー</a></li>
          <li><a href="">メニュー</a></li>
        </ul>
      </li>
      <li class="item">
        <h3 class="head">メニュー3</h3>
        <ul class="list">
          <li><a href="">メニュー</a></li>
          <li><a href="">メニュー</a></li>
          <li><a href="">メニュー</a></li>
          <li><a href="">メニュー</a></li>
        </ul>
      </li>
      <li class="item">
        <h3 class="head">メニュー4</h3>
        <ul class="list">
          <li><a href="">メニュー</a></li>
          <li><a href="">メニュー</a></li>
          <li><a href="">メニュー</a></li>
          <li><a href="">メニュー</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div><!--/l-footer-->

</div><!--/wrap-->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo base_url()?>js/lightbox.js"></script>
<script>
  jQuery(document).ready(function($) {
    $('a').smoothScroll({
      speed: 1000,
      easing: 'easeInOutCubic'
    });

    $('.showOlderChanges').on('click', function(e){
      $('.changelog .old').slideDown('slow');
      $(this).fadeOut();
      e.preventDefault();
    })
  });
</script>
</body>
</html>