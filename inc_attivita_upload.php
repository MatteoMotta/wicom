<?
$dir = BASE_PATH."upload/";
				
					if (!is_dir($dir))
					{
					  mkdir($dir);
					  chmod($dir, 0777);
					}
					$dir = BASE_PATH."upload/$id_attivita/";
					if (!is_dir($dir))
					{
					  mkdir($dir);
					  chmod($dir, 0777);
					}

					if (strlen($_FILES['attivita_allegato']['name'])>0)
					{
					  $arr = explode('.', $_FILES['attivita_allegato']['name']);
						$ext  = strtolower(array_pop($arr));
						$upload_name = $_FILES['attivita_allegato']['name'];
						$upload_path = $dir.$upload_name;
						if (!move_uploaded_file($_FILES['attivita_allegato']['tmp_name'], $upload_path))
							die ("<font color=red>ERRORE</font>: Impossibile copiare ".$_FILES['attivita_allegato']['name']." in ".$upload_path);
						else	
							chmod($upload_path, 0777);

						$queryAllegato = "						
						INSERT INTO allegati(id_att, allegato) VALUES ('$id_attivita','$upload_name')
						";
						doQuery($queryAllegato);
						
						
					}
?>