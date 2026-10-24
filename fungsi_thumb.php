<?php	
	function employeeImage($iupload_name)
	{
		//direktori gambar
		$vdir_upload 	= "employee/";
		$vfile_upload 	= $vdir_upload . $iupload_name;

		//Simpan gambar dalam ukuran sebenarnya
		if(move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload))  
		{
			//identitas file asli
			$im_src 	= imagecreatefromjpeg($vfile_upload);
			$src_width1 = imageSX($im_src);
			$src_height1= imageSY($im_src);

			//Simpan dalam versi small 110 pixel
			//Set ukuran gambar hasil perubahan
			$dst_width1 = 138;
			$dst_height1= 124;

			//proses perubahan ukuran
			$im1 		= imagecreatetruecolor($dst_width1,$dst_height1);
			imagecopyresampled($im1, $im_src, 0, 0, 0, 0, $dst_width1, $dst_height1, $src_width1, $src_height1);

			//Simpan gambar
			imagejpeg($im1,$vdir_upload . 'small_' . $iupload_name);
		  
			//Hapus gambar di memori komputer
			imagedestroy($im_src);
			imagedestroy($im1);
		}
		else
		{
			echo "<script>window.alert('Photo Pegawai Gagal Terupload');
			window.location=('employee.php')</script>";
		}
	}
	function homeImage($fupload_name)
	{
		//direktori gambar
		$vdir_upload 		= "home/";
		$vfile_upload 		= $vdir_upload . $fupload_name;
	  
		//Simpan gambar dalam ukuran sebenarnya
		if(move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload))  
		{
			//identitas file asli
			$im_src 		= imagecreatefromjpeg($vfile_upload);
			$src_width 		= imageSX($im_src);
			$src_height 	= imageSY($im_src);

			//Simpan dalam versi small 110 pixel
			//Set ukuran gambar hasil perubahan
			$dst_width  = 110;
			$dst_height = 73;

			//proses perubahan ukuran
			$im = imagecreatetruecolor($dst_width,$dst_height);
			imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

			//Simpan gambar
			imagejpeg($im,$vdir_upload . 'small_' . $fupload_name);

			//Hapus gambar di memori komputer
			imagedestroy($im_src);
			imagedestroy($im);
		}
		else
		{
			echo "<script>window.alert('Photo Rumah Gagal Terupload');
			window.location=('home.php')</script>";
		}
	}
	function gardenImage($fupload_name)
	{
		//direktori gambar
		$vdir_upload 		= "garden/";
		$vfile_upload 		= $vdir_upload . $fupload_name;
	  
		//Simpan gambar dalam ukuran sebenarnya
		if(move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload))  
		{
			//identitas file asli
			$im_src 		= imagecreatefromjpeg($vfile_upload);
			$src_width 		= imageSX($im_src);
			$src_height 	= imageSY($im_src);

			//Simpan dalam versi small 110 pixel
			//Set ukuran gambar hasil perubahan
			$dst_width  = 110;
			$dst_height = 73;

			//proses perubahan ukuran
			$im = imagecreatetruecolor($dst_width,$dst_height);
			imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

			//Simpan gambar
			imagejpeg($im,$vdir_upload . 'small_' . $fupload_name);

			//Hapus gambar di memori komputer
			imagedestroy($im_src);
			imagedestroy($im);
		}
		else
		{
			echo "<script>window.alert('Photo Taman Gagal Terupload');
			window.location=('garden.php')</script>";
		}
	}
	function saunaImage($fupload_name)
	{
		//direktori gambar
		$vdir_upload 		= "sauna/";
		$vfile_upload 		= $vdir_upload . $fupload_name;
	  
		//Simpan gambar dalam ukuran sebenarnya
		if(move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload))  
		{
			//identitas file asli
			$im_src 		= imagecreatefromjpeg($vfile_upload);
			$src_width 		= imageSX($im_src);
			$src_height 	= imageSY($im_src);

			//Simpan dalam versi small 110 pixel
			//Set ukuran gambar hasil perubahan
			$dst_width  = 110;
			$dst_height = 73;

			//proses perubahan ukuran
			$im = imagecreatetruecolor($dst_width,$dst_height);
			imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

			//Simpan gambar
			imagejpeg($im,$vdir_upload . 'small_' . $fupload_name);

			//Hapus gambar di memori komputer
			imagedestroy($im_src);
			imagedestroy($im);
		}
		else
		{
			echo "<script>window.alert('Photo Sauna Gagal Terupload');
			window.location=('sauna.php')</script>";
		}
	}
?>