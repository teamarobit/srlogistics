<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState19CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1266,
'name' => 'Alastaro'
],[
'state_id' => 1266,
'name' => 'Askainen'
],[
'state_id' => 1266,
'name' => 'Aura'
],[
'state_id' => 1266,
'name' => 'Dragsfjärd'
],[
'state_id' => 1266,
'name' => 'Halikko'
],[
'state_id' => 1266,
'name' => 'Houtskär'
],[
'state_id' => 1266,
'name' => 'Iniö'
],[
'state_id' => 1266,
'name' => 'Kaarina'
],[
'state_id' => 1266,
'name' => 'Karinainen'
],[
'state_id' => 1266,
'name' => 'Kiikala'
],[
'state_id' => 1266,
'name' => 'Kimito'
],[
'state_id' => 1266,
'name' => 'Kisko'
],[
'state_id' => 1266,
'name' => 'Kustavi'
],[
'state_id' => 1266,
'name' => 'Kuusjoki'
],[
'state_id' => 1266,
'name' => 'Laitila'
],[
'state_id' => 1266,
'name' => 'Lemu'
],[
'state_id' => 1266,
'name' => 'Lieto'
],[
'state_id' => 1266,
'name' => 'Marttila'
],[
'state_id' => 1266,
'name' => 'Masku'
],[
'state_id' => 1266,
'name' => 'Mellilä'
],[
'state_id' => 1266,
'name' => 'Merimasku'
],[
'state_id' => 1266,
'name' => 'Mietoinen'
],[
'state_id' => 1266,
'name' => 'Muurla'
],[
'state_id' => 1266,
'name' => 'Mynämäki'
],[
'state_id' => 1266,
'name' => 'Naantali'
],[
'state_id' => 1266,
'name' => 'Nagu'
],[
'state_id' => 1266,
'name' => 'Nousiainen'
],[
'state_id' => 1266,
'name' => 'Oripää'
],[
'state_id' => 1266,
'name' => 'Paimio'
],[
'state_id' => 1266,
'name' => 'Pargas'
],[
'state_id' => 1266,
'name' => 'Perniö'
],[
'state_id' => 1266,
'name' => 'Pertteli'
],[
'state_id' => 1266,
'name' => 'Piikkiö'
],[
'state_id' => 1266,
'name' => 'Pyhäranta'
],[
'state_id' => 1266,
'name' => 'Pöytyä'
],[
'state_id' => 1266,
'name' => 'Raisio'
],[
'state_id' => 1266,
'name' => 'Rusko'
],[
'state_id' => 1266,
'name' => 'Rymättylä'
],[
'state_id' => 1266,
'name' => 'Salo'
],[
'state_id' => 1266,
'name' => 'Sauvo'
],[
'state_id' => 1266,
'name' => 'Somero'
],[
'state_id' => 1266,
'name' => 'Suomusjärvi'
],[
'state_id' => 1266,
'name' => 'Särkisalo'
],[
'state_id' => 1266,
'name' => 'Taivassalo'
],[
'state_id' => 1266,
'name' => 'Tarvasjoki'
],[
'state_id' => 1266,
'name' => 'Turku'
],[
'state_id' => 1266,
'name' => 'Uusikaupunki'
],[
'state_id' => 1266,
'name' => 'Vahto'
],[
'state_id' => 1266,
'name' => 'Vehmaa'
],[
'state_id' => 1266,
'name' => 'Velkua'
],[
'state_id' => 1266,
'name' => 'Västanfjärd'
],[
'state_id' => 1266,
'name' => 'Väståboland'
],[
'state_id' => 1266,
'name' => 'Yläne'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
