<!-- resources/views/auth/register.blade.php -->

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
      <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link href="assets/css/style.css" rel="stylesheet">


</head>
<style>


    body {
        width: 100%;
    height: 100vh;
    font-family: 'Open Sans', sans-serif;
    background: url("/img/resto2.jpeg") top center;
    background-size: cover;
    position: relative;
    padding: 0;
    }
    body::before{
    content: "";
    background: rgba(0, 0, 0, 0.5);
    position: absolute;
    bottom: 0;
    top: 0;
    left: 0;
    right: 0;
    }

    .card {
    max-width: 600px;
    margin-top: 200px;
    padding: 20px;
    margin-left: 100px;
    background: rgba(42, 40, 38, 0.778);
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }
    .card-header{
        font-size: 2rem;
      font-weight: 700;
      margin-bottom: 30px;
      text-align: center;
      color: #cda45e;
    }



    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-size: 1.2rem;
      font-weight: 500;
      margin-bottom: 5px;
      color: #fff;
    }

    input[type='text'],
    input[type='email'],
    input[type='password'] {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: none;
      background-color: #28251f;
      color: #fff;
    }

    button[type='submit'] {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: none;
      background-color: #cda45e;
      color: #fff;
      font-size: 1.2rem;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button[type='submit']:hover {
      background-color: #d3af71;
    }

    p {
      font-size: 1.2rem;
      font-weight: 500;
      text-align: center;
      color: #fff;
    }

    p a {
      color: #cda45e;
      text-decoration: none;
    }

    p a:hover {
      text-decoration: underline;
    }

  </style>
  <body>
    <div id="topbar" class="d-flex align-items-center fixed-top">
        <div class="container d-flex justify-content-center justify-content-md-between">

          <div class="contact-info d-flex align-items-center">
            <i class="bi bi-phone d-flex align-items-center"><span>+1 5589 55488 55</span></i>
            <i class="bi bi-clock d-flex align-items-center ms-4"><span> Senin-Minggu: 10.00 - 21.00</span></i>
          </div>
        </div>
      </div>
    <header id="header" class="fixed-top d-flex align-items-cente">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">

          <h1 class="logo me-auto me-lg-0"><a href="{{ __('/') }}">Pizza Andaliman</a></h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->


          <fieldset>
            <a href="{{ __('/') }}" class="book-a-table-btn ">< Kembali</a>
          <a href="{{ route('login') }}" class="book-a-table-btn ">Masuk</a>

          </fieldset>
        </div>
      </header>
      <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Daftar') }}</div>

                    <div class="card-body">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}"><br>
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"><br>
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" required><br><br>
                            <button type="submit">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
