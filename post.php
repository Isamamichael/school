<?php
  session_start();

  $username = $_SESSION['username'];

  $host = "localhost";
  $user = "root";
  $password = "soundofrevival";
  $dbname = "gmotion";
  
  
  $pdo = new PDO("mysql:host=$host; dbname=$dbname", $user, $password);

//   ===== CHECKING WHETHER THIS IS THE SUPER ADMIN ======
    $sql = "SELECT * FROM admin WHERE username = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$username]);
    $admin = $statement->fetch(PDO::FETCH_ASSOC);


//   Displaying Topics
    $sql = "SELECT * FROM topics ORDER BY id DESC";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $topics = $statement->fetchAll(PDO::FETCH_ASSOC);


// Displaying Posts in table form
  $sql = "SELECT * FROM post ORDER BY id DESC";
  $statement = $pdo->prepare($sql);
  $statement->execute();
  $posts = $statement->fetchAll(PDO::FETCH_ASSOC);


 
    
//   Creating a new Profile
  $updatepro = false;

  if (isset($_GET['edit'])) {
        $id=filter_input(INPUT_GET, 'edit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $updatepro=true;
        $sql = 'SELECT * FROM post WHERE id = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $post=$statement->fetch(PDO::FETCH_ASSOC);
        $rowCount = $statement->rowCount();
        if($rowCount>0){ 
            $title = $post['title'];
            $text = $post['text'];
            $image = $post['image'];
            $author = $post['author'];
            $top= $post['topic'];
            $reward= $post['reward'];
            $id = $post['id'];

        }
        else{
            $_SESSION['status'] =  "Post Created Successfully";
        }
    }


    // ======  PUBLISHING POST =======

    if(isset($_GET['publish']))
    {
      $id=filter_input(INPUT_GET, 'publish', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sql = 'UPDATE post SET published = ? WHERE id = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute([1, $id]);
        $post=$statement->fetch(PDO::FETCH_ASSOC);
    }
    else{
        $_SESSION['status'] =  "Post Published Successfully";
    }


    // ========= UNPUBLISHING POST ==========

    if(isset($_GET['unpublish']))
    {
      $id=filter_input(INPUT_GET, 'unpublish', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sql = 'UPDATE post SET published = ? WHERE id = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute([0, $id]);
        $post=$statement->fetch(PDO::FETCH_ASSOC);
    }
    else{
        $_SESSION['status'] =  "Post Unpublished Successfully";
    }

    


    // ========  INITIATING DELETION OF POST =======

  $deletepro = false;

    if(isset($_GET['delete']))
    {
      $id=filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $deletepro = true;
    }
    else{
        echo "Failed to Delete Post";
    }



    // =========== CONFIRMING DELETION OF POST  ==========

    if(isset($_GET['confirm']))
    {
        $id=filter_input(INPUT_GET, 'confirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sql = 'DELETE FROM post WHERE id = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
    }
    else{
        echo "Failed to Delete Post";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Post</title>

    <!-- linking to bootstrap   -->
    <link rel="stylesheet" href="../../assets/css/public/bootstrap.css">

<!-- linking to bootstrap   -->
<link rel="stylesheet" href="../../assets/css/admin/dashboard.css">

<!-- ==== Linking To Iconscout ========= -->
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>
<body>

<div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button id="toggle-btn" type="button">
                   <span>h</span>
                </button>

                <div class="sidebar-logo">
                    <a href="#">Gmotion</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="uil uil-user"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                    <i class="uil uil-user-md"></i>
                        <span>Users</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                    <i class="uil uil-dollar-alt"></i>
                        <span>Withdrawals</span>
                    </a>
                </li>

                <?php if($admin['priviledge'] == "super") { ?>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="uil uil-cog"></i>
                            <span>Admins</span>
                        </a>
                    </li>
                <?php } ?>

                <li class="sidebar-item">
                    <a href="post.php" class="sidebar-link">
                        <i class="uil uil-fast-mail"></i>
                        <span>Posts</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i>T</i>
                        <span>Topics</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <a href="logout.php" class="sidebar-link">
                    <span>Logout</span>
                </a>
            </div>
            
        </aside>

        <div class="main text-center">
            <?php echo $username; ?>
            <?php if ($admin['priviledge'] == "super") { ?>
                <?php if ($updatepro == true) { ?>
                    <h3>Editing Post <?php echo $post['id']; ?></h3>
                <?php } else { ?>
                    <h3>Create New Post</h3>
                <?php } ?>

                <h1><?php echo $_SESSION['status']; ?></h1>
                <form action="../processes/post_create.php" method="post" class="mb-5">
                    <?php if($updatepro == true) {  ?>
                        <div class="row justify-content-md-center justify-content-sm-center justify-content-center">
                            <div class="col-md-6 col-sm-6 col-10 mb-3">
                                <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" value="<?php echo $title; ?>">
                            </div>
                        </div>
                    <?php }else{ ?> 
                        <div class="row justify-content-md-center justify-content-sm-center justify-content-center">
                            <div class="col-md-6 col-sm-6 col-10 mb-3">
                                <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title">
                            </div>
                        </div>
                    <?php } ?>
                    
                        <div class="row justify-content-md-center justify-content-sm-center justify-content-center">
                            <?php if($updatepro == true) {  ?>
                                <div class="col-md-6 col-sm-6 col-10  mb-3">
                                    <input type="text-area" name="text" id="text" value="<?php echo $text; ?>" class="form-control">
                                </div>
                            <?php }else{ ?>  
                                <div class="col-md-6 col-sm-6 col-10  mb-3">
                                    <textarea name="text" id="text" cols="50" rows="5" placeholder="Enter Body Of Blog" class="form-control"></textarea>
                                </div>
                            <?php } ?>
                        </div>
                    

                    
                        <div class="row justify-content-md-center justify-content-sm-center justify-content-center">
                            <?php if($updatepro == true) {  ?>
                                <div class="col-md-6 col-sm-6 col-10  mb-3">
                                    <input type="file" name="image" id="image" class="form-control" placeholder="Choose Image" value="<?php echo $image; ?>">
                                </div>
                            <?php }else{ ?>
                                <div class="col-md-6 col-sm-6 col-10  mb-3">
                                    <input type="file" name="image_name" id="image_name" class="form-control" placeholder="Choose Image">
                                </div>
                            <?php } ?>
                        </div>
                    

                    <div class="row justify-content-md-center justify-content-sm-center justify-content-center">
                        <?php if($updatepro == true) { ?>
                            <div class="col-md-6 col-sm-6 col-10  mb-3">
                                <input type="text" name="author" id="author" class="form-control" placeholder="Author" value="<?php echo $author; ?>">
                            </div>
                        <?php } else { ?>
                            <div class="col-md-6 col-sm-6 col-10  mb-3">
                                <input type="text" name="author" id="author" class="form-control" placeholder="Author">
                            </div>
                        <?php } ?>
                    </div>

                    <div class="row justify-content-md-center justify-content-sm-center justify-content-center">
                        <?php if($updatepro == true) { ?>
                            <div class="col-md-6 col-sm-6 col-10  mb-3">
                                <select name="topic" id="topic" class="form-select">
                                    <option value="<?php echo $top; ?>"><?php echo $top; ?></option>
                                    <?php foreach($topics as $topic){ ?>
                                        <option value="<?php echo $topic['topic']; ?>"><?php echo $topic['topic']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-6 col-sm-6 col-10  mb-3">
                                <select name="topic" id="topic" class="form-select">
                                <?php foreach($topics as $topic){ ?>
                                        <option value="<?php echo $topic['topic']; ?>"><?php echo $topic['topic']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="row justify-content-md-center justify-content-sm-center justify-content-center">
                        <?php if($updatepro == true) { ?>
                            <div class="col-md-6 col-sm-6 col-10  mb-3">
                                <input type="text" name="reward" id="reward" class="form-control" placeholder="Reward" value="<?php echo $reward; ?>">
                            </div>
                        <?php } else { ?>
                            <div class="col-md-6 col-sm-6 col-10  mb-3">
                                <input type="text" name="reward" id="reward" class="form-control" placeholder="Enter Reward">
                            </div>
                        <?php } ?>
                    </div>

                    

                    <div class="row justify-content-md-center justify-content-sm-center justify-content-center">
                        <?php if($updatepro == true) { ?>
                            <div class="col-md-6 col-sm-6 col-10  mb-3">
                                <input type="text" name="id" id="id" class="form-control" placeholder="User Id" value="<?php echo $id; ?>">
                            </div>
                        <?php } ?>
                    </div>

                    

                    
                    
                    <?php if($updatepro == true) { ?>
                        <button class="btn btn-outline-danger mb-5" name="post_update">Update</button>
                    <?php } else { ?>
                        <button class="btn btn-outline-primary mb-5" name="post_create">Create</button>
                    <?php } ?>


                    
                </form>
            <?php } ?>
                        


            <div class="table-responsive container mt-5">
                    <h3>Updated List of All Post</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Reward</th>
                                <?php if($admin['priviledge'] == "super") { ?>
                                    <th>Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($posts as $post){ ?>
                                <tr>
                                    <td><?php echo $post['id']; ?></td>
                                    <td><?php echo $post['title']; ?></td>
                                    <td><?php echo $post['author']; ?></td>
                                    <td><?php echo $post['reward']; ?></td>

                                    <?php if ($admin['priviledge'] == "super") { ?>
                                        <td  scope="col">
                                            <a href="post.php?edit=<?php echo $post['id'];?>"><button class="btn btn-outline-danger">Edit</button></a>
                                        </td>
                                        <td>
                                            <a href="post.php?delete=<?php echo $post['id'];?>"><button class="btn btn-outline-danger">Delete</button></a>
                                        </td>
                                        <?php if ($deletepro == true){ ?>
                                            <td>
                                                <a href="post.php?confirm=<?php echo $post['id'];?>"><button class="btn btn-outline-danger">Confirm Delete</button></a>
                                            </td>
                                        <?php } ?>
                                        <td>
                                        <?php if($post['published'] == 0) { ?>
                                            <a href="post.php?publish=<?php echo $post['id'];?>"><button class="btn btn-outline-danger">Publish</button></a>
                                        <?php } else { ?>
                                            <a href="post.php?unpublish=<?php echo $post['id'];?>"><button class="btn btn-outline-danger">Unpublish</button></a>
                                        <?php } ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>

                        <tfoot>

                        </tfoot>
                    </table>
                </div>
        </div>




                



        </div>

        

            
    </div>
    

    

    <!-- link to script sheet -->
    <script src="../../assets/js/public/bootstrap.js"></script>

<!-- link to script sheet -->
<script src="../../assets/js/admin/dashboard.js"></script>
</body>
</html>