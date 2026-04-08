<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState01CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1094,
'name' => 'Bella Vista'
],[
'state_id' => 1094,
'name' => 'Ciudad Nueva'
],[
'state_id' => 1094,
'name' => 'Cristo Rey'
],[
'state_id' => 1094,
'name' => 'Ensanche Luperón'
],[
'state_id' => 1094,
'name' => 'La Agustina'
],[
'state_id' => 1094,
'name' => 'La Julia'
],[
'state_id' => 1094,
'name' => 'San Carlos'
],[
'state_id' => 1094,
'name' => 'Santo Domingo'
],[
'state_id' => 1094,
'name' => 'Villa Consuelo'
],[
'state_id' => 1094,
'name' => 'Villa Francisca'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
