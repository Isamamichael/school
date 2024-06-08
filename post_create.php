<?php



    include '../classes/post_class.php';


    if (isset($_POST['post_create']))
    {
        session_start();
        


        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $topic = filter_input(INPUT_POST, 'topic', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reward = filter_input(INPUT_POST, 'reward', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $allowed_ext = ['png', 'jpg', 'jpeg', 'gif', 'PNG', 'JPG', 'JPEG', 'GIF'];
        $image_name = $_FILES["image_name"]["name"];

        
        $image_size = $_FILES['image_name']['size'];
        //Get temporary directory with name of image that is being uploaded
        //When image is being uploaded, it is first sent to a temporal directory 
        //before after successfull upload it is now moved from there to your target directory
        $image_tmp = $_FILES['image_name']['tmp_name'];
        //Get image extension
        $image_ext = explode(".", $image_name);
        //Convert image extension to lowercase and make usable
        $image_ext = strtolower(end($image_ext));
        //Set directory images enter when uploaded
        //We are saving image name as their phone number attached with the current day, month, year and time
        //and appending image extension to it so as to have a unique image name
        $dayInNumber = date("d");
        $monthInNumber = date("m");
        $year = date("Y");
        $time24Hour = date("G");
        $timeMin = date("i");
        $timeSecs = date("s");
        $image_name = "{$phone}{$dayInNumber}{$monthInNumber}{$year}{$time24Hour}{$timeMin}{$timeSecs}.{$image_ext}";
        $final_dir = "uploads/{$image_name}";

            
          
        
        $testObj = new CreatePost();
        $testObj->NewPost($title, $text, $image_name, $image_size, $image_tmp, $allowed_ext, $final_dir, $author, $topic, $reward);
    }

    if (isset($_POST['post_update']))
    {
        session_start();
        


        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //Get image size

        $allowed_ext = ['png', 'jpg', 'jpeg', 'gif'];

        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        //Get temporary directory with name of image that is being uploaded
        //When image is being uploaded, it is first sent to a temporal directory 
        //before after successfull upload it is now moved from there to your target directory
        $image_tmp = $_FILES['image']['tmp_name'];
        //Get image extension
        // $image_ext = explode('.', $image);
        // //Convert image extension to lowercase and make usable
        // $image_ext = strtolower(end($image_ext));
        //Set directory images enter when uploaded
        //We are saving image name as their phone number attached with the current day, month, year and time
        //and appending image extension to it so as to have a unique image name
        $dayInNumber = date("d");
        $monthInNumber = date("m");
        $year = date("Y");
        $time24Hour = date("G");
        $timeMin = date("i");
        $timeSecs = date("s");
        $image = "{$phone}{$dayInNumber}{$monthInNumber}{$year}{$time24Hour}{$timeMin}{$timeSecs}.png";
        $folder = "uploads/".$image;


        $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $topic = filter_input(INPUT_POST, 'topic', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reward = filter_input(INPUT_POST, 'reward', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        
        
             
        
        $testObj = new CreatePost();
        $testObj->UpdatePost($title, $text, $image, $image_size, $image_tmp, $allowed_ext, $folder, $author, $topic, $reward, $id);
    }

    if (isset($_POST['post_publish']))
    {
        session_start();
        
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        
        
             
        
        $testObj = new CreatePost();
        $testObj->PublishPost($id);
    }


?>