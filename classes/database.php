<?php
    class database
    {
        function opencon(){
        return new PDO('mysql:host=localhost;dbname=phpoop_221', 'root', '');
    }
    
    function check($username, $password){
        $con = $this->opencon();
        $query = "SELECT * from users WHERE user_name = '".$username."'&&user_pass='".$password."' ";
        return $con->query($query)->fetch();

    }


    function signupUser($username, $password, $firstname, $lastname, $date, $sex){
        $con = $this->opencon();

        $query = $con->prepare("SELECT user_name FROM users WHERE user_name = ?");
        $query->execute([$username]);
        $existingUser = $query->fetch();

        if ($existingUser) {
            return false;
        }

        return $con->prepare("INSERT INTO users (user_name, user_pass, user_fn, user_ln, user_birth, user_sex) VALUES (?, ?, ?, ?, ? ,?)")
        ->execute([$username, $password, $firstname, $lastname, $date, $sex]);
    }
    function insertAddress($user_id, $street, $barangay, $city, $province){
        $con = $this->opencon();

        $query = $con->prepare("INSERT INTO user_address (user_id, user_street, user_barangay, user_city, user_province) VALUES (?, ?, ?, ?, ?)")
        ->execute([$user_id, $street, $barangay, $city, $province]);
        return $con->lastInsertId();
    }

    function view (){
        $con = $this->opencon();
        return $con->query("SELECT users.user_id, users.user_fn, users.user_ln, users.user_birth, users.user_sex, users.user_name, 
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
}