<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BYStateHRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 428,
'name' => 'Ashmyanski Rayon'
],[
'state_id' => 428,
'name' => 'Ashmyany'
],[
'state_id' => 428,
'name' => 'Astravyets'
],[
'state_id' => 428,
'name' => 'Astravyetski Rayon'
],[
'state_id' => 428,
'name' => 'Baruny'
],[
'state_id' => 428,
'name' => 'Byarozawka'
],[
'state_id' => 428,
'name' => 'Dyatlovo'
],[
'state_id' => 428,
'name' => 'Grodnenskiy Rayon'
],[
'state_id' => 428,
'name' => 'Hal’shany'
],[
'state_id' => 428,
'name' => 'Horad Hrodna'
],[
'state_id' => 428,
'name' => 'Hrodna'
],[
'state_id' => 428,
'name' => 'Hyeranyony'
],[
'state_id' => 428,
'name' => 'Indura'
],[
'state_id' => 428,
'name' => 'Iwye'
],[
'state_id' => 428,
'name' => 'Karelichy'
],[
'state_id' => 428,
'name' => 'Karelitski Rayon'
],[
'state_id' => 428,
'name' => 'Krasnosel’skiy'
],[
'state_id' => 428,
'name' => 'Kreva'
],[
'state_id' => 428,
'name' => 'Lida'
],[
'state_id' => 428,
'name' => 'Lidski Rayon'
],[
'state_id' => 428,
'name' => 'Lyubcha'
],[
'state_id' => 428,
'name' => 'Mir'
],[
'state_id' => 428,
'name' => 'Mosty'
],[
'state_id' => 428,
'name' => 'Novogrudok'
],[
'state_id' => 428,
'name' => 'Ross’'
],[
'state_id' => 428,
'name' => 'Sapotskin'
],[
'state_id' => 428,
'name' => 'Shchuchyn'
],[
'state_id' => 428,
'name' => 'Shchuchynski Rayon'
],[
'state_id' => 428,
'name' => 'Skidel’'
],[
'state_id' => 428,
'name' => 'Slonim'
],[
'state_id' => 428,
'name' => 'Smarhon’'
],[
'state_id' => 428,
'name' => 'Soly'
],[
'state_id' => 428,
'name' => 'Svislach'
],[
'state_id' => 428,
'name' => 'Vishnyeva'
],[
'state_id' => 428,
'name' => 'Volkovysk'
],[
'state_id' => 428,
'name' => 'Voranava'
],[
'state_id' => 428,
'name' => 'Vyalikaya Byerastavitsa'
],[
'state_id' => 428,
'name' => 'Zel’va'
],[
'state_id' => 428,
'name' => 'Zhaludok'
],[
'state_id' => 428,
'name' => 'Zhirovichi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
