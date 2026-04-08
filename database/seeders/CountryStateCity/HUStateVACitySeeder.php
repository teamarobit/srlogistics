<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateVACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1640,
'name' => 'Bük'
],[
'state_id' => 1640,
'name' => 'Celldömölk'
],[
'state_id' => 1640,
'name' => 'Celldömölki Járás'
],[
'state_id' => 1640,
'name' => 'Csepreg'
],[
'state_id' => 1640,
'name' => 'Gencsapáti'
],[
'state_id' => 1640,
'name' => 'Ják'
],[
'state_id' => 1640,
'name' => 'Jánosháza'
],[
'state_id' => 1640,
'name' => 'Körmend'
],[
'state_id' => 1640,
'name' => 'Körmendi Járás'
],[
'state_id' => 1640,
'name' => 'Kőszeg'
],[
'state_id' => 1640,
'name' => 'Kőszegi Járás'
],[
'state_id' => 1640,
'name' => 'Répcelak'
],[
'state_id' => 1640,
'name' => 'Szentgotthárd'
],[
'state_id' => 1640,
'name' => 'Szentgotthárdi Járás'
],[
'state_id' => 1640,
'name' => 'Szombathely'
],[
'state_id' => 1640,
'name' => 'Szombathelyi Járás'
],[
'state_id' => 1640,
'name' => 'Sárvár'
],[
'state_id' => 1640,
'name' => 'Sárvári Járás'
],[
'state_id' => 1640,
'name' => 'Táplánszentkereszt'
],[
'state_id' => 1640,
'name' => 'Vasvár'
],[
'state_id' => 1640,
'name' => 'Vasvári Járás'
],[
'state_id' => 1640,
'name' => 'Vép'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
