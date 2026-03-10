<?php
session_start();

if(isset($_SESSION['success'])){
    echo "<div class='success-message'>" . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
}
?>

<!DOCTYPE html>
<head> 
    <link rel = "stylesheet" href = "../css/intro.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>

    <?php 
    if (isset($_GET['welcome'])):
        echo '<div id="toast"> Welcome, ' . $_SESSION['usernamePeserta'] . '!</div>';
    endif;
    ?>


    <ul> 
    <li  class="active"><a href="../html/loginmasuk.php">Home</a></li> 
    <li><a href=../html/intro.html>Introduction </a></li> 
    <li><a href="../html/laporan.html"> Laporan </a></li>
    <li><a href="../html/aboutus.php">About Us</a></li> 
    <li><a href="../html/daftarpeserta.php">Register</a></li>
   </ul> 


    <header> 
    <div> 
    <h1>Pertandingan Mendeklamasikan Sajak</h1> 
    <p>"Speak your truth , you are not voiceless" </p> 
    </div> 
    </header> 
    <main> 
    <ul id="cards"> 
    <li class="card" id="card_1"> 
    <div class="card__content"> 
        <div> 
        <h2> Peraturan dan Tatacara Pertandingan Mendeklamasikan Sajak </h2> 
        <p>" - Pertandingan ini hanya terbuka kepada pelajar Arus Perdana dari sekolah MSAB , English College 
            - Pemenang yang merangkul tempat tertinggi akan bertanding ke peringkat antarabangsa 
            - Tarikh penutup penhantaran deklamasi sajak adalah 31 December 2022 "    </p> 
        <p><a href="#top" class="btn btn--accent">Read more</a></p> 
        </div> 
        <figure> 
        <img src="../css/skullpoetrycards.jpg" alt="Image description"> 
        </figure> 
    </div> 
    </li> 
    <li class="card" id="card_2"> 
    <div class="card__content"> 
        <div> 
        <h2>Format</h2> 
        <b></b>
        <p>Penyampaian sajak haruslah tidak melebihi 10 minit . Tajuk sajak adalah bebas kepada kreativiti peserta .</p>
        <p>Sajak mestilah dalam Bahasa Melayu.</p>
        <p>Sajak haruslah dicipta sendiri.</p>
        <p>Penghantaran sajak tidak boleh published, self-published, published on a website or made public on social media</p>
        <p><a href="#top" class="btn btn--accent">Read more</a></p> 
        </div> 
        <figure> 
            <img src="../css/Dare To Be Great Training.jpg" alt="Image description"> 
        </figure> 
    </div> 
    </li> 
    <li class="card" id="card_3"> 
    <div class="card__content"> 
        <div> 
        <h2>Memorable Quotes from Poets </h2> 
        <p></p> 
        <p><a href="#top" class="btn btn--accent">Read more</a></p> 
        </div> 
        <figure> 
            <img src="../css/download (9).jpg" alt="Image description"> 
        </figure> 
    </div> 
    </li> 
    <li class="card" id="card_4"> 
    <div class="card__content"> 
        <div> 
        <h2> Tambahan Info </h2> 
        <p>Tarikh peghantaran sajak akan diumumkan secepat mungkin </p>
        <p>Pingat dan Sijil akan diberikan kepada semua peserta</p>
        <p>Untuk sebarang pertanyaan sila tekan link "About Us" di atas kiri halaman web ini atau sila berhubung dengan Jeevan Gabriel Francis , 5 Akas</p> 
        <p><a href="#top" class="btn btn--accent">Read more</a></p> 
        </div> 
        <figure> 
            <img src="../css/poetrycards.jpg" alt="Image description"> 
        </figure> 
    </div> 
    </li> 
    </ul> 
    </main>
     <script>
    <?php if (isset($_GET['welcome'])): ?>
        const toast = document.getElementById('toast');
        toast.style.display = 'block';
        setTimeout(() => { toast.style.right = '30px'; }, 100);
        setTimeout(() => { toast.style.right = '-400px'; }, 3000);
        setTimeout(() => { toast.style.display = 'none'; }, 3500);
    <?php endif; ?>
    </script>
</body>
