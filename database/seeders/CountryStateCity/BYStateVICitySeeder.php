<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BYStateVICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 432,
'name' => 'Balbasava'
],[
'state_id' => 432,
'name' => 'Baran’'
],[
'state_id' => 432,
'name' => 'Braslaw'
],[
'state_id' => 432,
'name' => 'Braslawski Rayon'
],[
'state_id' => 432,
'name' => 'Byahoml’'
],[
'state_id' => 432,
'name' => 'Byeshankovitski Rayon'
],[
'state_id' => 432,
'name' => 'Chashniki'
],[
'state_id' => 432,
'name' => 'Chashnitski Rayon'
],[
'state_id' => 432,
'name' => 'Dokshytski Rayon'
],[
'state_id' => 432,
'name' => 'Dokshytsy'
],[
'state_id' => 432,
'name' => 'Druya'
],[
'state_id' => 432,
'name' => 'Dubrowna'
],[
'state_id' => 432,
'name' => 'Dzisna'
],[
'state_id' => 432,
'name' => 'Haradok'
],[
'state_id' => 432,
'name' => 'Haradotski Rayon'
],[
'state_id' => 432,
'name' => 'Hlybokaye'
],[
'state_id' => 432,
'name' => 'Hlybotski Rayon'
],[
'state_id' => 432,
'name' => 'Kokhanava'
],[
'state_id' => 432,
'name' => 'Konstantinovo'
],[
'state_id' => 432,
'name' => 'Lyepyel’'
],[
'state_id' => 432,
'name' => 'Lyepyel’ski Rayon'
],[
'state_id' => 432,
'name' => 'Lyntupy'
],[
'state_id' => 432,
'name' => 'Lyozna'
],[
'state_id' => 432,
'name' => 'Lyoznyenski Rayon'
],[
'state_id' => 432,
'name' => 'Mosar'
],[
'state_id' => 432,
'name' => 'Myorski Rayon'
],[
'state_id' => 432,
'name' => 'Myory'
],[
'state_id' => 432,
'name' => 'Navapolatsk'
],[
'state_id' => 432,
'name' => 'Novolukoml’'
],[
'state_id' => 432,
'name' => 'Orsha'
],[
'state_id' => 432,
'name' => 'Osveya'
],[
'state_id' => 432,
'name' => 'Pastavy'
],[
'state_id' => 432,
'name' => 'Pastawski Rayon'
],[
'state_id' => 432,
'name' => 'Polatsk'
],[
'state_id' => 432,
'name' => 'Polatski Rayon'
],[
'state_id' => 432,
'name' => 'Rasonski Rayon'
],[
'state_id' => 432,
'name' => 'Rasony'
],[
'state_id' => 432,
'name' => 'Sharkawshchyna'
],[
'state_id' => 432,
'name' => 'Sharkawshchynski Rayon'
],[
'state_id' => 432,
'name' => 'Shumilinski Rayon'
],[
'state_id' => 432,
'name' => 'Syanno'
],[
'state_id' => 432,
'name' => 'Syennyenski Rayon'
],[
'state_id' => 432,
'name' => 'Talachyn'
],[
'state_id' => 432,
'name' => 'Ushachy'
],[
'state_id' => 432,
'name' => 'Vidzy'
],[
'state_id' => 432,
'name' => 'Vitebsk'
],[
'state_id' => 432,
'name' => 'Vyerkhnyadzvinsk'
],[
'state_id' => 432,
'name' => 'Vyerkhnyadzvinski Rayon'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
