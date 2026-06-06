<?php

namespace Database\Seeders;

use App\Models\Gunung;
use Illuminate\Database\Seeder;

class GunungSeeder extends Seeder {
    public function run(): void {
      $data = [
        [
            'nama' => 'Semeru',
            'lokasi' => 'Lumajang, Jawa Timur',
            'ketinggian' => 3676,
            'syarat_pendakian' => 'Surat Sehat, Fotokopi KTP',
            'deskripsi' => 'Gunung Semeru atau Gunung Meru adalah sebuah gunung berapi kerucut di Jawa Timur, Indonesia. Gunung Semeru merupakan gunung tertinggi di Pulau Jawa.',
            'status_buka' => 1,
            'foto_cover' => 'https://images.unsplash.com/photo-1596395819057-e37f55a8528c?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'nama' => 'Bromo',
            'lokasi' => 'Probolinggo, Jawa Timur',
            'ketinggian' => 2329,
            'syarat_pendakian' => 'Booking Online, Surat Sehat',
            'deskripsi' => 'Gunung Bromo adalah sebuah gunung berapi aktif di Jawa Timur, Indonesia. Gunung ini memiliki ketinggian 2.329 meter di atas permukaan laut.',
            'status_buka' => 1,
            'foto_cover' => 'https://images.unsplash.com/photo-1588666309990-d68f08e3d4a6?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'nama' => 'Merbabu',
            'lokasi' => 'Boyolali, Jawa Tengah',
            'ketinggian' => 3142,
            'syarat_pendakian' => 'Surat Sehat, E-KTP',
            'deskripsi' => 'Gunung Merbabu adalah gunung berapi tidur yang terletak di Jawa Tengah, Indonesia. Gunung ini sangat populer karena keindahan sabananya.',
            'status_buka' => 1,
            'foto_cover' => 'https://images.unsplash.com/photo-1544198365-f5d60b6d8190?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'nama' => 'Gede',
            'lokasi' => 'Cianjur, Jawa Barat',
            'ketinggian' => 2958,
            'syarat_pendakian' => 'SIMAKSI, Surat Sehat',
            'deskripsi' => 'Gunung Gede merupakan sebuah gunung api bertipe stratovolcano yang berada di Pulau Jawa, Indonesia. Terletak dalam ruang lingkup Taman Nasional Gede Pangrango.',
            'status_buka' => 1,
            'foto_cover' => 'https://images.unsplash.com/photo-1589182373726-e4f658ab50f0?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'nama' => 'Lawu',
            'lokasi' => 'Karanganyar, Jawa Tengah',
            'ketinggian' => 3265,
            'syarat_pendakian' => 'Identitas Asli, Perlengkapan Standar',
            'deskripsi' => 'Gunung Lawu terletak di perbatasan Provinsi Jawa Tengah dan Jawa Timur. Gunung ini memiliki tiga puncak, yakni Hargo Dalem, Hargo Dumiling, dan puncak tertinggi Hargo Dumilah.',
            'status_buka' => 1,
            'foto_cover' => 'https://images.unsplash.com/photo-1624388636511-209930f9a941?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'nama' => 'Slamet',
            'lokasi' => 'Purbalingga, Jawa Tengah',
            'ketinggian' => 3428,
            'syarat_pendakian' => 'Surat Sehat, Fotokopi KTP',
            'deskripsi' => 'Gunung Slamet adalah sebuah gunung api kerucut yang terdapat di Jawa Tengah, Indonesia. Gunung Slamet merupakan gunung tertinggi di Jawa Tengah.',
            'status_buka' => 1,
            'foto_cover' => 'https://images.unsplash.com/photo-1611638682121-69769947926e?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'nama' => 'Sindoro',
            'lokasi' => 'Temanggung, Jawa Tengah',
            'ketinggian' => 3153,
            'syarat_pendakian' => 'Surat Sehat, Fotokopi KTP',
            'deskripsi' => 'Gunung Sindoro adalah gunung volkano aktif yang terletak di Jawa Tengah, Indonesia, dengan Temanggung sebagai kota terdekat.',
            'status_buka' => 1,
            'foto_cover' => 'https://images.unsplash.com/photo-1620138546344-7b2c0b056edb?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'nama' => 'Sumbing',
            'lokasi' => 'Magelang, Jawa Tengah',
            'ketinggian' => 3371,
            'syarat_pendakian' => 'Surat Sehat, Fotokopi KTP',
            'deskripsi' => 'Gunung Sumbing adalah gunung api yang terletak di Jawa Tengah, Indonesia. Gunung ini merupakan gunung tertinggi ketiga di Pulau Jawa.',
            'status_buka' => 1,
            'foto_cover' => 'https://images.unsplash.com/photo-1570163353459-d8305047f1fe?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'nama' => 'Prau',
            'lokasi' => 'Wonosobo, Jawa Tengah',
            'ketinggian' => 2565,
            'syarat_pendakian' => 'Surat Sehat, Fotokopi KTP',
            'deskripsi' => 'Gunung Prau terletak di kawasan Dataran Tinggi Dieng, Jawa Tengah, Indonesia. Gunung ini terkenal dengan view golden sunrise-nya.',
            'status_buka' => 1,
            'foto_cover' => 'https://images.unsplash.com/photo-1533038590840-1cde6b66b721?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'nama' => 'Raung',
            'lokasi' => 'Banyuwangi, Jawa Timur',
            'ketinggian' => 3344,
            'syarat_pendakian' => 'Surat Sehat, Peralatan Climbing (untuk puncak)',
            'deskripsi' => 'Gunung Raung adalah gunung api yang terletak di ujung timur Pulau Jawa. Gunung ini memiliki kawah terbesar di Jawa.',
            'status_buka' => 1,
            'foto_cover' => 'https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'nama' => 'Arjuno',
            'lokasi' => 'Malang, Jawa Timur',
            'ketinggian' => 3339,
            'syarat_pendakian' => 'Surat Sehat, Fotokopi KTP',
            'deskripsi' => 'Gunung Arjuno merupakan sebuah gunung berapi kerucut di Jawa Timur, Indonesia dengan ketinggian 3.339 mdpl.',
            'status_buka' => 1,
            'foto_cover' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'nama' => 'Ciremai',
            'lokasi' => 'Kuningan, Jawa Barat',
            'ketinggian' => 3078,
            'syarat_pendakian' => 'Surat Sehat, Booking Online',
            'deskripsi' => 'Gunung Ciremai adalah gunung tertinggi di Jawa Barat. Gunung ini secara administratif termasuk ke dalam wilayah Kabupaten Kuningan dan Kabupaten Majalengka.',
            'status_buka' => 1,
            'foto_cover' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80'
        ],
      ];

      foreach($data as $g) {
        $gunung = Gunung::create($g);
        
        // Buat minimal 2 jalur per gunung
        $gunung->jalurs()->create([
          'nama_jalur' => 'Jalur ' . $g['nama'] . ' via Utara',
          'deskripsi' => 'Jalur pendakian resmi melalui pintu utara dengan medan yang cukup menantang.',
          'harga_per_orang' => rand(15, 30) * 1000,
          'kuota_default' => rand(50, 150),
          'estimasi_jam' => rand(6, 12)
        ]);

        $gunung->jalurs()->create([
          'nama_jalur' => 'Jalur ' . $g['nama'] . ' via Selatan',
          'deskripsi' => 'Jalur pendakian santai melalui pintu selatan, cocok untuk pendaki pemula.',
          'harga_per_orang' => rand(10, 25) * 1000,
          'kuota_default' => rand(40, 120),
          'estimasi_jam' => rand(5, 10)
        ]);
      }
    }
}
