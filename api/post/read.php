<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/post.php';

// instatiate db and connect
$database = new Database();
$db = $database->connect();

// instatiate blog post object
$post = new Post($db);

// blog post query
$result = $post->read();
// get row count
$num = $result->rowcount();

//check if any posts
if ($num > 0) {
  //post array
  $posts_arr = array();
  $posts_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $post_item = array(
      'id' => $id,
      'title' => $title,
      'body' => html_entity_decode($body),
      'author' => $author,
      'category_id' => $category_id,
      'category_name' => $category_name
    );

    // Push to "data"
    array_push($posts_arr['data'], $post_item);
    // array_push($posts_arr['data'], $post_item);
  }

  // Turn to JSON & output
  echo json_encode($posts_arr);
} else {
  // No Posts
  echo json_encode(
    array('message' => 'No Posts Found')
  );
}

