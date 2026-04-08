<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateSACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1729,
'name' => 'Kabupaten Bolaang Mongondow'
],[
'state_id' => 1729,
'name' => 'Kabupaten Bolaang Mongondow Selatan'
],[
'state_id' => 1729,
'name' => 'Kabupaten Bolaang Mongondow Timur'
],[
'state_id' => 1729,
'name' => 'Kabupaten Bolaang Mongondow Utara'
],[
'state_id' => 1729,
'name' => 'Kabupaten Kepulauan Sangihe'
],[
'state_id' => 1729,
'name' => 'Kabupaten Kepulauan Talaud'
],[
'state_id' => 1729,
'name' => 'Kabupaten Minahasa'
],[
'state_id' => 1729,
'name' => 'Kabupaten Minahasa Selatan'
],[
'state_id' => 1729,
'name' => 'Kabupaten Minahasa Tenggara'
],[
'state_id' => 1729,
'name' => 'Kabupaten Minahasa Utara'
],[
'state_id' => 1729,
'name' => 'Kabupaten Siau Tagulandang Biaro'
],[
'state_id' => 1729,
'name' => 'Kota Bitung'
],[
'state_id' => 1729,
'name' => 'Kota Kotamobagu'
],[
'state_id' => 1729,
'name' => 'Kota Manado'
],[
'state_id' => 1729,
'name' => 'Kota Tomohon'
],[
'state_id' => 1729,
'name' => 'Laikit Laikit II (Dimembe)'
],[
'state_id' => 1729,
'name' => 'Manado'
],[
'state_id' => 1729,
'name' => 'Tomohon'
],[
'state_id' => 1729,
'name' => 'Tondano'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
