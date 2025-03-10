<?php

class M_customer extends DataMapper
{
  var $table = 'clientes';

  public function __construct($id = NULL)
  {
    parent::__construct($id);
  }
}