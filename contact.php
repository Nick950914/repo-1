<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim(filter_input(INPUT_POST,"first_name",FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL));
    $subject = trim(filter_input(INPUT_POST,"subject",FILTER_SANITIZE_STRING));
    $message = trim(filter_input(INPUT_POST,"message",FILTER_SANITIZE_SPECIAL_CHARS));
    $meme = "";
    if(isset($_POST['meme']) && $_POST['meme'] == 1) {
      $meme = 1;
    } else {
      $meme = 0;
    }

    
    if ($name == "" || $email == "" || $subject == "" || $message == "") {
        $error_message = "Моля, попълнете необходимите полета: Име, Имейл, Относно и Съобщение";
    }
    if (!isset($error_message) && $_POST["address"] != "") {
        $error_message = "Bad form input";
    }
    if (!isset($error_message)) {
      header("location:contact.php?status=thanks");
      //keeping this line commented out; stops the database insertion from happening
      //exit;
    }
    
    // Connection to the DB

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "suggest";

    $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
      die('Connect Error (' . mysqli_connect_errno() . ') '
      . mysqli_connect_error());
    } else if (!$error_message) {
      $sql = "INSERT INTO clients (name, email, subject, message, meme) values (?, ?, ?, ?, '$meme')";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssss", $name, $email, $subject, $message);
      $stmt->execute();

      $stmt->close();
      
        if ($conn->query($sql)){
          echo "New record is inserted successfully";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      $conn->close();
    }

   
}


$pageTitle = "Contact us";
$section = contact;
include("inc/header.php"); 
?>


<div class="contact-form">
  <?php 
  if (!isset($error_message)) {
   echo "<h3>Ако имате въпроси, свържете се с нас!</h3>";
  } else {
   echo "<h3 class='error'>".$error_message."</h3>";
  }
  ?>
  <?php if (isset($_GET["status"]) && $_GET["status"] == "thanks") {
    echo "<h3 class='thanks'>Thank you for your input!</h3>";
  } else { ?>
 <form method="post" action="contact.php">
  <table>
    <tr>
      <th><label for="име">Име:</label></th>
      <td><input type="text" id="име" name="first_name" value="<?php if (isset($name)) { echo $name; } ?>"></td>
    </tr>
    <tr>
      <th><label for="имейл">Имейл:</label></th>
      <td><input type="email" id="имейл" name="email" value="<?php if (isset($email)) { echo $email; } ?>"></td>
    </tr>
    <tr>
      <th><label for="относно">Относно:</label></th>
      <td><input type="text" id="относно" name="subject" value="<?php if (isset($subject)) { echo $subject; } ?>"></td>
    </tr>
    <tr>
      <th><label for="съобщение">Съобщение:</label></th>
      <td><textarea id="съобщение" name="message"></textarea></td>
    </tr>
    <tr style="display:none">
      <th><label for="address">Address</label></th>
      <td><input type="text" id="address" name="address" />
      <p>Please leave this field blank</p></td>
    </tr>
   </table>
    <input type="checkbox" name="meme" value="1"> Съсипаха я тая държава...<br><br>
    
    <button class="form-submit-button" type="submit">Изпрати</button>
  </form>
   <?php } ?>
 </div>

<?php include("inc/footer.php"); ?>







