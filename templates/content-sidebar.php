<?php
  while ( have_posts() ){ the_post();
    $content = gdlr_content_filter(get_the_content(), true);
    if(!empty($content)){
      ?>
      <div class="with-sidebar-container container">
        <div class="with-sidebar-left twelve columns">
          <?php echo $content; ?>
          <div class="clear"></div>
        </div>
      </div>
      <?php
    }
  }
?>
