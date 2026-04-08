<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateSUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1715,
'name' => 'Ambarita'
],[
'state_id' => 1715,
'name' => 'Bandar'
],[
'state_id' => 1715,
'name' => 'Belawan'
],[
'state_id' => 1715,
'name' => 'Berastagi'
],[
'state_id' => 1715,
'name' => 'Binjai'
],[
'state_id' => 1715,
'name' => 'Deli Tua'
],[
'state_id' => 1715,
'name' => 'Gunungsitoli'
],[
'state_id' => 1715,
'name' => 'Kabanjahe'
],[
'state_id' => 1715,
'name' => 'Kabupaten Asahan'
],[
'state_id' => 1715,
'name' => 'Kabupaten Batu Bara'
],[
'state_id' => 1715,
'name' => 'Kabupaten Dairi'
],[
'state_id' => 1715,
'name' => 'Kabupaten Deli Serdang'
],[
'state_id' => 1715,
'name' => 'Kabupaten Humbang Hasundutan'
],[
'state_id' => 1715,
'name' => 'Kabupaten Karo'
],[
'state_id' => 1715,
'name' => 'Kabupaten Labuhan Batu'
],[
'state_id' => 1715,
'name' => 'Kabupaten Labuhan Batu Selatan'
],[
'state_id' => 1715,
'name' => 'Kabupaten Labuhan Batu Utara'
],[
'state_id' => 1715,
'name' => 'Kabupaten Langkat'
],[
'state_id' => 1715,
'name' => 'Kabupaten Mandailing Natal'
],[
'state_id' => 1715,
'name' => 'Kabupaten Nias'
],[
'state_id' => 1715,
'name' => 'Kabupaten Nias Barat'
],[
'state_id' => 1715,
'name' => 'Kabupaten Nias Utara'
],[
'state_id' => 1715,
'name' => 'Kabupaten Padang Lawas'
],[
'state_id' => 1715,
'name' => 'Kabupaten Padang Lawas Utara'
],[
'state_id' => 1715,
'name' => 'Kabupaten Pakpak Bharat'
],[
'state_id' => 1715,
'name' => 'Kabupaten Samosir'
],[
'state_id' => 1715,
'name' => 'Kabupaten Serdang Bedagai'
],[
'state_id' => 1715,
'name' => 'Kabupaten Simalungun'
],[
'state_id' => 1715,
'name' => 'Kabupaten Tapanuli Selatan'
],[
'state_id' => 1715,
'name' => 'Kabupaten Tapanuli Tengah'
],[
'state_id' => 1715,
'name' => 'Kabupaten Tapanuli Utara'
],[
'state_id' => 1715,
'name' => 'Kisaran'
],[
'state_id' => 1715,
'name' => 'Kota Binjai'
],[
'state_id' => 1715,
'name' => 'Kota Gunungsitoli'
],[
'state_id' => 1715,
'name' => 'Kota Medan'
],[
'state_id' => 1715,
'name' => 'Kota Padangsidimpuan'
],[
'state_id' => 1715,
'name' => 'Kota Pematang Siantar'
],[
'state_id' => 1715,
'name' => 'Kota Sibolga'
],[
'state_id' => 1715,
'name' => 'Kota Tanjung Balai'
],[
'state_id' => 1715,
'name' => 'Kota Tebing Tinggi'
],[
'state_id' => 1715,
'name' => 'Labuhan Deli'
],[
'state_id' => 1715,
'name' => 'Medan'
],[
'state_id' => 1715,
'name' => 'Padangsidempuan'
],[
'state_id' => 1715,
'name' => 'Pangkalan Brandan'
],[
'state_id' => 1715,
'name' => 'Parapat'
],[
'state_id' => 1715,
'name' => 'Pekan Bahapal'
],[
'state_id' => 1715,
'name' => 'Pematangsiantar'
],[
'state_id' => 1715,
'name' => 'Perbaungan'
],[
'state_id' => 1715,
'name' => 'Percut'
],[
'state_id' => 1715,
'name' => 'Rantauprapat'
],[
'state_id' => 1715,
'name' => 'Sibolga'
],[
'state_id' => 1715,
'name' => 'Stabat'
],[
'state_id' => 1715,
'name' => 'Sunggal'
],[
'state_id' => 1715,
'name' => 'Tanjungbalai'
],[
'state_id' => 1715,
'name' => 'Tanjungtiram'
],[
'state_id' => 1715,
'name' => 'Tebingtinggi'
],[
'state_id' => 1715,
'name' => 'Teluk Nibung'
],[
'state_id' => 1715,
'name' => 'Tomok Bolon'
],[
'state_id' => 1715,
'name' => 'Tongging'
],[
'state_id' => 1715,
'name' => 'Tuktuk Sonak'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
