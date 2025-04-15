<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mpakaian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <style>
      body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }
    </style>
    <style>
        
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            background-color: #D2D2D2;
            background-image:
            repeating-linear-gradient(
                to right, transparent 0 100px,
                #25283b22 100px 101px
            ),
            repeating-linear-gradient(
                to bottom, transparent 0 100px,
                #25283b22 100px 101px
            );
        }
        
        body::before{
            position: absolute;
            width: min(1400px, 90vw);
            top: 10%;
            left: 50%;
            height: 90%;
            transform: translateX(-50%);
            content: '';
            background-image: url(images/bg.png);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: top center;
            pointer-events: none;
        }

        @import url('https://fonts.cdnfonts.com/css/ica-rubrik-black');
@import url('https://fonts.cdnfonts.com/css/poppins');

.banner{
    width: 100%;
    height: 100vh;
    text-align: center;
    overflow: hidden;
    position: relative;
}
.banner .slider{
    position: absolute;
    width: 200px;
    height: 250px;
    top: 10%;
    left: calc(50% - 100px);
    transform-style: preserve-3d;
    transform: perspective(1000px);
    animation: autoRun 20s linear infinite;
    z-index: 2;
}
@keyframes autoRun{
    from{
        transform: perspective(1000px) rotateX(-16deg) rotateY(0deg);
    }to{
        transform: perspective(1000px) rotateX(-16deg) rotateY(360deg);
    }
}

.banner .slider .item{
    position: absolute;
    inset: 0 0 0 0;
    transform: 
        rotateY(calc( (var(--position) - 1) * (360 / var(--quantity)) * 1deg))
        translateZ(550px);
}
.banner .slider .item img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.banner .content{
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: min(1400px, 100vw);
    height: max-content;
    padding-bottom: 100px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    z-index: 1;
}
.banner .content h1{
    font-family: 'ICA Rubrik';
    font-size: 16em;
    line-height: 1em;
    color: #25283B;
    position: relative;
}
.banner .content h1::after{
    position: absolute;
    inset: 0 0 0 0;
    content: attr(data-content);
    z-index: 2;
    -webkit-text-stroke: 2px #d2d2d2;
    color: transparent;
}
.banner .content .author{
    font-family: Poppins;
    text-align: right;
    max-width: 200px;
}
.banner .content h2{
    font-size: 3em;
}
.banner .content .model{
    background-image: url(images/model.png);
    width: 100%;
    height: 75vh;
    position: absolute;
    bottom: 0;
    left: 0;
    background-size: auto 130%;
    background-repeat: no-repeat;
    background-position: top center;
    z-index: 1;
}
@media screen and (max-width: 1023px) {
    .banner .slider{
        width: 160px;
        height: 200px;
        left: calc(50% - 80px);
    }
    .banner .slider .item{
        transform: 
            rotateY(calc( (var(--position) - 1) * (360 / var(--quantity)) * 1deg))
            translateZ(300px);
    }
    .banner .content h1{
        text-align: center;
        width: 100%;
        text-shadow: 0 10px 20px #000;
        font-size: 7em;
    }
    .banner .content .author{
        color: #fff;
        padding: 20px;
        text-shadow: 0 10px 20px #000;
        z-index: 2;
        max-width: unset;
        width: 100%;
        text-align: center;
        padding: 0 30px;
    }
}
@media screen and (max-width: 767px) {
    .banner .slider{
        width: 100px;
        height: 150px;
        left: calc(50% - 50px);
    }
    .banner .slider .item{
        transform: 
            rotateY(calc( (var(--position) - 1) * (360 / var(--quantity)) * 1deg))
            translateZ(180px);
    }
    .banner .content h1{
        font-size: 5em;
    }
}
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="banner">
        <div class="slider" style="--quantity: 10">
            <div class="item" style="--position: 1"><img src="images/1.jpg" alt=""></div>
            <div class="item" style="--position: 2"><img src="images/2.jpg" alt=""></div>
            <div class="item" style="--position: 3"><img src="images/3.jpg" alt=""></div>
            <div class="item" style="--position: 4"><img src="images/4.jpg" alt=""></div>
            <div class="item" style="--position: 5"><img src="images/5.jpg" alt=""></div>
            <div class="item" style="--position: 6"><img src="images/6.jpg" alt=""></div>
           
        </div>
        <div class="content">
            <h1 data-content="CLOTHES">
                CLOTHES
            </h1>
            <div class="author">
                <h2>KEL 3</h2>
                <p><b>Baju Dan Skincare</b></p>
                <p>
                    Siap atasi masalah kamu dalam menentukan baju yang cocok untuk harian dan masalah skincare terlewat
                </p>
            </div>
            
            <div class="model"></div>
            
        </div>
    </div>
  <!-- Tentang Kami -->
<section class="bg-gradient-to-r from-purple-100 to-pink-100 py-20 px-6">
  <div class="max-w-6xl mx-auto text-center">
    <h2 class="text-5xl font-extrabold text-purple-800 mb-6">Siapa Kami?</h2>
    <p class="text-gray-700 max-w-2xl mx-auto text-lg leading-relaxed">
      Kami dari <span class="font-semibold text-purple-600">Kelompok 3</span>, hadir membawa solusi pintar untuk outfit dan skincare kamu. Biar kamu tetap kece, segar, dan percaya diri setiap harinya — tanpa mikir panjang!
    </p>
  </div>
</section>

