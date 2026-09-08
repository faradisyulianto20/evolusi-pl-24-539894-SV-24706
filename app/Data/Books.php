<?php

namespace App\Data;

final class Books
{
    /**
     * @return array<int, array<string, string|float|int>>
     */
    public static function all(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'genre' => 'Self Development',
                'year' => 2018,
                'rating' => 4.5,
                'image' => 'cover-atomic-habits.jpg',
                'snippet' => 'Strategi praktis untuk membangun kebiasaan kecil yang berdampak besar dalam jangka panjang.',
                'paragraph' => 'Buku ini bukan sekadar teori motivasi, melainkan panduan berbasis sains tentang bagaimana mengubah identitas dan sistem kebiasaan secara bertahap. Clear menawarkan konsep compounding of habits, di mana perbaikan kecil sebesar satu persen setiap hari berlipat menjadi hasil yang mengesankan. Sangat direkomendasikan bagi siapa pun yang ingin membangun rutinitas yang bertahan lama.',
            ],
            [
                'id' => 2,
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'genre' => 'Programming',
                'year' => 2008,
                'rating' => 4.0,
                'image' => 'cover-atomic-habits.jpg',
                'snippet' => 'Panduan menulis kode yang bersih, mudah dibaca, dan mudah dipelihara oleh tim mana pun.',
                'paragraph' => 'Robert C. Martin menyusun kumpulan prinsip dan praktik menulis kode berkualitas, mulai dari penamaan yang deskriptif, aturan kelas kecil, hingga test-driven development. Buku ini menjadi standar acuan bahwa kode yang baik bukan hanya berfungsi, tetapi juga mudah dipahami manusia lain. Wajib dibaca bagi developer yang peduli pada maintainability jangka panjang.',
            ],
            [
                'id' => 3,
                'title' => 'The Pragmatic Programmer',
                'author' => 'Andrew Hunt & David Thomas',
                'genre' => 'Programming',
                'year' => 1999,
                'rating' => 4.5,
                'image' => 'cover-atomic-habits.jpg',
                'snippet' => 'Kumpulan praktik terbaik menjadi developer yang tangkas dan berpikir kritis.',
                'paragraph' => 'Ditulis oleh Andrew Hunt dan David Thomas, buku ini menekankan tanggung jawab pribadi seorang programmer terhadap karier dan kualitas hasil kerjanya. Filosofi utama seperti DRY (Don\'t Repeat Yourself), programming by coincidence, serta pentingnya bekerja dengan tim menjadikannya bacaan wajib lintas generasi. Meskipun usianya lebih dari dua dekade, prinsip-prinsipnya masih sangat relevan hingga kini.',
            ],
            [
                'id' => 4,
                'title' => 'Deep Work',
                'author' => 'Cal Newport',
                'genre' => 'Productivity',
                'year' => 2016,
                'rating' => 4.0,
                'image' => 'cover-atomic-habits.jpg',
                'snippet' => 'Seni fokus penuh tanpa distraksi untuk menghasilkan karya yang benar-benar berkualitas.',
                'paragraph' => 'Cal Newport berargumen bahwa kemampuan deep work semakin langka dan semakin berharga di tengah dunia yang penuh notifikasi. Buku ini merinci strategi menjadwalkan sesi fokus menyeluruh, membatasi shallow work, serta melatih otak agar tahan terhadap distraksi. Panduan ini cocok untuk pekerja kreatif dan praktisi yang ingin produktivitas nyata, bukan sekadar sibuk.',
            ],
            [
                'id' => 5,
                'title' => 'Design Patterns',
                'author' => 'Erich Gamma et al.',
                'genre' => 'Programming',
                'year' => 1994,
                'rating' => 3.5,
                'image' => 'cover-atomic-habits.jpg',
                'snippet' => 'Referensi klasik 23 pola desain yang menjadi fondasi arsitektur perangkat lunak modern.',
                'paragraph' => 'Gang of Four merangkum 23 pola desain yang menjadi solusi umum atas permasalahan recurring dalam desain berorientasi objek, dikelompokkan menjadi creational, structural, dan behavioral. Bagi arsitek dan developer senior, buku ini menawarkan kosakata bersama untuk mendiskusikan solusi desain. Namun, pola sebaiknya dipakai dengan bijak agar tidak menambah kompleksitas yang tidak perlu.',
            ],
            [
                'id' => 6,
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'genre' => 'History',
                'year' => 2011,
                'rating' => 5.0,
                'image' => 'cover-atomic-habits.jpg',
                'snippet' => 'Perjalanan sejarah umat manusia, dari revolusi kognitif hingga era teknologi modern.',
                'paragraph' => 'Yuval Noah Harari mengambil sudut pandang makro untuk menjelaskan bagaimana Homo sapiens mendominasi planet melalui kemampuan bercerita dan kerja sama dalam skala besar. Alur buku melintasi Revolusi Kognitif, Revolusi Pertanian, hingga Revolusi Ilmiah dengan narasi yang memikat dan menantang asumsi kita tentang kebahagiaan dan masa depan umat manusia.',
            ],
        ];
    }
}
