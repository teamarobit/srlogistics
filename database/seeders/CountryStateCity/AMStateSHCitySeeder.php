<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AMStateSHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 203,
'name' => 'Akhuryan'
],[
'state_id' => 203,
'name' => 'Amasia'
],[
'state_id' => 203,
'name' => 'Anushavan'
],[
'state_id' => 203,
'name' => 'Arevik'
],[
'state_id' => 203,
'name' => 'Arevshat'
],[
'state_id' => 203,
'name' => 'Arrap’i'
],[
'state_id' => 203,
'name' => 'Azatan'
],[
'state_id' => 203,
'name' => 'Basen'
],[
'state_id' => 203,
'name' => 'Dzit’hank’ov'
],[
'state_id' => 203,
'name' => 'Gyumri'
],[
'state_id' => 203,
'name' => 'Haykavan'
],[
'state_id' => 203,
'name' => 'Horrom'
],[
'state_id' => 203,
'name' => 'Kamo'
],[
'state_id' => 203,
'name' => 'Lerrnakert'
],[
'state_id' => 203,
'name' => 'Maralik'
],[
'state_id' => 203,
'name' => 'Marmashen'
],[
'state_id' => 203,
'name' => 'Mayisyan'
],[
'state_id' => 203,
'name' => 'Meghrashen'
],[
'state_id' => 203,
'name' => 'Mets Mant’ash'
],[
'state_id' => 203,
'name' => 'Pemzashen'
],[
'state_id' => 203,
'name' => 'P’ok’r Mant’ash'
],[
'state_id' => 203,
'name' => 'Saratak'
],[
'state_id' => 203,
'name' => 'Shirak'
],[
'state_id' => 203,
'name' => 'Spandaryan'
],[
'state_id' => 203,
'name' => 'Voskehask'
],[
'state_id' => 203,
'name' => 'Yerazgavors'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
