<?php

namespace Biko\Models;

/**
 * @Source("biko_users")
 */
class Users extends ModelBase
{

	/**
	 * @Primary
	 * @Column(type="integer", nullable=false, column="usr_id")
	 * @Identity
	 */
	public $id;

	/**
	 * @Column(type="string", nullable=false, column="usr_login")
	 */
	public $login;

	/**
	 * @Column(type="string", nullable=false, column="usr_password")
	 */
	public $password;

	/**
	 * @Column(type="string", nullable=false, column="usr_name")
	 */
	public $name;

}