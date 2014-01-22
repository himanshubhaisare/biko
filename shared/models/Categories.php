<?php

namespace Biko\Models;

/**
 * @Source("biko_categories")
 * @HasMany("id", "Biko\Models\Products", "categoriesId", {"alias": "products"})
 */
class Categories extends ModelBase
{

	/**
	 * @Primary
	 * @Column(type="integer", nullable=false, column="cat_id")
	 * @Identity
	 */
	public $id;

	/**
	 * @Column(type="string", nullable=false, column="cat_short_name")
	 */
	public $shortName;

	/**
	 * @Column(type="string", nullable=false, column="cat_name")
	 */
	public $name;

}