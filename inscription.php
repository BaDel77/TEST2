<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "mon_site");
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    $pseudo = $conn->real_escape_string($_POST['pseudo']);
    $email = $conn->real_escape_string($_POST['email']);
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    $sql_check = "SELECT id FROM utilisateurs WHERE email='$email'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        $message = "Cette adresse email est déjà utilisée.";
        $message_type = "error";
    } else {
        $sql = "INSERT INTO utilisateurs (pseudo, email, mot_de_passe) VALUES ('$pseudo', '$email', '$mot_de_passe')";
        if ($conn->query($sql) === TRUE) {
            $message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            $message_type = "success";
        } else {
            $message = "Erreur : " . $conn->error;
            $message_type = "error";
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Inscription - Flover</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background-color: #111;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      overflow: hidden;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.05);
      padding: 40px 50px;
      border-radius: 20px;
      box-shadow: 0 0 20px #ff5c8d66;
      width: 400px;
      animation: slideDown 0.6s ease forwards;
      backdrop-filter: blur(8px);
    }

    @keyframes slideDown {
      from { transform: translateY(-30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #ff5c8d;
      font-size: 28px;
      text-shadow: 1px 1px 6px #ff5c8d88;
    }

    label {
      font-weight: 600;
      color: #eee;
      display: block;
      margin-bottom: 6px;
      font-size: 15px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px 15px;
      margin-bottom: 20px;
      border: 2px solid #444;
      border-radius: 12px;
      font-size: 15px;
      background-color: #222;
      color: #fff;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: #ff5c8d;
      box-shadow: 0 0 8px #ff5c8d88;
      outline: none;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #ff5c8d;
      border: none;
      border-radius: 25px;
      color: white;
      font-size: 17px;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.3s ease;
      box-shadow: 0 0 15px #ff5c8d88;
    }

    button:hover {
      transform: translateY(-2px);
      background-color: #e54d7a;
    }

    .message {
      margin-bottom: 20px;
      padding: 12px;
      border-radius: 8px;
      font-weight: 600;
      text-align: center;
      font-size: 14px;
    }

    .message.success {
      background-color: rgba(0, 255, 140, 0.1);
      color: #00e887;
      border: 1px solid #00e887;
      box-shadow: 0 0 10px #00e88755;
    }

    .message.error {
      background-color: rgba(255, 92, 141, 0.15);
      color: #ff5c8d;
      border: 1px solid #ff5c8d;
      box-shadow: 0 0 10px #ff5c8d55;
    }

    p {
      text-align: center;
      margin-top: 15px;
      color: #aaa;
    }

    a {
      color: #ff5c8d;
      text-decoration: none;
      font-weight: 600;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Inscription</h2>

    <?php if (!empty($message)): ?>
      <div class="message <?= htmlspecialchars($message_type) ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form action="inscription.php" method="post" novalidate>
      <label for="pseudo">Pseudo :</label>
      <input type="text" id="pseudo" name="pseudo" required autocomplete="username" />

      <label for="email">Email :</label>
      <input type="email" id="email" name="email" required autocomplete="email" />

      <label for="mot_de_passe">Mot de passe :</label>
      <input type="password" id="mot_de_passe" name="mot_de_passe" required autocomplete="new-password" />

      <button type="submit">S’inscrire</button>
      <p>Déjà un compte ? <a href="connexion.php">Connecte-toi ici</a></p>
    </form>
  </div>
</body>
</html>
