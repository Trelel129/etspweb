<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

//create database once
$sql = "CREATE DATABASE if not exists etspweb";
if ($link->query($sql) === TRUE) {
    echo "";
    $link->select_db("etspweb");
  } else {
    echo "Error creating database: " . $link->error;
  }

//create employees
$sql_employees = "CREATE TABLE if not exists employees (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    salary INT(10) NOT NULL
);";
if (mysqli_query($link, $sql_employees)) {
    echo "";
  } else {
    echo "Error creating table: " . mysqli_error($link);
  }

//create users
$sql_users = "CREATE TABLE if not exists users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);";
if (mysqli_query($link, $sql_users)) {
    echo "";
  } else {
    echo "Error creating table: " . mysqli_error($link);
  }
?>