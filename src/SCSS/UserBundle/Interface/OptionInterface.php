<?php
namespace SCSS\UserBundle\Interface;

interface OptionInterface
{
	public function getName();

	public function getValue();

	public function getType();

	public function isDefault();
}