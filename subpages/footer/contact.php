<?php

$pagePath = 'footer/contact.php';
$pageName = "Skontaktuj się z nami";

session_start();
$_SESSION['pagePath'] = $pagePath;
$_SESSION['pageName'] = $pageName;

$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : '';
if (isset($_SESSION['thankYou']) && $_SESSION['thankYou'] === true) {
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Dziękujemy!",
                    text: "Twoje zgłoszenie zostało przesłane.",
                    confirmButtonColor: "#ff7bac",
                });
            });
         </script>';

    $_SESSION['thankYou'] = false;
}
$errorBoxDisplay = isset($_SESSION['errorMessage']) ? 'block' : 'none';


unset($_SESSION['thankYouMessage']);
unset($_SESSION['errorMessage']);

$text = "<span style='
    display: flex;
    flex-direction: column;
    align-items: center;'>
        <h1>Skontaktuj się z nami</h1>
    </span>
    <form method='post' action='../sendEmail.php' id='contact-form'>
        <div class='form__group field'>
            <input type='text' class='form__field' placeholder='Imię' name='name'/>
            <label for='name' class='form__label'>Imię</label>
        </div>
        <br>
        <div class='form__group field'>
            <input type='text' class='form__field' placeholder='Email' name='email'/>
            <label for='email' class='form__label'>Email</label>
        </div>
        <br>
        <div class='form__group field' id='textareaDiv'>
            <textarea class='form__field' id='textarea' placeholder='Wiadomość' name='message'></textarea>
            <label for='message' class='form__label'>Wiadomość</label>
        </div>
        <div id='error-box'>
            <div id='error-contact'>
                <p class='error-contact' style='display: $errorBoxDisplay;'>$errorMessage</p>
            </div>
        </div>
        <div style='text-align: right;'>
            <input type='submit' value='Wyślij' id='contact-send'/>
        </div>
    </form>";


?>

<?php include "footerTemplate.php" ?>

<style>
    .context {
        width: 80%;
    }
</style>

<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    const constraints = {
        name: {
            presence: {
                allowEmpty: false,
                message: 'Imię nie może być puste. Uzupełnij polę imię'
            }
        },
        email: {
            presence: {
                allowEmpty: false,
                message: 'E-mail nie może być pusty. Uzupełnij polę e-mail'
            },
            email: {
                message: 'E-mail jest niepoprawny. Wpisz poprawny e-mail'
            }
        },
        message: {
            presence: {
                allowEmpty: false,
                message: 'Wiadomość jest pusta. Uzupełnij polę wiadomość'
            }
        }
    };

    const form = document.querySelector('#contact-form');

    form.addEventListener('submit', function(event) {
        const formValues = {
            name: form.elements.name.value,
            email: form.elements.email.value,
            message: form.elements.message.value
        };

        const errors = validate(formValues, constraints);

        if (errors) {
            event.preventDefault();
            document.querySelector('#error-contact').innerHTML = Object.values(errors)
                .map(fieldValues => fieldValues.map(error => `<p class="error-contact">${error.split(' ').slice(1).join(' ')}</p>`).join(''))
                .join('');
        } else {
            document.querySelector('#error-contact').innerHTML = '';
        }

    });
</script>