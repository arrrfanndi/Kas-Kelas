<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kasku</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Google+Sans+Code:ital,wght,MONO@0,300..800,1;1,300..800,1&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="halamanLogin.css">

</head>

<body>

    <div class="container">
        <!-- Bagian Atas / Header Card -->
        <div class="teks_sapa">
            <h1>Kasqeu</h1>
            <h2>Selamat Datang</h2>
            <p>Masuk untuk mengelola keuangan kelas</p>
        </div>

        <!-- Bagian Form -->
        <div class="container-form">
            <form action="/config/proses_login.php" method="POST">
                <div class="input_username">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                </div>
                <div class="input_password">
                    <label for="password">Password</label>

                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>

                <button type="submit" id="tombol_login" >Masuk</button>
            </form>
        </div>
    </div>

</body>

</html>