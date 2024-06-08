<?php
    include 'dbconnect.php';
    class CreatePost extends Dbh{
        public function NewPost ($title, $text, $image_name, $image_size, $image_tmp, $allowed_ext, $final_dir, $author, $topic, $reward)
        {
            if(empty($title) or empty($text) or empty($image_name) or empty($author) or empty($topic) or empty($reward))
            {
                $_SESSION['status'] = "All fields are required";
                header("Location: ../pages/post.php");
                exit();
            }

            if(!empty($image_name)) 
            {
                if(!in_array($image_ext, $allowed_ext))
                {
                    $_SESSION['status'] = "The File type is not supported";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../pages/post.php");
                    exit();
                }

                if($image_size > 1000000)
                {
                    $_SESSION['status'] = "Your Image is too Large";
                    $_SESSION['status_code'] = "warning";
                    header("Location: ../pages/post.php");
                    exit();
                }
            }

            if(!preg_match('/^[0-9]+$/', $reward)) {
                $_SESSION['status'] = "Invalid Reward";
                $_SESSION['status_code'] = "warning";
                header("Location: ../pages/post.php");
                exit();
            }
    

            
            $sql = "INSERT INTO post (title, text, image, author, topic, published, reward) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([ $title, $text, $image_name, $author, $topic, 0, $reward]);
            move_uploaded_file($image_tmp, $final_dir);

            if($stmt->rowCount() > 0){

                $_SESSION['status'] =  "Post Created successfully";
                $_SESSION['status_code'] = "success";
                header("Location: ../pages/post.php");
                exit();

                
            }
            else{
                $_SESSION['status'] =  "Failed To Create Post";
                $_SESSION['status_code'] = "success";
                header("Location: ../pages/post.php");
                exit();
            }
            
           
        }

        public function DisplayPost()
        {
            $sql = "SELECT * FROM post";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function UpdatePost ($title, $text, $image, $image_size, $image_tmp, $allowed_ext, $folder, $author, $topic, $reward, $id)
        {
            if(empty($title) or empty($text) or empty($image) or empty($author) or empty($topic) or empty($reward))
            {
                $_SESSION['status'] = "All fields are required";
                header("Location: ../pages/post.php");
                exit();
            }

            if(!empty($image)) 
            {
                // if(!in_array($image_ext, $allowed_ext))
                // {
                //     $_SESSION['status'] = "The File type is not supported";
                //     $_SESSION['status_code'] = "error";
                //     header("Location: ../pages/post.php");
                //     exit();
                // }

                if($image_size > 1000000)
                {
                    $_SESSION['status'] = "Your Image is too Large";
                    $_SESSION['status_code'] = "warning";
                    header("Location: ../pages/post.php");
                    exit();
                }
            }
    

            
            $sql = "UPDATE post SET title=  ?, text = ?, image = ?, author = ?, topic = ?, reward = ? WHERE id=?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([ $title, $text, $image, $author, $topic, $reward, $id]);
            move_uploaded_file($image_tmp, $folder);

            if($stmt->rowCount() > 0){

                $_SESSION['status'] =  "Post Updated successfully";
                $_SESSION['status_code'] = "success";
                header("Location: ../pages/post.php");
                exit();

                
            }
            else{
                $_SESSION['status'] =  "Failed To Update Post";
                $_SESSION['status_code'] = "success";
                header("Location: ../pages/post.php");
                exit();
            }
            
           
        }
        
    
    }


?>