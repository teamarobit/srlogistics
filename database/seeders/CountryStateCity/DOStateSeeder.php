<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class DOStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 62,
'name' => 'El Seibo Province',
'iso2' => '08'
],[
'country_id' => 62,
'name' => 'La Romana Province',
'iso2' => '12'
],[
'country_id' => 62,
'name' => 'Sánchez Ramírez Province',
'iso2' => '24'
],[
'country_id' => 62,
'name' => 'Hermanas Mirabal Province',
'iso2' => '19'
],[
'country_id' => 62,
'name' => 'Barahona Province',
'iso2' => '04'
],[
'country_id' => 62,
'name' => 'San Cristóbal Province',
'iso2' => '21'
],[
'country_id' => 62,
'name' => 'Puerto Plata Province',
'iso2' => '18'
],[
'country_id' => 62,
'name' => 'Santo Domingo Province',
'iso2' => '32'
],[
'country_id' => 62,
'name' => 'María Trinidad Sánchez Province',
'iso2' => '14'
],[
'country_id' => 62,
'name' => 'Distrito Nacional',
'iso2' => '01'
],[
'country_id' => 62,
'name' => 'Peravia Province',
'iso2' => '17'
],[
'country_id' => 62,
'name' => 'Independencia',
'iso2' => '10'
],[
'country_id' => 62,
'name' => 'San Juan Province',
'iso2' => '22'
],[
'country_id' => 62,
'name' => 'Monseñor Nouel Province',
'iso2' => '28'
],[
'country_id' => 62,
'name' => 'Santiago Rodríguez Province',
'iso2' => '26'
],[
'country_id' => 62,
'name' => 'Pedernales Province',
'iso2' => '16'
],[
'country_id' => 62,
'name' => 'Espaillat Province',
'iso2' => '09'
],[
'country_id' => 62,
'name' => 'Samaná Province',
'iso2' => '20'
],[
'country_id' => 62,
'name' => 'Valverde Province',
'iso2' => '27'
],[
'country_id' => 62,
'name' => 'Baoruco Province',
'iso2' => '03'
],[
'country_id' => 62,
'name' => 'Hato Mayor Province',
'iso2' => '30'
],[
'country_id' => 62,
'name' => 'Dajabón Province',
'iso2' => '05'
],[
'country_id' => 62,
'name' => 'Santiago Province',
'iso2' => '25'
],[
'country_id' => 62,
'name' => 'La Altagracia Province',
'iso2' => '11'
],[
'country_id' => 62,
'name' => 'San Pedro de Macorís',
'iso2' => '23'
],[
'country_id' => 62,
'name' => 'Monte Plata Province',
'iso2' => '29'
],[
'country_id' => 62,
'name' => 'San José de Ocoa Province',
'iso2' => '31'
],[
'country_id' => 62,
'name' => 'Duarte Province',
'iso2' => '06'
],[
'country_id' => 62,
'name' => 'Azua Province',
'iso2' => '02'
],[
'country_id' => 62,
'name' => 'Monte Cristi Province',
'iso2' => '15'
],[
'country_id' => 62,
'name' => 'La Vega Province',
'iso2' => '13'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
