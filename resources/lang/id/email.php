<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris-baris bahasa untuk email
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan selama proses email untuk beberapa
    | pesan yang perlu kita tampilkan ke pengguna. Anda bebas untuk memodifikasi
    | baris bahasa sesuai dengan keperluan aplikasi anda.
    |
    */

    'greeting' => 'Hallo!',
    'greeting_user' => 'Hallo, :user!',
    'do_not_reply' => 'Ini adalah email otomatis yang dikirim oleh sistem, mohon untuk tidak membalas ke alamat email ini.',
    'copy_link_help' => 'Jika Anda memiliki masalah pada saat meng-klik tombol ":action", salin dan tempel URL berikut pada web browser:',
    'regards' => 'Salam,',
    'regards_sender' => 'OMG Team',
    'any_questions' => 'Ada pertanyaan atau bantuan?',
    'visit_link' => 'Kunjungi tautan ini ',
    
    // Welcome Email Template
    'welcome' => [
        'title'=> 'Selamat Datang di :app_name',
        'paragraph_1' => 'Selamat datang di :app_name. Email Anda berhasil diverifikasi. Ini adalah langkah pertama, langkah selanjutnya adalah melengkapi halaman profil dengan foto, deskripsi, dan sedikit tentang Anda.',
        'paragraph_2' => ':app_name ingin memberikan yang terbaik untuk Anda sebagai Content Creator dan Fans. Tunjukan karyamu dan dapatkan pendukung!',
        'button_1' => 'Buka Dashboard',
    ],

    // Verify Email Template
    'verify' => [
        'title'=> 'Verifikasi Alamat Email',
        'paragraph_1' => 'Silakan klik tombol di bawah ini untuk verifikasi alamat email dan mengkonfirmasi bahwa Anda adalah pemilik akun ini. Jika tidak, silakan abaikan email ini.',
        'button_1' => 'Verifikasi',
    ],

    // Reset Password Template
    'reset_pw' => [
        'title' => 'Atur Ulang Kata Sandi',
        'paragraph_1' => 'Seseorang telah mengirim permintaan untuk mengatur ulang kata sandi, Jika ini bukan anda, silahkan abaikan email ini.',
        'button_1' => 'Reset Password',
    ],

];
