<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BWStateKWCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 523,
'name' => 'Botlhapatlou'
],[
'state_id' => 523,
'name' => 'Dutlwe'
],[
'state_id' => 523,
'name' => 'Gabane'
],[
'state_id' => 523,
'name' => 'Gaphatshwe'
],[
'state_id' => 523,
'name' => 'Khudumelapye'
],[
'state_id' => 523,
'name' => 'Lenchwe Le Tau'
],[
'state_id' => 523,
'name' => 'Letlhakeng'
],[
'state_id' => 523,
'name' => 'Metsemotlhaba'
],[
'state_id' => 523,
'name' => 'Mmopone'
],[
'state_id' => 523,
'name' => 'Mogoditshane'
],[
'state_id' => 523,
'name' => 'Molepolole'
],[
'state_id' => 523,
'name' => 'Nkoyaphiri'
],[
'state_id' => 523,
'name' => 'Thamaga'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
