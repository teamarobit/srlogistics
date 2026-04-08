<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState30CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 122,
'name' => 'Djamaa'
],[
'state_id' => 122,
'name' => 'El Hadjira'
],[
'state_id' => 122,
'name' => 'Hassi Messaoud'
],[
'state_id' => 122,
'name' => 'Megarine'
],[
'state_id' => 122,
'name' => 'Ouargla'
],[
'state_id' => 122,
'name' => 'Rouissat'
],[
'state_id' => 122,
'name' => 'Sidi Amrane'
],[
'state_id' => 122,
'name' => 'Tebesbest'
],[
'state_id' => 122,
'name' => 'Touggourt'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
