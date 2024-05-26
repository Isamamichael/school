<?php



    include '../classes/test.class.php';

    

    if (isset($_POST['entrance_submit']))
    {
        session_start();
        


        $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirm = filter_input(INPUT_POST, 'confirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //Get image size

        $allowed_ext = ['png', 'jpg', 'jpeg', 'gif'];

        $passport = $_FILES['passport']['name'];
        $passport_size = $_FILES['passport']['size'];
        //Get temporary directory with name of image that is being uploaded
        //When image is being uploaded, it is first sent to a temporal directory 
        //before after successfull upload it is now moved from there to your target directory
        $passport_tmp = $_FILES['passport']['tmp_name'];
        //Get image extension
        $passport_ext = explode('.', $passport);
        //Convert image extension to lowercase and make usable
        $passport_ext = strtolower(end($passport_ext));
        //Set directory images enter when uploaded
        //We are saving image name as their phone number attached with the current day, month, year and time
        //and appending image extension to it so as to have a unique image name
        $dayInNumber = date("d");
        $monthInNumber = date("m");
        $year = date("Y");
        $time24Hour = date("G");
        $timeMin = date("i");
        $timeSecs = date("s");
        $passport = "{$phone}{$dayInNumber}{$monthInNumber}{$year}{$time24Hour}{$timeMin}{$timeSecs}.{$passport_ext}";
        $target_dir = "../uploads/{$passport}";


        $dateOfBirth = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $class = filter_input(INPUT_POST, 'class', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg = filter_input(INPUT_POST, 'reg', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        
        
             
        
        $testObj = new Test();
        $testObj->CommonEntrance($firstName, $lastName, $address, $phone, $email, $password, $confirm, $gender, $passport, $passport_ext, $passport_size, $passport_tmp, $allowed_ext, $target_dir, $dateOfBirth, $country, $state, $city, $class, $reg) ;
    }


?>