<?php

namespace Konek\Database;

interface ConnectionInterface
{

	public function setConnection();

	public abstract function connection();

	public function getConnection();

	public function purgeConnection();

	public function hasConnection();

}