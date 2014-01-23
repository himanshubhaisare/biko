<?php

namespace Biko\Models;

use Phalcon\Mvc\Model;

/**
 * @Source("biko_revisions")
 * @HasMany("id", "Biko\Models\Records", "revisionsId", {"alias"="records"})
 * @BelongsTo("usersId", "Biko\Models\Users", "id", {"alias"="user"})
 */
class Revisions extends Model
{
	/**
	 * @Identity
	 * @Primary
     * @Column(type="integer", nullable=true, column="rev_id")
	 */
	public $id;

	/**
	 * @Column(type="string", nullable=false, column="rev_source")
	 */
	public $source;

	/**
     * @Column(type="integer", nullable=false, column="rev_users_id")
	 */
	public $usersId;

	/**
	 * @Column(type="string", nullable=false, column="rev_ipaddress")
	 */
	public $ipaddress;

	/**
	 * @Column(type="string", nullable=false, column="rev_date")
	 */
	public $createdAt;

}
