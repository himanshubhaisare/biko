<?php

namespace Biko\Models;

/**
 * @Source("biko_products")
 * @BelongsTo("categoriesId", "Biko\Models\Categories", "id", {"alias": "category"})
 * @Behavior("Biko\Behaviors\Rcs")
 */
class Products extends ModelBase
{

	/**
	 * @Primary
	 * @Column(type="integer", nullable=false, column="pro_id")
	 * @Identity
	 */
	public $id;

	/**
	 * @Column(type="integer", nullable=false, column="pro_cat_id")
	 */
	public $categoriesId;

	/**
	 * @Column(type="string", nullable=true, column="pro_icon")
	 */
	public $icon;

	/**
	 * @Column(type="string", nullable=false, column="pro_code")
	 */
	public $code;

	/**
	 * @Column(type="string", nullable=false, column="pro_name")
	 */
	public $name;

	/**
	 * @Column(type="string", nullable=false, column="pro_description")
	 */
	public $description;

	/**
	 * @Column(type="decimal", nullable=false, column="pro_price")
	 */
	public $price;

	/**
	 * @Column(type="integer", nullable=false, column="pro_created_at")
	 */
	public $createdAt;

}