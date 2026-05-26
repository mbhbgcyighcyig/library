<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BOOKIFY Landing Page</title>

<link href="https://fonts.googleapis.com/css2?family=Newsreader:wght@400;600;700;800&display=swap" rel="stylesheet">

<!-- Font Awesome untuk icon like -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body{
    font-family: 'Newsreader', serif;
    background: #c4d9e8;
    color: #183b63;
    overflow-x: hidden;
}

/* ================= NAVBAR ================= */

.navbar{
    background: #173f67;
    padding: 22px 80px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-left{
    display: flex;
    align-items: center;
    gap: 45px;
}

.nav-left a{
    color: white;
    text-decoration: none;
    font-size: 21px;
    font-weight: 600;
}

.profile-circle{
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: #ddd;
}

/* ================= HERO ================= */

.hero{
    padding: 60px 80px;
}

.hero-box{
    background: #d6e5ef;
    border-radius: 30px;
    overflow: hidden;
    display: flex;
    align-items: center;
    min-height: 460px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.hero-text{
    width: 55%;
    padding: 60px;
}

.hero-text h1{
    font-size: 58px;
    line-height: 1.1;
    color: black;
    margin-bottom: 25px;
    font-weight: 800;
}

.hero-text p{
    font-size: 24px;
    line-height: 1.5;
    color: black;
    font-weight: 600;
}

.hero-image{
    width: 45%;
    height: 460px;
    background: url('images/hero-book.jpg') center/cover no-repeat;
    opacity: 0.7;
}

/* ================= REKOMENDASI ================= */

.rekomendasi{
    padding: 50px 40px 80px;
    text-align: center;
}

.rekomendasi h2{
    font-size: 62px;
    font-weight: 800;
    color: #4c78a8;
    margin-bottom: 10px;
}

.rekomendasi p{
    font-size: 34px;
    margin-bottom: 50px;
}

.book-grid{
    display: flex;
    justify-content: center;
    gap: 35px;
    flex-wrap: wrap;
}

.book-card{
    width: 250px;
    height: 430px;
    background: white;
    border-radius: 14px;
    padding: 18px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.book-card img{
    width: 100%;
    height: 320px;
    object-fit: cover;
    border-radius: 8px;
}

.collection-btn{
    margin-top: 45px;
    background: #173f67;
    color: white;
    border: none;
    padding: 18px 50px;
    border-radius: 18px;
    font-size: 24px;
    font-weight: 700;
    cursor: pointer;
}

/* ================= KUTIPAN ================= */

.kutipan{
    background: #f8f8f8;
    padding: 70px 40px;
    text-align: center;
}

.kutipan h2{
    font-size: 62px;
    color: #4c78a8;
    margin-bottom: 20px;
    font-weight: 800;
}

.kutipan p{
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 60px;
    line-height: 1.4;
}

.quote-grid{
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}

.quote-card{
    width: 280px;
    background: #b9d0e2;
    border-radius: 18px;
    padding: 18px;
}

.quote-card img{
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 8px;
}

.like-section{
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 15px;
    font-size: 18px;
    color: white;
    justify-content: flex-start;
}

.like-btn{
    font-size: 34px;
    cursor: pointer;
    transition: 0.3s;
    color: black;
}

.like-btn.liked{
    color: red;
}

/* ================= CONTACT ================= */

.contact{
    background: #c4d9e8;
    text-align: center;
    padding: 80px 40px 30px;
}

.contact h2{
    font-size: 62px;
    margin-bottom: 25px;
    font-weight: 800;
}

.contact p{
    font-size: 24px;
    margin-bottom: 80px;
    font-weight: 600;
    line-height: 1.5;
}

/* ================= FOOTER ================= */

.footer{
    background: #4f7ca8;
    color: white;
    padding: 45px 60px;
}

.footer-grid{
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 50px;
}

.footer h3{
    margin-bottom: 20px;
    font-size: 26px;
}

.footer p{
    font-size: 18px;
    line-height: 1.6;
}

.social-icons{
    margin-top: 30px;
    display: flex;
    gap: 25px;
    font-size: 42px;
    color: black;
}

.subscribe input{
    width: 300px;
    height: 55px;
    border: none;
    padding-left: 20px;
    font-size: 18px;
    outline: none;
}

.footer-bottom{
    background: black;
    color: white;
    padding: 15px 20px;
    font-size: 17px;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="nav-left">
        <a href="#">Home</a>
        <a href="#">Books</a>
        <a href="#">Contact</a>
        <a href="{{ route('login') }}">Log in</a>
    </div>

    <div class="profile-circle"></div>
</div>

<!-- HERO -->
<section class="hero">
    <div class="hero-box">
        <div class="hero-text">
            <h1>Temukan Dunia Buku Favoritmu</h1>
            <p>
                Nikmati pengalaman membaca yang lebih menyenangkan
                dengan koleksi buku pilihan dari berbagai genre.
                Dari cerita fiksi yang menghibur hingga buku
                pengembangan diri yang menginspirasi.
            </p>
        </div>

        <div class="hero-image"></div>
    </div>
</section>

<!-- REKOMENDASI -->
<section class="rekomendasi">
    <h2>Rekomendasi Buku</h2>
    <p>Bacaan Pilihan Khusus Untukmu</p>

    <div class="book-grid">
        <div class="book-card">
            <img src="images/book1.jpg">
        </div>

        <div class="book-card">
            <img src="images/book2.jpg">
        </div>

        <div class="book-card">
            <img src="images/book3.jpg">
        </div>

        <div class="book-card">
            <img src="images/book4.jpg">
        </div>
    </div>

 <a href="{{ route('books.catalog') }}" class="collection-btn">
    Lihat Koleksi
</a>
</section>

<!-- KUTIPAN -->
<section class="kutipan">
    <h2>Kutipan Pilihan</h2>
    <p>Setiap halaman yang kamu baca adalah langkah kecil menuju masa depan yang lebih baik</p>

    <div class="quote-grid">

        <div class="quote-card">
            <img src="images/q1.jpg">

            <div class="like-section">
                <i class="fa-regular fa-heart like-btn"></i>
                <span>Hujan - Tere Liye</span>
            </div>
        </div>

        <div class="quote-card">
            <img src="images/q2.jpg">

            <div class="like-section">
                <i class="fa-regular fa-heart like-btn"></i>
                <span>Dilan - Pidi Baiq</span>
            </div>
        </div>

        <div class="quote-card">
            <img src="images/q3.jpg">

            <div class="like-section">
                <i class="fa-regular fa-heart like-btn"></i>
                <span>5 cm - Donny Dhirgantoro</span>
            </div>
        </div>

        <div class="quote-card">
            <img src="images/q4.jpg">

            <div class="like-section">
                <i class="fa-regular fa-heart like-btn"></i>
                <span>Perahu Kertas - Dee Lestari</span>
            </div>
        </div>

    </div>
</section>

<!-- CONTACT -->
<section class="contact">
    <h2>Let’s Connect!</h2>
    <p>Kami percaya, setiap pengalaman membaca yang baik dimulai dari koneksi yang sederhana.</p>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-grid">

        <div>
            <h3>Informasi Kontak</h3>
            <p>
                Email: support@bookify.com<br>
                WhatsApp: +62 812-3456-7890<br>
                Alamat: Indonesia
            </p>

            <div class="social-icons">
                <i class="fab fa-instagram"></i>
                <i class="fab fa-whatsapp"></i>
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-google"></i>
            </div>
        </div>

        <div>
            <h3>Menu</h3>
            <p>
                Home<br>
                Books<br>
                Login<br>
                Contact
            </p>
        </div>

        <div class="subscribe">
            <h3>Subscribe</h3>
            <input type="email" placeholder="Email">
        </div>

    </div>
</footer>

<div class="footer-bottom">
    Read more. Feel more. Be more.
</div>

<script>
document.querySelectorAll(".like-btn").forEach(button => {
    button.addEventListener("click", function () {
        this.classList.toggle("liked");

        if(this.classList.contains("liked")){
            this.classList.remove("fa-regular");
            this.classList.add("fa-solid");
        } else {
            this.classList.remove("fa-solid");
            this.classList.add("fa-regular");
        }
    });
});
</script>

</body>
</html>