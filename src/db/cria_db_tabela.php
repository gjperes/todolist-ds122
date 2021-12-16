<?php
require 'db_credentials.php';

// Create connection
$conn = mysqli_connect($servername, $username, $db_password);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE $dbname";
if (mysqli_query($conn, $sql)) {
    echo "<br>Database created successfully<br>";
} else {
    echo "<br>Error creating database: " . mysqli_error($conn);
}

// Choose database
$sql = "USE $dbname";
if (mysqli_query($conn, $sql)) {
    echo "<br>Database changed";
} else {
    echo "<br>Error creating database: " . mysqli_error($conn);
}

// SQL para criar a tabela de tarefas
$sql = "CREATE TABLE $tarefas (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(100) NOT NULL,
            feito BOOLEAN DEFAULT false,
            data_criado DATETIME NOT NULL
        )";

if (mysqli_query($conn, $sql)) {
    echo "<br>Tabela $tarefas criada com sucesso";
} else {
    echo "<br>Erro criando tabela: " . mysqli_error($conn);
}

// SQL para criar a tabela de dados do usuário
$sql = "CREATE TABLE $tabela_user (
            userID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nomeUser VARCHAR(50) NOT NULL,
            emailUser VARCHAR(50) NOT NULL,
            senhaUser VARCHAR(40) NOT NULL,
            CONSTRAINT user_unique UNIQUE (userID),
            CONSTRAINT emailuser_unique UNIQUE (emailUser)
        )";

if (mysqli_query($conn, $sql)) {
    echo "<br>Tabela $tabela_user criada com sucesso";
} else {
    echo "<br>Erro criando tabela: " . mysqli_error($conn);
}

// SQL para criar a tabela de relacionamento entre usuário/tarefas
$sql = "CREATE TABLE $relacionamento (
            userID INT UNSIGNED,
            myTasksID INT UNSIGNED,
            FOREIGN KEY (userID) REFERENCES $tabela_user(userID),
            FOREIGN KEY (myTasksID) REFERENCES $tarefas(id)
        )";

if (mysqli_query($conn, $sql)) {
    echo "<br>Tabela $relacionamento criada com sucesso";
} else {
    echo "<br>Erro criando tabela: " . mysqli_error($conn);
}


mysqli_close($conn);

?>
