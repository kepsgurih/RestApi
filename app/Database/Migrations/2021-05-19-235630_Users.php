<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPSTORM_META\type;

class Users extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'id' => [
				'type'				=> 'INT',
				'constraint' 		=> 11,
                'auto_increment'	=> TRUE
			],
			'email'					=>[
				'type'				=> 'VARCHAR',
				'constraint'    	=> 100,
				'unique'			=> TRUE
			],
			'phone'					=>[
				'type'				=> 'VARCHAR',
				'constraint'		=> 13,
				'unique'			=> TRUE
			],
			'password' 				=> [
                'type' 				=> 'VARCHAR',
                'constraint' 		=> 255
            ]
		]);
		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('users');
	}

	public function down()
	{
		//
	}
}
