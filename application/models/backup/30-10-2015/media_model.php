<?php
if(!defined('BASEPATH')) exit('No direct access allowed');

class media_model extends CI_Model
{	
	public $base64_data							=	'';
	public $file_name								=	'';
	public $upload_type							=	'';
	public $file_data								=	'';
	public $extension								=	'';
	public $folder									=	'';
	public $max_file_size						=	2097152;#in bytes	
	public $file_application_types	=	array("application/zip", "application/x-zip", "application/x-zip-compressed","application/pdf","image/jpeg","image/png","application/vnd.openxmlformats-officedocument.wordprocessingml.document","image/jpg");
	public $thumb_width							=	 array('profile'=>50,'clinic'=>50,'user_files'=>640);
	public $content_type						=	'user_files';
	public $allowed_file_types			= array('image/jpeg','image/png','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword','text/plain','application/pdf','application/zip','application/x-zip','application/x-zip-compressed');	
	public $file_path									=	TRUE;
	
	public function __construct()
	{
		parent::__construct();
	}

	public function upload()
	{
		if($this->upload_type=='base64')
		{
				return $this->base64_fileupload($this->base64_data,$this->file_name);
		}
		else if($this->upload_type=='multipart')
		{
			
				return $this->multipart_fileupload(current($this->file_data));
		}
		return array(FALSE,"please provide upload_type");
	}

	public function delete_file($file_path)
	{
		if($file_path)
		{
			if(file_exists($file_path))
			{
				$unlink = unlink($file_path);
				if($unlink)
				{
					/* code to delete thumbnail if type is image */
					$file_path_array	=	pathinfo($file_path);
					$file_type				=	$this->get_file_type();
					if($file_type	==	"image")
					{
						$file_thumbnail	=	$file_path_array['dirname']."/".$file_path_array['filename']."_t".".".$file_path_array['extension'];
						$$file_thumbnail = DOCUMENT_ROOT.$file_thumbnail;
						if(file_exists($file_thumbnail))
						{
							$unlink = unlink($file_thumbnail);
						}
					}
					/* code to delete thumbnail if type is image */
					return TRUE;
				}
			}
		}
		return FALSE;
	}
	
	private function multipart_fileupload($file)
	{
		if(isset($file['type']) && !in_array($file['type'],$this->allowed_file_types)){
			return array(FALSE,"Sorry, allowed image types are jpeg,png,pdf,document,excel");
		}
		if(isset($file["name"]))
		{
			if($file["size"]> $this->max_file_size)
			{
				return array(FALSE,"File size cannot grater than 2 MB");
			}
			$this->extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
			$this->folder =	 $this->get_file_folder();
			$file_path	=	$this->createfilepath($file["name"]);

			if(move_uploaded_file($file["tmp_name"], $file_path))
			{
				if(in_array($file['type'],array('image/jpeg','image/jpg','image/png')))
				{
					$thumbnail	=	$this->create_thumbnail($file_path,$this->thumb_width[$this->content_type]);
				}
				else if($file['type']=='application/pdf')
				{
					$thumbnail	=	'./static/images/pdf_image.jpg';
				}
				else if(in_array($file['type'],array('application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword')))
				{
					$thumbnail	=	'./static/images/document_image.jpg';
				}
				else
				{
					$thumbnail	=	'./static/images/other_image.jpg';
				}	
				$path	=	pathinfo($file_path);
				$path['thumbnail']	=	$thumbnail;
				if($this->file_path)
				{
					return array(TRUE,$path['dirname']."/".$path['basename']);
				}
				return $path;
			}
			else
			{
				return array(FALSE,"Sorry, there was an error uploading your file.");
			}
		}
		else
		{
			return array(FALSE,"no file name available");
		}
	}
	
