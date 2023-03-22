<?php 
$data = array(
    'title' => 'First Question',
    'body' => 'This is the first question',
    'author' => 'Beh Yong Sam',
);

$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer cb66a81d2459f06484c75a371f4b8acc5b9797bd299a9278ff798ceb45008f65'
);

function create_post($data){
    $url = 'https://gorest.co.in/public/v2/posts';
    $ch = curl_init($url);
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer cb66a81d2459f06484c75a371f4b8acc5b9797bd299a9278ff798ceb45008f65'
    );

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function read_post(){
      // Fetch data from API and decode JSON response
      $url = 'https://gorest.co.in/public-api/posts?limit=5';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      $data = json_decode($response, true);

      // Loop through records and display them in table
      foreach ($data['data'] as $record) {
        echo '<tr>';
        echo '<td>' . $record['id'] . '</td>';
        echo '<td>' . $record['title'] . '</td>';
        echo '<td>' . $record['body'] . '</td>';
        echo '<td>' . $record['user_id'] . '</td>';
        $userID = $record['user_id'];
        /*delete button for the specific id post*/
        echo '<td>' .'<form method="POST" action="https://gorest.co.in/public-api/posts/$user_id">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="access-token" value="cb66a81d2459f06484c75a371f4b8acc5b9797bd299a9278ff798ceb45008f65">
            <button type="submit">Delete Post</button>
          </form>'. '</td>';
        echo '</tr>';
      }
}

function edit_post($userID, $data){
    $url = "https://gorest.co.in/public/v2/posts/$userID";
    $ch = curl_init($url);

    $header = array(
        'Content-Type: application/json',
        'Authorization: Bearer cb66a81d2459f06484c75a371f4b8acc5b9797bd299a9278ff798ceb45008f65'
    );

    $options = array(
        "http" => array(
            "method" => "PUT",
            "header" => $header,
            "content" => json_encode($data)
        )
        
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if($result === false){
        echo "Error";
    }else{
        echo "Success";
    }
}

?>

<!DOCTYPE html>
<html>
    <header>
        <?php wp_head();?>
    </header>
    <body>
        <?php get_header();
        if(is_page('faq')){?>
        <div class="row">
            <div class="main_title_faq">
                <div class="page_header">
                    <h1><?php the_title(); ?></h1>
                </div>
            </div>
            <ul id="accordion">
                <?php 

                $query = new WP_Query(array(
                    'post_type' => 'post',
                    'posta_status' => 'publish',
                    'category_name' => 'faq',
                ));

                if($query->have_posts()){
                    while($query->have_posts()){
                        $query->the_post();?>
                        
                       <li>
                        <label for="<?php the_title() ?>"><?php the_title(); ?><span>&#x3e;</span></label>
                        <input type="radio" name="accordion" id="<?php the_title() ?>">
                        <div class="content">
                            <p><?php the_content(); ?></p>
                        </div>
                    </li>
                    <?php 
                    }
                    wp_reset_postdata();
                }?>

                
                
            </ul>
        </div>

            
        <?php }else if(is_page('contact')){?>
            <div class="row">
                <div class="contact_details">
                    
                    <ul id="accordion">
                    <?php 

                    $query = new WP_Query(array(
                        'post_type' => 'post',
                        'posta_status' => 'publish',
                        'category_name' => 'contact',
                    ));

                    if($query->have_posts()){
                        while($query->have_posts()){
                            $query->the_post();?>
                        
                            <li>
                                <label for="<?php the_title() ?>"><?php the_title(); ?><span class="arrow">&#x3e;</span></label>
                                <input type="radio" name="accordion" id="<?php the_title() ?>">
                                <div class="content">
                                    <p><?php the_content(); ?></p>
                                </div>
                            </li>
                            <?php 
                            }
                            wp_reset_postdata();
                        }?>

                
                
                    </ul>
                    
                </div>
                <div class="contact_title">
                    <h1><?php the_title(); ?></h1>
                </div>
                    
            </div>

        <?php }
        else if(is_page('post')){ ?>
            <div class="Container">
                <div class = "F_row">
                    <div class = "F_column">
                        <table>
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Body</th>
                                <th>User ID</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php read_post(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="S_column">
                        <h1> Add Post</h1>
                        <form method="POST" action="https://gorest.co.in/public-api/posts">
                            <input type="hidden" name="access-token" value="cb66a81d2459f06484c75a371f4b8acc5b9797bd299a9278ff798ceb45008f65">
                               
                            <table>
                                <tr>
                                    <tb><label for="title">Title:</label></tb>
                                    <tb><input type="text" name="title" id="title"></tb>
                             </tr>
                                <tr>
                                    <tb><label for="user">User:</label></tb>
                                    <tb><input type="text" name="user" id="user"></tb>
                                </tr>
                                <tr>
                                    <tb><label for="user_id">User ID:</label></tb>
                                    <tb><input type="text" name="user_id" id="user_id"></tb>
                                </tr>
                                <tr>
                                    <tb><label for="body">Body:</label></tb>
                                    <tb><textarea name="body" id="body"></textarea></tb>
                                </tr>
                                <tr>
                                    <tb><button type="submit">Create Post</button></tb>
                                </tr>
                            </table>
                        </form>


                    </div>
                </div>
            </div>

        

                 

                
            
        <footer>
            <?php } get_footer();?>
        </footer>
    </body>
</html>

