<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState22CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 128,
'name' => 'Aïn El Berd District'
],[
'state_id' => 128,
'name' => 'Balidat Ameur'
],[
'state_id' => 128,
'name' => 'Belarbi'
],[
'state_id' => 128,
'name' => 'Ben Badis Sid Bel Abbés'
],[
'state_id' => 128,
'name' => 'Djamaa'
],[
'state_id' => 128,
'name' => 'El Bour'
],[
'state_id' => 128,
'name' => 'El Hadjira'
],[
'state_id' => 128,
'name' => 'Haoud El Hamra'
],[
'state_id' => 128,
'name' => 'Hassi Messaoud'
],[
'state_id' => 128,
'name' => 'Lamtar'
],[
'state_id' => 128,
'name' => 'Marhoum'
],[
'state_id' => 128,
'name' => 'Megarine'
],[
'state_id' => 128,
'name' => 'Merine'
],[
'state_id' => 128,
'name' => 'Mezaourou'
],[
'state_id' => 128,
'name' => 'Moggar'
],[
'state_id' => 128,
'name' => 'Moulay Slissen'
],[
'state_id' => 128,
'name' => 'N\'Goussa'
],[
'state_id' => 128,
'name' => 'Ouargla'
],[
'state_id' => 128,
'name' => 'Rouissat'
],[
'state_id' => 128,
'name' => 'Sfissef'
],[
'state_id' => 128,
'name' => 'Sidi Ali Boussidi'
],[
'state_id' => 128,
'name' => 'Sidi Amrane'
],[
'state_id' => 128,
'name' => 'Sidi Bel Abbès'
],[
'state_id' => 128,
'name' => 'Sidi Brahim'
],[
'state_id' => 128,
'name' => 'Sidi Hamadouche'
],[
'state_id' => 128,
'name' => 'Sidi Slimane'
],[
'state_id' => 128,
'name' => 'Sidi Yacoub'
],[
'state_id' => 128,
'name' => 'Sidi Yahia'
],[
'state_id' => 128,
'name' => 'Tabia Sid Bel Abbés'
],[
'state_id' => 128,
'name' => 'Taibet'
],[
'state_id' => 128,
'name' => 'Tamellaht'
],[
'state_id' => 128,
'name' => 'Tamerna Djedida'
],[
'state_id' => 128,
'name' => 'Tebesbest'
],[
'state_id' => 128,
'name' => 'Teghalimet'
],[
'state_id' => 128,
'name' => 'Telagh'
],[
'state_id' => 128,
'name' => 'Tenezara'
],[
'state_id' => 128,
'name' => 'Tenira'
],[
'state_id' => 128,
'name' => 'Tessala'
],[
'state_id' => 128,
'name' => 'Touggourt'
],[
'state_id' => 128,
'name' => 'Zerouala'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
