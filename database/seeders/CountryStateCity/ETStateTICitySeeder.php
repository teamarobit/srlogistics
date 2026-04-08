<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ETStateTICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
		$jayParsedAry = [
			[
				'state_id' => 1226,
				'name' => 'Axum'
			], [
				'state_id' => 1226,
				'name' => 'Inda Silasē'
			], [
				'state_id' => 1226,
				'name' => 'Korem'
			], [
				'state_id' => 1226,
				'name' => 'Maych’ew'
			], [
				'state_id' => 1226,
				'name' => 'Mek\'ele'
			], [
				'state_id' => 1226,
				'name' => 'Southeastern Tigray Zone'
			], [
				'state_id' => 1226,
				'name' => 'Southern Tigray Zone'
			], [
				'state_id' => 1226,
				'name' => 'Ādīgrat'
			],
		];
		foreach ($jayParsedAry as $data) {
			City::create($data);
		}
	}
}
