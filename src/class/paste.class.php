<?php
// Class for ecrpyting a submiting pastes
class submit_paste {
	private function crypt_paste($paste){
			$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CFB,'');
			$key 	= mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
			$iv 	= mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
			mcrypt_generic_init($cipher, $key, $iv);
			$encrypted = mcrypt_generic($cipher,$paste);
			mcrypt_generic_deinit($cipher);
			$return = array('key' => base64_encode($key), 'paste' => base64_encode($encrypted), 'iv' => base64_encode($iv));
		return $return;
	}

	private function submitpastesql($title, $paste, $userid) {
		global $database;
		global $member;
		$encrypted = $this->crypt_paste($paste);
		$encrypted['key'] = $encrypted['key'].":".$encrypted['iv'];
		echo "Key: ".$encrypted['key']."</br>Encryted text: <textarea>".$encrypted['paste']."</textarea>";

		//$database->query("INSERT INTO pastes (title, userid, paste, iv) VALUES (:title, :userid, :paste, :iv);",
		//	array(':title' => $title, ':userid' => $userid, ':paste' => $sections[1], ':iv' => $sections[2]));

		$database->query("INSERT INTO pastes (title, userid, paste) VALUES (:title, :userid, :paste);",
			array(':title' => $title, ':userid' => $userid, ':paste' => $encrypted['paste']));

		$database->query("SELECT id FROM pastes WHERE title = :title AND paste = :paste LIMIT 0, 1;",
			array(':title' => $title, ':paste' => $encrypted['paste']));
		if($database->count() === 1) {
			$data = $database->statement->fetch(PDO::FETCH_OBJ);
			echo '</br>You can view your paste with the following link</br>
				<a href="'.$member->currentPath().'paste.php?action=getpaste&id='.$data->id.'&key='.$encrypted['key'].'\"/>Here</a></br>';
		} else echo "</br>Database error</br>";
		return;
	}

	public function submitpaste($title, $paste){
		if(@$_SESSION['member_id']){
			$this->submitpastesql($title,$paste,$_SESSION['member_id']);
		} else {
			$err = "E10";
			return $err;
		}

	}

	public function grabpaste($pasteid,$iv,$key = null){
		global $database;
		$database->query("SELECT paste, title FROM pastes WHERE id = :id LIMIT 0, 1;",
			array( ':id' => $pasteid));

		if($database->count() === 1) {
			$data = $database->statement->fetch(PDO::FETCH_OBJ);
			if (null === $key) {
				echo "</br>You did no supply a key, Decryption was not attempted.";
			} else {
				$d = $this->decrypt_paste($data->paste,$key,$iv);
				$return = array('title' => $data->title, 'paste' => $d);
			}
			
		} else {
			$err = "E1";
			return $err;
		}
		return $return;
	}

	private function decrypt_paste($encrypted_paste, $key, $iv){
		$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CFB,'');
		mcrypt_generic_init($cipher, base64_decode($key), base64_decode($iv));
		$decrypted = mdecrypt_generic($cipher,base64_decode($encrypted_paste));
		mcrypt_generic_deinit($cipher);
		//$last_char=substr($decrypted,-1);
		return $decrypted;
	}
}
