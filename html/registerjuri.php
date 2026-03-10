<html>
    <head>
        <title>Daftar Peserta</title>
    </head>
    <body>
        <form method = "POST" action = "../php/processDaftarPeserta.php">
            <input type = "text" placeholder = "Enter Username" name = "usernamePeserta" minlength = "7" maxlength = "49" required>
            <input type = "text" placeholder = "Enter name" name = "namaPeserta" maxlength = "255" required>
            <input type = "password" placeholder = "Enter password" name = "kataLaluanPeserta" minlength = "8" required>
            <input type = "password" placeholder = "Enter password" name = "ComKataLaluanPeserta" minlength = "8" required>
            <input type = "integer" placeholder = "Enter age" name = "umurPeserta" maxlength = "4" required>
            <input type = "text" placeholder = "Enter email" name = "emelPeserta" minlength = "7" maxlength = "50" required>
            <button type = "submit" > register </button>
    </body>
</html>