<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateJICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1746,
'name' => 'Babat'
],[
'state_id' => 1746,
'name' => 'Balung'
],[
'state_id' => 1746,
'name' => 'Bangil'
],[
'state_id' => 1746,
'name' => 'Bangkalan'
],[
'state_id' => 1746,
'name' => 'Banyuwangi'
],[
'state_id' => 1746,
'name' => 'Batu'
],[
'state_id' => 1746,
'name' => 'Besuki'
],[
'state_id' => 1746,
'name' => 'Blitar'
],[
'state_id' => 1746,
'name' => 'Bojonegoro'
],[
'state_id' => 1746,
'name' => 'Bondowoso'
],[
'state_id' => 1746,
'name' => 'Boyolangu'
],[
'state_id' => 1746,
'name' => 'Buduran'
],[
'state_id' => 1746,
'name' => 'Dampit'
],[
'state_id' => 1746,
'name' => 'Diwek'
],[
'state_id' => 1746,
'name' => 'Driyorejo'
],[
'state_id' => 1746,
'name' => 'Gambiran Satu'
],[
'state_id' => 1746,
'name' => 'Gampengrejo'
],[
'state_id' => 1746,
'name' => 'Gedangan'
],[
'state_id' => 1746,
'name' => 'Genteng'
],[
'state_id' => 1746,
'name' => 'Gongdanglegi Kulon'
],[
'state_id' => 1746,
'name' => 'Gresik'
],[
'state_id' => 1746,
'name' => 'Gresik Regency'
],[
'state_id' => 1746,
'name' => 'Jember'
],[
'state_id' => 1746,
'name' => 'Jombang'
],[
'state_id' => 1746,
'name' => 'Kabupaten Bangkalan'
],[
'state_id' => 1746,
'name' => 'Kabupaten Banyuwangi'
],[
'state_id' => 1746,
'name' => 'Kabupaten Blitar'
],[
'state_id' => 1746,
'name' => 'Kabupaten Bojonegoro'
],[
'state_id' => 1746,
'name' => 'Kabupaten Bondowoso'
],[
'state_id' => 1746,
'name' => 'Kabupaten Jember'
],[
'state_id' => 1746,
'name' => 'Kabupaten Jombang'
],[
'state_id' => 1746,
'name' => 'Kabupaten Kediri'
],[
'state_id' => 1746,
'name' => 'Kabupaten Lamongan'
],[
'state_id' => 1746,
'name' => 'Kabupaten Lumajang'
],[
'state_id' => 1746,
'name' => 'Kabupaten Madiun'
],[
'state_id' => 1746,
'name' => 'Kabupaten Magetan'
],[
'state_id' => 1746,
'name' => 'Kabupaten Malang'
],[
'state_id' => 1746,
'name' => 'Kabupaten Mojokerto'
],[
'state_id' => 1746,
'name' => 'Kabupaten Nganjuk'
],[
'state_id' => 1746,
'name' => 'Kabupaten Ngawi'
],[
'state_id' => 1746,
'name' => 'Kabupaten Pacitan'
],[
'state_id' => 1746,
'name' => 'Kabupaten Pamekasan'
],[
'state_id' => 1746,
'name' => 'Kabupaten Pasuruan'
],[
'state_id' => 1746,
'name' => 'Kabupaten Ponorogo'
],[
'state_id' => 1746,
'name' => 'Kabupaten Probolinggo'
],[
'state_id' => 1746,
'name' => 'Kabupaten Sampang'
],[
'state_id' => 1746,
'name' => 'Kabupaten Sidoarjo'
],[
'state_id' => 1746,
'name' => 'Kabupaten Situbondo'
],[
'state_id' => 1746,
'name' => 'Kabupaten Sumenep'
],[
'state_id' => 1746,
'name' => 'Kabupaten Trenggalek'
],[
'state_id' => 1746,
'name' => 'Kabupaten Tuban'
],[
'state_id' => 1746,
'name' => 'Kabupaten Tulungagung'
],[
'state_id' => 1746,
'name' => 'Kalianget'
],[
'state_id' => 1746,
'name' => 'Kamal'
],[
'state_id' => 1746,
'name' => 'Kebomas'
],[
'state_id' => 1746,
'name' => 'Kediri'
],[
'state_id' => 1746,
'name' => 'Kedungwaru'
],[
'state_id' => 1746,
'name' => 'Kencong'
],[
'state_id' => 1746,
'name' => 'Kepanjen'
],[
'state_id' => 1746,
'name' => 'Kertosono'
],[
'state_id' => 1746,
'name' => 'Kota Batu'
],[
'state_id' => 1746,
'name' => 'Kota Blitar'
],[
'state_id' => 1746,
'name' => 'Kota Kediri'
],[
'state_id' => 1746,
'name' => 'Kota Madiun'
],[
'state_id' => 1746,
'name' => 'Kota Malang'
],[
'state_id' => 1746,
'name' => 'Kota Mojokerto'
],[
'state_id' => 1746,
'name' => 'Kota Pasuruan'
],[
'state_id' => 1746,
'name' => 'Kota Probolinggo'
],[
'state_id' => 1746,
'name' => 'Kota Surabaya'
],[
'state_id' => 1746,
'name' => 'Kraksaan'
],[
'state_id' => 1746,
'name' => 'Krian'
],[
'state_id' => 1746,
'name' => 'Lamongan'
],[
'state_id' => 1746,
'name' => 'Lawang'
],[
'state_id' => 1746,
'name' => 'Lumajang'
],[
'state_id' => 1746,
'name' => 'Madiun'
],[
'state_id' => 1746,
'name' => 'Malang'
],[
'state_id' => 1746,
'name' => 'Mojoagung'
],[
'state_id' => 1746,
'name' => 'Mojokerto'
],[
'state_id' => 1746,
'name' => 'Muncar'
],[
'state_id' => 1746,
'name' => 'Nganjuk'
],[
'state_id' => 1746,
'name' => 'Ngoro'
],[
'state_id' => 1746,
'name' => 'Ngunut'
],[
'state_id' => 1746,
'name' => 'Paciran'
],[
'state_id' => 1746,
'name' => 'Pakisaji'
],[
'state_id' => 1746,
'name' => 'Pamekasan'
],[
'state_id' => 1746,
'name' => 'Panarukan'
],[
'state_id' => 1746,
'name' => 'Pandaan'
],[
'state_id' => 1746,
'name' => 'Panji'
],[
'state_id' => 1746,
'name' => 'Pare'
],[
'state_id' => 1746,
'name' => 'Pasuruan'
],[
'state_id' => 1746,
'name' => 'Ponorogo'
],[
'state_id' => 1746,
'name' => 'Prigen'
],[
'state_id' => 1746,
'name' => 'Probolinggo'
],[
'state_id' => 1746,
'name' => 'Sampang'
],[
'state_id' => 1746,
'name' => 'Sidoarjo'
],[
'state_id' => 1746,
'name' => 'Singojuruh'
],[
'state_id' => 1746,
'name' => 'Singosari'
],[
'state_id' => 1746,
'name' => 'Situbondo'
],[
'state_id' => 1746,
'name' => 'Soko'
],[
'state_id' => 1746,
'name' => 'Srono'
],[
'state_id' => 1746,
'name' => 'Sumberpucung'
],[
'state_id' => 1746,
'name' => 'Sumenep'
],[
'state_id' => 1746,
'name' => 'Surabaya'
],[
'state_id' => 1746,
'name' => 'Tanggul'
],[
'state_id' => 1746,
'name' => 'Tanggulangin'
],[
'state_id' => 1746,
'name' => 'Trenggalek'
],[
'state_id' => 1746,
'name' => 'Tuban'
],[
'state_id' => 1746,
'name' => 'Tulangan Utara'
],[
'state_id' => 1746,
'name' => 'Tulungagung'
],[
'state_id' => 1746,
'name' => 'Wongsorejo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
