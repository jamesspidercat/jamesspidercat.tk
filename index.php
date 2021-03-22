<?php
    include("connect.php");
    include("book_of_the_day.php");
    $query = "SELECT * FROM `book_data` ORDER BY `book_name`";
    $results = mysqli_query( $link, $query );
?>
<!doctype html>
<html lang="en">
    <head id="head">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="normalize.css" rel="stylesheet" type="text/css">
        <link href="bootstrap-5.0.0-beta2-dist/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="styles.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="imgs/book_stack.jpg">
        <title>Home | Sam's Books</title>
        <script src="jquery-3.5.0.js"></script>
        <link rel="stylesheet" type="text/css" href="jquery.dataTables.css">
        <script src="jquery.dataTables.js"></script>
        <script src="bootstrap-5.0.0-beta2-dist/js/bootstrap.bundle.js"></script>
        <script src="main.js"></script>
    </head>
    <body>
        <header id="header" class="col-12">
        </header>
        <nav class="col-12">
            <a href="index.php" class="samePage">Home</a>
            <a href="table.php">Table</a>
            <a href="wishlist.php">Wishlist</a>
            <a href="sources.php">Sources</a>
            <a href="contact.php">Contact</a>
        </nav>
        <div class="row">
            <div class="col-12 col-md-6"><!--Left-->
                <section class="col-12"><!--Currently Reading-->
                    <div id="gr_custom_widget_1588896719"></div>
                    <script src="https://www.goodreads.com/review/custom_widget/68562138.Currently%20Reading?cover_position=left&cover_size=medium&num_books=7&order=d&shelf=currently-reading&show_author=1&show_cover=1&show_rating=0&show_review=0&show_tags=0&show_title=1&sort=date_updated&widget_bg_color=FFFFFF&widget_bg_transparent=&widget_border_width=1&widget_id=1588895837&widget_text_color=00000F&widget_title_size=medium&widget_width=medium"></script>
                </section>
                <section class="col-12"><!--Recent Updates -->
                    <div id="gr_updates_widget">
                        <iframe id="the_iframe" src="https://goodreads.com/widgets/user_update_widget?height=400&num_updates=50&user=68562138&width=-1"  height="330px"></iframe>
                        
                        <div id="gr_footer">
                            <a href="https://www.goodreads.com/">
                                <img alt="Goodreads: Book reviews, recommendations, and discussion" src="https://www.goodreads.com/images/layout/goodreads_logo_140.png" />
                            </a>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-12 col-md-6"><!--Right-->
                <section class="col-12"><!--Reading challenge-->
                
                    <div id="gr_challenge_11621" class="gr_custom_container_1588895837">
                        <div id="gr_challenge_progress_body_11650">
                        </div>
                        <script src="https://www.goodreads.com/user_challenges/widget/68562138-sam?challenge_id=11650&v=2"></script>
                    </div>
                </section>
                <section class="col-12"><!--Random Quote -->
                    <div class="gr_custom_container_1588895837">
                        <h3 >
                            <a href="https://www.goodreads.com/user/show/68562138-sam" style="text-decoration: none;color:#aaa;font-family:georgia,serif;font-style:italic;" rel="nofollow">Pretentious Quote</a>
                        </h3>
                        <br/>
                        <div id="gr_quote_body"></div>
                        <script src="https://www.goodreads.com/quotes/widget/68562138-sam?v=2"></script>
                        <div style="text-align: right;">
                            <a href="https://www.goodreads.com/quotes" style="color: #382110; text-decoration: none; font-size: 10px;" rel="nofollow">Goodreads Quotes</a>
                        </div>
                    </div>
    
                </section>
                <?php
                include("book_of_the_day.txt");
                ?>
            </div>
        </div>

        <footer>
            <a href="sources.php">© Sam</a>
        </footer>
    </body>
</html>