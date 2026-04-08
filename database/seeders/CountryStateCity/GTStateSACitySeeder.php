<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateSACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1520,
'name' => 'Alotenango'
],[
'state_id' => 1520,
'name' => 'Antigua Guatemala'
],[
'state_id' => 1520,
'name' => 'Ciudad Vieja'
],[
'state_id' => 1520,
'name' => 'Jocotenango'
],[
'state_id' => 1520,
'name' => 'Magdalena Milpas Altas'
],[
'state_id' => 1520,
'name' => 'Municipio de Alotenango'
],[
'state_id' => 1520,
'name' => 'Municipio de Antigua Guatemala'
],[
'state_id' => 1520,
'name' => 'Municipio de Ciudad Vieja'
],[
'state_id' => 1520,
'name' => 'Municipio de Jocotenango'
],[
'state_id' => 1520,
'name' => 'Municipio de Magdalena Milpas Altas'
],[
'state_id' => 1520,
'name' => 'Municipio de Santa Lucía Milpas Altas'
],[
'state_id' => 1520,
'name' => 'Municipio de Santa María de Jesús'
],[
'state_id' => 1520,
'name' => 'Pastores'
],[
'state_id' => 1520,
'name' => 'San Antonio Aguas Calientes'
],[
'state_id' => 1520,
'name' => 'San Bartolomé Milpas Altas'
],[
'state_id' => 1520,
'name' => 'San Lucas Sacatepéquez'
],[
'state_id' => 1520,
'name' => 'San Miguel Dueñas'
],[
'state_id' => 1520,
'name' => 'Santa Catarina Barahona'
],[
'state_id' => 1520,
'name' => 'Santa Lucía Milpas Altas'
],[
'state_id' => 1520,
'name' => 'Santa María de Jesús'
],[
'state_id' => 1520,
'name' => 'Santiago Sacatepéquez'
],[
'state_id' => 1520,
'name' => 'Santo Domingo Xenacoj'
],[
'state_id' => 1520,
'name' => 'Sumpango'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
