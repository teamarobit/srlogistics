<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateCOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 771,
'name' => 'Coquimbo'
],[
'state_id' => 771,
'name' => 'Illapel'
],[
'state_id' => 771,
'name' => 'La Serena'
],[
'state_id' => 771,
'name' => 'Monte Patria'
],[
'state_id' => 771,
'name' => 'Ovalle'
],[
'state_id' => 771,
'name' => 'Salamanca'
],[
'state_id' => 771,
'name' => 'Vicuña'
],[
'state_id' => 771,
'name' => 'Andacollo'
],[
'state_id' => 771,
'name' => 'Canela'
],[
'state_id' => 771,
'name' => 'Combarbalá'
],[
'state_id' => 771,
'name' => 'La Higuera'
],[
'state_id' => 771,
'name' => 'Los Vilos'
],[
'state_id' => 771,
'name' => 'Paihuano'
],[
'state_id' => 771,
'name' => 'Punitaqui'
],[
'state_id' => 771,
'name' => 'Río Hurtado'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
