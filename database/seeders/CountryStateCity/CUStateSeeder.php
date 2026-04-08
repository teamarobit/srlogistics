<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CUStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 56,
'name' => 'Havana Province',
'iso2' => '03'
],[
'country_id' => 56,
'name' => 'Santiago de Cuba Province',
'iso2' => '13'
],[
'country_id' => 56,
'name' => 'Sancti Spíritus Province',
'iso2' => '07'
],[
'country_id' => 56,
'name' => 'Granma Province',
'iso2' => '12'
],[
'country_id' => 56,
'name' => 'Mayabeque Province',
'iso2' => '16'
],[
'country_id' => 56,
'name' => 'Pinar del Río Province',
'iso2' => '01'
],[
'country_id' => 56,
'name' => 'Isla de la Juventud',
'iso2' => '99'
],[
'country_id' => 56,
'name' => 'Holguín Province',
'iso2' => '11'
],[
'country_id' => 56,
'name' => 'Villa Clara Province',
'iso2' => '05'
],[
'country_id' => 56,
'name' => 'Las Tunas Province',
'iso2' => '10'
],[
'country_id' => 56,
'name' => 'Ciego de Ávila Province',
'iso2' => '08'
],[
'country_id' => 56,
'name' => 'Artemisa Province',
'iso2' => '15'
],[
'country_id' => 56,
'name' => 'Matanzas Province',
'iso2' => '04'
],[
'country_id' => 56,
'name' => 'Guantánamo Province',
'iso2' => '14'
],[
'country_id' => 56,
'name' => 'Camagüey Province',
'iso2' => '09'
],[
'country_id' => 56,
'name' => 'Cienfuegos Province',
'iso2' => '06'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
