<?php

    include 'dbh.class.php';
    

    class Test extends Dbh{
        public function getUsers() {
            $sql = "SELECT * FROM commonentrance";
            $stmt = $this->connect()->query($sql);

            while($row = $stmt->fetch()){
                echo $row['first_name'].'<br>';
            }
        }

        public function getUsersStmt($firstname, $lastname) {
            $sql = "SELECT * FROM commonentrance WHERE first_name = ? AND last_name = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$firstname, $lastname]);
            $names = $stmt->fetchAll();

            
        }


        public function checkRegNo($randstr) {
            $sql = "SELECT * FROM commonentrance";
            $stmt = $this->connect()->prepare($sql);
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

        public function generateRegNo(){
            $keyLength = 8;
            $str = 'abcdefg';
            $randstr = substr(str_shuffle($str), 0, $keyLength);

            $checkRegNo= checkRegNo($randstr);

            while($checkRegNo == true){
                $randstr = substr(str_shuffle($str), 0, $keyLength);
                $checkRegNo = checkRegNo($randstr);
            }

            return $randstr;
        }

        public function CommonEntrance($firstName, $lastName, $address, $phone, $email, $password, $confirm, $gender, $passport, $passport_ext, $passport_size, $passport_tmp, $allowed_ext, $target_dir, $dateOfBirth, $country, $state, $city, $class) 
        {

            

            
            if(empty($firstName) or empty($lastName) or empty($address) or empty($phone) or empty($email) or empty($gender) or empty($passport)
                or empty($dateOfBirth) or empty($country) or empty($state) or empty($city) or empty($class)) 
            {
                $_SESSION['status'] = "All fields are required";
                $_SESSION['status_code'] = "warning";
                header("Location: ../../../public/register.php");
                exit();
            }
            
            if(!empty($passport)) 
            {
                if(!in_array($passport_ext, $allowed_ext))
                {
                    $_SESSION['status'] = "The File type is not supported";
                    $_SESSION['status_code'] = "error";
                    header("Location: ../../../public/register.php");
                    exit();
                }

                if($passport_size > 1000000)
                {
                    $_SESSION['status'] = "Your passport is too Large";
                    $_SESSION['status_code'] = "warning";
                    header("Location: ../../../public/register.php");
                    exit();
                }
            }

            if (!preg_match("/^[a-zA-Z-' ]*$/",$firstName) or !preg_match("/^[a-zA-Z-' ]*$/",$lastName)) {
                $_SESSION['status'] = "Only letters and white space allowed";
                $_SESSION['status_code'] = "warning";
                header("Location: ../../../public/register.php");
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['status'] = "Invalid email format";
                $_SESSION['status_code'] = "warning";
                header("Location: ../../../public/register.php");
                exit();
            }

            if(!preg_match('/^[0-9]{10}+$/', $phone)) {
                $_SESSION['status'] = "Invalid Phone Number";
                $_SESSION['status_code'] = "warning";
                header("Location: ../../../public/register.php");
                exit();
            }

            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                $_SESSION['status'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                $_SESSION['status_code'] = 'warning';
                header("Location: ../../../public/register.php");
                exit();
            }

            if($password !== $confirm){
                $_SESSION['status'] = 'Password and Confirm password do not match';
                $_SESSION['status_code'] = 'warning';
                header("Location: ../../../public/register.php");
                exit();
            }



            $sql = "SELECT * FROM commonentrance where email = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$email]);
            $applicants = $stmt->fetch(PDO::FETCH_ASSOC);
            $applicant_count = $stmt->rowCount();

            if($applicant_count> 0){
                $_SESSION['status'] = "Email already taken";
                $_SESSION['status_code'] = "error";
                header("Location: ../../../public/register.php");
                exit();
            }
            

            // $regNo = generateRegNo();

           
            // $stmt = $this->connect()->prepare('INSERT INTO commonentrance (first_name, last_name, address, phone, email, password, gender, passport, date, country, state, city, class, registration_no) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
        
            // $stmt->execute(array($firstName, $lastName, $address, $phone, $email, $password, $gender, $passport, $dateOfBirth, $country, $state, $city, $class, $reg));

            $sql = "INSERT INTO commonentrance (first_name,last_name,addresses,phone,email,passwords,gender,passport,dates,country,states,city,class,registration_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$firstName, $lastName, $address, $phone, $email, $password, $gender, $passport, $dateOfBirth, $country, $state, $city, $class, $reg]);
            
            move_uploaded_file($passport_tmp, $target_dir);

            if($stmt->rowCount() > 0){

                $_SESSION['status'] =  "Registration successful";
                $_SESSION['status_code'] = "success";
                header("Location: ../../../public/login.php");
               

                
            }
            else{
                $_SESSION['status'] = "Registration failed";
                $_SESSION['status_code'] = "error";
                header("Location: ../../../public/register.php");

            }

            
        }

        public function LoginEntrance($email, $password)
        {
            if(empty($email) or empty($password))
            {
                $_SESSION['status'] = 'All fields are required';
                $_SESSION['status_code'] = 'warning';
                header("Location: ../../../public/login.php");
            }

            $sql = "SELECT * FROM commonentrance WHERE email = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$email]);
            $email_taken = $stmt->fetch(PDO::FETCH_ASSOC);
            $email_count = $stmt->rowCount();
            if(!($email_count > 0))
            {
                $_SESSION['status'] = 'Email Address is Incorrect';
                $_SESSION['status_code'] = 'error';
                header("Location: ../../../public/login.php");
            }


            $sql = "SELECT * FROM commonentrance WHERE passwords = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$password]);
            $password_count = $stmt->rowCount();
            if(!($password_count > 0))
            {
                $_SESSION['status'] = 'Your password is Incorrect';
                $_SESSION['status_code'] = 'error';
                header("Location: ../../../public/login.php");
            }

            if($email_count > 0  && $password_count > 0)
            {
                $_SESSION['first_name'] = $email_taken['first_name'];
                $_SESSION['last_name'] = $email_taken['last_name'];
                $_SESSION['passport'] = $email_taken['passport'];
                $_SESSION['email'] = $email_taken['email'];
                $_SESSION['status'] = 'Welcome Back '.$_SESSION['first_name'].' '.$_SESSION['last_name'];
                $_SESSION['status_code'] = 'success';
                header("Location: ../pages/applicantDashboard.php");
            }
        }
        
    }

?>