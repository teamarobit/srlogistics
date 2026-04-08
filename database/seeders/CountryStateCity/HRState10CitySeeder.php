<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState10CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 939,
'name' => 'Crnac'
],[
'state_id' => 939,
'name' => 'Grad Orahovica'
],[
'state_id' => 939,
'name' => 'Grad Slatina'
],[
'state_id' => 939,
'name' => 'Grad Virovitica'
],[
'state_id' => 939,
'name' => 'Gradina'
],[
'state_id' => 939,
'name' => 'Mikleuš'
],[
'state_id' => 939,
'name' => 'Nova Bukovica'
],[
'state_id' => 939,
'name' => 'Orahovica'
],[
'state_id' => 939,
'name' => 'Pitomača'
],[
'state_id' => 939,
'name' => 'Rezovac'
],[
'state_id' => 939,
'name' => 'Slatina'
],[
'state_id' => 939,
'name' => 'Sopje'
],[
'state_id' => 939,
'name' => 'Suhopolje'
],[
'state_id' => 939,
'name' => 'Virovitica'
],[
'state_id' => 939,
'name' => 'Voćin'
],[
'state_id' => 939,
'name' => 'Zdenci'
],[
'state_id' => 939,
'name' => 'Čačinci'
],[
'state_id' => 939,
'name' => 'Čađavica'
],[
'state_id' => 939,
'name' => 'Špišić Bukovica'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
