<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState44CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1222,
'name' => 'Iisaku'
],[
'state_id' => 1222,
'name' => 'Jõhvi'
],[
'state_id' => 1222,
'name' => 'Jõhvi vald'
],[
'state_id' => 1222,
'name' => 'Kiviõli'
],[
'state_id' => 1222,
'name' => 'Kohtla-Järve'
],[
'state_id' => 1222,
'name' => 'Kohtla-Nõmme'
],[
'state_id' => 1222,
'name' => 'Lüganuse vald'
],[
'state_id' => 1222,
'name' => 'Narva'
],[
'state_id' => 1222,
'name' => 'Narva-Jõesuu'
],[
'state_id' => 1222,
'name' => 'Narva-Jõesuu linn'
],[
'state_id' => 1222,
'name' => 'Püssi'
],[
'state_id' => 1222,
'name' => 'Sillamäe'
],[
'state_id' => 1222,
'name' => 'Toila'
],[
'state_id' => 1222,
'name' => 'Voka'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
