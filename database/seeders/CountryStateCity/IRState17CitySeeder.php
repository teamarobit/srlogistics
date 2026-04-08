<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState17CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1759,
'name' => 'Dehdasht'
],[
'state_id' => 1759,
'name' => 'Dogonbadan'
],[
'state_id' => 1759,
'name' => 'Landeh'
],[
'state_id' => 1759,
'name' => 'Bahmai'
],[
'state_id' => 1759,
'name' => 'Basht'
],[
'state_id' => 1759,
'name' => 'Charam'
],[
'state_id' => 1759,
'name' => 'Gachsaran'
],[
'state_id' => 1759,
'name' => 'Kohgiluyeh'
],[
'state_id' => 1759,
'name' => 'Yasuj'
],[
'state_id' => 1759,
'name' => 'Chitab'
],[
'state_id' => 1759,
'name' => 'Garab-e Sofla'
],[
'state_id' => 1759,
'name' => 'Madavan'
],[
'state_id' => 1759,
'name' => 'Margoon'
],[
'state_id' => 1759,
'name' => 'Likak'
],[
'state_id' => 1759,
'name' => 'Choram'
],[
'state_id' => 1759,
'name' => 'sarfariyab'
],[
'state_id' => 1759,
'name' => 'Pataveh'
],[
'state_id' => 1759,
'name' => 'Sisakht'
],[
'state_id' => 1759,
'name' => 'Dishmok'
],[
'state_id' => 1759,
'name' => 'Suq'
],[
'state_id' => 1759,
'name' => 'Qaleh Raisi'
],[
'state_id' => 1759,
'name' => 'Lendeh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
