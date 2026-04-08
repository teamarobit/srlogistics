<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ALStateGJCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 62,
'name' => 'Bashkia Dropull'
],[
'state_id' => 62,
'name' => 'Bashkia Kelcyrë'
],[
'state_id' => 62,
'name' => 'Bashkia Libohovë'
],[
'state_id' => 62,
'name' => 'Bashkia Memaliaj'
],[
'state_id' => 62,
'name' => 'Bashkia Përmet'
],[
'state_id' => 62,
'name' => 'Bashkia Tepelenë'
],[
'state_id' => 62,
'name' => 'Gjinkar'
],[
'state_id' => 62,
'name' => 'Gjirokastër'
],[
'state_id' => 62,
'name' => 'Këlcyrë'
],[
'state_id' => 62,
'name' => 'Lazarat'
],[
'state_id' => 62,
'name' => 'Libohovë'
],[
'state_id' => 62,
'name' => 'Memaliaj'
],[
'state_id' => 62,
'name' => 'Përmet'
],[
'state_id' => 62,
'name' => 'Tepelenë'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
