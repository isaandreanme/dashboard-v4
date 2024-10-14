<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Takenaka</title>

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
        }

        .modal.active {
            opacity: 1;
            pointer-events: all;
        }

        .modal-content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 20px;
            /* Membuat sudut modal lebih melengkung */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 90%;
            max-height: 90%;
            width: 100%;
            height: 100%;
            overflow-y: auto;
            margin: 20px;
            /* Memberikan margin agar tidak menempel ke tepi layar */
        }

        .close-modal {
            background: #7D1B3D;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 20px;
            /* Membuat tombol close juga melengkung */
            cursor: pointer;
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        /* Aturan umum untuk efek hover pada layar desktop */
        img:not(.no-hover) {
            filter: grayscale(100%);
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
    </style>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white text-black shadow-md p-4 fade-in">
        <nav class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="/images/icon.png" alt="Logo" class="mr-4 w-12 h-12 no-hover" />
                <h1 class="text-lg font-bold">{{ env('COMPANY_NAME') }}</h1>
            </div>

            <!-- Menu Navigasi Desktop -->
            <ul class="hidden md:flex space-x-6 font-semibold text-sm text-gray-800">
                <li><a href="/" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out">BERANDA</a></li>
                <li><a href="#company" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out"
                        data-modal="modal-1">PERUSAHAAN</a></li>
                <li><a href="#services" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out"
                        data-modal="modal-3">FORMAL</a></li>
                <li><a href="#projects" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out"
                        data-modal="modal-4">INFORMAL</a></li>
                <li><a href="#contact" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out"
                        data-modal="modal-5">KONTAK</a></li>
            </ul>

            <!-- Tombol Menu Mobile -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-black">
                    <!-- Ikon hamburger -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" strokeWidth={2}>
                        <path strokeLinecap="round" strokeLinejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Menu Dropdown Mobile -->
        <ul id="mobile-menu"
            class="slide-down md:hidden bg-white text-black flex flex-col items-center space-y-4 p-6 hidden">
            <li><a href="/" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out">BERANDA</a></li>
            <li><a href="#company" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out"
                    data-modal="modal-1">PERUSAHAAN</a></li>
            <li><a href="#services" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out"
                    data-modal="modal-3">FORMAL</a></li>
            <li><a href="#projects" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out"
                    data-modal="modal-4">INFORMAL</a></li>
            <li><a href="#contact" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out"
                    data-modal="modal-5">KONTAK</a></li>
        </ul>
    </header>

    <!-- Konten Utama -->
    <main class="container mx-auto py-12 px-4 fade-in">
        <section id="featured-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-1/2 mx-auto">
            <!-- Kolom 1: Gambar besar -->
            <div class="md:col-span-1 h-[610px] scale-up cursor-pointer" data-modal="modal-1">
                <div class="relative group w-full h-full overflow-hidden">
                    <img src="/images/tentangkami.jpg" alt="PT TAKENAKA INDONESIA"
                        class="w-full h-full object-cover no-hover">
                    <div
                        class="absolute bottom-0 left-0 w-full bg-gray-800 bg-opacity-70 text-white p-2 text-sm text-center">
                        <h1 class="text-lg font-bold">{{ env('COMPANY_NAME') }}</h1>
                    </div>
                </div>
            </div>

            <!-- Kolom 2: Dua gambar kecil -->
            <div class="md:col-span-1 grid grid-rows-2 gap-6">
                <div class="relative group w-full h-full overflow-hidden scale-up cursor-pointer" data-modal="modal-3">
                    <img src="/images/formal.jpg" alt="FORMAL" class="w-full h-full object-cover">
                    <div
                        class="absolute bottom-0 left-0 w-full bg-gray-800 bg-opacity-70 text-white p-2 text-sm text-center">
                        FORMAL
                    </div>
                </div>
                <div class="relative group w-full h-full overflow-hidden scale-up cursor-pointer" data-modal="modal-2">
                    <img src="/images/tentangkami.jpg" alt="TENTANG KAMI" class="w-full h-full object-cover">
                    <div
                        class="absolute bottom-0 left-0 w-full bg-gray-800 bg-opacity-70 text-white p-2 text-sm text-center">
                        TENTANG KAMI
                    </div>
                </div>
            </div>

            <!-- Kolom 3: Dua gambar kecil -->
            <div class="md:col-span-1 grid grid-rows-2 gap-6">
                <div class="relative group w-full h-full overflow-hidden scale-up cursor-pointer" data-modal="modal-4">
                    <img src="/images/informal.jpg" alt="INFORMAL" class="w-full h-full object-cover">
                    <div
                        class="absolute bottom-0 left-0 w-full bg-gray-800 bg-opacity-70 text-white p-2 text-sm text-center">
                        INFORMAL
                    </div>
                </div>
                <div class="relative group w-full h-full overflow-hidden scale-up cursor-pointer" data-modal="modal-5">
                    <img src="/images/hubungi.jpg" alt="KONTAK" class="w-full h-full object-cover">
                    <div
                        class="absolute bottom-0 left-0 w-full bg-gray-800 bg-opacity-70 text-white p-2 text-sm text-center">
                        KONTAK
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal untuk konten masing-masing grid dan menu -->
    <div id="modal-1" class="modal">
        <div class="modal-content">
            <button class="close-modal">X</button>
            <h1 class="text-lg font-bold">{{ env('COMPANY_NAME') }}</h1>
            <p class="mt-4">Perusahaan Penempatan Pekerja Migran Indonesia adalah lembaga yang berfokus pada
                penyediaan tenaga kerja berkualitas untuk bekerja di luar negeri.
                Kami berkomitmen memberikan layanan perekrutan yang profesional, memastikan kepatuhan terhadap regulasi
                ketenagakerjaan, serta menjamin perlindungan hak-hak
                pekerja migran. Melalui jaringan global dan kemitraan dengan berbagai negara, kami membantu tenaga kerja
                Indonesia mendapatkan peluang kerja yang aman dan
                sejahtera di luar negeri, sekaligus memberikan kontribusi pada peningkatan kualitas hidup mereka serta
                perekonomian nasional.</p>
        </div>
    </div>

    <div id="modal-2" class="modal">
        <div class="modal-content">
            <button class="close-modal">X</button>
            <h2 class="text-2xl font-bold">Tentang Kami</h2>
            <p class="mt-4">
                Perusahaan Penempatan Pekerja Migran Indonesia adalah perusahaan dengan pengalaman lebih dari 10 tahun
                dalam memberikan layanan penempatan tenaga kerja profesional ke berbagai negara di seluruh dunia. Dengan
                fokus pada penyediaan tenaga kerja terlatih dan berkualitas, kami telah berhasil membantu ribuan pekerja
                Indonesia mendapatkan pekerjaan yang layak dan aman di luar negeri. Kami bekerja sama dengan mitra
                internasional yang tepercaya untuk memastikan proses perekrutan yang adil dan sesuai regulasi.
            </p>
            <p class="mt-4">
                <strong>Visi</strong><br>
                Menjadi perusahaan penempatan pekerja migran terkemuka yang mendukung kesejahteraan tenaga kerja
                Indonesia di panggung global, serta berkontribusi pada peningkatan perekonomian nasional melalui
                penempatan tenaga kerja berkualitas.
            </p>
            <p class="mt-4">
                <strong>Misi</strong>
            </p>
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
        </div>
    </div>

    <div id="modal-3" class="modal">
        <div class="modal-content">
            <button class="close-modal">X</button>
            <h2 class="text-2xl font-bold">SEKTOR FORMAL</h2>
            <p class="mt-4">
            <h2 class="text-2xl font-bold">Negara Tujuan</h2>
            <strong>Asia - Afrika (Hong Kong, Singapura, Taiwan, Malaysia).</strong>
            <br>
            <br>

            </p>
            <p class="mt-4">
                Sektor formal merujuk pada aktivitas ekonomi yang diatur oleh hukum dan pemerintah, di mana perusahaan
                dan pekerja biasanya terdaftar secara resmi. Pekerja di sektor formal memiliki kontrak yang jelas, serta
                hak-hak seperti upah minimum, jam kerja yang diatur, perlindungan sosial, dan hak jaminan kesehatan.
                Berikut adalah beberapa jenis pekerjaan yang umumnya termasuk dalam sektor formal:
            </p>
            <p class="mt-4">
                <strong>Pekerjaan di Perusahaan Swasta (Private Sector Jobs)</strong><br>
                Pekerja di perusahaan swasta yang terdaftar secara resmi, termasuk pekerjaan di bidang teknologi,
                manufaktur, perbankan, ritel, dan jasa lainnya. Perusahaan-perusahaan ini biasanya mematuhi
                undang-undang ketenagakerjaan dan memberikan jaminan sosial serta hak-hak pekerja seperti cuti dan
                asuransi kesehatan.
            </p>
            <p class="mt-4">
                <strong>Pekerjaan di Lembaga Pemerintah (Public Sector Jobs)</strong><br>
                Pekerjaan di lembaga pemerintah, baik pusat maupun daerah, termasuk administrasi, pendidikan, kesehatan,
                dan keamanan publik. Pekerja sektor formal di pemerintahan biasanya mendapatkan jaminan pekerjaan yang
                lebih stabil, gaji tetap, serta tunjangan pensiun.
            </p>
            <p class="mt-4">
                <strong>Industri Manufaktur Besar (Large-Scale Manufacturing)</strong><br>
                Industri besar seperti otomotif, tekstil, makanan, dan bahan kimia biasanya beroperasi di sektor formal.
                Pekerja di industri ini biasanya memiliki kontrak kerja formal, mendapatkan upah sesuai standar
                industri, serta perlindungan keselamatan kerja.
            </p>
            <p class="mt-4">
                <strong>Perbankan dan Keuangan (Banking and Finance)</strong><br>
                Pekerjaan di bank, perusahaan asuransi, dan lembaga keuangan lainnya termasuk dalam sektor formal.
                Karyawan di sektor ini biasanya mendapatkan tunjangan seperti asuransi kesehatan, bonus kinerja, dan
                rencana pensiun yang terstruktur.
            </p>
            <p class="mt-4">
                <strong>Sektor Pendidikan (Education Sector)</strong><br>
                Guru, dosen, dan staf pendidikan di sekolah atau universitas yang diakui oleh pemerintah termasuk dalam
                sektor formal. Mereka biasanya mendapatkan gaji tetap, cuti tahunan, serta tunjangan kesehatan dan
                pensiun.
            </p>
            <p class="mt-4">
                <strong>Sektor Kesehatan (Healthcare Sector)</strong><br>
                Dokter, perawat, dan tenaga medis lainnya yang bekerja di rumah sakit, klinik, atau pusat kesehatan yang
                terdaftar secara resmi. Pekerja di sektor ini mendapatkan upah yang diatur, jaminan kesehatan, dan
                sering kali memiliki perlindungan ketenagakerjaan yang baik.
            </p>
            <p class="mt-4">
                <strong>Industri Teknologi Informasi (Information Technology)</strong><br>
                Pekerjaan di bidang teknologi informasi seperti pengembangan perangkat lunak, keamanan siber, dan
                layanan digital umumnya termasuk sektor formal, dengan gaji yang kompetitif, jam kerja yang diatur, dan
                tunjangan lain seperti asuransi kesehatan.
            </p>
            <p class="mt-4">
                Sektor formal menawarkan lebih banyak perlindungan bagi pekerja dibandingkan sektor informal. Ini
                termasuk jaminan sosial, hak-hak ketenagakerjaan, dan tunjangan yang lebih lengkap. Pekerjaan di sektor
                formal juga lebih stabil dan terjamin dalam jangka panjang.
            </p>
        </div>
    </div>

    <div id="modal-4" class="modal">
        <div class="modal-content">
            <button class="close-modal">X</button>
            <h2 class="text-2xl font-bold">SEKTOR INFORMAL</h2>
            <p class="mt-4">
            <p class="mt-4">
            <h2 class="text-2xl font-bold">Negara Tujuan</h2>
            <strong>Asia - Afrika (Hong Kong, Singapura, Taiwan, Malaysia).</strong>
            <br>
            <br>

            </p>
            <strong>Pekerjaan Domestik (Domestic Work)</strong><br>
            Banyak pekerja rumah tangga yang bekerja dalam sektor informal, baik di rumah mereka sendiri atau di
            rumah orang lain, menyediakan layanan seperti membersihkan rumah, mencuci pakaian, memasak, dan merawat
            anak atau orang tua. Di Asia dan Afrika, pekerja domestik sering kali tidak terdaftar secara resmi dan
            tidak memiliki kontrak kerja yang formal, sehingga tidak mendapatkan hak-hak seperti upah minimum atau
            perlindungan kesehatan.
            </p>
            <p class="mt-4">
                <strong>Industri Rumahan (Home-Based Industries)</strong><br>
                Banyak rumah tangga di Asia dan Afrika yang menjalankan usaha rumahan sebagai sumber pendapatan
                tambahan. Ini bisa termasuk produksi makanan, menjahit pakaian, kerajinan tangan, atau barang-barang
                dekoratif. Usaha ini biasanya dijalankan oleh anggota keluarga di dalam rumah tanpa registrasi formal.
                Misalnya, di Indonesia, banyak rumah tangga yang memproduksi makanan ringan tradisional untuk dijual di
                pasar lokal.
            </p>
            <p class="mt-4">
                <strong>Pekerja Lepas di Rumah (Freelancers from Home)</strong><br>
                Banyak individu, terutama perempuan, bekerja dari rumah dengan menyediakan jasa seperti penjahit, tukang
                jahit, pengrajin, atau pembuat kerajinan. Di beberapa negara, seperti India dan Bangladesh, banyak
                perempuan yang bekerja dari rumah membuat tekstil atau pakaian untuk industri garmen, namun mereka
                sering kali tidak mendapatkan hak dan perlindungan yang dimiliki pekerja formal.
            </p>
            <p class="mt-4">
                <strong>Petani Rumah Tangga Skala Kecil (Small-Scale Family Farming)</strong><br>
                Pertanian keluarga yang kecil, di mana seluruh rumah tangga terlibat dalam mengelola lahan atau
                peternakan kecil, merupakan bentuk sektor informal yang signifikan di banyak negara Asia dan Afrika.
                Hasil pertanian ini biasanya untuk kebutuhan sendiri dan sebagian kecil dijual di pasar lokal. Karena
                kegiatan ini tidak terdaftar secara resmi, pekerja pertanian rumah tangga sering kali tidak mendapat
                perlindungan hukum atau jaminan sosial.
            </p>
            <p class="mt-4">
                <strong>Usaha Mikro di Rumah (Micro-Enterprises at Home)</strong><br>
                Rumah tangga juga sering kali berfungsi sebagai basis usaha mikro, seperti warung kecil atau toko
                kelontong yang dikelola dari rumah. Di banyak negara seperti Indonesia, Filipina, Nigeria, atau Kenya,
                warung kecil atau usaha ritel yang dijalankan dari rumah menjadi sumber pendapatan utama bagi keluarga.
                Ini termasuk penjualan makanan, minuman, atau barang kebutuhan sehari-hari.
            </p>
            <p class="mt-4">
                <strong>Pekerjaan Perawatan dan Jasa dari Rumah (Care Work and Home-Based Services)</strong><br>
                Selain pekerjaan domestik, banyak rumah tangga menyediakan layanan seperti perawatan anak atau
                pendidikan informal (misalnya mengajar les) dari rumah. Pekerjaan ini sering kali tidak terdaftar
                sebagai bisnis formal, meskipun berkontribusi pada ekonomi rumah tangga.
            </p>
            <p class="mt-4">
                <strong>Rumah sebagai Tempat Usaha Informal (Home as a Workplace)</strong><br>
                Di banyak daerah, terutama di kawasan perkotaan yang padat di Asia dan Afrika, rumah juga berfungsi
                sebagai tempat kerja informal. Banyak pengusaha kecil atau buruh informal yang menggunakan rumah mereka
                sebagai tempat memproduksi barang atau menjual jasa. Misalnya, seorang tukang cukur bisa bekerja dari
                ruang tamu rumahnya, atau seorang pedagang kecil mungkin menjual barang dari depan rumah.
            </p>
        </div>
    </div>


    <div id="modal-5" class="modal">
        <div class="modal-content">
            <button class="close-modal">X</button>
            <h2 class="text-2xl font-bold">Hubungi Kami</h2>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom 1 -->
                <div>
                    <p>
                        <strong>Alamat Kantor:</strong><br>
                        PT. Penempatan Pekerja Migran Indonesia<br>
                        Jl. Sudirman No. 123, Jakarta Pusat, Indonesia 10210
                    </p>
                    <p class="mt-4">
                        <strong>Nomor Telepon:</strong><br>
                        +62 21 1234 5678
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
                        Instagram: <a href="https://instagram.com/pekerjamigran" target="_blank"
                            class="text-blue-500">instagram.com/pekerjamigran</a><br>
                        Facebook: <a href="https://facebook.com/pekerjamigran" target="_blank"
                            class="text-blue-500">facebook.com/pekerjamigran</a><br>
                        Twitter: <a href="https://twitter.com/pekerjamigran" target="_blank"
                            class="text-blue-500">twitter.com/pekerjamigran</a>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer dengan warna solid -->
    <footer class="text-white py-6 fade-in" style="background-color: #7D1B3D;">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <!-- Logo dan Teks -->
                <div class="flex flex-col">
                    <div class="flex items-center">
                        <img src="/images/icon.png" alt="Logo" class="mr-4 w-12 h-12 no-hover" />
                        <h1 class="text-lg font-bold">{{ env('COMPANY_NAME') }}</h1>
                    </div>
                    <p class="text-sm mt-2 hover:text-gray-300 transition duration-300 ease-in-out">
                        Perusahaan Penempatan Pekerja Migran Indonesia
                    </p>
                </div>

                <!-- Tautan Navigasi -->
                <ul class="flex flex-wrap justify-start md:justify-center space-x-6 font-semibold text-sm">
                    <li><a href="/" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out">BERANDA</a>
                    </li>
                    <li><a href="#company" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out"
                            data-modal="modal-1">PERUSAHAAN</a></li>
                    <li><a href="#services" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out"
                            data-modal="modal-3">FORMAL</a></li>
                    <li><a href="#projects" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out"
                            data-modal="modal-4">INFORMAL</a></li>
                    <li><a href="#contact" class="hover:text-[#7D1B3D] transition duration-300 ease-in-out"
                            data-modal="modal-5">KONTAK</a></li>
                </ul>

                <!-- Tautan Internasional -->
                <ul class="flex space-x-6 text-sm">
                    <li><a href="/admin" class="hover:text-gray-300 transition duration-300 ease-in-out"
                            data-modal="modal-1">LOGIN
                            STAFF</a>
                    </li>
                    <li><a href="/admin" class="hover:text-gray-300 transition duration-300 ease-in-out"
                            data-modal="modal-1">LOGIN
                            AGENCY</a>
                    </li>
                </ul>
            </div>

            <!-- Bagian Hak Cipta -->
            <div class="border-t border-gray-400 mt-6 pt-4 text-center">
                <p class="text-sm">&copy; {{ now()->year }} {{ env('COMPANY_NAME') }}</p>
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
</body>

</html>
