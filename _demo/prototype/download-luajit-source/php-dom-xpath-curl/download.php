#!/usr/bin/env php
<?php



	// http://php.net/manual/en/function.error-reporting.php
	error_reporting(E_ALL & ~(E_WARNING|E_NOTICE));


class App {

	public $target_dir_path = __DIR__ . '/download';

	protected function do_downlod ($source_url, $save_file_path)
	{
		$ch = curl_init(); // http://php.net/manual/en/function.curl-init.php

		// http://php.net/manual/en/function.curl-setopt.php
		curl_setopt($ch, CURLOPT_URL, $source_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // for curl_exec return
		curl_setopt($ch, CURLOPT_HEADER, false);
		
		//https://www.runoob.com/note/639
		//https://codertw.com/%E7%A8%8B%E5%BC%8F%E8%AA%9E%E8%A8%80/111328/
		//https://www.php.net/manual/en/function.curl-setopt.php
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // for https
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 

		$contents = curl_exec($ch); // http://php.net/manual/en/function.curl-exec.php
		
		//var_dump($contents);

		curl_close($ch); // http://php.net/manual/en/function.curl-close.php

		file_put_contents($save_file_path, $contents);

	}


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

	protected function download_url_list()
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


			if (!strstr($source_file_name, 'LuaJIT-')) { // http://php.net/manual/en/function.strstr.php
				continue;
			}

			$source_url = dirname($base_url) . '/' . $source_file_name;
			$save_file_path = dirname($this->target_dir_path) . '/' . $source_file_name;

			echo 'Download: ' . $source_url . PHP_EOL;
			$this->do_downlod($source_url, $save_file_path);

		}


	}

	public function run()
	{
		if (!$this->prepare_target_directory()) {
			return;
		}

		$this->download_url_list();


	}

}

(new App)->run();
