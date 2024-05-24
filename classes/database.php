<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    class database
    {
        function opencon(){
        return new PDO('mysql:host=localhost;dbname=phpoop_221', 'root', '');
    }
    
    //function check($username, $password){
        //$con = $this->opencon();
        //$query = "SELECT * from users WHERE user_name = '".$username."'&&user_pass='".$password."' ";
        //return $con->query($query)->fetch();

    //}
        function check($username, $password) {
        // Open database connection
        $con = $this->opencon();
    
        // Prepare the SQL query
        $stmt = $con->prepare("SELECT * FROM users WHERE user_name = ?");
        $stmt->execute([$username]);
    
        // Fetch the user data as an associative array
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // If a user is found, verify the password
        if ($user && password_verify($password, $user['user_pass'])) {
            return $user;
        }
    
        // If no user is found or password is incorrect, return false
        return false;
    }


    //function signupUser($username, $password, $firstname, $lastname, $date, $sex){
        //$con = $this->opencon();

        //$query = $con->prepare("SELECT user_name FROM users WHERE user_name = ?");
        //$query->execute([$username]);
        //$existingUser = $query->fetch();

        //if ($existingUser) {
            //return false;
        //}

        //return $con->prepare("INSERT INTO users (user_name, user_pass, user_fn, user_ln, user_birth, user_sex) VALUES (?, ?, ?, ?, ? ,?)")
        //->execute([$username, $password, $firstname, $lastname, $date, $sex]);
    //}
    function signupUser($firstname, $lastname, $birthday, $sex, $email, $username, $password, $profilePicture)
    {
        $con = $this->opencon();
        // Save user data along with profile picture path to the database
        $con->prepare("INSERT INTO users (user_fn, user_ln, user_birth, user_sex, user_email, user_name, user_pass, user_profile_picture) VALUES (?,?,?,?,?,?,?,?)")->execute([$firstname, $lastname, $birthday, $sex, $email, $username, $password, $profilePicture]);
        return $con->lastInsertId();
        }
    function insertAddress($user_id, $street, $barangay, $city, $province){
        $con = $this->opencon();

        $query = $con->prepare("INSERT INTO user_address (user_id, user_street, user_barangay, user_city, user_province) VALUES (?, ?, ?, ?, ?)")
        ->execute([$user_id, $street, $barangay, $city, $province]);
        return $con->lastInsertId();
    }

    function view (){
        $con = $this->opencon();
        return $con->query("SELECT users.user_id, users.user_fn, users.user_ln, users.user_birth, users.user_sex, users.user_email, users.user_name, users.user_profile_picture,
        CONCAT (user_address.user_street, ' ', user_address.user_barangay, ' ', user_address.user_city, ' ', user_address.user_province) 
        AS users_address
        FROM users
        INNER JOIN user_address ON users.user_id = user_address.user_id;")->fetchAll();
    }

    function delete($id)
    {
        try {
            $con = $this->opencon();
            $con->beginTransaction();

            //Delete user address
            $query = $con->prepare("DELETE FROM user_address WHERE user_id=?");
            $query->execute([$id]);
 
            $query2 = $con->prepare("DELETE FROM users WHERE user_id=?");
            $query2->execute([$id]);

            $con->commit();
            return true; //Deletion successful
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
       }
    }    
    
    function viewdata($id){
        try{
        $con = $this->opencon();
        $query= $con->prepare("SELECT users.user_id, users.user_fn, users.user_ln, users.user_birth, users.user_sex, users.user_name, users.user_pass, 
        user_address.user_street, user_address.user_barangay, user_address.user_city, user_address.user_province
        FROM users
        INNER JOIN user_address ON users.user_id = user_address.user_id WHERE users.user_id =?;");
        $query->execute([$id]);
        return  $query->fetch();
    } catch (PDOException $e){
        return [];
        }
    }

    function updateUser ($user_id, $username, $password, $firstname, $lastname, $date, $sex){
        try {
            $con = $this->opencon();
            $query = $con->prepare("UPDATE users SET user_name=?, user_pass=?, user_fn=?, user_ln=?, user_birth=?, user_sex=? WHERE user_id=?");
            return $query->execute([$username, $password, $firstname, $lastname, $date, $sex, $user_id]);
        } catch (PDOException $e) {
            return false;
        }
    }
    function updateUserAddress($user_id, $street, $barangay, $city, $province){
        try {
            $con = $this->opencon();
            $query = $con->prepare("UPDATE user_address SET user_street=?, user_barangay=?, user_city=?, user_province=? WHERE user_id=?");
            return $query->execute([$street, $barangay, $city, $province, $user_id]);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    function getusercount()
    {
        $con = $this->opencon();
        return $con->query("SELECT SUM(CASE WHEN user_sex = 'Male' THEN 1 ELSE 0 END) AS male_count,
        SUM(CASE WHEN user_sex = 'Female' THEN 1 ELSE 0 END) AS female_count FROM users;")->fetch();
    }
    
    function checkEmailExists($email) {
        $con = $this->opencon();
        $query = $this->$con->prepare("SELECT user_email FROM users WHERE user_email = ?");
        $query->execute([$email]);
        return $query->fetch();
    }
    
    function validateCurrentPassword($userId, $currentPassword) {
        // Open database connection
        $con = $this->opencon();
    
        // Prepare the SQL query
        $query = $con->prepare("SELECT user_pass FROM users WHERE user_id = ?");
        $query->execute([$userId]);
    
        // Fetch the user data as an associative array
        $user = $query->fetch(PDO::FETCH_ASSOC);
    
        // If a user is found, verify the password
        if ($user && password_verify($currentPassword, $user['user_pass'])) {
            return true;
        }
    
        // If no user is found or password is incorrect, return false
        return false;
    }
    function updatePassword($userId, $hashedPassword) {
        $con = $this->opencon();
        $query = $con->prepare("UPDATE users SET user_pass = ? WHERE user_id = ?");
        return $query->execute([$hashedPassword, $userId]);
    }
    }