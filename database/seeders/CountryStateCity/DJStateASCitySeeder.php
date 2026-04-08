<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DJStateASCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
		$jayParsedAry = [
			[
				'state_id' => 1074,
				'name' => 'Ali Sabieh'
			], [
				'state_id' => 1074,
				'name' => 'Goubétto'
			], [
				'state_id' => 1074,
				'name' => 'Holhol'
			],
		];
		foreach ($jayParsedAry as $data) {
			City::create($data);
		}
	}
}
