<?php
namespace Fmi;

class Role
{
  protected $name;
  
  public getName()
  {
    return $this->name;
  }
  
  public setName($name)
  {
     $this->name = $name;
  }
    
}