	private function base64_fileupload($base64_file,$file_name)
	{
		if(empty($base64_file) || empty($file_name) )
		{
			return array(FALSE,"no base64 format or file_name provided");
		}

		$isvalidb64 = $this->is_base64($base64_file);
		if(!$isvalidb64)
		{
			return array(FALSE,"invalid base64 format");
		}
		$this->extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
		if(empty($this->extension))
		{
			return array(FALSE,"invalid extension");
		}
		else
		{
			if(!in_array($this->extension,array('jpg','jpeg','png','pdf','doc','docx','txt')))
			{
				return array(FALSE,"invalid extension");
			}
		}
		$this->folder =	 $this->get_file_folder();
		$file_path		=	$this->createfilepath($file_name);
		$decoded_pic   = base64_decode($base64_file);

		if(file_put_contents($file_path, $decoded_pic))
		{
			$file	=	DOCUMENT_ROOT.$file_path;
			if(filesize($file) > $this->max_file_size)
			{
					$this->delete_file($file);
					return array(FALSE,"File size cannot grater than 2 MB");
			}
			
			$finfo = new finfo(FILEINFO_MIME);
			$type = $finfo->file($file);
			$type	=	 explode(";",$type);
			$type	=	 current($type);
			if(!in_array($type,$this->file_application_types))
			{
				$this->delete_file($file);
				return array(FALSE,"invalid file type");
			}
			
			$file_type	=	$this->get_file_type();
			$thumbnail	=	'';
			
			if($file_type=='image' && !in_array($type,array("application/zip", "application/x-zip", "application/x-zip-compressed","application/pdf")))
			{
				$thumbnail	=	$this->create_thumbnail($file_path,$this->thumb_width[$this->content_type]);
			}
			else if($file_type=='pdf')
			{
				$thumbnail	=	'static/images/pdf_image.jpg';
			}
			else if($file_type=='document')
			{
				$thumbnail	=	'static/images/document_image.jpg';
			}
			else
			{
				$thumbnail	=	'static/images/other_image.jpg';
			}						
			$path	=	pathinfo($file_path);
			$path['thumbnail']	=	$thumbnail;
			if($this->file_path)
			{
				return array(TRUE,$path['dirname']."/".$path['basename']);
			}
			return $path;
		}
		else
		{
			return array(FALSE,"file not uploaded to $file_path");
		}
	}
	
	private function create_thumbnail($file_path,$thumbWidth)
	{
		$file	=	DOCUMENT_ROOT.$file_path;
		$file_data	=	pathinfo($file_path);
		$new_file	=	$file_data['dirname']."/".$file_data['filename']."_t.".$file_data['extension'];
		$new_file_path	=	DOCUMENT_ROOT.$new_file;
		$image_type	=	exif_imagetype($file);
		if($image_type==1)
		{
			$img = @imagecreatefromgif($file);
		}
		else if($image_type==2)
		{
			$img = @imagecreatefromjpeg($file);
		}
		else if($image_type==3)
		{
			$img = @imagecreatefrompng($file);
		}
		else
		{
			$img = @imagecreatefromjpeg($file);
		}
		
		// load image and get image size
		$width = imagesx( $img );
		$height = imagesy( $img );

		// calculate thumbnail size
		$new_width = $thumbWidth;
		$new_height = floor( $height * ( $thumbWidth / $width ) );

		// create a new temporary image
		$tmp_img = imagecreatetruecolor( $new_width, $new_height );

		// copy and resize old image into new image 
		imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

		// save thumbnail into a file
		
		if($image_type==1)
		{
			if(imagegif( $tmp_img, $new_file_path ))
			{
				return $new_file;
			}
		}
		else if($image_type==2)
		{
			if(imagejpeg( $tmp_img, $new_file_path ))
			{
				return $new_file;
			}
		}
		else if($image_type==3)
		{
			if(imagepng( $tmp_img, $new_file_path ))
			{
				return $new_file;
			}
		}
		else
		{
			if(imagejpeg( $tmp_img, $new_file_path ))
			{
				return $new_file;
			}
		}
		return false;		
	}
	
	private function createfilepath($file_name)
	{
		$file_name	= md5(pathinfo($file_name,PATHINFO_BASENAME));
		$md        	= substr($file_name,0,2)."/".substr($file_name,2,1);
		$structure 	= "media/".$this->folder."/".$md; 

		if(!is_dir(DOCUMENT_ROOT.$structure))
		{
			$this->mkpath(DOCUMENT_ROOT.$structure,0777);
		}
		return $structure."/".$file_name.".".$this->extension;
	}
	
	private function mkpath($path,$perm)
	{
		if(@mkdir($path) or file_exists($path)) return true;
		return ($this->mkpath(dirname($path),$perm) and mkdir($path,$perm));
	}

	private function is_base64($s)
	{
		return base64_decode($s,true);
	}

	private function get_file_type()
	{
		if(in_array($this->extension,array("jpg","jpeg","png")))
		{
			return "image";
		}
		else if($this->extension=="pdf")
		{
			return "pdf";
		}
		else if(in_array($this->extension,array("doc","docx","txt")))
		{
			return "document";
		}
		else
		{
			return "other";
		}
	}

	private function get_file_folder()
	{
		if(in_array($this->extension,array("jpg","jpeg","png")))
		{
			return "photos";
		}
		else if(in_array($this->extension,array("doc","docx","txt","pdf")))
		{
			return "reports";
		}
		else
		{
			return "other";
		}
	}
	
	public function __toString()
	{
		return (string)$this->file_name;
	}
}