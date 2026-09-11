@extends('layouts.app')

@section('content')
    <style>
        body {
            background: #080d19;
            color: #f8fafc;
        }

        .tentang-page {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        .tentang-card {
            background: #111827;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 20px;
        }

        /* CONTAINER FOTO & DESKRIPSI */
        .about-header {
            display: flex;
            align-items: flex-start;
            gap: 25px;
        }

        /* BOX FOTO PROFIL */
        .profile-box {
            position: relative;
            flex-shrink: 0;
        }

        .profile-img {
            width: 140px;
            height: 140px;
            border-radius: 16px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .profile-avatar-fallback {
            width: 140px;
            height: 140px;
            border-radius: 16px;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: #ffffff;
            font-size: 48px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }

        /* TOMBOL UPLOAD FOTO (IKON KAMERA) */
        .btn-upload-avatar {
            position: absolute;
            bottom: -8px;
            right: -8px;
            background: #6366f1;
            color: #ffffff;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 2px solid #111827;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: 0.2s;
            font-size: 14px;
        }

        .btn-upload-avatar:hover {
            background: #4f46e5;
            transform: scale(1.1);
        }

        .about-text p {
            color: #cbd5e1;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 12px;
        }

        .section p {
            color: #cbd5e1;
            font-size: 16px;
            line-height: 1.8;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 15px;
        }

        .contact-item {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 16px 20px;
        }

        .contact-item .label {
            color: #94a3b8;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .contact-item .value {
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
            padding: 10px 18px;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 10px;
            color: #ffffff;
            text-decoration: none;
            transition: .2s;
        }

        .btn-back:hover {
            background: #334155;
            color: #ffffff;
        }

        @media (max-width: 700px) {
            .about-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .contact-grid {
                grid-template-columns: 1fr;
            }

            .tentang-card {
                padding: 25px;
            }
        }
    </style>

    <div class="tentang-page">

        <div class="tentang-card">

            {{-- TENTANG SAYA + FOTO --}}
            <div class="section">
                <h2>Tentang Saya</h2>

                <div class="about-header">
                    {{-- FOTO PROFIL --}}
                    <div class="profile-box">
                        <!-- Elemen Gambar -->
                        <img id="previewFoto" src="" alt="Foto Profile" class="profile-img" style="display: none;">

                        <!-- Fallback Inisial Nama (Jika foto belum diupload) -->
                        <div id="fallbackFoto" class="profile-avatar-fallback">
                            {{ strtoupper(substr(auth()->user()->name ?? 'Alfadz', 0, 1)) }}
                        </div>

                        <!-- Tombol Upload -->
                        <label for="inputFoto" class="btn-upload-avatar" title="Ganti Foto Profil">
                            📷
                        </label>

                        <!-- Input File Kategori Gambar -->
                        <input type="file" id="inputFoto" accept="image/*" style="display: none;"
                            onchange="previewAndSaveImage(this)">
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="about-text">
                        <p>
                            Halo, saya <strong>{{ auth()->user()->name ?? 'Alfadz' }}</strong>, saya merupakan siswa
                            kelas <strong>XII PPLG 4</strong>.
                        </p>

                        <p style="margin-bottom: 0;">
                            Saya memiliki ketertarikan dalam bidang teknologi,
                            khususnya pemrograman dan pengembangan aplikasi.
                            Saat ini saya sedang belajar dan mengembangkan kemampuan
                            dalam membuat aplikasi berbasis web.
                        </p>
                    </div>
                </div>
            </div>

            {{-- PENDIDIKAN --}}
            <div class="section">
                <h2>Pendidikan</h2>

                <p>
                    <strong>SMK NEGERI 4 TASIKMALAYA Kelas XII PPLG 4</strong><br>
                    Jurusan <strong>Pengembangan Perangkat Lunak dan Gim (PPLG)</strong>.
                </p>

                <p>
                    Selama belajar, saya mempelajari berbagai hal tentang
                    pemrograman, pengembangan website, database, serta
                    pembuatan aplikasi.
                </p>
            </div>

            {{-- KONTAK --}}
            <div class="section">
                <h2>Kontak</h2>

                <div class="contact-grid">

                    <div class="contact-item">
                        <div class="label">Nama</div>
                        <div class="value">{{ auth()->user()->name ?? 'Alfadz' }}</div>
                    </div>

                    <div class="contact-item">
                        <div class="label">Kelas</div>
                        <div class="value">XII PPLG 4</div>
                    </div>

                    <div class="contact-item">
                        <div class="label">Jurusan</div>
                        <div class="value">PPLG</div>
                    </div>

                    <div class="contact-item">
                        <div class="label">Email</div>
                        <div class="value">{{ auth()->user()->email }}</div>
                    </div>

                    <div class="contact-item">
                        <div class="label">Telepon</div>
                        <div class="value">{{ auth()->user()->telepon ?? '0899990909' }}</div>
                    </div>

                </div>
            </div>

            <a href="{{ url()->previous() }}" class="btn-back">
                ← Kembali
            </a>

        </div>

    </div>

    {{-- JAVASCRIPT TANPA DATABASE --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Cek apakah ada foto yang tersimpan di LocalStorage
            const savedImage = localStorage.getItem("userProfilePhoto");
            const imgElement = document.getElementById("previewFoto");
            const fallbackElement = document.getElementById("fallbackFoto");

            if (savedImage) {
                imgElement.src = savedImage;
                imgElement.style.display = "block";
                fallbackElement.style.display = "none";
            }
        });

        function previewAndSaveImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const base64Image = e.target.result;
                    const imgElement = document.getElementById("previewFoto");
                    const fallbackElement = document.getElementById("fallbackFoto");

                    // Tampilkan foto
                    imgElement.src = base64Image;
                    imgElement.style.display = "block";
                    fallbackElement.style.display = "none";

                    // Simpan ke LocalStorage browser
                    localStorage.setItem("userProfilePhoto", base64Image);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
