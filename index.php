<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Janob DTD | Ro'yxatdan o'tish va Tizimga kirish sahifasi</title>

        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">
                
        <!-- Boxicons CSS -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
                        
    </head>
    <body>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                <p style="background-color: #4070f4; color: red; text-align: center; padding-top:25px; font-size:25px;">
<?php
$site = $_SERVER['HTTP_HOST'];
      require "app/config.php";
  ###### Tizimga kirish PHP #####

  if(isset($_POST['signin'])){
   $user = $_POST['user'];
   $select=mysqli_query($connect,"SELECT * FROM users WHERE username = '$user'");
   $num=mysqli_num_rows($select);
   if($num > 0){
      $MyPass = base64_decode(mysqli_fetch_assoc(mysqli_query($connect,"SELECT*FROM users WHERE username = '$user'"))['password']);
      $pass = $_POST['pass'];
      if($MyPass == $pass){
         $secret = "6Lf43qYmAAAAAGYrOCO8VX3MgOczvdYFAIhEVD5i";
         $response = $_POST['g-recaptcha-response'];
         $remoteip = $_SERVER['REMOTE_ADDR'];
         $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
         $data = file_get_contents($url);
         $row = json_decode($data, true);
          if ($row['success'] == "true") {
            header("Location: https://$site/login/success.php");
          }else{
            echo "Iltimos Captchani hal qiling !";
          }
      }else{
         echo "Parol noto'g'ri kiritildi !";
      }
   }else{
      echo "Bunday foydalanuvchi mavjud emas !";
   }
  }
     
    ###### Ro'yxatdan o'tish PHP #####
  
    if(isset($_POST['signup'])){
      $user = $_POST['user'];
      $select=mysqli_query($connect,"SELECT * FROM users WHERE username = '$user'");
      $num=mysqli_num_rows($select);
      if($num < 1){
         $email = $_POST['email'];
         $select=mysqli_query($connect,"SELECT * FROM users WHERE email = '$email'");
         $num1=mysqli_num_rows($select);
         if($num1 < 1){
            $secret = "6Lf43qYmAAAAAGYrOCO8VX3MgOczvdYFAIhEVD5i";
            $response = $_POST['g-recaptcha-response'];
            $remoteip = $_SERVER['REMOTE_ADDR'];
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
            $data = file_get_contents($url);
            $row = json_decode($data, true);
             if ($row['success'] == "true") {
               $pass = base64_encode($_POST['pass']);
               $sql = "INSERT INTO users (username,email,password) VALUES ('$user','$email','$pass')";
               $result = mysqli_query($connect, $sql);
               header("Location: https://$site/login/success.php");
             }else{
               echo "Iltimos Captchani hal qiling !";
             }
         }else{
            echo "Ushbu email avval ro'yxatdan o'tgan !";
         }
      }else{
         echo "Ushbu Username band !";
      }
   }

?>
     </p>
        <section class="container forms">
            <div class="form login">
                <div class="form-content">
                    <header>Tizimga kirish</header>
                    <form action="" method="POST">
                        <div class="field input-field">
                            <input type="text" name="user" placeholder="Username" class="input">
                        </div>

                        <div class="field input-field">
                            <input type="password" name="pass" placeholder="Parol" class="password">
                            <i class='bx bx-hide eye-icon'></i>
                        </div><br>
                <div>
                      <div class="g-recaptcha" data-sitekey="6Lf43qYmAAAAAIG7Dym35hGcj8a4ofFJP7vpssj1"></div>
                  </div>

                        <div class="field button-field">
                            <button type="submit" name="signin">Tizimga kirish</button>
                        </div>
                    </form>

                    <div class="form-link">
                        <span>Hisobingiz yo'qmi ? <a href="#" class="link signup-link">Ro'yxatdan o'tish</a></span>
                    </div>
                </div>

            </div>

            <!-- Signup Form -->

            <div class="form signup">
                <div class="form-content">
                    <header>Ro'yxatdan o'tish</header>
                    <form action="" method="POST">
                        <div class="field input-field">
                            <input type="text" name="user" placeholder="Username" class="input">
                        </div>
                        <div class="field input-field">
                            <input type="email" name="email" placeholder="Email" class="input">
                        </div>
                        <div class="field input-field">
                            <input type="password" name="pass" placeholder="Parol" class="password">
                            <i class='bx bx-hide eye-icon'></i>
                        </div><br>
 <div>
                      <div class="g-recaptcha" data-sitekey="6Lf43qYmAAAAAIG7Dym35hGcj8a4ofFJP7vpssj1"></div>
                  </div>
                        <div class="field button-field">
                            <button type="submit" name="signup">Ro'yxatdan o'tish</button>
                        </div>
                    </form>

                    <div class="form-link">
                        <span>Hisobingiz bormi ? <a href="#" class="link login-link">Tizimga kirish</a></span>
                    </div>
                </div>

            </div>
        </section>

        <!-- JavaScript -->
        <script src="js/script.js"></script>
    </body>
</html>