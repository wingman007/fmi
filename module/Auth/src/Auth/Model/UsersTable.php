<?php
namespace Auth\Model;

use Zend\Db\TableGateway\TableGateway;

class UsersTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
	
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getUser($usr_id)
    {
        $usr_id  = (int) $usr_id;
        $rowset = $this->tableGateway->select(array('usr_id' => $usr_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

	public function getUserByToken($token)
    {
        $rowset = $this->tableGateway->select(array('usr_registration_token' => $token));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $token");
        }
        return $row;
    }
	
    public function activateUser($usr_id)
    {
		$data['usr_active'] = 1;
		$data['usr_email_confirmed'] = 1;
		$this->tableGateway->update($data, array('usr_id' => (int)$usr_id));
    }	

    public function getUserByEmail($usr_email)
    {
        $rowset = $this->tableGateway->select(array('usr_email' => $usr_email));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $usr_email");
        }
        return $row;
    }

    public function changePassword($usr_id, $password)
    {
		$data['password'] = $password;
		$this->tableGateway->update($data, array('usr_id' => (int)$usr_id));
    }
	
    public function saveUser(Auth $auth)
    {
		// for Zend\Db\TableGateway\TableGateway we need the data in array not object
        $data = array(
            'usr_name' 				=> $auth->usr_name,
            'usr_password'  		=> $auth->usr_password,
            'usr_email'  			=> $auth->usr_email,
            'usrl_id'  				=> $auth->usrl_id,
            'lng_id'  				=> $auth->lng_id,
            'usr_active'  			=> $auth->usr_active,
            'usr_question'  		=> $auth->usr_question,
            'usr_answer'  			=> $auth->usr_answer,
            'usr_picture'  			=> $auth->usr_picture,
            'usr_password_salt' 	=> $auth->usr_password_salt,
            'usr_registration_date' => $auth->usr_registration_date,
            'usr_registration_token'=> $auth->usr_registration_token,
			'usr_email_confirmed'	=> $auth->usr_email_confirmed,
        );
		// If there is a method getArrayCopy() defined in Auth you can simply call it.
		// $data = $auth->getArrayCopy();

        $usr_id = (int)$auth->usr_id;
        if ($usr_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($usr_id)) {
                $this->tableGateway->update($data, array('usr_id' => $usr_id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
	
    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('usr_id' => $usr_id));
    }	
}