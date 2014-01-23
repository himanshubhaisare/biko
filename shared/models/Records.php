<?php

namespace Biko\Models;

use Phalcon\Mvc\Model;

/**
 * @Source("biko_records")
 * @HasMany("revisionsId", "Invoicing\Models\Revisions", "id", {"alias": "revisions"})
 */
class Records extends Model
{
	/**
	 * @Primary
	 * @Identity
     * @Column(type="integer", nullable=true, column="rec_id")
	 */
	public $id;

	/**
     * @Column(type="integer", nullable=false, column="rec_rev_id")
	 */
	public $revisionsId;

	/**
	 * @Column(type="string", nullable=false, column="rec_field_name")
	 */
	public $fieldName;

	/**
	 * @Column(type="string", nullable=true, column="rec_value")
	 */
	public $value;

	/**
	 * @Column(type="string", nullable=false, column="rec_is_primary")
	 */
	public $primary;

	/**
	 * @Column(type="string", nullable=false, column="rec_changed")
	 */
	public $changed;

}
