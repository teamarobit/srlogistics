<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState13CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 934,
'name' => 'Benkovac'
],[
'state_id' => 934,
'name' => 'Bibinje'
],[
'state_id' => 934,
'name' => 'Biograd na Moru'
],[
'state_id' => 934,
'name' => 'Galovac'
],[
'state_id' => 934,
'name' => 'Gornji Karin'
],[
'state_id' => 934,
'name' => 'Grad Biograd na Moru'
],[
'state_id' => 934,
'name' => 'Gračac'
],[
'state_id' => 934,
'name' => 'Jasenice'
],[
'state_id' => 934,
'name' => 'Kali'
],[
'state_id' => 934,
'name' => 'Kruševo'
],[
'state_id' => 934,
'name' => 'Nin'
],[
'state_id' => 934,
'name' => 'Novigrad Općina'
],[
'state_id' => 934,
'name' => 'Obrovac'
],[
'state_id' => 934,
'name' => 'Osljak'
],[
'state_id' => 934,
'name' => 'Pag'
],[
'state_id' => 934,
'name' => 'Pakoštane'
],[
'state_id' => 934,
'name' => 'Polača'
],[
'state_id' => 934,
'name' => 'Poličnik'
],[
'state_id' => 934,
'name' => 'Posedarje'
],[
'state_id' => 934,
'name' => 'Preko'
],[
'state_id' => 934,
'name' => 'Pridraga'
],[
'state_id' => 934,
'name' => 'Privlaka'
],[
'state_id' => 934,
'name' => 'Ražanac'
],[
'state_id' => 934,
'name' => 'Sali'
],[
'state_id' => 934,
'name' => 'Stari Grad'
],[
'state_id' => 934,
'name' => 'Starigrad'
],[
'state_id' => 934,
'name' => 'Sukošan'
],[
'state_id' => 934,
'name' => 'Sveti Filip i Jakov'
],[
'state_id' => 934,
'name' => 'Tkon'
],[
'state_id' => 934,
'name' => 'Turanj'
],[
'state_id' => 934,
'name' => 'Ugljan'
],[
'state_id' => 934,
'name' => 'Vir'
],[
'state_id' => 934,
'name' => 'Vrsi'
],[
'state_id' => 934,
'name' => 'Zadar'
],[
'state_id' => 934,
'name' => 'Škabrnja'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
