<?php

class FileHandler
{
	private $config = [];
	private $videos_ext = ".{avi,mp4,flv,webm,mkv}";
	private $musics_ext = ".{mp3,ogg,m4a,opus}";

	public function __construct()
	{
		$this->config = require dirname(__DIR__).'/config/config.php';
	}

	public function listVideos()
	{
		$videos = [];

		if(!$this->outuput_folder_exists())
			return;

		$folder = $this->get_downloads_folder().'/';

		foreach(glob($folder.'*'.$this->videos_ext, GLOB_BRACE) as $file)
		{
			$video = [];
			$video["name"] = str_replace($folder, "", $file);
			$video["size"] = $this->to_human_filesize(filesize($file));
			
			$videos[] = $video;
		}

		return $videos;
	}

	public function listMusics()
	{
		$musics = [];

		if(!$this->outuput_folder_exists())
			return;

		$folder = $this->get_downloads_folder().'/';

		foreach(glob($folder.'*'.$this->musics_ext, GLOB_BRACE) as $file)
		{
			$music = [];
			$music["name"] = str_replace($folder, "", $file);
			$music["size"] = $this->to_human_filesize(filesize($file));
			
			$musics[] = $music;
		}

		return $musics;
	}

	public function delete($id, $type)
	{
		$folder = $this->get_downloads_folder().'/';
		$i = 0;

		if($type === 'v')
		{
			$exts = $this->videos_ext;
		}
		elseif($type === 'm')
		{
			$exts = $this->musics_ext;
		}
		else
		{
			return;
		}

		foreach(glob($folder.'*'.$exts, GLOB_BRACE) as $file)
		{
			if($i == $id)
			{
				unlink($file);
			}
			$i++;
		}
	}

	private function outuput_folder_exists()
	{
		if(!is_dir($this->get_downloads_folder()))
		{
			//Folder doesn't exist
			if(!mkdir($this->get_downloads_folder(),0777))
			{
				return false; //No folder and creation failed
			}
		}
		
		return true;
	}

	public function to_human_filesize($bytes, $decimals = 0)
	{
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
	}

	public function free_space()
	{
		return $this->to_human_filesize(disk_free_space($this->get_downloads_folder()));
	}

	public function get_downloads_folder()
	{
                $path =  $this->config["outputFolder"];
                if(strpos($path , "/") !== 0) 
                {
                        $path = dirname(__DIR__).'/' . $path;
                }
		return $path;
	}
}

?>
