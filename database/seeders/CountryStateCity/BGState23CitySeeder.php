<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState23CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 581,
'name' => 'Anton'
],[
'state_id' => 581,
'name' => 'Botevgrad'
],[
'state_id' => 581,
'name' => 'Bozhurishte'
],[
'state_id' => 581,
'name' => 'Chavdar'
],[
'state_id' => 581,
'name' => 'Chelopech'
],[
'state_id' => 581,
'name' => 'Dolna Banya'
],[
'state_id' => 581,
'name' => 'Dragoman'
],[
'state_id' => 581,
'name' => 'Elin Pelin'
],[
'state_id' => 581,
'name' => 'Etropole'
],[
'state_id' => 581,
'name' => 'Godech'
],[
'state_id' => 581,
'name' => 'Gorna Malina'
],[
'state_id' => 581,
'name' => 'Ihtiman'
],[
'state_id' => 581,
'name' => 'Koprivshtitsa'
],[
'state_id' => 581,
'name' => 'Kostinbrod'
],[
'state_id' => 581,
'name' => 'Lakatnik'
],[
'state_id' => 581,
'name' => 'Mirkovo'
],[
'state_id' => 581,
'name' => 'Obshtina Anton'
],[
'state_id' => 581,
'name' => 'Obshtina Botevgrad'
],[
'state_id' => 581,
'name' => 'Obshtina Bozhurishte'
],[
'state_id' => 581,
'name' => 'Obshtina Chavdar'
],[
'state_id' => 581,
'name' => 'Obshtina Chelopech'
],[
'state_id' => 581,
'name' => 'Obshtina Dolna Banya'
],[
'state_id' => 581,
'name' => 'Obshtina Dragoman'
],[
'state_id' => 581,
'name' => 'Obshtina Elin Pelin'
],[
'state_id' => 581,
'name' => 'Obshtina Etropole'
],[
'state_id' => 581,
'name' => 'Obshtina Gorna Malina'
],[
'state_id' => 581,
'name' => 'Obshtina Koprivshtitsa'
],[
'state_id' => 581,
'name' => 'Obshtina Kostenets'
],[
'state_id' => 581,
'name' => 'Obshtina Kostinbrod'
],[
'state_id' => 581,
'name' => 'Obshtina Mirkovo'
],[
'state_id' => 581,
'name' => 'Obshtina Pirdop'
],[
'state_id' => 581,
'name' => 'Obshtina Pravets'
],[
'state_id' => 581,
'name' => 'Obshtina Samokov'
],[
'state_id' => 581,
'name' => 'Obshtina Slivnitsa'
],[
'state_id' => 581,
'name' => 'Obshtina Svoge'
],[
'state_id' => 581,
'name' => 'Obshtina Zlatitsa'
],[
'state_id' => 581,
'name' => 'Pirdop'
],[
'state_id' => 581,
'name' => 'Pravets'
],[
'state_id' => 581,
'name' => 'Samokov'
],[
'state_id' => 581,
'name' => 'Slivnitsa'
],[
'state_id' => 581,
'name' => 'Svoge'
],[
'state_id' => 581,
'name' => 'Zlatitsa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
