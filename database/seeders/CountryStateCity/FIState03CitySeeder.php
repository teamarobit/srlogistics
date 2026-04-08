<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState03CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1258,
'name' => 'Alahärmä'
],[
'state_id' => 1258,
'name' => 'Alajärvi'
],[
'state_id' => 1258,
'name' => 'Alavus'
],[
'state_id' => 1258,
'name' => 'Evijärvi'
],[
'state_id' => 1258,
'name' => 'Ilmajoki'
],[
'state_id' => 1258,
'name' => 'Isojoki'
],[
'state_id' => 1258,
'name' => 'Jalasjärvi'
],[
'state_id' => 1258,
'name' => 'Jurva'
],[
'state_id' => 1258,
'name' => 'Karijoki'
],[
'state_id' => 1258,
'name' => 'Kauhajoki'
],[
'state_id' => 1258,
'name' => 'Kauhava'
],[
'state_id' => 1258,
'name' => 'Kortesjärvi'
],[
'state_id' => 1258,
'name' => 'Kuortane'
],[
'state_id' => 1258,
'name' => 'Kurikka'
],[
'state_id' => 1258,
'name' => 'Lappajärvi'
],[
'state_id' => 1258,
'name' => 'Lapua'
],[
'state_id' => 1258,
'name' => 'Lehtimäki'
],[
'state_id' => 1258,
'name' => 'Nurmo'
],[
'state_id' => 1258,
'name' => 'Seinäjoki'
],[
'state_id' => 1258,
'name' => 'Soini'
],[
'state_id' => 1258,
'name' => 'Teuva'
],[
'state_id' => 1258,
'name' => 'Töysä'
],[
'state_id' => 1258,
'name' => 'Vimpeli'
],[
'state_id' => 1258,
'name' => 'Ylihärmä'
],[
'state_id' => 1258,
'name' => 'Ylistaro'
],[
'state_id' => 1258,
'name' => 'Ähtäri'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
