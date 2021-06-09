<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Properties extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'	=> [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'judul' => [
				'type'           => 'VARCHAR',
				'constraint'     => '250',
			],
			'slug'	=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> 255,
			],
			'tipe'	=>[
				'type'			=> 'ENUM("Rumah","Apartemen","Indekos","Tanah","Ruko")',
				'default' 		=> 'Rumah',
				'null'			=> FALSE
			],
			'luas_tanah'	=> [
				'type'			=> 'INT',
				'constraint'	=> 5,
			],
			'luas_bangunan'	=> [
				'type'			=> 'INT',
				'constraint'	=> 5,
			],
			'luas_tanah'	=> [
				'type'			=> 'INT',
				'constraint'	=> 5,
			],
			'sertifikat'	=> [
				'type'			=> 'ENUM("SHM","HGB","STRATA TITLE","Lainnya")'
			],
			"deskripsi"		=> [
				'type'		=> 'text',
			],
			"harga"			=> [
				'type'		=> 'VARCHAR',
				'constraint'=> 12
			],
			'jumlah_lantai'=>[
				'type'		=> 'INT',
				'constraint'=> 2
			],
			'jumlah_km'=>[
				'type'		=> 'INT',
				'constraint'=> 2
			],
			'jumlah_kt'=>[
				'type'		=> 'INT',
				'constraint'=> 2
			]
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('properties');
	}

	public function down()
	{
		//
	}
}
