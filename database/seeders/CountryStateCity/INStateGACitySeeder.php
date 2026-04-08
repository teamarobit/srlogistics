<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateGACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1682,
'name' => 'Aldona'
],[
'state_id' => 1682,
'name' => 'Arambol'
],[
'state_id' => 1682,
'name' => 'Baga'
],[
'state_id' => 1682,
'name' => 'Bambolim'
],[
'state_id' => 1682,
'name' => 'Bandora'
],[
'state_id' => 1682,
'name' => 'Benaulim'
],[
'state_id' => 1682,
'name' => 'Calangute'
],[
'state_id' => 1682,
'name' => 'Candolim'
],[
'state_id' => 1682,
'name' => 'Carapur'
],[
'state_id' => 1682,
'name' => 'Cavelossim'
],[
'state_id' => 1682,
'name' => 'Chicalim'
],[
'state_id' => 1682,
'name' => 'Chinchinim'
],[
'state_id' => 1682,
'name' => 'Colovale'
],[
'state_id' => 1682,
'name' => 'Colva'
],[
'state_id' => 1682,
'name' => 'Cortalim'
],[
'state_id' => 1682,
'name' => 'Cuncolim'
],[
'state_id' => 1682,
'name' => 'Curchorem'
],[
'state_id' => 1682,
'name' => 'Curti'
],[
'state_id' => 1682,
'name' => 'Davorlim'
],[
'state_id' => 1682,
'name' => 'Dicholi'
],[
'state_id' => 1682,
'name' => 'Goa Velha'
],[
'state_id' => 1682,
'name' => 'Guirim'
],[
'state_id' => 1682,
'name' => 'Jua'
],[
'state_id' => 1682,
'name' => 'Kankon'
],[
'state_id' => 1682,
'name' => 'Madgaon'
],[
'state_id' => 1682,
'name' => 'Morjim'
],[
'state_id' => 1682,
'name' => 'Mormugao'
],[
'state_id' => 1682,
'name' => 'Mapuca'
],[
'state_id' => 1682,
'name' => 'Navelim'
],[
'state_id' => 1682,
'name' => 'North Goa'
],[
'state_id' => 1682,
'name' => 'Palle'
],[
'state_id' => 1682,
'name' => 'Panaji'
],[
'state_id' => 1682,
'name' => 'Pernem'
],[
'state_id' => 1682,
'name' => 'Ponda'
],[
'state_id' => 1682,
'name' => 'Quepem'
],[
'state_id' => 1682,
'name' => 'Queula'
],[
'state_id' => 1682,
'name' => 'Raia'
],[
'state_id' => 1682,
'name' => 'Saligao'
],[
'state_id' => 1682,
'name' => 'Sancoale'
],[
'state_id' => 1682,
'name' => 'Sanguem'
],[
'state_id' => 1682,
'name' => 'Sanquelim'
],[
'state_id' => 1682,
'name' => 'Sanvordem'
],[
'state_id' => 1682,
'name' => 'Serula'
],[
'state_id' => 1682,
'name' => 'Solim'
],[
'state_id' => 1682,
'name' => 'South Goa'
],[
'state_id' => 1682,
'name' => 'Taleigao'
],[
'state_id' => 1682,
'name' => 'Vagator'
],[
'state_id' => 1682,
'name' => 'Valpoy'
],[
'state_id' => 1682,
'name' => 'Varca'
],[
'state_id' => 1682,
'name' => 'Vasco da Gama'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
