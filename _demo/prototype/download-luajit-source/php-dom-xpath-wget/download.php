#!/usr/bin/env php
<?php



	// http://php.net/manual/en/function.error-reporting.php
	error_reporting(E_ALL & ~(E_WARNING|E_NOTICE));


class App {

	public $target_dir_path = __DIR__ . '/download';

	protected function prepare_target_directory()
	{
		if (file_exists($this->target_dir_path) && is_dir($this->target_dir_path)) {
			return true;
		}

		//https://www.php.net/manual/en/function.mkdir.php
		if (!mkdir($this->target_dir_path, 0777, true)) {
			return false;
		}

		return true;

	}

	protected function find_download_url_list()
	{
		$base_url = 'https://luajit.org/download.html';

		$doc = new DOMDocument; // http://php.net/manual/en/class.domdocument.php

		$doc->preserveWhiteSpace = false; // http://php.net/manual/en/class.domdocument.php#domdocument.props.preservewhitespace

		$doc->loadHTMLFile($base_url); // http://php.net/manual/en/domdocument.loadhtmlfile.php

		$xpath = new DOMXPath($doc); // http://php.net/manual/en/class.domxpath.php

		$query = '//a/@href';

		$nodes = $xpath->query($query); // http://php.net/manual/en/domxpath.query.php

		if (is_null($nodes)) { // http://php.net/manual/en/function.is-null.php
			return;
		}


		$list = '';
		// http://php.net/manual/en/class.domnodelist.php
		// http://php.net/manual/en/class.domnode.php
		foreach ($nodes as $node) {

			//var_dump($node);
			//echo $source_file_name . PHP_EOL;

			$source_file_name = $node->nodeValue;


			if (!strstr($source_file_name, 'LuaJIT')) { // http://php.net/manual/en/function.strstr.php
				continue;
			}

			$source_url = dirname($base_url) . '/' . $source_file_name;

			#echo $source_url . PHP_EOL;

			$list .= $source_url . PHP_EOL;
		}

		return $list;
	}

	public function run()
	{
		if (!$this->prepare_target_directory()) {
			return;
		}

		$list = $this->find_download_url_list();
		#echo $list;


		$list_file_path = $this->target_dir_path . '/luajit-source.txt';

		file_put_contents($list_file_path, $list); // http://php.net/manual/en/function.file-put-contents.php

		system('cd ' . $this->target_dir_path . ' && wget -c -i ' . $list_file_path); // http://php.net/manual/en/function.system.php


	}

}

(new App)->run();
