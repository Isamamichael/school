<?php

    session_start();
    include '../private/commonentrance/classes/test.class.php';
    include '../private/commonentrance/classes/script.php';

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- ==========    LInking to bootstrap    ================== -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">    -->
    <link rel="stylesheet" href="../assets/css/public/bootstrap.css">

    <!-- ========   Linking with external stylesheet  =============== -->
    <link rel="stylesheet" href="../assets/css/public/register.css">
    
</head>
<body>
    <?php
        

        

        function generateRegNo(){
            $keyLength = 8;
            $str = '0123456789';
            $randstr = substr(str_shuffle($str), 0, $keyLength);

            $checkRegNo= checkRegNo($randstr);

            while($checkRegNo == true){
                $randstr = substr(str_shuffle($str), 0, $keyLength);
                $checkRegNo = checkRegNo($randstr);
            }

            return $randstr;
        }

        $registration_no = generateRegNo();

        function checkRegNo($randstr) {
            $host = "localhost";
            $user = "root";
            $password = "soundofrevival";
            $dbname = "schoolmanagementsystem";
            //Create a PDO instance which takes in the host, dbname, user and password
            $pdo = new PDO("mysql:host=$host; dbname=$dbname", $user, $password);
            $sql = "SELECT * FROM commonentrance";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            while($row = $stmt->fetch()) {
                if($row['registration_no']  == $randstr){
                    $keyExists = true;
                    break;
                }
                else{
                    $keyExists = false;
                }

            }

            return $keyExists;
        }
    ?>
     
    <section class="registration_filters text-center" id="btn">
        <div class="container">
        
            <h1>REGISTER WITH US</h1>
            <div class="btnOption" id="btnOption">
                <button onclick="toggleButton()" class="btn btn-outline-dark">Register Here</button>
            </div>
        </div>
    </section>
    
    <section class="registration_select" id="registration_select">
        <div class="container">
            <div class="register_btn">
                <p>What Kind Of Account Are You Creating</p>

                <select name="register" id="register" class="form-select" onchange="toggleRegistration()">
                    <option value="" selected disabled>Select Category</option>
                    <option value="Student">Student</option>
                    <option value="Applicant">Applicant</option>
                    <option value="Teacher">Teacher</option>
                    <option value="Job">Job Application</option>
                </select>
            </div>
        </div>
    </section>
        


    <!-- ===========   STUDENT REGISTRATION FORM   =============== -->

    <section id="student">
        <aside>
            <div class="container student_section">
                <div class="row justify-content-md-center justify-content-sm-center justify-content-center mb-5">
                    <div class="col-md-6 col-sm-6 col-10 img_column">
                        <img src="../assets/images/registration.jpg" alt="" class="img-fluid" style="height: 100%;">
                    </div>
                
                    <div class="col-md-5 col-sm-5 col-10">
                        <h2>Student Registration</h2>
                        <a onclick="toggleRegistration()" href="" class="close">
                                close
                            </a>
                        <form action="../private/commonentrance/logics/commonentrance.process.php" class="entrance_form" method="POST" enctype="multipart/form-data">
                            
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-12 mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name">
                                </div>
                                <div class="col-md-6 col-sm-6 col-12 mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-12 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-md-6 col-sm-6 col-12 mb-3">
                                    <label for="email" class="form-label">Email-Address</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-12 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="col-md-6 col-sm-6 col-12 mb-3">
                                    <label for="confirm" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="confirm" name="confirm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-12 mb-3">
                                    <span style="margin-right: 2rem;">Gender: </span>
                                    <select name="gender" id="gender" class="form-select">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Prefer not to mention">Prefer not to mention</option>
                                    </select>                                   
                                </div>
                                <div class="col-md-6 col-sm-6 col-12 mb-3">
                                    <label for="passport">Passport</label>
                                    <input type="file" name="passport" id="passport" class="form-control">                                  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-12 mb-3">
                                    <label for="date">Date of Birth</label>
                                    <input type="date" name="date" id="date" class="form-control">
                                </div>
                                <div class="col-md-6 col-sm-6 col-12 mb-3">
                                    <label for="country">Country</label>
                                    <select name="country" id="country" class="form-select" onchange="display()">
                                    
                                    </select>
                                </div>
                                <div class="display_state" id="display_state">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-12 mb-3">
                                            <label for="state" class="form-label">State</label>
                                            <input type="text" name="state" id="state" class="form-control">
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-12 mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" name="city" id="city" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-12 mb-3">
                                        <label for="class">Class Applying to</label>
                                        <select name="class" id="class" class="form-select">
                                            <option value="JSS1">JSS1</option>
                                            <option value="SS1">SS1</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="text" name="reg" id="reg" class="form-control registration" value="<?php echo $registration_no; ?>" >
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-12 text-center mb-3">
                                        <button class="btn btn-outline-primary" name="entrance_submit" >Submit</button>
                                    </div>
                                </div>

                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </aside>
    </section>


    <!-- ===========  COMMON ENTRANCE REGISTRATION FORM  =============== -->

    <!-- <section id="entrance">
        <aside>
            <h2>Common Entrance Registration</h2>
            <form action="">
                <a onclick="toggleEntrance()" href="" class="close">
                    close
                </a>
                <h4>Username</h4>
                <input type="text">
                <h4>Password</h4>
                <input type="password">
                <button type="submit">login</button>
            </form>
        </aside>
    </section> -->

    <!-- ========== TEACHER REGISTRATION FORM  ================== -->

    <!-- <section id="teacher">
        <aside>
            <h2>Teacher Registration</h2>
            <form action="">
                <a onclick="toggleTeacher()" href="" class="close">
                    close
                </a>
                <h4>Username</h4>
                <input type="text">
                <h4>Password</h4>
                <input type="password">
                <button type="submit">login</button>
            </form>
        </aside>
    </section> -->

    <!-- ==========  JOB APPLICATION REGISTRATION FORM  ================= -->

    <!-- <section id="application">
        <aside>
            <h2>Job Application Registration</h2>
            <form action="">
                <a onclick="toggleApplication()" href="" class="close">
                    close
                </a>
                <h4>Username</h4>
                <input type="text">
                <h4>Password</h4>
                <input type="password">
                <button type="submit">login</button>
            </form>
        </aside>
    </section> -->



    <!-- Linking to the bootstrap script tag  ==================== -->
    <script src="../assets/js/public/bootstrap.js"></script>

    <!-- ========   Linking to the jquery library  ================ -->
    <script src="../assets/js/publicjquery.js"></script>

    <!-- ===========  Linking to mixitup  ============== -->
    <script src="../assets/js/public/mixitup.js"></script>

    <!-- =======    Linking to javascript file ========== -->
    <script src="../assets/js/public/register.js"></script>

    <!-- ==========  FOR MIXITUP FUNCTIONALITY -->

    <script src="../assets/js/public/axios.js"></script>
    <script>

        
    </script>


<script src="../assets/js/public/sweetalert.min.js"></script>

        <?php 
            if(isset($_SESSION['status'])){
        ?>
            <script>
                swal({
                    title: "<?php echo $_SESSION['status']; ?>",
                    icon: "<?php echo $_SESSION['status_code']; ?>",
                    button: "Done!",
                });
            </script>
                <?php
                unset($_SESSION['status']);  
            }
            ?>
</body>

</html>