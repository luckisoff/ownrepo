<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase {
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testBasicTest() {
		$response = $this->withHeaders([
			'Accept'        => 'application/json',
			'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjZhZmFiMmQ4NGI3NzI0N2IzYjkwNDhjMzYwMDUwMjU4OTk0YzIzOWM2ZTY1OTJhOWNkYTU3ZDM2OWYxZmNkNzViNzMxM2Y5ZGFmM2Q1OWYwIn0.eyJhdWQiOiI3IiwianRpIjoiNmFmYWIyZDg0Yjc3MjQ3YjNiOTA0OGMzNjAwNTAyNTg5OTRjMjM5YzZlNjU5MmE5Y2RhNTdkMzY5ZjFmY2Q3NWI3MzEzZjlkYWYzZDU5ZjAiLCJpYXQiOjE1MTg3NTkxOTYsIm5iZiI6MTUxODc1OTE5NiwiZXhwIjoxNTUwMjk1MTk2LCJzdWIiOiIyNzMiLCJzY29wZXMiOlsiKiJdfQ.FbznT4GHqnB6F_aljkpjNy_FChQZEMiAsrnMiEQDRLhHL3DHYzzI7fAUQRSCoe6pM_1vlPqFKAb-SlcZoyIt6p7JsVrhfjysy3QEL3JekFEcA72ybKFL2nBvqK-cbVo2SHecSMvU9FCA3lSwcLb0XvMcPHEA3wZW2nq-tBOFp1shCGOCTuOZQL0A3KgmW6LaTlL2d4E3cyeYy5VtGuLp0l1EMpdzGNw7b-MR38Lf7QzfIei6WiNYMAbGvkG3BC2MMUBw0-upHi4plgV1RBvPHxAYOpw_z-zd_m9bu0rZbkBIg3qEJkP3q6hpG-55EApAkUFHXrb2CKouG1WbOyollZKuo-GP9q7pV6xtAli1OpeWykVdvoFbY3Rkf5O7c8S764GJnUFw6QlztydogopqI9KC8niNXLm4_GdXYet8Q0tNIYowiweQXYEo5oNfjI8imJiuMQZUyzeYVayR5xQvny_fv6QAaLk9QzIoYMSJ_JkMMbRDBKIbcNz9-KxfiOenY-8tJ3EabsizPrlwgSiGW3A4BkUx9o9sKEk8ELmKri8Mka0Yi5SL_mAz_-WJ0vFNBHWqZ7kdckEGUNRkyA3Cnycl50t7GPUw5TSKjwn4lTfM1jthSHS5YuMUa4BAsAQZPhUhxizOcf0Q5p5N_on25WMnfsG5fMyauG3TPfSZB7s',
		])->json('GET', '/api/offline-questions-random');

		$response
			->assertStatus(200)
			->assertJson([
				'status' => true,
				'code'   => 200
			]);
	}
}
