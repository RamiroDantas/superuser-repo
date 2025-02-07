<?php

require_once '../config.php';

$email = $password = $confirm_password = $name = "";
$email_err = $password_err = $confirm_password_err = $name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = trim($_POST["Name"]);
  $role = trim($_POST["Role"]);

  $sql = "SELECT atendente_id FROM atendente_users WHERE atendente_email = :email";

  if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":email", $param_email);
    $param_email = trim($_POST["Email"]);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
      $email_err = "Esse email já foi usado.";
    } else {
      $email = $param_email;
    }
  }

  $password = trim($_POST["Password"]);
  // Insere no banco de dados se não houver erros
  if (empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($name_err)) {

    // Prepara a instrução INSERT
    $sql = "INSERT INTO atendente_users (atendente_name, atendente_email, password, role) VALUES (:name, :email, :password, :role)";

    if ($stmt = $pdo->prepare($sql)) {
      // Define os parâmetros
      $param_password = password_hash($password, PASSWORD_DEFAULT);

      // Associa os valores aos placeholders
      $stmt->bindParam(":name", $name);
      $stmt->bindParam(":email", $email);
      $stmt->bindParam(":password", $param_password);
      $stmt->bindParam(":role", $role);
      // Executa a instrução
      if ($stmt->execute()) {
        header("location: ../register.php");
        exit();
      } else {
        echo "Oops! Algo deu errado. Por favor, tente novamente.";
      }
    }
  }

  // Fecha a conexão
  unset($pdo);
}
?>