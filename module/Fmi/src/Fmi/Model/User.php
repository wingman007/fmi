<?php
namespace Fmi;

class User
{
  protected $name;
  protected $password;
  protected $email;
  protected $role;
  
  public getName()
  {
    return $this->name;
  }
  
  public setName($name)
  {
     $this->name = $name;
  }
    
}
