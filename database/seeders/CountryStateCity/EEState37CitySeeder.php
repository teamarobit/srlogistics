<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState37CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1220,
'name' => 'Anija vald'
],[
'state_id' => 1220,
'name' => 'Aruküla'
],[
'state_id' => 1220,
'name' => 'Haabneeme'
],[
'state_id' => 1220,
'name' => 'Harku'
],[
'state_id' => 1220,
'name' => 'Harku vald'
],[
'state_id' => 1220,
'name' => 'Jõelähtme vald'
],[
'state_id' => 1220,
'name' => 'Jüri'
],[
'state_id' => 1220,
'name' => 'Kehra'
],[
'state_id' => 1220,
'name' => 'Keila'
],[
'state_id' => 1220,
'name' => 'Kiili'
],[
'state_id' => 1220,
'name' => 'Kiili vald'
],[
'state_id' => 1220,
'name' => 'Kose'
],[
'state_id' => 1220,
'name' => 'Kuusalu'
],[
'state_id' => 1220,
'name' => 'Laagri'
],[
'state_id' => 1220,
'name' => 'Loksa'
],[
'state_id' => 1220,
'name' => 'Loksa linn'
],[
'state_id' => 1220,
'name' => 'Loo'
],[
'state_id' => 1220,
'name' => 'Maardu'
],[
'state_id' => 1220,
'name' => 'Maardu linn'
],[
'state_id' => 1220,
'name' => 'Paldiski'
],[
'state_id' => 1220,
'name' => 'Pringi'
],[
'state_id' => 1220,
'name' => 'Raasiku'
],[
'state_id' => 1220,
'name' => 'Rae vald'
],[
'state_id' => 1220,
'name' => 'Riisipere'
],[
'state_id' => 1220,
'name' => 'Rummu'
],[
'state_id' => 1220,
'name' => 'Saku'
],[
'state_id' => 1220,
'name' => 'Saku vald'
],[
'state_id' => 1220,
'name' => 'Saue'
],[
'state_id' => 1220,
'name' => 'Saue vald'
],[
'state_id' => 1220,
'name' => 'Tabasalu'
],[
'state_id' => 1220,
'name' => 'Tallinn'
],[
'state_id' => 1220,
'name' => 'Turba'
],[
'state_id' => 1220,
'name' => 'Vaida'
],[
'state_id' => 1220,
'name' => 'Viimsi'
],[
'state_id' => 1220,
'name' => 'Viimsi vald'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
