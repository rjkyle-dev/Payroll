<?php

function views_path($view)
{

    if(file_exists("../app/view/$view.view.php"))
    {
       return "../app/view/$view.view.php";
    }
    else{
        echo "View '$view' Not Found!";
    }
}
function esc($str)
{
	return htmlspecialchars($str);
}

function set_title($title) {
    echo "<script>document.title = '$title';</script>";
}

function crop($filename,$size = 400,$type = 'product')
{

	$ext = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
	$cropped_file = preg_replace("/\.$ext$/", "_cropped.".$ext, $filename);

	//if cropped file already exists
	if(file_exists($cropped_file))
	{
		return $cropped_file;
	}

	//if file to be cropped does not exist
	if(!file_exists($filename))
	{
		if($type == "male"){
			return 'assets/images/user_male.jpg';
		}else
		if($type == "female"){
			return 'assets/images/user_female.jpg';
		}else{
			return 'assets/images/no_image.jpg';
		}
	}

	
	//create image resource
	switch ($ext) {
		case 'jpg':
		case 'jpeg':
			$src_image = imagecreatefromjpeg($filename);
			break;
		
		case 'gif':
			$src_image = imagecreatefromgif($filename);
			break;
		
		case 'png':
			$src_image = imagecreatefrompng($filename);
			break;
		
		default:
			return $filename;
			break;
	}

	//set cropping params

	//assign values
	$dst_x = 0;
	$dst_y = 0;
	$dst_w = (int)$size;
	$dst_h = (int)$size;

	$original_width = imagesx($src_image);
	$original_height = imagesy($src_image);

	if($original_width < $original_height)
	{
		$src_x = 0;
		$src_y = ($original_height - $original_width) / 2;
		$src_w = $original_width;
		$src_h = $original_width;

	}else{

		$src_y = 0;
		$src_x = ($original_width - $original_height) / 2;
		$src_w = $original_height;
		$src_h = $original_height;
	}
 
	$dst_image = imagecreatetruecolor((int)$size, (int)$size);
	imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

	//save final image
	switch ($ext) {
		case 'jpg':
		case 'jpeg':
			imagejpeg($dst_image,$cropped_file,90);
			break;
		
		case 'gif':
			imagegif($dst_image,$cropped_file);
			break;
		
		case 'png':
			imagepng($dst_image,$cropped_file);
			break;
		
		default:
			return $filename;
			break;
	}

	imagedestroy($dst_image);
	imagedestroy($src_image);

	return $cropped_file;
}

function redirect($page)
{

	header("Location: index.php?payroll=" .$page);
	die;
}

