<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<a href="" id="toTheTop">
    <i class="fa-solid fa-chevron-up fa-3x" style="color: #ffffff;"></i>
</a>
<div class="search">
    <span class="close-btn"></span>
    <div class="search-container">
        <p>Search</p>
        <div class="form-item search-form">
            <a class='mglass' style="cursor: pointer;"><i class="fa-solid fa-magnifying-glass fa-xl"></i></a>
            <input type="text" placeholder="Wyszukaj..." id="searchForm" name="search" autofocus>
        </div>
        <div id="searchResults">
            <div id="typeResults">
                <strong>KATEGORIE</strong>
                <div class="tWrapper"></div>
            </div>
            <div id="cosmeticsResults">
                <strong>PRODUKTY</strong>
                <div class="cWrapper">
                    <div class="cRow"></div>
                    <div class="cRow"></div>
                    <div class="cRow"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="account">
    <span class="close-btn"></span>
    <div class="login-container active">
        <p>Logowanie</p>
        <p>Zaloguj się, aby korzystać z platformy</p>
        <form action="" method="post">
            <div class="form-item">
                <i class="fa-regular fa-envelope fa-xl"></i>
                <input type="text" placeholder="Wpisz Email" id="emailForm" name="username" autofocus required>
            </div>
            <div class="form-item">
                <i class="fa-solid fa-lock fa-xl"></i>
                <input type="password" placeholder="Wpisz Hasło" class="passwordForm" name="password" required>
            </div>
            <div class="form-item-other">
                <div class="checkbox">
                    <input type="checkbox" class="rememberMeCheckbox" checked>
                    <label for="rememberMeCheckbox">Pamiętaj mnie</label>
                </div>
                <a id="toPassword">Nie pamiętasz hasła?</a>
            </div>
            <button type="submit">Zaloguj się</button>
        </form>
        <div>
            Nie masz konta? <a id="toRegister">Załóż je za darmo.</a>
        </div>
    </div>
    <div class="register-container">
        <p>Rejestracja</p>
        <p>Zarejestruj się, aby korzystać z platformy</p>
        <form action="" method="post">
            <div class="form-item">
                <i class="fa-regular fa-face-smile fa-xl"></i>
                <input type="text" placeholder="Wpisz Imię" id="nameForm" name="name" autofocus required>
            </div>
            <div class="form-item">
                <i class="fa-regular fa-envelope fa-xl"></i>
                <input type="text" placeholder="Wpisz Email" class="emailForm" name="username" required>
            </div>
            <div class="form-item">
                <i class="fa-solid fa-lock fa-xl"></i>
                <input type="password" placeholder="Wpisz Hasło" class="passwordForm" name="password" required>
            </div>
            <div class="form-item-other">
                <div class="checkbox">
                    <input type="checkbox" class="rememberMeCheckbox" required>
                    <label for="rememberMeCheckbox">Akceptuję terminy i warunki</label>
                </div>
            </div>
            <button type="submit">Zarejestruj się</button>
        </form>
        <div>
            Masz już konto? <a id="toLogin">Zaloguj się.</a>
        </div>

    </div>
    <div class="password-container">
        <p>Przypomnienie hasła</p>
        <p>Podaj swój adres email,</p>
        <p>a wyślemy Ci instrukcje do zresetowania hasła</p>
        <form action="" method="post">
            <div class="form-item">
                <i class="fa-regular fa-envelope fa-xl"></i>
                <input type="text" placeholder="Wpisz Email" class="emailForm" name="username" required>
            </div>
            <button type="submit">Prześlij</button>
        </form>
    </div>
</div>
<div class="cart">
    <span class="close-btn"></span>
    <div class="cart-container">
        <p>Shopping Cart</p>
    </div>
</div>