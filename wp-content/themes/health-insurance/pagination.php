<?php
/**
 *  pagination
 *
 */
 ?>
      
            <div class="pagination">
              <?php
              global $wp_query;
              $big = 999999999;
              echo paginate_links( array( 'base'    => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
                'format'  => '?paged=%#%',
                'prev_text'    => esc_html__('', 'health-insurance'),
	            'next_text'    => esc_html__('', 'health-insurance'),
                'current' => max( 1, get_query_var( 'paged' ) ),
                'total'   => $wp_query->max_num_pages) );
              ?>
            </div>
      
