<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursy giełdowe</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="logo_stopka.png" type="image/png">
    <script src="https://kit.fontawesome.com/dbdc945dcf.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" asyncdefer></script>
  <script src="https://www.google.com/recaptcha/enterprise.js?render=6LdqJWQqAAAAAK8rKqLnYNveOjSty6fZbAVE9Ib0"></script>


</head>
<?php
session_start();
?>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            // rejestracja
            const urlParams = new URLSearchParams(window.location.search);
            const registerError = urlParams.get('register_error');

            if (registerError) {
            switch (registerError) {
                case 'empty':
                    alert('Wszystkie pola są wymagane przy rejestracji!');
                    break;
                case 'user_or_email_exists':
                    alert('Nazwa lub adres E-mail już jest zajęty.');
                    break;
                case 'weak_password':
                    alert('Hasło musi mieć co najmniej 12 znaków i maksymalnie 128.');
                    break;
                case 'password_mismatch':
                    alert('Hasła nie są zgodne. Wpisz ponownie.');
                    break;
                case 'server':
                    alert('Wystąpił błąd serwera podczas rejestracji. Spróbuj ponownie później.');
                    break;
                case 'invalid_request':
                    alert('Nieprawidłowe żądanie rejestracji.');
                    break;
                case 'invalid_email':
                    alert('Niepoprawny adres E-mail.');
                    break;
                default:
                    alert('Wystąpił nieznany błąd podczas rejestracji.');
            }
        }

        // logowanie
        const loginerror = urlParams.get('login_error');

            if (loginerror) {
                switch (loginerror) {
                    case 'empty':
                        alert('Wszystkie pola są wymagane!');
                        break;
                    case 'invalid':
                        alert('Niepoprawna nazwa użytkownika lub hasło.');
                        break;
                    case 'server':
                        alert('Wystąpił błąd serwera. Spróbuj ponownie później.');
                        break;
                    case 'invalid_request':
                        alert('Nieprawidłowe żądanie.');
                        break;
                    default:
                        alert('Wystąpił nieznany błąd.');
                }
            }

            const resetError = urlParams.get('error');
            const resetSuccess = urlParams.get('success');

            if (resetError) {
                switch (resetError) {
                    case 'invalid_email':
                        alert('Niepoprawny adres E-mail. Proszę wprowadzić poprawny adres.');
                        break;
                    case 'email_not_found':
                        alert('Podany adres E-mail nie istnieje w naszej bazie danych.');
                        break;
                    case 'server':
                        alert('Wystąpił błąd serwera. Spróbuj ponownie później.');
                        break;
                    case 'invalid_request':
                        alert('Nieprawidłowe żądanie. Spróbuj ponownie.');
                        break;
                    default:
                        alert('Wystąpił nieznany błąd podczas próby wysłania linku do resetowania hasła.');
                }
            }

            if (resetSuccess) {
                switch (resetSuccess) {
                    case 'reset_link_sent':
                        alert('Link do resetowania hasła został wysłany na Twój adres e-mail.');
                        break;
                    default:
                        alert('Wysłanie linku zakończone sukcesem, ale wystąpił nieoczekiwany problem.');
                }
            }

            const resetPasswordError = urlParams.get('error');
            const resetPasswordSuccess = urlParams.get('success');

            if (resetPasswordError) {
                switch (resetPasswordError) {
                    case 'password_mismatch':
                        alert('Hasła nie są zgodne. Wpisz ponownie.');
                        break;
                    case 'weak_password':
                        alert('Hasło musi mieć co najmniej 12 znaków i maksymalnie 128 znaków.');
                        break;
                    case 'invalid_token':
                        alert('Link do resetowania hasła jest nieprawidłowy lub wygasł.');
                        break;
                    case 'server':
                        alert('Wystąpił błąd serwera podczas resetowania hasła. Spróbuj ponownie później.');
                        break;
                    case 'invalid_request':
                        alert('Nieprawidłowe żądanie resetowania hasła.');
                        break;
                    default:
                        alert('Wystąpił nieznany błąd podczas resetowania hasła.');
                }
            }

            if (resetPasswordSuccess) {
                switch (resetPasswordSuccess) {
                    case 'password_reset':
                        alert('Hasło zostało pomyślnie zresetowane! Możesz teraz się zalogować.');
                        break;
                    default:
                        alert('Resetowanie hasła zakończone sukcesem, ale wystąpił nieoczekiwany problem.');
                }
            }

            const changePasswordError = urlParams.get('error');
            const changePasswordSuccess = urlParams.get('success');

            if (changePasswordError) {
                switch (changePasswordError) {
                    case 'password_mismatch':
                        alert('Nowe hasła nie są zgodne. Wpisz ponownie.');
                        break;
                    case 'weak_password':
                        alert('Nowe hasło musi mieć co najmniej 12 znaków i maksymalnie 128 znaków.');
                        break;
                    case 'incorrect_old_password':
                        alert('Podane stare hasło jest nieprawidłowe.');
                        break;
                    case 'server':
                        alert('Wystąpił błąd serwera podczas zmiany hasła. Spróbuj ponownie później.');
                        break;
                    default:
                        alert('Wystąpił nieznany błąd podczas zmiany hasła.');
                }
            }

            if (changePasswordSuccess) {
                switch (changePasswordSuccess) {
                    case 'password_changed':
                        alert('Hasło zostało pomyślnie zmienione!');
                        break;
                    default:
                        alert('Zmiana hasła zakończona sukcesem, ale wystąpił nieoczekiwany problem.');
                }
            }
        })         
    </script>
