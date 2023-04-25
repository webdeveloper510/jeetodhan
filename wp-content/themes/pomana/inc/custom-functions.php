<?php
/**
Function name:              pomana_footer_row1()
Function description:       Footer row 1
*/
function pomana_footer_row1(){

    global  $pomana_redux;

    echo '<div class="row">';
        echo '<div class="col-md-12 footer-row-1">';
            echo '<div class="row">';

            $footer_row_1_layout = $pomana_redux['footer_row_1_layout'];
            $nr = array("1", "2", "3", "4", "6");

            if (in_array($footer_row_1_layout, $nr)) {
                $columns    = 12/$footer_row_1_layout;
                $class = 'col-md-'.esc_attr($columns);
                for ( $i=1; $i <= $footer_row_1_layout ; $i++ ) { 
                    if ( is_active_sidebar( 'footer_row_1_'.esc_attr($i) ) ){
                        echo '<div class="'.esc_attr($class).' sidebar-'.esc_attr($i).'">';
                            dynamic_sidebar( 'footer_row_1_'.esc_attr($i) );
                        echo '</div>';
                    }
                }
            }elseif($footer_row_1_layout == '5'){
                if ( is_active_sidebar( 'footer_row_1_1' ) ){
                    echo '<div class="col-md-2 col-md-offset-1 sidebar-1">';
                        dynamic_sidebar( 'footer_row_1_1' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_2' ) ){
                    echo '<div class="col-md-2 sidebar-2">';
                        dynamic_sidebar( 'footer_row_1_2' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_3' ) ){
                    echo '<div class="col-md-2 sidebar-3">';
                        dynamic_sidebar( 'footer_row_1_3' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_4' ) ){
                    echo '<div class="col-md-2 sidebar-4">';
                        dynamic_sidebar( 'footer_row_1_4' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_5' ) ){
                    echo '<div class="col-md-2 sidebar-5">';
                        dynamic_sidebar( 'footer_row_1_5' );
                    echo '</div>';
                }
            }elseif($footer_row_1_layout == 'column_half_sub_half'){
                if ( is_active_sidebar( 'footer_row_1_1' ) ){
                    echo '<div class="col-md-6 sidebar-1">';
                        dynamic_sidebar( 'footer_row_1_1' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_2' ) ){
                    echo '<div class="col-md-3 sidebar-2">';
                        dynamic_sidebar( 'footer_row_1_2' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_3' ) ){
                    echo '<div class="col-md-3 sidebar-3">';
                        dynamic_sidebar( 'footer_row_1_3' );
                    echo '</div>';
                }
            }elseif($footer_row_1_layout == 'column_sub_half_half'){
                if ( is_active_sidebar( 'footer_row_1_1' ) ){
                    echo '<div class="col-md-3 sidebar-1">';
                        dynamic_sidebar( 'footer_row_1_1' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_2' ) ){
                    echo '<div class="col-md-3 sidebar-2">';
                        dynamic_sidebar( 'footer_row_1_2' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_3' ) ){
                    echo '<div class="col-md-6 sidebar-3">';
                        dynamic_sidebar( 'footer_row_1_3' );
                    echo '</div>';
                }
            }elseif($footer_row_1_layout == 'column_sub_fourth_third'){
                if ( is_active_sidebar( 'footer_row_1_1' ) ){
                    echo '<div class="col-md-2 sidebar-1">';
                        dynamic_sidebar( 'footer_row_1_1' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_2' ) ){
                    echo '<div class="col-md-2 sidebar-2">';
                        dynamic_sidebar( 'footer_row_1_2' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_3' ) ){
                    echo '<div class="col-md-2 sidebar-3">';
                        dynamic_sidebar( 'footer_row_1_3' );
                    echo '</div>';
                }
                    
                if ( is_active_sidebar( 'footer_row_1_4' ) ){
                    echo '<div class="col-md-2 sidebar-4">';
                        dynamic_sidebar( 'footer_row_1_4' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_5' ) ){
                    echo '<div class="col-md-4 sidebar-5">';
                        dynamic_sidebar( 'footer_row_1_5' );
                    echo '</div>';
                }
            }elseif($footer_row_1_layout == 'column_third_sub_fourth'){
                if ( is_active_sidebar( 'footer_row_1_1' ) ){
                    echo '<div class="col-md-4 sidebar-1">';
                        dynamic_sidebar( 'footer_row_1_1' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_2' ) ){
                    echo '<div class="col-md-2 sidebar-2">';
                        dynamic_sidebar( 'footer_row_1_2' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_3' ) ){
                    echo '<div class="col-md-2 sidebar-3">';
                        dynamic_sidebar( 'footer_row_1_3' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_4' ) ){
                    echo '<div class="col-md-2 sidebar-4">';
                        dynamic_sidebar( 'footer_row_1_4' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_5' ) ){
                    echo '<div class="col-md-2 sidebar-5">';
                        dynamic_sidebar( 'footer_row_1_5' );
                    echo '</div>';
                }
            }elseif($footer_row_1_layout == 'column_sub_third_half'){
                if ( is_active_sidebar( 'footer_row_1_1' ) ){
                    echo '<div class="col-md-2 sidebar-1">';
                        dynamic_sidebar( 'footer_row_1_1' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_2' ) ){
                    echo '<div class="col-md-2 sidebar-2">';
                        dynamic_sidebar( 'footer_row_1_2' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_3' ) ){
                    echo '<div class="col-md-2 sidebar-3">';
                        dynamic_sidebar( 'footer_row_1_3' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_4' ) ){
                    echo '<div class="col-md-6 sidebar-4">';
                        dynamic_sidebar( 'footer_row_1_4' );
                    echo '</div>';
                }
            }elseif($footer_row_1_layout == 'column_half_sub_third'){
                if ( is_active_sidebar( 'footer_row_1_1' ) ){
                    echo '<div class="col-md-6 sidebar-1">';
                        dynamic_sidebar( 'footer_row_1_1' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_2' ) ){
                    echo '<div class="col-md-2 sidebar-2">';
                        dynamic_sidebar( 'footer_row_1_2' );
                    echo '</div>';
                }
                    
                if ( is_active_sidebar( 'footer_row_1_3' ) ){
                    echo '<div class="col-md-2 sidebar-3">';
                        dynamic_sidebar( 'footer_row_1_3' );
                    echo '</div>';
                }
                    
                if ( is_active_sidebar( 'footer_row_1_4' ) ){
                    echo '<div class="col-md-2 sidebar-4">';
                        dynamic_sidebar( 'footer_row_1_4' );
                    echo '</div>';
                }
            }elseif($footer_row_1_layout == 'column_fourth_sub_half'){
                if ( is_active_sidebar( 'footer_row_1_1' ) ){
                    echo '<div class="col-md-4 sidebar-1">';
                        dynamic_sidebar( 'footer_row_1_1' );
                    echo '</div>';
                }

                if ( is_active_sidebar( 'footer_row_1_2' ) ){
                    echo '<div class="col-md-2 sidebar-2">';
                        dynamic_sidebar( 'footer_row_1_2' );
                    echo '</div>';
                }
                    
                if ( is_active_sidebar( 'footer_row_1_3' ) ){
                    echo '<div class="col-md-2 sidebar-3">';
                        dynamic_sidebar( 'footer_row_1_3' );
                    echo '</div>';
                }
                    
                if ( is_active_sidebar( 'footer_row_1_4' ) ){
                    echo '<div class="col-md-4 sidebar-4">';
                        dynamic_sidebar( 'footer_row_1_4' );
                    echo '</div>';
                }
            }
            echo '</div>';
        echo '</div>';
    echo '</div>';
}