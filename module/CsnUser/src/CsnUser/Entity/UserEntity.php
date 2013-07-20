<?php

namespace CsnUser\Entity;
// For Zend\Db\ResultSet\HydratingResultSet. Use it for the Adapter or Table data Gateway
class UserEntity
{
    private $usr_id;
    private $usr_name;
    private $usr_password;
    private $usr_email;	
    private $usrl_id;	
    private $lng_id;	
    private $usr_active;	
    private $usr_question;	
    private $usr_answer;	
    private $usr_picture;	
    private $usr_password_salt;
    private $usr_registration_date;
    private $usr_registration_token;	
    private $usr_email_confirmed;	

	// extraction ->
	public function getUsrId() {return $this->usr_id;}
	public function getUsrName() {return $this->usr_name;}
	public function getUsrPassword() {return $this->usr_password;}
	public function getUsrEmail() {return $this->usr_email;}
	public function getUsrlId() {return $this->usrl_id;}
	public function getLngId() {return $this->lng_id;}
	public function getUsrActive() {return $this->usr_active;}
	public function getUsrQuestion() {return $this->usr_question;}
	public function getUsrAnswer() {return $this->usr_answer;}
	public function getUsrPicture() {return $this->usr_picture;}
	public function getUsrPasswordSalt() {return $this->usr_password_salt;}
	public function getUsrRegistrationDate() {return $this->usr_registration_date;}
	public function getUsrRegistrationToken() {return $this->usr_registration_token;}
	public function getUsrEmailConfirmed() {return $this->usr_email_confirmed;}
	
	// hydration <-
	public function setUsrId($usr_id) {$this->usr_id = $usr_id;}
	public function setUsrName($usr_name) {$this->usr_name = $usr_name;}
	public function setUsrPassword($usr_password) {$this->usr_password = $usr_password;}
	public function setUsrEmail($usr_email) {$this->usr_email = $usr_email;}
	public function setUsrlId($usrl_id) {$this->usrl_id = $usrl_id;}
	public function setLngId($lng_id) {$this->lng_id = $lng_id;}
	public function setUsrActive($usr_active) {$this->usr_active = $usr_active;}
	public function setUsrQuestion($usr_question) {$this->usr_question = $usr_question;}
	public function setUsrAnswer($usr_answer) {$this->usr_answer = $usr_answer;}
	public function setUsrPicture($usr_picture) {$this->usr_picture = $usr_picture;}
	public function setUsrPasswordSalt($usr_password_salt) {$this->usr_password_salt = $usr_password_salt;}
	public function setUsrRegistrationDate($usr_registration_date) {$this->usr_registration_date = $usr_registration_date;}
	public function setUsrRegistrationToken($usr_registration_token) {$this->usr_registration_token = $usr_registration_token;}
	public function setUsrEmailConfirmed($usr_email_confirmed) {$this->usr_email_confirmed = $usr_email_confirmed;}
}