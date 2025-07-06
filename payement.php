<?php
// traitement du formulaire (en haut du fichier)
$message = '';
$message_type = ''; // success or error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // connexion BDD (modifie ces infos)
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "mon_site";

    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    // récupérer et nettoyer les données
    $nom = trim($_POST['nom_complet'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $numero_cb = trim($_POST['numero_cb'] ?? '');
    $date_exp = trim($_POST['date_exp'] ?? '');
    $cvv = trim($_POST['cvv'] ?? '');

    // validation simple
    $errors = [];
    if ($nom === '') $errors[] = "Le nom complet est obligatoire.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide.";
    if (!preg_match('/^\d{4} \d{4} \d{4} \d{4}$/', $numero_cb)) $errors[] = "Le numéro de carte doit être au format 0000 0000 0000 0000.";
    if (!preg_match('/^(0[1-9]|1[0-2])\/?([0-9]{2})$/', $date_exp)) $errors[] = "Date d'expiration invalide (MM/AA).";
    if (!preg_match('/^\d{3}$/', $cvv)) $errors[] = "CVV invalide.";

    if (count($errors) === 0) {
        // préparer la requête
        $stmt = $conn->prepare("INSERT INTO paiements (nom, email, numero_cb, date_exp, cvv, date_paiement) VALUES (?, ?, ?, ?, ?, NOW())");
        $numero_cb_clean = str_replace(' ', '', $numero_cb); // enlever espaces
        $stmt->bind_param("sssss", $nom, $email, $numero_cb_clean, $date_exp, $cvv);

        if ($stmt->execute()) {
            $message = "Paiement effectué avec succès, merci $nom !";
            $message_type = 'success';
            $nom = $email = $numero_cb = $date_exp = $cvv = '';
        } else {
            $message = "Erreur lors de l'enregistrement du paiement : " . $stmt->error;
            $message_type = 'error';
        }
        $stmt->close();
    } else {
        $message = implode("<br>", $errors);
        $message_type = 'error';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Paiement - Flover</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <style>
    /* === CSS amélioré === */
    html, body {
      height: 100%;
      margin: 0;
      background: linear-gradient(135deg, #1a1a1a, #111);
      color: #fff;
      font-family: 'Poppins', sans-serif;
      overflow: hidden;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 30px 15px 15px;
      box-sizing: border-box;
      height: 100vh;
    }

    .payment-container {
      background: rgba(255, 92, 141, 0.18);
      backdrop-filter: blur(30px);
      border-radius: 30px;
      padding: 35px 30px 30px;
      width: 100%;
      max-width: 500px;
      max-height: 95vh;
      box-sizing: border-box;
      overflow-y: auto;
      box-shadow: 0 8px 30px rgba(255, 92, 141, 0.4);
      border: 2px solid #ff5c8d;
      display: flex;
      flex-direction: column;
    }

    h1 {
      text-align: center;
      color: #ff5c8d;
      margin: 0 0 25px;
      font-weight: 900;
      font-size: 2.4rem;
      letter-spacing: 1.2px;
      text-shadow: 0 0 12px #ff5c8dcc;
      user-select: none;
    }

    .payment-methods {
      display: flex;
      justify-content: space-evenly;
      margin-bottom: 30px;
      flex-shrink: 0;
      gap: 15px;
    }

    .payment-method {
      cursor: pointer;
      border: 2.5px solid transparent;
      border-radius: 20px;
      padding: 12px 18px;
      background: rgba(255, 255, 255, 0.12);
      box-shadow: 0 2px 10px rgba(255, 92, 141, 0.25);
      transition: border-color 0.35s ease, box-shadow 0.35s ease, transform 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      filter: grayscale(40%);
      user-select: none;
    }

    .payment-method.selected {
      border-color: #ff5c8d;
      box-shadow: 0 0 25px #ff5c8d;
      filter: none;
      transform: scale(1.05);
    }

    .payment-method img {
      width: 55px;
      height: auto;
      display: block;
      pointer-events: none;
      user-select: none;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
      flex-shrink: 0;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 14px 18px;
      border-radius: 22px;
      border: 2.5px solid rgba(255, 255, 255, 0.25);
      background: rgba(255, 255, 255, 0.05);
      color: #fff;
      font-size: 1.1rem;
      font-weight: 500;
      outline: none;
      transition: border-color 0.4s ease, box-shadow 0.4s ease;
      box-sizing: border-box;
      box-shadow: inset 0 1px 3px rgba(255, 255, 255, 0.15);
    }

    input::placeholder {
      color: #ffabc1cc;
      font-style: italic;
      letter-spacing: 0.03em;
    }

    input:focus {
      border-color: #ff5c8d;
      box-shadow: 0 0 12px #ff5c8daa, inset 0 0 6px #ff5c8dcc;
      background: rgba(255, 92, 141, 0.1);
    }

    .btn-pay {
      background-color: #ff5c8d;
      border: none;
      border-radius: 30px;
      color: #fff;
      font-weight: 900;
      font-size: 1.25rem;
      padding: 14px 0;
      cursor: pointer;
      box-shadow: 0 0 25px #ff5c8dbb;
      transition: background-color 0.4s ease, box-shadow 0.4s ease, transform 0.15s ease;
      user-select: none;
      flex-shrink: 0;
    }

    .btn-pay:hover {
      background-color: #e54177;
      box-shadow: 0 0 35px #e54177cc;
      transform: translateY(-3px);
    }

    .btn-pay:active {
      transform: translateY(0);
      box-shadow: 0 0 20px #d53c6bcc;
    }

    .message {
      margin-bottom: 20px;
      padding: 14px 20px;
      border-radius: 20px;
      font-weight: 700;
      font-size: 1rem;
      line-height: 1.3;
      word-break: break-word;
      user-select: none;
    }

    .message.success {
      background-color: #28a745;
      color: #d4f8d4;
      border: 2px solid #1f7a31;
      text-shadow: 0 0 6px #d4f8d4;
      box-shadow: 0 0 15px #28a74599;
    }

    .message.error {
      background-color: #dc3545;
      color: #ffccd1;
      border: 2px solid #a12632;
      text-shadow: 0 0 6px #ffccd1;
      box-shadow: 0 0 15px #dc354599;
    }

    @media (max-width: 520px) {
      .payment-methods {
        flex-direction: column;
        gap: 18px;
      }
      .payment-method {
        width: 100%;
        text-align: center;
      }
      .payment-method img {
        width: 48px;
      }
    }
  </style>
</head>
<body>
  <div class="payment-container">
    <h1>Paiement</h1>

    <div class="payment-methods" id="payment-methods">
      <div class="payment-method selected" data-method="visa" title="Visa">
        <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" />
      </div>
      <div class="payment-method" data-method="mastercard" title="MasterCard">
        <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="MasterCard" />
      </div>
      <div class="payment-method" data-method="paypal" title="PayPal">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" />
      </div>
    </div>

    <?php if($message): ?>
      <div class="message <?= $message_type === 'success' ? 'success' : 'error' ?>">
        <?= $message ?>
      </div>
    <?php endif; ?>

    <form id="payment-form" action="" method="post" novalidate>
      <input type="text" name="nom_complet" placeholder="Nom complet" value="<?= htmlspecialchars($nom ?? '') ?>" required>
      <input type="email" name="email" placeholder="exemple@mail.com" value="<?= htmlspecialchars($email ?? '') ?>" required>
      <input type="text" name="numero_cb" placeholder="0000 0000 0000 0000" value="<?= htmlspecialchars($numero_cb ?? '') ?>" required pattern="\d{4} \d{4} \d{4} \d{4}">
      <input type="text" name="date_exp" placeholder="MM/AA" value="<?= htmlspecialchars($date_exp ?? '') ?>" required pattern="^(0[1-9]|1[0-2])\/?([0-9]{2})$">
      <input type="password" name="cvv" placeholder="123" value="<?= htmlspecialchars($cvv ?? '') ?>" required pattern="\d{3}">
      <input class="btn-pay" type="submit" value="Payer">
    </form>
  </div>

  <script>
    const paymentMethods = document.querySelectorAll('.payment-method');
    let selectedMethod = 'visa';

    paymentMethods.forEach(method => {
      method.addEventListener('click', () => {
        paymentMethods.forEach(m => m.classList.remove('selected'));
        method.classList.add('selected');
        selectedMethod = method.dataset.method;
      });
    });

  </script>
</body>
</html>
