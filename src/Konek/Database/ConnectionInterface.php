<?php

namespace Yakovmeister\Konek\Database;

interface ConnectionInterface
{

	public function setConnection();

	public function getConnection();

	public function purgeConnection();

	public function hasConnection();

}