<body>

    <header>

        <div class="navow">            
            <a href="#">Z ostatniej chwili</a>
            <a href="#">Notowania</a>
            <a href="#">AI</a>
            <a href="#">Firma</a>
            <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
                <a href="" id="registerLink">Załóż konto</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <a class="welcome">Witaj <?php echo htmlspecialchars($_SESSION['username']);?>!</a>
            <?php endif;?>

            
       
            <script>
                document.getElementById('registerForm').addEventListener('submit', function (e) {
                const password = document.getElementById('password').value;
                const passwordConfirm = document.getElementById('password_confirm').value;

                const passwordPolicy = /^[A-Za-z0-9!@#$%^&* \s]{12,128}$/u;
                

                if (!passwordPolicy.test(password)) {
                    alert('Hasło musi mieć co najmniej 12 znaków i maksymalnie 128.');
                    e.preventDefault();
                    return;
                }

                if (password !== passwordConfirm) {
                    alert('Hasła nie są zgodne. Wpisz ponownie.');
                    e.preventDefault();
                }
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                const registerLink = document.getElementById('registerLink');
                const registerModal = document.getElementById('registerModal');
                const closeRegisterModal = document.getElementById('closeRegisterModal');
                const content = document.getElementById('content');

                registerLink.addEventListener('click', (event) => {
                    event.preventDefault();
                    registerModal.style.display = 'flex';
                    content.style.display = 'none';
                });

                if (closeRegisterModal) {
                    closeRegisterModal.addEventListener('click', () => {
                        registerModal.style.display = 'none';
                        content.style.display = 'flex';
                    });
                }
                });
            </script>
        </div>

        <div id="registerModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeRegisterModal">&times;</span>
                    <h2>Rejestracja</h2>
                    <form id="registerForm" action="register.php" method="post">
                        <input type="text" name="username" placeholder="Login" required>
                        <input type="email" name="email" placeholder="Adres e-mail" required>
                        <input type="password" name="password" placeholder="Hasło" required id="password">                   

                            <label for="password">
                                <span class="toggle-password" onclick="togglePassword()">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </label>

                        <script>
                            function togglePassword() {
                            const passwordField = document.getElementById("password");
                            const type = passwordField.type === "password" ? "text" : "password";
                            passwordField.type = type;
                            }
                        </script>

                        <input type="password" name="password_confirm" placeholder="Powtórz hasło" required id="password_confirm">
                            <label for="password_confirm">
                                <span class="toggle-confirm_password" onclick="togglePasswordConfirm()">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </label>

                        <script>
                            function togglePasswordConfirm() {
                            const passwordField = document.getElementById("password_confirm");
                            const type = passwordField.type === "password" ? "text" : "password";
                            passwordField.type = type;
                            }
                        </script>

                        <div></div>
                        <progress max="100" value="0" id="meter"></progress>
                        <div class="textbox">Siła hasła</div>
                        <button type="submit">Zarejestruj się</button>
                    </form>                   

                    <script>
                        var code = document.getElementById("password");

                        var strengthbar = document.getElementById("meter");
                        var display = document.getElementsByClassName("textbox")[0];

                        code.addEventListener("keyup", function() {
                            checkpassword(code.value);
                        });

                        function checkpassword(password) {
                            var strength = 0;
                            if (password.match(/[a-z]+/)) {
                                strength += 1;
                            }
                            if (password.match(/[A-Z]+/)) {
                                strength += 1;
                            }
                            if (password.match(/[0-9]+/)) {
                                strength += 1;
                            }
                            if (password.match(/[$@#&!]+/)) {
                                strength += 1;
                            }

                            if (password.length < 12){
                                display.innerHTML="Minimalna liczba znaków to 12";
                            }

                            if (password.length > 128){
                                display.innerHTML="Maksymalna liczba znaków to 128";
                            }

                        switch (strength) {
                            case 0:
                                strengthbar.value = 0;
                                break;

                            case 1:
                                strengthbar.value = 25;
                                break;

                            case 2:
                                strengthbar.value = 50;
                                break;

                            case 3:
                                strengthbar.value = 75;
                                break;

                            case 4:
                                strengthbar.value = 100;
                                break;
                            }
                        }
                        </script>

                </div>
        </div>

        <div class="rejestracja">
            <div class="head">    
                <img class="lock" src="lock-solid.svg" alt="">
            </div>

                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <div id="welcome">
             
                    <a href="logout.php" id="logoutButton">Wyloguj się</a>
                </div>
                <?php else: ?>
                    <a href="#" id="loginLink">Zaloguj się</a>
                <?php endif; ?>

            <div id="loginModal" class="modal">
            <div class="modal-content">

            <span class="close" id="closeModal">&times;</span>
            <h2>Logowanie</h2>

            <form id="loginForm" action="login.php" method="post">
                <input type="text" name="username" placeholder="Login" required>
                <input type="password" name="password" placeholder="Hasło" required>
                <div id="recaptcha-container"></div>
                <div class="g-recaptcha" data-sitekey="'6LdqJWQqAAAAAK8rKqLnYNveOjSty6fZbAVE9Ib0"></div>

                

                <button type="submit">Zaloguj się</button>
                <button type="button" id="forgotPasswordLink">Zapomniałem Hasła</button>
            </form>

            </div>
            </div>

            <div id="forgotPasswordModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeForgotPasswordModal">&times;</span>
                    <h2>Zapomniałem hasła</h2>
                    <form id="forgotPasswordForm" action="send_reset_link.php" method="post">
                        <input type="email" name="email" placeholder="Adres e-mail" required>
                        <button type="submit">Wyślij link do resetowania hasła</button>
                    </form>
                </div>
            </div>           

        </div>

        <div class="shared_chart" id="content">
            <h2>Sprawdź najnowsze zmiany cen surowców na rynku <br> Porównaj ceny z trzech różnych źródeł!</h2>
            <a href="index_shared_chart.php">Porównaj zmiany w jednym miejscu!</a>          

            <div id="mustBeLoggedInModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeMustBeLoggedInModal">&times;</span>
                    <p>Musisz być zalogowany, aby porównać zmiany.</p>
                </div>
            </div>

        </div>

        <script>
            const loginLink = document.getElementById('loginLink');
            const loginModal = document.getElementById('loginModal');
            const closeModal = document.getElementById('closeModal');
            const forgotPasswordLink = document.getElementById('forgotPasswordLink');
            const forgotPasswordModal = document.getElementById('forgotPasswordModal');
            const closeForgotPasswordModal = document.getElementById('closeForgotPasswordModal');
            const content = document.getElementById('content');
            const welcome = document.getElementById('welcome');
            const compareLink = document.querySelector('.shared_chart a');
            const mustBeLoggedInModal = document.getElementById('mustBeLoggedInModal');
            const closeMustBeLoggedInModal = document.getElementById('closeMustBeLoggedInModal');
            
            // Pokaż modal logowania i ukryj content
            if (loginLink) {
                loginLink.addEventListener('click', (event) => {
                    event.preventDefault();
                    loginModal.style.display = 'flex';
                    content.style.display = 'none';
                });
            }

            if (forgotPasswordLink) {
                forgotPasswordLink.addEventListener('click', (event) => {
                    event.preventDefault();
                    forgotPasswordModal.style.display = 'flex';
                    content.style.display = 'none';                   
                });
            }

            if (closeModal) {
                closeModal.addEventListener('click', () => {
                    loginModal.style.display = 'none';
                    content.style.display = 'flex';
                });
            }

            if (closeForgotPasswordModal) {
                closeForgotPasswordModal.addEventListener('click', () => {
                    forgotPasswordModal.style.display = 'none';
                    loginModal.style.display = 'none';
                    content.style.display = 'flex';
                });
            }

            <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
                    if (compareLink) {
                        compareLink.addEventListener('click', (event) => {
                            event.preventDefault();
                            mustBeLoggedInModal.style.display = 'flex';
                        });
                    }
                <?php endif; ?>

                if (closeMustBeLoggedInModal) {
                    closeMustBeLoggedInModal.addEventListener('click', () => {
                        mustBeLoggedInModal.style.display = 'none';
                    });
                }
    </script>

    </header>

        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>

    <main id="mainsite">

        <div class="stock">
            <h2>Dane surowców pobrane z :</h2><br>
            <a href="https://notowania.pb.pl/commodities/">https://notowania.pb.pl/commodities/</a>
        <?php
        $url = 'https://notowania.pb.pl/commodities/';
        // cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            die('Błąd w pobieraniu danych.');
        }

        $dom = new DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML($response);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        $commodityXpaths = [
            'złoto' =>  /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[14]/td[2]',

            'pszenica' => /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[32]/td[2]',

            'aluminium' =>  /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[1]/td[2]',

            'kakao'     => /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[5]/td[2]',

            'cukier'    => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[31]/td[2]',

            'pallad'    => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[20]/td[2]'


        ];

        $rateXpaths = [
            'złoto' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[14]/td[3]/span',

            'pszenica' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[32]/td[3]/span',

            'aluminium' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[1]/td[3]/span',

            'kakao' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[5]/td[3]/span',

            'cukier' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[31]/td[3]/span',

            'pallad' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[20]/td[3]/span'

        ];

        // Dane
        echo '<table border="1">';
        echo '<tr><th>Surowiec</th><th>Jednostka</th><th>Cena</th></tr>';

        foreach ($commodityXpaths as $commodity => $xPathCommodity) {
            $commodityelements = $xpath->query($xPathCommodity);

            $xPathRate = $rateXpaths[$commodity];
            $rateElements = $xpath->query($xPathRate);

            echo '<tr><td>'.ucfirst($commodity) . '</td>';

            echo '<td>';
            if ($commodityelements->length > 0) {
                echo $commodityelements->item(0)->nodeValue;
            } else {
                echo 'Brak danych.';
            }
            echo '</td>';

            echo '<td>';


        if ($rateElements->length > 0) {
                echo $rateElements->item(0)->nodeValue;
            } else {
                echo 'Brak danych.';
            }
            echo '</td>';
            
            echo '</tr>';
        }

        echo '</table>';

        ?>

    </div>

    <div class="stock2">
        <p>Zobrazuj zmiany cen na wykresie</p>

        <a href="index_chart.php">sprawdź</a>
    </div>


    <?php endif; ?>

    </main>

    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>

    <div class="main2" id="mainsite2">
        <div class="stock2_1">
                <h2>Dane surowców pobrane z :</h2><br>
                <a href="https://www.bankier.pl/surowce/notowania">https://www.bankier.pl/surowce/notowania</a>
        <?php
        $url = 'https://www.bankier.pl/surowce/notowania';
        // cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            die('Błąd w pobieraniu danych.');
        }

        $dom = new DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML($response);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

            $commodityXpaths = [
                'złoto' =>  /*jedn*/ '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[1]/tr[2]/td[2]',

                'pszenica' => /*jedn*/ '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[2]/tr[18]/td[2]',

                'aluminium' =>  /*jedn*/ '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[1]/tr[8]/td[2]',

                'kakao'     => /*jedn*/ '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[2]/tr[10]/td[2]',

                'cukier'    => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[2]/tr[6]/td[2]',

                'pallad'    => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[1]/tr[5]/td[2]'


            ];

            $rateXpaths = [
                'złoto' => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[1]/tr[2]/td[3]',

                'pszenica' => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[2]/tr[18]/td[3]',

                'aluminium' => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[1]/tr[8]/td[3]',

                'kakao' => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[2]/tr[10]/td[3]',

                'cukier' => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[2]/tr[6]/td[3]',

                'pallad' => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[1]/tr[5]/td[3]'

            ];

            // Dane
            echo '<table border="1">';
            echo '<tr><th>Surowiec</th><th>Jednostka</th><th>Cena</th></tr>';

            foreach ($commodityXpaths as $commodity => $xPathCommodity) {
                $commodityelements = $xpath->query($xPathCommodity);

                $xPathRate = $rateXpaths[$commodity];
                $rateElements = $xpath->query($xPathRate);

                echo '<tr><td>'.ucfirst($commodity) . '</td>';

                echo '<td>';
                if ($commodityelements->length > 0) {
                    echo $commodityelements->item(0)->nodeValue;
                } else {
                    echo 'Brak danych.';
                }
                echo '</td>';

                echo '<td>';


            if ($rateElements->length > 0) {
                    echo $rateElements->item(0)->nodeValue;
                } else {
                    echo 'Brak danych.';
                }
                echo '</td>';
                
                echo '</tr>';
            }

            echo '</table>';

            ?>

        </div>

    <div class="stock2_2">
        <p>Zobrazuj zmiany cen na wykresie</p>
        <a href="index_chart2.php">sprawdź</a>
    </div>

    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>

    <div class="main3" id="mainsite3">
        <div class="stock3_1">
                <h2>Dane surowców pobrane z :</h2><br>
                <a href="https://next.gazeta.pl/surowce/notowania-surowcow">https://next.gazeta.pl/surowce/notowania-surowcow</a>
        <?php
        $url = 'https://next.gazeta.pl/surowce/notowania-surowcow';
        // cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            die('Błąd w pobieraniu danych.');
        }

        $dom = new DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML($response);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

            $commodityXpaths = [
                'złoto' =>  /*jedn*/ '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[36]/div[2]',

                'pszenica' => /*jedn*/ '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[24]/div[2]',

                'aluminium' =>  /*jedn*/ '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[1]/div[2]',

                'kakao'     => /*jedn*/ '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[8]/div[2]',

                'cukier'    => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[4]/div[2]',

                'pallad'    => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[22]/div[2]'


            ];

            $rateXpaths = [
                'złoto' => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[36]/div[3]',

                'pszenica' => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[24]/div[3]',

                'aluminium' => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[1]/div[3]',

                'kakao' => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[8]/div[3]',

                'cukier' => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[4]/div[3]',

                'pallad' => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[22]/div[3]'

            ];

            // Dane
            echo '<table border="1">';
            echo '<tr><th>Surowiec</th><th>Jednostka</th><th>Cena</th></tr>';

            foreach ($commodityXpaths as $commodity => $xPathCommodity) {
                $commodityelements = $xpath->query($xPathCommodity);

                $xPathRate = $rateXpaths[$commodity];
                $rateElements = $xpath->query($xPathRate);

                echo '<tr><td>'.ucfirst($commodity) . '</td>';

                echo '<td>';
                if ($commodityelements->length > 0) {
                    echo $commodityelements->item(0)->nodeValue;
                } else {
                    echo 'Brak danych.';
                }
                echo '</td>';

                echo '<td>';


            if ($rateElements->length > 0) {
                    echo $rateElements->item(0)->nodeValue;
                } else {
                    echo 'Brak danych.';
                }
                echo '</td>';
                
                echo '</tr>';
            }

            echo '</table>';

            ?>

        </div>

    <div class="stock3_2">
        <p>Zobrazuj zmiany cen na wykresie</p>
        <a href="index_chart3.php">sprawdź</a>
    </div>
   
    </div>
    <?php endif; ?>
    <footer>

        <div class="footer1">
        <h1>Przydatne informacje</h1>
        <ul>
            <li><a href="#">Kursy walut</a></li>
            <li><a href="#">Pogoda</a></li>
            <li><a href="#">Sport</a></li>
            <li><a href="#">Dieta</a></li>
            <li><a href="#">Horoskop</a></li>
            <li><a href="#">Oferta</a></li>
            <li><a href="#">Powódź 2024</a></li>
        </ul>
        </div>

        <div class="O_nas">
            <h1>Nazwa</h1>
            <ul>
                <li><a href="#">O nas</a></li>
                <li><a href="#">Kariera</a></li>
                <li><a href="#">Aktualności</a></li>
                <li><a href="#">Biuro prasowe</a></li>
                <li><a href="#">System partnerski</a></li>
                <li><a href="#">Obsługa klienta</a></li>   
            </ul>
        </div>

        <div class="Pomoc">
            <h1>Pomoc i kontakt</h1>
            <ul>
                <li><a href="#">Kontaktuj się online</a></li>
                <li><a href="#">Nasza placówka</a></li>
                <li><a href="#">Telefon: 1 9999</a></li><p>24h / 7dni</p>
                <li><a href="#">Pytania i odpowiedzi</a></li>
            </ul>   
        </div>

        <div class="footer2">
            <h1>Znajdziesz nas też na</h1>
            <img class="facb" src="facebook.png" alt="">
            <img class="facb" src="instagram.png" alt="">
            <img class="facb" src="x-twitter-s.svg" alt="">
            <img class="facb" src="youtube.png" alt="">

            <div class="wersja">
                <h2>Wersja językowa</h2>

                <a href="#">PL</a>
                <a href="#">EN</a>
                <a href="#">ES</a>
            </div>
        </div>

        <div class="footer3">
            <p>2024 &copy; Nazwa. Wszelkie prawa zastrzeżone.
            Nazwa i logo są zarejestrowanymi znakami towarowymi.</p>

            <p>Opłata za połączenie z infolinią wiadomości zgodna z taryfą danego operatora.
            Słowniczek pojęć i definicji dotyczących usług reprezentatywnych, wynikających z rozporządzenia
            <br>Ministra Rozwoju i Finansów z dnia 14 lipca 2017 r. w sprawie wykazu usług reprezentatywnych
                powiązanych z rachunkiem płatniczym,
            dostępny jest na stronie<br> strona.pl/PAD oraz w placówkach.</p>

        </div>

        <div class="footer4">
            <img src="logo_stopka.png" alt="">
            <a href="#">Regulamin serwisu</a>
            <a href="#">Polityka prywatności</a>
            <a href="#">Polityka przetwarzania danych osobowych (RODO)</a>
            <a href="#">Polityka cookies</a>
        </div>

</footer>   
</body>
</html>