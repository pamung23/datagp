<!DOCTYPE html>
<html>

<head>
    <title>Data GEPANG</title>
    <link rel="icon" type="image/x-icon" href="https://datagp.gedepangrango.org/logo.png" />
    <link rel="stylesheet" type="text/css" href="{{ asset('login2/css/style.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    @if ($errors->any())
    <div id="myToast" class="toast align-items-center text-white bg-danger border-0 position-fixed top-0 end-0 m-4"
        role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                @foreach ($errors->all() as $error)
                {{ $error }}<br>
                @endforeach
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
    @endif
    <img class="wave" src="https://gedepangrango.org/wp-content/uploads/2022/04/222-1024x536.jpg">
    <div class="container">
        <div class="img">
            <img src="https://gedepangrango.org/wp-content/uploads/2022/04/Logo-diatas-dan-lebel-dibawah-1-1.png">
        </div>
        <div class="login-content">

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <img src="https://gedepangrango.org/wp-content/uploads/2022/04/Logo-diatas-dan-lebel-dibawah-1-1.png">
                <h2 class="title">DATA GEPANG</h2>

                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Email or Username</h5>
                        <input type="text" class="input" name="username" required>
                    </div>
                </div>

                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input type="password" class="input" name="password" required>
                    </div>
                </div>

                <a href="{{ route('auth.forgotpassword') }}" class="forgot-password-link">Forgot Password?</a>
                <input type="submit" class="btn" value="Login">
            </form>
        </div>
        <div class="footer">
            <p>&copy; <a href="https://www.instagram.com/pam.ungkas_/">Aprilian Hapid Pamungkas</a> & <a
                    href="https://gedepangrango.org/ ">Balai Besar TNGGP</a></p>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('login2/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myToast = new bootstrap.Toast(document.getElementById('myToast'));
            myToast.show();
        });
    </script>

</body>

</html>