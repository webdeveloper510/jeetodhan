<?php
/*
* Template Name: Blog New
*/
get_header(); 
?>

<!-- Breadcrumbs -->
<div class="modeltheme-breadcrumbs">
    <div id="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title"><?php echo get_the_title(); ?></h1>
            </div>
            <?php $breadcrumbs_text = get_post_meta( get_the_ID(), 'breadcrumbs_text', true ); ?>
            <?php if(isset($breadcrumbs_text) && !empty($breadcrumbs_text)) { ?>
                <div class="col-md-12 breadcrumbs-content">
                    <p><?php echo esc_html($breadcrumbs_text); ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Page content -->
<div id="primary" class="high-padding">
    <?php
    global $wpdb;

$table_name =  'scrappy_datascraping'; // get the full table name with the WordPress prefix

// Step 1: Determine the number of records to display per page
$records_per_page = 16;

// Step 2: Get the current page number from the URL
$current_page = get_query_var('paged') ? get_query_var('paged') : 1;

// Step 3: Calculate the offset for the current page
$offset = ($current_page - 1) * $records_per_page;

// Step 4: Build the custom select query with the offset and limit
$my_query = "SELECT * FROM $table_name LIMIT $offset, $records_per_page";

// Step 5: Execute the custom select query
$my_results = $wpdb->get_results($my_query);

// Step 6: Loop through the query results and display them

if ( !empty( $my_results ) ) { // check if there are any results
echo "<ul class='blog-list'>";
    foreach ( $my_results as $my_result ) {
        echo "<li><a href='https://www.topgear.com$my_result->anchor' class='card' target='_blank'><img src='$my_result->image_url' /><h3> $my_result->title . </h3></a></li>"; // display the value of a column in each result
    }
    echo "</ul>";

}

// Step 7: Build and display the pagination links
$total_records = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
$total_pages = ceil($total_records / $records_per_page);
$pagination_args = array(
    'base' => esc_url(add_query_arg('paged', '%#%')),
    'format' => '?paged=%#%',
    'total' => $total_pages,
    'current' => $current_page,
);
echo "<div class='pagination'>" . paginate_links($pagination_args) . "</div>";
?>
<style>
        .blog-list {
            display: flex;
            flex-wrap: wrap;
            padding: 0 15px;
        }
        
        .blog-list li {
            width: 100%;
            display: flex;
            flex-direction: column;
            margin-bottom: 40px;
        }
        
        .blog-list .card {
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            text-decoration: none;
        }

        .blog-list .card img {
            width: 100%;
            min-height: 232px;
            max-height: 232px;
            object-fit: cover;
        }

        .blog-list .card h3 {
            display: flex;
            color: #000;
            font-weight: bold;
            font-size: 20px !important;
            padding: 3.5rem 2rem;
            margin: 0;
            min-height: 158px;
            line-height: 1.4 !important;
        }
        a.prev.page-numbers, a.next.page-numbers {
    width: 105px;
}
        
        @media only screen and (min-width: 768px) {
            .blog-list li {
                width: 50%;
                padding: 0 10px;
                margin-bottom: 20px;
            }
            
            .blog-list .card h3 {
                min-height: 182px;
            }
        }
        
        @media only screen and (min-width: 992px) {
            .blog-list li {
                width: 33%;
                padding: 0 10px;
            }
        }
        
        @media only screen and (min-width: 1200px) {
            .blog-list li {
                width: 25%;
                padding: 0 10px;
            }
        }
    </style>
    
   </div>
<?php
get_footer();
?>