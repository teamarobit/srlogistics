<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IEStateUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1815,
'name' => 'An Cabhán'
],[
'state_id' => 1815,
'name' => 'Bailieborough'
],[
'state_id' => 1815,
'name' => 'Ballybofey'
],[
'state_id' => 1815,
'name' => 'Ballyconnell'
],[
'state_id' => 1815,
'name' => 'Ballyjamesduff'
],[
'state_id' => 1815,
'name' => 'Ballyshannon'
],[
'state_id' => 1815,
'name' => 'Belturbet'
],[
'state_id' => 1815,
'name' => 'Buncrana'
],[
'state_id' => 1815,
'name' => 'Bundoran'
],[
'state_id' => 1815,
'name' => 'Carndonagh'
],[
'state_id' => 1815,
'name' => 'Carrickmacross'
],[
'state_id' => 1815,
'name' => 'Castleblayney'
],[
'state_id' => 1815,
'name' => 'Cavan'
],[
'state_id' => 1815,
'name' => 'Clones'
],[
'state_id' => 1815,
'name' => 'Convoy'
],[
'state_id' => 1815,
'name' => 'Cootehill'
],[
'state_id' => 1815,
'name' => 'County Donegal'
],[
'state_id' => 1815,
'name' => 'County Monaghan'
],[
'state_id' => 1815,
'name' => 'Derrybeg'
],[
'state_id' => 1815,
'name' => 'Donegal'
],[
'state_id' => 1815,
'name' => 'Dungloe'
],[
'state_id' => 1815,
'name' => 'Dunlewy'
],[
'state_id' => 1815,
'name' => 'Gweedore'
],[
'state_id' => 1815,
'name' => 'Killybegs'
],[
'state_id' => 1815,
'name' => 'Kingscourt'
],[
'state_id' => 1815,
'name' => 'Leifear'
],[
'state_id' => 1815,
'name' => 'Letterkenny'
],[
'state_id' => 1815,
'name' => 'Monaghan'
],[
'state_id' => 1815,
'name' => 'Moville'
],[
'state_id' => 1815,
'name' => 'Muff'
],[
'state_id' => 1815,
'name' => 'Mullagh'
],[
'state_id' => 1815,
'name' => 'Newtown Cunningham'
],[
'state_id' => 1815,
'name' => 'Ramelton'
],[
'state_id' => 1815,
'name' => 'Raphoe'
],[
'state_id' => 1815,
'name' => 'Virginia'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
