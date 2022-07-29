<?php
require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students WHERE email='$email'"))>=1) {
        echo "<script>alert('User Email Already Taken')</script>";
        header("refresh: 1; url=../forms/register.html"); 
    } else {
        $query = "INSERT INTO `students` (`full_names`, `email`, `password`, `gender`, `country`) 
                    VALUES ('$fullnames','$email', '$password','$gender','$country')
                ";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('User Successfully created')</script>";
            header("refresh: 1; url=../forms/login.html");
        } else {
            echo "Error:" . $query . "</br>" . mysqli_error($conn);
        }
    }
   //check if user with this email already exist in the database
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    $query = "SELECT * FROM students WHERE email='$email' AND password='$password'";
    $return = mysqli_query($conn, $query);
    if (mysqli_num_rows($return) >= 1) {
        session_start();
        $_SESSION['username'] = $email;
        header("location: ../dashboard.php");
    } else {
        header("Location: ../forms/login.html?message=UserDoesNotExist");
    }
    echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students WHERE email='$email'"))>=1) {
        $query = "UPDATE students set password='$password' WHERE email='$email'";
        if (mysqli_query($conn, $query)) {
            echo "<script> alert('Password Successfully Updated!');</script>";
        }else {
            echo "<script> alert('Error!!! Please try again!!!');</script>";
        }
    } else {
        echo "<script> alert('User does not exist, Please try again!!!');</script>";
    }
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students WHERE id=$id"))) {
        $query = "DELETE FROM students WHERE id=$id";
        if (mysqli_query($conn, $query)) {
            echo "Successfully deleted";
            header("refresh: 1, url=action.php?all=");
        }
    }
     //delete user with the given id from the database
 }
 
 function logout(){
     if($_SESSION['username']) {
        session_unset();
        session_destroy();
        header("Location: ../index.php");
     }
     //delete user with the given id from the database
 }