<!-- Fitur Unggulan -->
<section class="bg-white py-20 px-6">
  <div class="max-w-6xl mx-auto text-center">
    <h2 class="text-5xl font-extrabold text-gray-800 mb-12">Fitur Unggulan</h2>
    <div class="grid gap-10 md:grid-cols-3">
      <!-- Card 1 -->
      <div class="bg-gradient-to-br from-indigo-100 to-white rounded-2xl shadow-xl p-6 hover:scale-105 transition-transform">
        <img src="images/lemari.jpg" alt="Lemari Outfit" class="rounded-xl h-48 w-full object-cover mb-4">
        <h3 class="text-2xl font-bold text-indigo-700 mb-2">Lemari Outfit Harian</h3>
        <p class="text-gray-600 text-sm">Biar gak overthinking tiap pagi, semua baju udah diatur. Bangun tidur tinggal pakai!</p>
      </div>
      <!-- Card 2 -->
      <div class="bg-gradient-to-br from-pink-100 to-white rounded-2xl shadow-xl p-6 hover:scale-105 transition-transform">
        <img src="images/skincare.jpg" alt="Skincare Tracker" class="rounded-xl h-48 w-full object-cover mb-4">
        <h3 class="text-2xl font-bold text-pink-700 mb-2">Rutinitas Skincare</h3>
        <p class="text-gray-600 text-sm">Gak ada lagi skincare bolong. Jadwalmu tertata dari pagi sampai malam!</p>
      </div>
      <!-- Card 3 -->
      <div class="bg-gradient-to-br from-yellow-100 to-white rounded-2xl shadow-xl p-6 hover:scale-105 transition-transform">
        <img src="images/jadwal.jpg" alt="Kalender Harian" class="rounded-xl h-48 w-full object-cover mb-4">
        <h3 class="text-2xl font-bold text-yellow-700 mb-2">Kalender Gaya & Perawatan</h3>
        <p class="text-gray-600 text-sm">Tampilan mingguanmu bisa kamu lihat dengan jelas dalam tampilan kalender yang kece.</p>
      </div>
    </div>
  </div>
</section>

<!-- Keunggulan Web Kami -->
<section class="bg-white py-20 px-4 md:px-20">
  <div class="max-w-6xl mx-auto text-center">
    <h2 class="text-4xl font-bold mb-12 text-gray-800">Keunggulan Web Kami</h2>
    <div class="grid gap-10 sm:grid-cols-1 md:grid-cols-3">
      
      <!-- Card 1 -->
      <div class="bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl p-6 shadow-lg hover:scale-105 transition duration-300 ease-in-out">
        <div class="flex justify-center mb-4">
          <svg class="w-12 h-12 text-blue-800" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-blue-900 mb-2">User-Friendly</h3>
        <p class="text-gray-700">Antarmuka intuitif dan mudah digunakan untuk segala usia. Gak bikin bingung!</p>
      </div>

      <!-- Card 2 -->
      <div class="bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl p-6 shadow-lg hover:scale-105 transition duration-300 ease-in-out">
        <div class="flex justify-center mb-4">
          <svg class="w-12 h-12 text-purple-800" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-purple-900 mb-2">Personalisasi Harian</h3>
        <p class="text-gray-700">Rancang jadwal fashion dan skincare sesuai kebiasaan kamu. Serasa punya asisten pribadi!</p>
      </div>

      <!-- Card 3 -->
      <div class="bg-gradient-to-br from-pink-100 to-pink-200 rounded-2xl p-6 shadow-lg hover:scale-105 transition duration-300 ease-in-out">
        <div class="flex justify-center mb-4">
          <svg class="w-12 h-12 text-pink-800" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8m-8 4h6m-6 4h4" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-pink-900 mb-2">Efisiensi Waktu</h3>
        <p class="text-gray-700">Semua rutinitas sudah tersusun, kamu tinggal ikuti. Hemat waktu, tetap kece!</p>
      </div>

    </div>
  </div>
  <!-- CTA Ajak Login dan Daftar -->
<section class="bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 text-white py-20 px-4 md:px-20 mt-10 relative overflow-hidden">
  <div class="absolute inset-0 bg-[url('images/bg-texture.png')] opacity-10 bg-cover"></div>
  
  <div class="relative max-w-5xl mx-auto text-center">
    <h2 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">Gabung & Mulai Hari yang Lebih Teratur</h2>
    <p class="text-lg md:text-xl text-white/90 mb-10">Tampil kece & kulit terawat? Gak perlu ribet, cukup 1 akun untuk semua solusi gaya & skincare harianmu!</p>
    
    <div class="flex flex-col sm:flex-row justify-center gap-4">
      <a href="register.php" class="inline-flex items-center justify-center gap-2 bg-white text-blue-700 font-bold py-3 px-6 rounded-2xl hover:bg-blue-100 shadow-xl transition duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Daftar Sekarang
      </a>
      <a href="login.php" class="inline-flex items-center justify-center gap-2 border border-white text-white font-bold py-3 px-6 rounded-2xl hover:bg-white hover:text-blue-700 transition duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
        </svg>
        Login
      </a>
    </div>
  </div>
</section>

</section>





<!-- Footer -->
<footer class="bg-[#1E1E2F] text-white pt-16 pb-10 px-6">
  <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12">
    <div>
      <h3 class="text-2xl font-bold mb-4">🌸 Kelompok 3</h3>
      <p class="text-gray-300">Kami bantu kamu tampil stylish & glowing setiap hari. One place for your daily confidence boost!</p>
    </div>
    <div>
      <h3 class="text-2xl font-bold mb-4">Dibuat Oleh :</h3>
      <ul class="space-y-2 text-gray-300">
        <li>Khoirul Yardan Mauluddin Zhorif</li>
        <li>Angelina Safara</li>
        <li>Pius Hari Purba</li>
      </ul>
    </div>
  </div>
  <div class="text-center text-sm text-gray-500 mt-10">
    &copy; 2025 <span class="font-semibold text-white">Kelompok 3</span>. All rights reserved.
  </div>
</footer>



  

   

</body>
</html>