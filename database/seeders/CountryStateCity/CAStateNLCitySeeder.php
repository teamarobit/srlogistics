<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CAStateNLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 704,
'name' => 'Bay Roberts'
],[
'state_id' => 704,
'name' => 'Bay St. George South'
],[
'state_id' => 704,
'name' => 'Bonavista'
],[
'state_id' => 704,
'name' => 'Botwood'
],[
'state_id' => 704,
'name' => 'Burgeo'
],[
'state_id' => 704,
'name' => 'Carbonear'
],[
'state_id' => 704,
'name' => 'Catalina'
],[
'state_id' => 704,
'name' => 'Channel-Port aux Basques'
],[
'state_id' => 704,
'name' => 'Clarenville-Shoal Harbour'
],[
'state_id' => 704,
'name' => 'Conception Bay South'
],[
'state_id' => 704,
'name' => 'Corner Brook'
],[
'state_id' => 704,
'name' => 'Deer Lake'
],[
'state_id' => 704,
'name' => 'Fogo Island'
],[
'state_id' => 704,
'name' => 'Gambo'
],[
'state_id' => 704,
'name' => 'Goulds'
],[
'state_id' => 704,
'name' => 'Grand Bank'
],[
'state_id' => 704,
'name' => 'Grand Falls-Windsor'
],[
'state_id' => 704,
'name' => 'Happy Valley-Goose Bay'
],[
'state_id' => 704,
'name' => 'Harbour Breton'
],[
'state_id' => 704,
'name' => 'Labrador City'
],[
'state_id' => 704,
'name' => 'Lewisporte'
],[
'state_id' => 704,
'name' => 'Marystown'
],[
'state_id' => 704,
'name' => 'Mount Pearl'
],[
'state_id' => 704,
'name' => 'Pasadena'
],[
'state_id' => 704,
'name' => 'Springdale'
],[
'state_id' => 704,
'name' => 'St. Anthony'
],[
'state_id' => 704,
'name' => 'St. John\'s'
],[
'state_id' => 704,
'name' => 'Stephenville'
],[
'state_id' => 704,
'name' => 'Stephenville Crossing'
],[
'state_id' => 704,
'name' => 'Torbay'
],[
'state_id' => 704,
'name' => 'Upper Island Cove'
],[
'state_id' => 704,
'name' => 'Wabana'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
