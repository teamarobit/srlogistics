<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class UYStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 235,
'name' => 'Flores Department',
'iso2' => 'FS'
],[
'country_id' => 235,
'name' => 'San José Department',
'iso2' => 'SJ'
],[
'country_id' => 235,
'name' => 'Artigas Department',
'iso2' => 'AR'
],[
'country_id' => 235,
'name' => 'Maldonado Department',
'iso2' => 'MA'
],[
'country_id' => 235,
'name' => 'Rivera Department',
'iso2' => 'RV'
],[
'country_id' => 235,
'name' => 'Colonia Department',
'iso2' => 'CO'
],[
'country_id' => 235,
'name' => 'Durazno Department',
'iso2' => 'DU'
],[
'country_id' => 235,
'name' => 'Río Negro Department',
'iso2' => 'RN'
],[
'country_id' => 235,
'name' => 'Cerro Largo Department',
'iso2' => 'CL'
],[
'country_id' => 235,
'name' => 'Paysandú Department',
'iso2' => 'PA'
],[
'country_id' => 235,
'name' => 'Canelones Department',
'iso2' => 'CA'
],[
'country_id' => 235,
'name' => 'Treinta y Tres Department',
'iso2' => 'TT'
],[
'country_id' => 235,
'name' => 'Lavalleja Department',
'iso2' => 'LA'
],[
'country_id' => 235,
'name' => 'Rocha Department',
'iso2' => 'RO'
],[
'country_id' => 235,
'name' => 'Florida Department',
'iso2' => 'FD'
],[
'country_id' => 235,
'name' => 'Montevideo Department',
'iso2' => 'MO'
],[
'country_id' => 235,
'name' => 'Soriano Department',
'iso2' => 'SO'
],[
'country_id' => 235,
'name' => 'Salto Department',
'iso2' => 'SA'
],[
'country_id' => 235,
'name' => 'Tacuarembó Department',
'iso2' => 'TA'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
