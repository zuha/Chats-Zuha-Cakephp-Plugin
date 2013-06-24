<?php
App::uses('AppModel', 'Model');
/**
 * Chat Model
 *
 */
class Chat extends AppModel {
	
	/**
	 * Before save - Generates a hash with the User ID to generate a Hash Key
	 */
	 
	 public function beforeSave($options = array()) {
	 	parent::beforeSave($options);
	 	$this->data['Chat']['chat_hash'] = Security::hash(uniqid(), 'sha1', true);
		
	 }
	 
	 /**
	  * This is the check key funciton. Used by the chat server to verify that the user is logged in an allowed
	  * to use the chat. and that the request actually came from our website.
	  * 
	  * @param $key - the key generated when the user opens an chat window.
	  * @return bool - True if key exists
	  */
	  
	 public function checkChatKey($key, $uid) {
	 	$chat = $this->find('first', array(
			'conditions' => array('chat_hash' => $key),
		));
		
		if(isset($chat) && !empty($chat)) {
			if($chat['Chat']['creator_id'] == $uid) {
				return true;
			}
		}
		
		return false;
	 }
	 
}