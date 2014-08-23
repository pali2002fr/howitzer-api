<?php
namespace Model;

interface UserInterface
{
 	public function setId($id);
 	public function getId();

 	public function setName($name);
 	public function getName();
}