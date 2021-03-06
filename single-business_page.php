<?php

get_header();
get_template_part('template-parts/banner');
?>
<?php get_header(); ?>

  <div id ="business-page" class="gdlr-content">
        <div class="with-sidebar-wrapper">
          <div class="with-sidebar-container container">
            <div class="with-sidebar-left eight columns">
              <div class="with-sidebar-content twelve columns">
                <div class="gdlr-item gdlr-blog-full gdlr-item-start-content">
                  <?php
                    get_template_part('templates/content', 'sidebar');
                    ?>
                    <div class="clear"></div>
                <div id="must-have">
            <?php
              echo '<h2>You Must Have</h2>' ;
              $required_docs = get_field('required');

                if($required_docs)  {
                  foreach($required_docs as $required_doc){
                    $content_types =  wp_get_post_terms( $required_doc->ID, 'content_type' );

                    if (! $content_types == ''){
                      $content_types =  wp_get_post_terms( $required_doc->ID, 'content_type' );
                      echo '<div ';
                      foreach($content_types as $content_type){
                        echo 'class=' . $content_type->slug . '>';
                        }
                      }else {
                        echo 'class="an-overview">';
                      }

                    echo '<a href="' . $required_doc->guid .'">'  . $required_doc->post_title . '</a>';

                    //pass the post ID to get_post, then extract the excerpt. BOOYAH
                    echo  '<span>' . get_post($required_doc->ID)->post_excerpt . '</span>';
                    echo '</div>';
                  }
                }
                ?>
              </div><!--#must-have-->
                <div id="might-need">
              <?php
                echo '<h2>You Might Need</h2>' ;
                $maybe_docs = get_field('might_need');
                  if($maybe_docs) {

                    foreach($maybe_docs as $maybe_doc){
                      $m_content_types =  wp_get_post_terms( $maybe_doc->ID, 'content_type' );

                      if (! $m_content_types == ''){
                        $m_content_types =  wp_get_post_terms( $maybe_doc->ID, 'content_type' );
                        echo '<div ';
                        foreach($m_content_types as $m_content_type){
                          echo 'class=' . $m_content_type->slug . '>';
                          }
                        }else {
                          echo 'class="an-overview">';
                        }

                      echo '<a href="' . $maybe_doc->guid .'">'  . $maybe_doc->post_title . '</a>';

                      echo '<span>' .  get_post($maybe_doc->ID)->post_excerpt . '</span>';
                      echo '</div>';
                    }
                  }

                ?>

              </div><!--#might-need -->
        </div>
      </div>
    </div>


          <div class="gdlr-sidebar gdlr-right-sidebar four columns">
            <div class="gdlr-item-start-content sidebar-right-item">
            <?php  dynamic_sidebar('sidebar_business'); ?>
            </div>
          </div>

        </div>
      </div>

  </div><!-- gdlr-content -->
<?php get_footer(); ?>



<?php
    $taxonomies = array('content_type');
    $args = array(
        'orderby'           => 'name',
        'order'             => 'ASC',
        'hide_empty'        => true,
        'hierarchical'      => true,
    );

    $terms = get_terms($taxonomies, $args);
    $tax_slugs = array();
      foreach($terms as $term) {
        array_push($tax_slugs, $term->slug);
      }
?>
<div id="dom-target"><?php foreach($tax_slugs as $key => $value){echo  htmlspecialchars($value . " ") ;}?></div>
