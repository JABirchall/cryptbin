<?php
// Class for ecrpyting a submiting pastes
class submit_paste {
	private function crypt_paste($paste){
			$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CFB,'');
			$key 	= base64_encode(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
			$iv 	= base64_encode(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
			mcrypt_generic_init($cipher, $key, $iv);
			$encrypted = mcrypt_generic($cipher,$paste);
			mcrypt_generic_deinit($cipher);
			$return = $key.":".base64_encode($encrypted).":".$iv;
		return $return;
	}

	private function submitpastesql($title, $paste, $userid) {
		global $database;
		global $member;
		$sections = explode(":",$this->crypt_paste($paste));
		//echo "Key: ".$sections[0]." </br>Encryted text: ".$sections[1]." </br>IV: ".$sections[2];

		$database->query("INSERT INTO pastes (title, userid, paste, iv) VALUES (:title, :userid, :paste, :iv);",
			array(':title' => $title, ':userid' => $userid, ':paste' => $sections[1], ':iv' => $sections[2]));

		$database->query("SELECT id, iv, key FROM pastes WHERE title = :title AND iv = :iv LIMIT 0, 1;",array(':title' => $title, ':iv' => $sections[2]));
		if($database->count() == 1) {
			$data = $database->statement->fetch(PDO::FETCH_OBJ);
			echo "You can view your paste with the following link</br>
				<a href=\"".$member->currentPath()."paste.php?action=getpaste&iv=".$data->iv."&id=".$data->id."&key=".$data->key."\"/>Here</a></br>";
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
		$database->query("SELECT paste, title FROM pastes WHERE iv = :iv AND id = :id LIMIT 0, 1;",
			array(':iv' => $iv, ':id' => $pasteid));
		if($database->count() >= '1') {
			$data = $database->statement->fetch(PDO::FETCH_OBJ);
			//echo $data->paste."</br>";
			if (null == $key) {
				echo "</br>You did no supply a key, Decryption was not attempted.";
			} else {
				$d = $this->decrypt_paste($data->paste,$key,$iv);
				echo "</br>title: ".$data->title. "</br>text: ".$d;
			}

			return;
		} else {
			$err = "E1";
			return $err;
		}
	}

	private function decrypt_paste($encrypted_paste,$key,$iv){
		$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CFB,'');
		mcrypt_generic_init($cipher, $key, $iv);
		$decrypted = mdecrypt_generic($cipher,base64_decode($encrypted_paste));
		mcrypt_generic_deinit($cipher);
		$last_char=substr($decrypted,-1);
		return $decrypted;
	}
}