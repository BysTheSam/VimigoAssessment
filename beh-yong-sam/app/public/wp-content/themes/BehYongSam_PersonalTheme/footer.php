<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        <footer>
            <div class="footer_content">
                <h3><?php bloginfo('name'); ?></h3>
                <?php 

                $query = new WP_Query(array(
                    'post_type' => 'post',
                    'posta_status' => 'publish',
                    'category_name' => 'footer',
                ));

                if($query->have_posts()){
                    while($query->have_posts()){
                        $query->the_post();?>
                            <p><?php the_content(); ?></p>
                    <?php 
                    }
                    wp_reset_postdata();
                }?>
                <ul class="social_Links">
                    <li><a href="https://www.facebook.com/profile.php?id=100008322033001"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="https://www.instagram.com/bys_dynamo/"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://www.linkedin.com/in/beh-yong-sam-77080b231/"><i class="fab fa-linkedin-in"></i></a></li>
                
                </ul>
            </div>
            <div class="copyrights">
                <p>copyright &copy; <?php echo date('Y'); ?> Designed by <span><?php bloginfo('name'); ?></span></p>
            </div>
        </footer>
        <?php wp_footer();?>
    </body>
</html>