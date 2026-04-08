<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState20CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 933,
'name' => 'Belica'
],[
'state_id' => 933,
'name' => 'Dekanovec'
],[
'state_id' => 933,
'name' => 'Domašinec'
],[
'state_id' => 933,
'name' => 'Goričan'
],[
'state_id' => 933,
'name' => 'Grad Čakovec'
],[
'state_id' => 933,
'name' => 'Hodošan'
],[
'state_id' => 933,
'name' => 'Ivanovec'
],[
'state_id' => 933,
'name' => 'Kotoriba'
],[
'state_id' => 933,
'name' => 'Kuršanec'
],[
'state_id' => 933,
'name' => 'Lopatinec'
],[
'state_id' => 933,
'name' => 'Mala Subotica'
],[
'state_id' => 933,
'name' => 'Mačkovec'
],[
'state_id' => 933,
'name' => 'Mihovljan'
],[
'state_id' => 933,
'name' => 'Mursko Središće'
],[
'state_id' => 933,
'name' => 'Nedelišće'
],[
'state_id' => 933,
'name' => 'Novo Selo Rok'
],[
'state_id' => 933,
'name' => 'Orehovica'
],[
'state_id' => 933,
'name' => 'Peklenica'
],[
'state_id' => 933,
'name' => 'Podturen'
],[
'state_id' => 933,
'name' => 'Prelog'
],[
'state_id' => 933,
'name' => 'Pribislavec'
],[
'state_id' => 933,
'name' => 'Strahoninec'
],[
'state_id' => 933,
'name' => 'Sveti Juraj na Bregu'
],[
'state_id' => 933,
'name' => 'Vratišinec'
],[
'state_id' => 933,
'name' => 'Čakovec'
],[
'state_id' => 933,
'name' => 'Šenkovec'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
