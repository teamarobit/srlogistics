<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateMLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 779,
'name' => 'Cauquenes'
],[
'state_id' => 779,
'name' => 'Colbún'
],[
'state_id' => 779,
'name' => 'Constitución'
],[
'state_id' => 779,
'name' => 'Curicó'
],[
'state_id' => 779,
'name' => 'Linares'
],[
'state_id' => 779,
'name' => 'Longaví'
],[
'state_id' => 779,
'name' => 'Molina'
],[
'state_id' => 779,
'name' => 'Parral'
],[
'state_id' => 779,
'name' => 'Rauco'
],[
'state_id' => 779,
'name' => 'San Clemente'
],[
'state_id' => 779,
'name' => 'San Javier'
],[
'state_id' => 779,
'name' => 'Talca'
],[
'state_id' => 779,
'name' => 'Teno'
],[
'state_id' => 779,
'name' => 'Chanco'
],[
'state_id' => 779,
'name' => 'Curepto'
],[
'state_id' => 779,
'name' => 'Empedrado'
],[
'state_id' => 779,
'name' => 'Hualañé'
],[
'state_id' => 779,
'name' => 'Licantén'
],[
'state_id' => 779,
'name' => 'Maule'
],[
'state_id' => 779,
'name' => 'Pelarco'
],[
'state_id' => 779,
'name' => 'Pelluhue'
],[
'state_id' => 779,
'name' => 'Pencahue'
],[
'state_id' => 779,
'name' => 'Retiro'
],[
'state_id' => 779,
'name' => 'Romeral'
],[
'state_id' => 779,
'name' => 'Río Claro'
],[
'state_id' => 779,
'name' => 'Sagrada Familia'
],[
'state_id' => 779,
'name' => 'San Rafael'
],[
'state_id' => 779,
'name' => 'Vichuquén'
],[
'state_id' => 779,
'name' => 'Villa Alegre'
],[
'state_id' => 779,
'name' => 'Yerbas Buenas'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
