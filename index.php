<?php
	header("Content-type:text/html;charset=gb2312");
	require_once 'class/Session.php';
	require_once 'class/Downloader.php';
	require_once 'class/FileHandler.php';

	$session = Session::getInstance();
	$file = new FileHandler;

	require 'views/header.php';

	if(!$session->is_logged_in())
	{
		header("Location: login.php");
	}
	else
	{
		if(isset($_GET['kill']) && !empty($_GET['kill']) && $_GET['kill'] === "all")
		{
			Downloader::kill_them_all();
		}

		if(isset($_POST['urls']) && !empty($_POST['urls']))
		{
			$audio_only = false;

			if(isset($_POST['audio']) && !empty($_POST['audio']))
			{
				$audio_only = true;
			}

			$downloader = new Downloader($_POST['urls'], $audio_only);
			
			if(!isset($_SESSION['errors']))
			{
				header("Location: index.php");
			}
		}
	}
?>
		<div class="container">
			<h1>下载</h1>
			<?php

				if(isset($_SESSION['errors']) && $_SESSION['errors'] > 0)
				{
					foreach ($_SESSION['errors'] as $e)
					{
						echo "<div class=\"alert alert-warning\" role=\"alert\">$e</div>";
					}
				}

			?>
			<form id="download-form" class="form-horizontal" action="index.php" method="post">					
				<div class="form-group">
					<div class="col-md-10">
						<input class="form-control" id="url" name="urls" placeholder="视频链接" type="text">
					</div>
					<div class="col-md-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="audio"> 只下载音频
							</label>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">下载</button>
			</form>
			<br>
			<div class="row">
				<div class="col-lg-6">
					<div class="panel panel-info">
						<div class="panel-heading"><h3 class="panel-title">信息</h3></div>
						<div class="panel-body">
							<p>剩余空间 : <?php echo $file->free_space(); ?></b></p>
							<p>下载目录 : <?php echo $file->get_downloads_folder(); ?></p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="panel panel-info">
						<div class="panel-heading"><h3 class="panel-title">帮助</h3></div>
						<div class="panel-body">
							<p><b>它是如何工作的？</b></p>
							<p>只需在编辑框中粘贴视频链接，然后点击“下载”</p>
							<p><b>支持哪些网站？</b></p>
							<p><a href="http://rg3.github.io/youtube-dl/supportedsites.html">点我 </a> 支持的网站列表</p>
							<p><b>如何在计算机上下载视频？</b></p>
							<p>转到 <a href="./list.php?type=v">视频列表</a> -> 选择一个 -> 右键单击链接 -> "将目标另存为..." </p>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	unset($_SESSION['errors']);
	require 'views/footer.php';
?>
