  <div class="l-footer">
    <p class="copyright">CopyRight &copy; 2016-<?php echo date("Y") ?> zaku All Rights Reserved.</p>
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