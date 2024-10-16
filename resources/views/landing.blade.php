<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title class="notranslate" translate="no">{{ env('COMPANY_NAME') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="/images/favicon.svg" type="image/x-icon">

    <!-- Link ke Google Font Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <!-- Link ke Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        /* Mengaktifkan smooth scrolling untuk seluruh halaman */
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Montserrat', sans-serif;
        }

        /* Animasi fade-in */
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Animasi scale */
        .scale-up {
            transition: transform 0.3s ease-in-out;
        }

        .scale-up:hover {
            transform: scale(1.05);
        }

        /* Animasi slide down untuk mobile menu */
        .slide-down {
            transform: scaleY(0);
            transition: transform 0.3s ease-in-out;
            transform-origin: top;
        }

        .slide-down.active {
            transform: scaleY(1);
        }

        /* Styling untuk modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.8);
            /* Background hitam transparan */
            z-index: 999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            padding: 10px;
            /* Tambahkan padding untuk memberi lebih banyak ruang di tepi layar */
        }

        .modal.active {
            opacity: 1;
            pointer-events: all;
        }

        .modal-content {
            background-color: #ffffff;
            padding: 30px;
            /* Tambahkan padding internal pada modal content */
            border-radius: 10px;
            /* Membuat sudut modal lebih melengkung */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 90%;
            max-height: 90%;
            width: 100%;
            height: auto;
            overflow-y: auto;
            margin: 10px;
            /* Tambahkan margin yang lebih besar */
        }

        .close-modal {
            background: #09b8a7;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 10px;
            /* Membuat tombol close juga melengkung */
            cursor: pointer;
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }


        /* Aturan umum untuk efek hover pada layar desktop */
        img:not(.no-hover) {
            filter: grayscale(60%);
            transition: filter 0.3s ease-in-out;
        }

        img:not(.no-hover):hover {
            filter: grayscale(0%);
        }

        .no-hover {
            filter: none;
            transform: none;
            transition: none;
        }

        .no-hover:hover {
            filter: none;
            transform: none;
        }

        /* Nonaktifkan hover pada layar kecil (mobile) */
        @media (max-width: 767px) {
            img:not(.no-hover) {
                filter: none;
                transition: none;
                /* Menonaktifkan transisi */
            }

            img:not(.no-hover):hover {
                filter: none;
                /* Tidak ada perubahan saat di-hover */
            }
        }

        #featured-grid {
            display: grid;
            /* width: 1150px; */
            grid-template-columns: 2fr 1fr 1fr;
            /* Kolom kiri lebih besar (2fr) dan dua kolom di sebelah kanan (1fr) */
            grid-template-rows: 1fr 1fr;
            /* Dua baris */
            gap: 1.5rem;
            grid-template-areas:
                "item1 item2 item3"
                "item1 item4 item5";
        }

        .grid-item-1 {
            grid-area: item1;
            /* Mencakup dua baris */
        }

        .grid-item-2 {
            grid-area: item2;
        }

        .grid-item-3 {
            grid-area: item3;
        }

        .grid-item-4 {
            grid-area: item4;
        }

        .grid-item-5 {
            grid-area: item5;
        }

        /* Media query untuk mobile (tampilan satu kolom) */
        @media (max-width: 767px) {
            #featured-grid {
                display: flex;
                flex-direction: column;
            }

            .grid-item-1,
            .grid-item-2,
            .grid-item-3,
            .grid-item-4,
            .grid-item-5 {
                order: initial;
            }
        }

        .logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            margin-top: 20px;
            flex-wrap: wrap;
            /* Membuat logo dapat berbaris pada layar kecil */
        }

        .logo {
            width: 200px;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.1);
        }

        /* Responsif: Tampilan layar lebih kecil */
        @media (max-width: 768px) {
            .logo {
                width: 120px;

                margin: 5px;
            }

            .modal-content {
                padding: 15px;
            }
        }

        /* Responsif: Tampilan layar ponsel */
        @media (max-width: 480px) {
            .logo {
                width: 100px;

                /* margin: 15px; */
            }

            .modal-content {
                padding: 10px;
            }

            h1 {
                font-size: 1.5rem;
            }

            p {
                font-size: 0.9rem;
            }
        }

        .title-line {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin: 20px 0;
            /* Jarak garis dengan elemen lain */
            position: relative;
        }

        .title-line::before,
        .title-line::after {
            content: "";
            width: 5%;
            /* Panjang garis kiri dan kanan masing-masing 20%, total 40% */
            height: 0.5px;
            /* Ketebalan garis */
            background-color: #d3d3d3;
            /* Warna garis */

        }

        .title-text {
            padding: 0 10px;
            /* Jarak antara teks dan garis */
            font-weight: bold;
            font-size: 16px;
            /* Ukuran font judul */
            text-transform: uppercase;
            /* Mengubah teks menjadi huruf kapital */

        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="p-4 text-[#09b8a7] bg-white shadow-md fade-in">
        <nav class="container flex items-center justify-between mx-auto">
            <div class="flex items-center">
                <img src="/images/logo.png" alt="Logo" class="w-12 h-12 mr-4 no-hover"
                    style="height: 50px; width: auto;" />
                <h1 class="hidden text-lg font-bold md:flex" translate="no">{{ env('COMPANY_NAME') }}</h1>
            </div>

            <!-- Menu Navigasi Desktop -->
            <ul class="hidden md:flex space-x-6 font-semibold text-sm text-[#09b8a7]">
                <li><a href="/" class="hover:text-[#09b8a7] transition duration-300 ease-in-out">BERANDA</a></li>
                <li><a href="#company" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                        data-modal="modal-1">PERUSAHAAN</a></li>
                <li><a href="#services" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                        data-modal="modal-3">FORMAL</a></li>
                <li><a href="#projects" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                        data-modal="modal-4">INFORMAL</a></li>
                <li><a href="#contact" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                        data-modal="modal-5">KONTAK</a></li>
            </ul>

            <!-- Tombol Menu Mobile -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-[#09b8a7]">
                    <!-- Ikon hamburger -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" strokeWidth={2}>
                        <path strokeLinecap="round" strokeLinejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Menu Dropdown Mobile -->
        <ul id="mobile-menu"
            class="flex-col items-center hidden p-6 space-y-4 text-[#09b8a7] bg-white slide-down md:hidden">
            <li><a href="/" class="hover:text-[#09b8a7] transition duration-300 ease-in-out">BERANDA</a></li>
            <li><a href="#company" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                    data-modal="modal-1">PERUSAHAAN</a></li>
            <li><a href="#services" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                    data-modal="modal-3">FORMAL</a></li>
            <li><a href="#projects" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                    data-modal="modal-4">INFORMAL</a></li>
            <li><a href="#contact" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                    data-modal="modal-5">KONTAK</a></li>
        </ul>
    </header>


    <!-- Konten Utama -->
    <main class="container px-4 py-12 mx-auto fade-in">
        <!-- Mengatur ukuran grid dan memastikan elemen di dalamnya tidak melebihi batas -->
        <section id="featured-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-[50%] w-[50%] mx-auto">
            <!-- Kolom 1: COMPANY_NAME (Mencakup dua baris) -->
            <div class="h-auto cursor-pointer md:col-span-1 scale-up grid-item grid-item-1" data-modal="modal-1">
                <div class="relative w-full h-full overflow-hidden group">
                    <!-- Pastikan gambar menggunakan lebar penuh dari kontainernya -->
                    <img src="/images/perusahaan.jpg" alt="PT TAKENAKA INDONESIA"
                        class="object-cover w-full h-full no-hover">
                    <div
                        class="absolute bottom-0 left-0 w-full p-2 text-sm text-center text-white bg-gray-800 bg-opacity-70">
                        <h1 class="text-lg font-bold" translate="no">{{ env('COMPANY_NAME') }}</h1>
                    </div>
                </div>
            </div>

            <!-- Kolom 2: FORMAL (baris pertama) -->
            <div class="relative w-full h-full overflow-hidden cursor-pointer group scale-up grid-item grid-item-2"
                data-modal="modal-3">
                <img src="/images/formal.jpg" alt="FORMAL" class="object-cover w-full h-full">
                <div
                    class="absolute bottom-0 left-0 w-full p-2 text-sm text-center text-white bg-gray-800 bg-opacity-70">
                    FORMAL
                </div>
            </div>

            <!-- Kolom 3: INFORMAL (baris pertama) -->
            <div class="relative w-full h-full overflow-hidden cursor-pointer group scale-up grid-item grid-item-3"
                data-modal="modal-4">
                <img src="/images/informal.jpg" alt="INFORMAL" class="object-cover w-full h-full">
                <div
                    class="absolute bottom-0 left-0 w-full p-2 text-sm text-center text-white bg-gray-800 bg-opacity-70">
                    INFORMAL
                </div>
            </div>

            <!-- Kolom 4: TENTANG KAMI (baris kedua) -->
            <div class="relative w-full h-full overflow-hidden cursor-pointer group scale-up grid-item grid-item-4"
                data-modal="modal-2">
                <img src="/images/tentangkami.jpg" alt="TENTANG KAMI" class="object-cover w-full h-full">
                <div
                    class="absolute bottom-0 left-0 w-full p-2 text-sm text-center text-white bg-gray-800 bg-opacity-70">
                    TENTANG KAMI
                </div>
            </div>

            <!-- Kolom 5: KONTAK (baris kedua) -->
            <div class="relative w-full h-full overflow-hidden cursor-pointer group scale-up grid-item grid-item-5"
                data-modal="modal-5">
                <img src="/images/hubungi.jpg" alt="KONTAK" class="object-cover w-full h-full">
                <div
                    class="absolute bottom-0 left-0 w-full p-2 text-sm text-center text-white bg-gray-800 bg-opacity-70">
                    KONTAK
                </div>
            </div>
        </section>
    </main>

    <div class="title-line">
        <span class="title-text">Sinkronisasi</span>
    </div>
    <div class="logos">
        <img src="images/bp2mi.png" alt="BP2MI" class="logo no-hover">
        <img src="images/kemnaker.png" alt="Kemnaker" class="logo no-hover">
        <img src="images/siapkerja.svg" alt="OSS" class="logo no-hover">
        <img src="images/karirhub.svg" alt="OSS" class="logo no-hover">
        <img src="images/oss.svg" alt="OSS" class="logo no-hover">
    </div>
    <br>
    <div class="title-line">
        <span class="title-text">Rekanan agency Teratas</span>
    </div>
    <div class="logos">
        <img src="images/agency/1.png"class="logo no-hover" style="height: 100px; width: auto;">
        <img src="images/agency/1.png"class="logo no-hover" style="height: 100px; width: auto;">
        <img src="images/agency/1.png"class="logo no-hover" style="height: 100px; width: auto;">
    </div>
    <br>
    <ul class="flex justify-center space-x-6 font-semibold text-sm text-[#09b8a7]">
        <li><a href="#company" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                data-modal="modal-1">LAINNYA</a></li>
    </ul>
    <br>
    <div class="title-line">
        <span class="title-text">pelatihan dan sertifikasi Teratas</span>
    </div>
    <div class="logos">
        <img src="images/ujk/1.png" alt="UJK" class="logo no-hover" style="height: 100px; width: auto;">
        <img src="images/ujk/2.png" alt="UJK" class="logo no-hover" style="height: 100px; width: auto;">

    </div>
    <br>
    <ul class="flex justify-center space-x-6 font-semibold text-sm text-[#09b8a7]">
        <li><a href="#company" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                data-modal="modal-1">LAINNYA</a></li>
    </ul>
    <br>
    <br>
    <!-- Modal untuk konten masing-masing grid dan menu -->
    <div id="modal-1" class="modal">
        <div class="modal-content">
            <button class="close-modal">X</button>
            <div class="flex justify-center mt-4 logos">
                <img src="images/logo.png"class="mx-2 logo no-hover" style="height: 150px; width: auto;">
            </div>
            <h1 class="text-lg font-bold" translate="no">{{ env('COMPANY_NAME') }}</h1>
            <p class="mt-4 text-justify">
                <strong>Adalah</strong> Perusahaan yang berfokus pada penyediaan tenaga kerja berkualitas untuk bekerja
                di luar negeri. Kami memiliki komitmen yang kuat untuk memberikan layanan perekrutan yang profesional,
                menjunjung tinggi kepatuhan terhadap regulasi ketenagakerjaan, dan menjamin perlindungan hak-hak pekerja
                migran.
            </p>
            <p class="mt-4 text-justify">
                Visi kami adalah menciptakan dunia kerja yang lebih baik bagi tenaga kerja Indonesia, di mana setiap
                pekerja memiliki akses ke peluang yang aman dan sejahtera. Kami percaya bahwa dengan memfasilitasi
                penempatan yang tepat, kami dapat berkontribusi pada peningkatan kualitas hidup mereka serta memperkuat
                perekonomian nasional.
            </p>
            <h3 class="mt-4 font-semibold">Visi</h3>
            <p class="mt-2 text-justify">
                Menjadi perusahaan penempatan pekerja migran terkemuka yang mendukung kesejahteraan tenaga kerja
                Indonesia di panggung global, serta berkontribusi pada peningkatan perekonomian nasional melalui
                penempatan tenaga kerja berkualitas.
            </p>

            <h3 class="mt-4 font-semibold">Misi</h3>
            <ul class="mt-4 list-disc list-inside">
                <li>Menyediakan tenaga kerja Indonesia yang terlatih dan kompeten sesuai dengan kebutuhan pasar
                    internasional.</li>
                <li>Menjamin proses perekrutan yang transparan, adil, dan sesuai dengan peraturan pemerintah serta
                    standar internasional.</li>
                <li>Memberikan perlindungan maksimal bagi pekerja migran melalui dukungan sebelum, selama, dan setelah
                    masa penempatan kerja.</li>
                <li>Membangun kemitraan strategis dengan perusahaan internasional yang tepercaya untuk menciptakan
                    peluang kerja yang aman dan menguntungkan.</li>
                <li>Meningkatkan kesejahteraan pekerja dan keluarganya melalui upaya pendidikan, pelatihan, dan advokasi
                    yang berkelanjutan.</li>
            </ul>
            <p class="mt-4 text-justify">
                Kami memahami bahwa setiap pekerja adalah aset berharga. Oleh karena itu, kami berkomitmen untuk
                mendukung mereka dalam perjalanan karir mereka, mulai dari proses perekrutan hingga penempatan, serta
                memberikan bimbingan untuk beradaptasi dengan lingkungan kerja baru.
            </p>
            <br>
            <!-- Menambahkan informasi perizinan resmi -->
            <p class="mt-2 text-sm font-semibold text-green-700">
                Kami telah berizin resmi dari <strong>BP2MI</strong>, <strong>Kementerian Ketenagakerjaan Republik
                    Indonesia</strong>, dan terdaftar dalam <strong>Online Single Submission (OSS)</strong> untuk
                operasi perekrutan pekerja migran.
            </p>
            <br>
            <br>
            <div class="flex justify-center mt-4 logos">
                <img src="images/bp2mi.png" alt="BP2MI" class="mx-2 logo no-hover">
                <img src="images/kemnaker.png" alt="Kemnaker" class="mx-2 logo no-hover">
                <img src="images/oss.svg" alt="OSS" class="mx-2 logo no-hover">
            </div>
            <br>
            <br>
            <div class="title-line">
                <span class="title-text">Rekanan</span>
            </div>
            <br>
            <div class="flex flex-col justify-between md:flex-row">
                <!-- Kolom 1 (Lembaga Pelatihan Dan Sertifikasi) -->
                <div class="w-full pl-4 md:w-1/2">
                    <h3 class="flex justify-center mt-4 font-semibold">Lembaga Pelatihan Dan Sertifikasi</h3>
                    <ul class="mt-4 list-disc list-inside">
                        @foreach ($pelatihan as $item)
                            <div class="p-4">
                                <h3 class="flex mt-4">{{ $item->nama }}</h3>
                            </div>
                        @endforeach
                    </ul>
                </div>

                <!-- Kolom 2 (Agency) -->
                <div class="w-full pr-4 md:w-1/2">
                    <h3 class="flex justify-center mt-4 font-semibold">Agensi Luar Negeri</h3>
                    <ul class="mt-4 list-disc list-inside">
                        @foreach ($agency as $item)
                            <div class="p-4">
                                <h3 class="flex mt-4">{{ $item->nama }}</h3>
                            </div>
                        @endforeach
                    </ul>
                </div>
            </div>


        </div>
    </div>


    <div id="modal-2" class="modal">
        <div class="modal-content">
            <button class="close-modal">X</button>
            <h2 class="text-2xl font-bold text-center">Tentang Kami</h2>
            <div class="flex justify-center mt-4 logos">
                <br>
                <div class="flex justify-center mt-4 logos">
                    <img src="images/logo.png"class="mx-2 logo no-hover" style="height: 150px; width: auto;">
                </div>
                <br>
                <br>
                <br>
            </div>
            <p class="mt-4 text-justify">
            <h1 class="text-lg font-bold" translate="no">{{ env('COMPANY_NAME') }}</h1>
            adalah Perushaan yang memiliki
            lebih dari 10 tahun pengalaman dalam menyediakan layanan penempatan tenaga kerja profesional ke berbagai
            negara di seluruh dunia. Dengan rekam jejak yang solid, kami fokus pada penyediaan tenaga kerja terlatih
            dan berkualitas tinggi, telah membantu ribuan pekerja Indonesia mendapatkan pekerjaan yang layak dan
            aman di luar negeri. Kami bangga menjadi mitra terpercaya di industri ini, dikenal atas komitmen kami
            untuk meningkatkan kesejahteraan tenaga kerja migran.
            </p>

            <p class="mt-4 text-justify">
                Kami menjalin kerjasama dengan mitra internasional yang tepercaya untuk memastikan bahwa proses
                perekrutan kami adil, transparan, dan sesuai dengan regulasi yang berlaku. Setiap langkah dalam proses
                ini didasarkan pada etika kerja yang tinggi dan perlindungan hak-hak pekerja migran.
            </p>

            <h3 class="mt-4 font-semibold">Latar Belakang Perusahaan</h3>
            <p class="mt-2 text-justify">
                Didirikan dengan visi untuk memberikan solusi tenaga kerja yang efisien, kami telah menjadi pemimpin
                dalam industri penempatan pekerja migran. Dengan pengalaman lebih dari satu dekade, kami memahami
                tantangan yang dihadapi oleh para pekerja dalam mendapatkan pekerjaan di luar negeri. Kami berkomitmen
                untuk memberikan dukungan penuh sepanjang proses penempatan, membantu pekerja mencapai tujuan karir
                mereka dengan tim profesional yang berpengalaman dan terlatih.
            </p>

            <h3 class="mt-4 font-semibold">Visi</h3>
            <p class="mt-2 text-justify">
                Menjadi perusahaan penempatan pekerja migran terkemuka yang mendukung kesejahteraan tenaga kerja
                Indonesia di panggung global, serta berkontribusi pada peningkatan perekonomian nasional melalui
                penempatan tenaga kerja berkualitas.
            </p>

            <h3 class="mt-4 font-semibold">Misi</h3>
            <ul class="mt-4 list-disc list-inside">
                <li>Menyediakan tenaga kerja Indonesia yang terlatih dan kompeten sesuai dengan kebutuhan pasar
                    internasional.</li>
                <li>Menjamin proses perekrutan yang transparan, adil, dan sesuai dengan peraturan pemerintah serta
                    standar internasional.</li>
                <li>Memberikan perlindungan maksimal bagi pekerja migran melalui dukungan sebelum, selama, dan setelah
                    masa penempatan kerja.</li>
                <li>Membangun kemitraan strategis dengan perusahaan internasional yang tepercaya untuk menciptakan
                    peluang kerja yang aman dan menguntungkan.</li>
                <li>Meningkatkan kesejahteraan pekerja dan keluarganya melalui upaya pendidikan, pelatihan, dan advokasi
                    yang berkelanjutan.</li>
            </ul>
            <br>
            <p class="mt-4 text-justify">
                <strong>Regards</strong>
                <br><br><br>
                <strong>David Beckam</strong>
                <br>
                Directur
            <h1 class="text-lg font-bold" translate="no">{{ env('COMPANY_NAME') }}</h1>
            </p>
        </div>
    </div>



    <div id="modal-3" class="modal">
        <div class="modal-content">
            <button class="close-modal">X</button>
            <h2 class="text-2xl font-bold">SEKTOR FORMAL</h2>
            <br>
            <h2 class="text-2xl font-bold">Negara Tujuan</h2>
            <strong>Asia - Afrika (Hong Kong, Singapura, Taiwan, Malaysia, Korea, Jepang. dll).</strong>
            <br>
            <p class="mt-4">
                Pekerja migran Indonesia di sektor formal sering kali terlibat dalam pekerjaan yang lebih terstruktur
                dan memiliki perlindungan hukum yang lebih baik. Berikut adalah beberapa sektor pekerjaan yang umum bagi
                pekerja migran di sektor formal:
            </p>
            <br>
            <h2 class="text-2xl font-bold">Sektor Pekerjaan</h2>
            <ul class="ml-6 list-disc">
                <li><strong>Pekerjaan Profesional:</strong> Dokter, perawat, insinyur, dan tenaga pendidik yang memiliki
                    kualifikasi tinggi dan izin kerja yang sesuai.</li>
                <li><strong>Teknologi Informasi:</strong> Pekerja di bidang IT seperti pengembang perangkat lunak,
                    analis sistem, dan teknisi jaringan.</li>
                <li><strong>Perbankan dan Keuangan:</strong> Pekerja di sektor perbankan, akuntansi, dan keuangan yang
                    terlibat dalam analisis keuangan dan manajemen investasi.</li>
                <li><strong>Industri Manufaktur:</strong> Pekerja yang terlibat dalam proses produksi barang dengan
                    pengawasan ketat dan standar keselamatan kerja.</li>
                <li><strong>Pekerjaan di Layanan Publik:</strong> Tenaga kerja yang bekerja di lembaga pemerintah dan
                    organisasi internasional.</li>
                <li><strong>Perhotelan dan Pariwisata:</strong> Pekerja di sektor perhotelan sebagai manajer hotel,
                    resepsionis, dan staf layanan lainnya.</li>
            </ul>
            <br>
            <br>
        </div>
    </div>

    <div id="modal-4" class="modal">
        <div class="modal-content">
            <button class="close-modal">X</button>
            <h2 class="text-2xl font-bold">SEKTOR INFORMAL</h2>
            <br>
            <h2 class="text-2xl font-bold">Negara Tujuan</h2>
            <strong>Asia - Afrika (Hong Kong, Singapura, Taiwan, Malaysia, Korea, Jepang. dll).</strong>
            <br>
            <p class="mt-4">
                Pekerja migran Indonesia di sektor informal terlibat dalam beragam pekerjaan yang sering kali berkaitan
                dengan layanan perawatan, pekerjaan rumah tangga, dan sektor industri. Berikut adalah sektor-sektor
                pekerjaan yang umum:
            </p>
            <br>
            <h2 class="text-2xl font-bold">Sektor Pekerjaan</h2>
            <ul class="ml-6 list-disc">
                <li><strong>Pekerjaan Rumah Tangga:</strong> Pembantu rumah tangga yang mengurus rumah tangga, merawat
                    anak, dan lansia. Layanan perawatan untuk individu dengan kebutuhan khusus.</li>
                <li><strong>Konstruksi:</strong> Tenaga kerja di proyek konstruksi dan infrastruktur. Bekerja di
                    proyek-proyek pembangunan.</li>
                <li><strong>Layanan Makanan:</strong> Bekerja di restoran dan kafe sebagai pelayan atau koki.</li>
                <li><strong>Pekerja Perawatan:</strong> Merawat orang tua atau individu yang membutuhkan bantuan.</li>
                <li><strong>Pekerja Pabrik:</strong> Terlibat dalam industri manufaktur, terutama di pabrik elektronik
                    dan tekstil.</li>
                <li><strong>Pertanian:</strong> Bekerja di sektor pertanian, termasuk pertanian sayuran, buah, dan
                    kelapa sawit.</li>
                <li><strong>Industri Perikanan:</strong> Terlibat dalam industri perikanan.</li>
            </ul>
            <br>
            <br>
        </div>
    </div>



    <div id="modal-5" class="modal">
        <div class="modal-content">
            <button class="close-modal">X</button>
            <h2 class="text-2xl font-bold">Hubungi Kami</h2>
            <div class="grid grid-cols-1 gap-6 mt-4 md:grid-cols-2">
                <!-- Kolom 1 -->
                <div>
                    <p>
                        <strong>Alamat Kantor:</strong><br>
                    <p class="text-sm" translate="no">{{ env('COMPANY_NAME') }}</p>
                    <p class="text-sm" translate="no">{{ env('COMPANY_ADD') }}</p>
                    </p>
                    <p class="mt-4">
                        <strong>Nomor Telepon:</strong><br>
                        +62 21 1234 5678 <br>
                        +62 21 1234 5678 <a href="https://wa.me/62112345678" target="_blank"
                            class="text-blue-500">WhatsApp Available</a><br>
                    </p>
                    <p class="mt-4">
                        <strong>Email:</strong><br>
                        info@pekerjamigran.co.id
                    </p>
                </div>

                <!-- Kolom 2 -->
                <div>
                    <p>
                        <strong>Jam Operasional:</strong><br>
                        Senin - Jumat: 09:00 - 17:00 WIB<br>
                        Sabtu: 09:00 - 13:00 WIB
                    </p>
                    <p class="mt-4">
                        <strong>Media Sosial:</strong><br>
                        Instagram: <a href="https://instagram.com/#" target="_blank"
                            class="text-blue-500">instagram.com/#</a><br>
                        Facebook: <a href="https://facebook.com/#" target="_blank"
                            class="text-blue-500">facebook.com/#</a><br>
                        Twitter: <a href="https://twitter.com/#" target="_blank"
                            class="text-blue-500">twitter.com/#</a>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer dengan warna solid -->
    <footer class="py-6 text-white fade-in" style="background-color: #09b8a7;">
        <div class="container px-4 mx-auto">
            <div class="flex flex-col items-start justify-between space-y-4 md:flex-row md:items-center md:space-y-0">
                <!-- Logo dan Teks -->
                <div class="flex flex-col">
                    <div class="flex items-center">
                        <img src="/images/logo-darkmode.png" alt="Logo" class="w-12 h-12 mr-4 no-hover"
                            style="height: 50px; width: auto;" />
                        <h1 class="hidden text-lg font-bold md:flex" translate="no">{{ env('COMPANY_NAME') }}</h1>
                    </div>
                    <br>
                    <p class="hidden mt-2 text-sm transition duration-300 ease-in-out md:flex hover:text-gray-300">
                        Perusahaan Penempatan Pekerja Migran Indonesia <br>
                    <p class="text-sm" translate="no">{{ env('COMPANY_ADD') }}</p>
                    </p>
                </div>

                <!-- Tautan Navigasi -->
                <ul class="hidden space-x-6 text-sm font-semibold text-white md:flex">
                    <li><a href="/" class="hover:text-[#09b8a7] transition duration-300 ease-in-out">BERANDA</a>
                    </li>
                    <li><a href="#company" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                            data-modal="modal-1">PERUSAHAAN</a></li>
                    <li><a href="#services" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                            data-modal="modal-3">FORMAL</a></li>
                    <li><a href="#projects" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                            data-modal="modal-4">INFORMAL</a></li>
                    <li><a href="#contact" class="hover:text-[#09b8a7] transition duration-300 ease-in-out"
                            data-modal="modal-5">KONTAK</a></li>
                </ul>

                <!-- Tautan Internasional -->
                <ul class="flex space-x-6 text-sm sm:justify-center md:justify-start">
                    <li><a href="/admin" class="transition duration-300 ease-in-out hover:text-gray-300">LOGIN
                            STAFF</a></li>
                    <li><a href="/admin" class="transition duration-300 ease-in-out hover:text-gray-300">LOGIN
                            AGENCY</a></li>
                </ul>

                {{-- <div id="google_translate_element" class="translate-button"></div> --}}
            </div>

            <!-- Bagian Hak Cipta -->
            <div class="pt-4 mt-6 text-center border-t border-gray-400">
                <p class="text-sm" translate="no">
                    {{ env('COMPANY_NAME') }} &copy; {{ now()->year }} All rights reserved
                </p>
            </div>
        </div>
    </footer>

    <!-- Script untuk mobile menu dan popup modal -->
    <script>
        // Mobile menu
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('active');
        });

        // Modal functionality
        const modalTriggers = document.querySelectorAll('[data-modal]');
        const modals = document.querySelectorAll('.modal');
        const closeModalButtons = document.querySelectorAll('.close-modal');

        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', (event) => {
                event.preventDefault(); // Mencegah scroll karena tautan
                const modalId = trigger.getAttribute('data-modal');
                document.getElementById(modalId).classList.add('active');
            });
        });

        closeModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                modals.forEach(modal => modal.classList.remove('active'));
            });
        });

        // Close modal when clicking outside the content
        window.addEventListener('click', (e) => {
            modals.forEach(modal => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });
    </script>

    <!-- Tombol Translate -->
    <div id="google_translate_element" onclick="triggerGoogleTranslate()"></div>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'en,zh-CN,zh-TW,ja,ko,ms,ru',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }

        // Fungsi untuk memunculkan widget Google Translate ketika ikon diklik
        function triggerGoogleTranslate() {
            var translateElement = document.querySelector('#google_translate_element .goog-te-gadget-simple');
            if (translateElement) {
                translateElement.click();
            }
        }
    </script>

    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>

    <!-- CSS untuk menampilkan logo Google Translate dan menyembunyikan elemen asli -->
    <style>
        /* Tampilan awal ikon Google Translate */
        #google_translate_element {
            position: fixed;
            /* Agar elemen tetap melayang */
            bottom: 20px;
            /* Jarak dari bawah layar */
            right: 20px;
            /* Jarak dari kanan layar */
            display: inline-block;
            cursor: pointer;
            z-index: 1000;
            /* Pastikan elemen di atas elemen lain */
        }

        /* Menambahkan logo Google Translate */
        #google_translate_element::before {
            content: url('https://upload.wikimedia.org/wikipedia/commons/d/d7/Google_Translate_logo.svg');
            display: inline-block;
            width: 40px;
            /* Sesuaikan ukuran ikon */
            height: 40px;
            /* Sesuaikan ukuran ikon */
        }

        /* Sembunyikan widget asli Google Translate */
        #google_translate_element .goog-te-gadget-simple {
            display: none;
        }
    </style>
    <!-- Batas Tombol Translate -->
</body>

</html>
