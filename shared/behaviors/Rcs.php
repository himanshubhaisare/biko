<?php

namespace Biko\Behaviors;

use Phalcon\DI,
	Biko\Models\Revisions,
	Biko\Models\Records;

/**
 * RcsBehavior
 *
 */
class Rcs
{

	/**
	 * Is the behavior enabled?
	 *
	 * @var boolean
	 */
	private static $_disabled = false;

	/**
	 * Fields changed
	 *
	 * @var array
	 */
	private static $_rcsChanged = array();

	/**
	 * Original record
	 *
	 * @var \Phalcon\Mvc\ModelInstance
	 */
	private static $_originalRecord = null;

	/**
	 * Saves revision master record
	 *
	 * @param \Phalcon\Mvc\ModelInstance $record
	 */
	private static function _createRevision($record)
	{

		$di = DI::getDefault();

		$session = $di->getSession();

		$identity = $session->get('identity');
		if (isset($identity['id']) && $identity['id'] > 0) {
			$rcsRevision = new Revisions();
			$rcsRevision->source = $record->getSource();
			$rcsRevision->usersId = $identity['id'];
			$rcsRevision->ipaddress = $di->getRequest()->getClientAddress();
			$rcsRevision->createdAt = time();
			if ($rcsRevision->save() == false) {
				foreach ($rcsRevision->getMessages() as $message) {
					echo $message->getMessage();
				}
			} else {
				return $rcsRevision;
			}
		}

		return false;
	}

	/**
	 * Evento para preparar la revisión antes de insertar un registro
	 *
	 * @param \Phalcon\Mvc\ModelInstance $record
	 */
	public static function beforeCreate()
	{
		self::$_rcsChanged = array();
		return true;
	}

	/**
	 * Evento para preparar la revisión antes de actualizar un registro
	 *
	 * @param \Phalcon\Mvc\ModelInstance $record
	 */
	public static function beforeUpdate($record)
	{
		if (self::$_disabled == false) {
			self::$_rcsChanged = array();
			self::$_originalRecord = clone $record;
			if (self::$_originalRecord == false) {
				throw new Exception('Record cannot be audited ' . $record->readAttribute('id'));
			} else {
				self::$_originalRecord->refresh();

				$metaData = $record->getModelsMetaData();
				$columnMap = $metaData->getColumnMap($record);
				foreach ($metaData->getAttributes($record) as $attribute) {
					if (isset($columnMap[$attribute])) {
						$attributeName = $columnMap[$attribute];
					} else {
						$attributeName = $attribute;
					}
					if ($record->readAttribute($attributeName) != self::$_originalRecord->readAttribute($attributeName)) {
						self::$_rcsChanged[$attribute] = true;
					}
				}
			}
		}
		return true;
	}

	/**
	 * Evento para grabar la revisión después de actualizar un registro
	 *
	 * @param ActiveRecordBase $record
	 */
	public static function afterUpdate($record)
	{
		if (self::$_disabled == false) {

			$rcsRevision = self::_createRevision($record);
			if ($rcsRevision == false) {
				return false;
			}

			$metaData = $record->getModelsMetaData();
			$primaryKeys = $metaData->getPrimaryKeyAttributes($record);
			$columnMap = $metaData->getColumnMap($record);

			foreach ($metaData->getAttributes($record) as $attribute) {

				$rcsRecord = new Records();

				$rcsRecord->revisionsId = $rcsRevision->id;
				$rcsRecord->fieldName = $attribute;

				if (isset($columnMap[$attribute])) {
					$attributeName = $columnMap[$attribute];
				} else {
					$attributeName = $attribute;
				}
				$rcsRecord->value = $record->readAttribute($attributeName);

				if (isset(self::$_rcsChanged[$attribute])) {
					$rcsRecord->changed = 'Y';
				} else {
					$rcsRecord->changed = 'N';
				}

				if (in_array($attribute, $primaryKeys)) {
					$rcsRecord->primary = 'Y';
				} else {
					$rcsRecord->primary = 'N';
				}

				if ($rcsRecord->save()==false) {
					foreach ($rcsRecord->getMessages() as $message){
						echo $message->getMessage();
					}
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Evento para grabar la revisión después de insertar un registro
	 *
	 * @param \Phalcon\Mvc\ModelInstance $record
	 */
	public static function afterCreate($record)
	{
		if (self::$_disabled == false) {

			$rcsRevision = self::_createRevision($record);
			if ($rcsRevision == false) {
				return false;
			}

			$metaData = $record->getModelsMetaData();
			$primaryKeys = $metaData->getPrimaryKeyAttributes($record);
			$columnMap = $metaData->getColumnMap($record);

			foreach ($metaData->getAttributes($record) as $attribute) {

				$rcsRecord = new Records();
				$rcsRecord->revisionsId = $rcsRevision->id;
				$rcsRecord->fieldName = $attribute;

				if (isset($columnMap[$attribute])) {
					$attributeName = $columnMap[$attribute];
				} else {
					$attributeName = $attribute;
				}
				$rcsRecord->value = $record->readAttribute($attributeName);

				$rcsRecord->changed = 'N';
				if (in_array($attribute, $primaryKeys)) {
					$rcsRecord->primary = 'Y';
				} else {
					$rcsRecord->primary = 'N';
				}

				if ($rcsRecord->save()==false) {
					foreach ($rcsRecord->getMessages() as $message){
						echo $message->getMessage();
					}
					return false;
				}
			}
			return true;
		}
	}

	/**
	 * Disables RCS
	 *
	 */
	public static function disable()
	{
		self::$_disabled = true;
	}

	/**
	 * This handler is called everytime an event happens in the models manager
	 *
	 * @param string $eventType
	 * @param Phalcon\Mvc\ModelInstance $record
	 */
	public function notify($eventType, $record)
    {
        switch ($eventType) {
        	case 'beforeCreate':
        		return self::beforeCreate($record);
            case 'afterCreate':
            	return self::afterCreate($record);
            case 'beforeUpdate':
        		return self::beforeUpdate($record);
            case 'afterUpdate':
            	return self::afterUpdate($record);
		}
	}

	public function missingMethod()
	{

	}

}