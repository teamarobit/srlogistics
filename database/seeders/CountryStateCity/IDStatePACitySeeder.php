<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStatePACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1720,
'name' => 'Abepura'
],[
'state_id' => 1720,
'name' => 'Biak'
],[
'state_id' => 1720,
'name' => 'Insrom'
],[
'state_id' => 1720,
'name' => 'Jayapura'
],[
'state_id' => 1720,
'name' => 'Kabupaten Asmat'
],[
'state_id' => 1720,
'name' => 'Kabupaten Biak Numfor'
],[
'state_id' => 1720,
'name' => 'Kabupaten Boven Digoel'
],[
'state_id' => 1720,
'name' => 'Kabupaten Deiyai'
],[
'state_id' => 1720,
'name' => 'Kabupaten Dogiyai'
],[
'state_id' => 1720,
'name' => 'Kabupaten Intan Jaya'
],[
'state_id' => 1720,
'name' => 'Kabupaten Jayapura'
],[
'state_id' => 1720,
'name' => 'Kabupaten Jayawijaya'
],[
'state_id' => 1720,
'name' => 'Kabupaten Keerom'
],[
'state_id' => 1720,
'name' => 'Kabupaten Kepulauan Yapen'
],[
'state_id' => 1720,
'name' => 'Kabupaten Lanny Jaya'
],[
'state_id' => 1720,
'name' => 'Kabupaten Mamberamo Raya'
],[
'state_id' => 1720,
'name' => 'Kabupaten Mamberamo Tengah'
],[
'state_id' => 1720,
'name' => 'Kabupaten Mappi'
],[
'state_id' => 1720,
'name' => 'Kabupaten Merauke'
],[
'state_id' => 1720,
'name' => 'Kabupaten Mimika'
],[
'state_id' => 1720,
'name' => 'Kabupaten Nabire'
],[
'state_id' => 1720,
'name' => 'Kabupaten Nduga'
],[
'state_id' => 1720,
'name' => 'Kabupaten Paniai'
],[
'state_id' => 1720,
'name' => 'Kabupaten Pegunungan Bintang'
],[
'state_id' => 1720,
'name' => 'Kabupaten Puncak Jaya'
],[
'state_id' => 1720,
'name' => 'Kabupaten Sarmi'
],[
'state_id' => 1720,
'name' => 'Kabupaten Supiori'
],[
'state_id' => 1720,
'name' => 'Kabupaten Tolikara'
],[
'state_id' => 1720,
'name' => 'Kabupaten Waropen'
],[
'state_id' => 1720,
'name' => 'Kabupaten Yahukimo'
],[
'state_id' => 1720,
'name' => 'Kabupaten Yalimo'
],[
'state_id' => 1720,
'name' => 'Kota Jayapura'
],[
'state_id' => 1720,
'name' => 'Nabire'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
