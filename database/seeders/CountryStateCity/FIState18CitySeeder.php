<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState18CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1269,
'name' => 'Askola'
],[
'state_id' => 1269,
'name' => 'Ekenäs'
],[
'state_id' => 1269,
'name' => 'Espoo'
],[
'state_id' => 1269,
'name' => 'Gumböle'
],[
'state_id' => 1269,
'name' => 'Hanko'
],[
'state_id' => 1269,
'name' => 'Helsinki'
],[
'state_id' => 1269,
'name' => 'Hyvinge'
],[
'state_id' => 1269,
'name' => 'Ingå'
],[
'state_id' => 1269,
'name' => 'Järvenpää'
],[
'state_id' => 1269,
'name' => 'Kaarela'
],[
'state_id' => 1269,
'name' => 'Kallio'
],[
'state_id' => 1269,
'name' => 'Karis'
],[
'state_id' => 1269,
'name' => 'Karjalohja'
],[
'state_id' => 1269,
'name' => 'Karkkila'
],[
'state_id' => 1269,
'name' => 'Kauniainen'
],[
'state_id' => 1269,
'name' => 'Kellokoski'
],[
'state_id' => 1269,
'name' => 'Kerava'
],[
'state_id' => 1269,
'name' => 'Kilo'
],[
'state_id' => 1269,
'name' => 'Kirkkonummi'
],[
'state_id' => 1269,
'name' => 'Koukkuniemi'
],[
'state_id' => 1269,
'name' => 'Kärkölä'
],[
'state_id' => 1269,
'name' => 'Lapinjärvi'
],[
'state_id' => 1269,
'name' => 'Lauttasaari'
],[
'state_id' => 1269,
'name' => 'Liljendal'
],[
'state_id' => 1269,
'name' => 'Lohja'
],[
'state_id' => 1269,
'name' => 'Lovisa'
],[
'state_id' => 1269,
'name' => 'Mellunkylä'
],[
'state_id' => 1269,
'name' => 'Munkkiniemi'
],[
'state_id' => 1269,
'name' => 'Myrskylä'
],[
'state_id' => 1269,
'name' => 'Mäntsälä'
],[
'state_id' => 1269,
'name' => 'Nurmijärvi'
],[
'state_id' => 1269,
'name' => 'Otaniemi'
],[
'state_id' => 1269,
'name' => 'Pernå'
],[
'state_id' => 1269,
'name' => 'Pohja'
],[
'state_id' => 1269,
'name' => 'Pornainen'
],[
'state_id' => 1269,
'name' => 'Porvoo'
],[
'state_id' => 1269,
'name' => 'Pukkila'
],[
'state_id' => 1269,
'name' => 'Raaseporin'
],[
'state_id' => 1269,
'name' => 'Ruotsinpyhtää'
],[
'state_id' => 1269,
'name' => 'Sammatti'
],[
'state_id' => 1269,
'name' => 'Sibbo'
],[
'state_id' => 1269,
'name' => 'Siuntio'
],[
'state_id' => 1269,
'name' => 'Tuusula'
],[
'state_id' => 1269,
'name' => 'Vantaa'
],[
'state_id' => 1269,
'name' => 'Vihti'
],[
'state_id' => 1269,
'name' => 'Vuosaari'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
