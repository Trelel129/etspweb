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
//drop first
$sql_drop = "DROP DATABASE IF EXISTS etspweb";


//create database once
$sql = "CREATE DATABASE if not exists etspweb";
if ($link->query($sql) === TRUE) {
    echo "";
    $link->select_db("etspweb");
  } else {
    echo "Error creating database: " . $link->error;
  }

//create users
$sql_users = "CREATE TABLE if not exists users (
    id INT NOT NULL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);";
if (mysqli_query($link, $sql_users)) {
    echo "";
  } else {
    echo "Error creating table: " . mysqli_error($link);
  }

  //create games (was employee)
$sql_games = "CREATE TABLE if not exists games (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  developer VARCHAR(100) NOT NULL,
  years INT(5) NOT NULL,
  descr VARCHAR(200),
  genre VARCHAR(200),
  author_id INT(10) NOT NULL,
  foreign key (author_id) references users(id)
);";
if (mysqli_query($link, $sql_games)) {
  echo "";
  } else {
    echo "Error creating table: " . mysqli_error($link);
  }

//cara ngambil nama developer dari tabel games gimana ya?
$sql_developerdetail = "CREATE TABLE if not exists games (
  id INT NOT NULL PRIMARY KEY,
  developer_id INT(100) NOT NULL,
  devdescription VARCHAR(500) NOT NULL,
  foreign key (developer_id) references games(id)
)";
if (mysqli_query($link, $sql_developerdetail)) {
  echo "";
  } else {
    echo "Error creating table: " . mysqli_error($link);
  }
?>

