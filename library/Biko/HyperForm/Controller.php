<?php

namespace Biko\HyperForm;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Forms\Element\Select;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Validation\Validator\PresenceOf;

use Biko\Controllers\ControllerBase;
use Biko\Reports\Report;

use Biko\Audit\Audit;

/**
 * Base Controller for HyperForm-based controllers
 */
class Controller extends ControllerBase
{
	protected $config;

	protected $form;

	protected $page;

	protected $record;

	protected $revisions;

	protected $skipOperation = false;

	public function fromInput($modelName, $data)
	{

		if (!is_array($data)) {
			throw new Exception("Input data must be an Array");
		}

		$conditions = array();
		if (count($data)) {

			$metaData = $this->getDI()->getShared('modelsMetadata');

			$model = new $modelName();
			$dataTypes = $metaData->getDataTypes($model);
			$columnMap = $metaData->getReverseColumnMap($model);

			$bind = array();

			foreach ($data as $fieldName => $value) {

				if (isset($columnMap[$fieldName])) {
					$field = $columnMap[$fieldName];
				} else {
					continue;
				}

				if (isset($dataTypes[$field])) {

					if (!is_null($value)) {
						if ($value != '') {
							$type = $dataTypes[$field];
							if ($type == 2) {
								$condition = $fieldName . " LIKE :" . $fieldName . ":";
								$bind[$fieldName] = '%' . $value . '%';
							} else {
								$condition = $fieldName . ' = :' . $fieldName . ':';
								$bind[$fieldName] = $value;
							}
							$conditions[] = $condition;
						}
					}
				}
			}
		}

		$criteria = new Criteria();
		if (count($conditions)) {
			$joinConditions = join(' AND ', $conditions);
			$criteria->where($joinConditions);
			$criteria->bind($bind);
		}

		return $criteria;

	}

	/**
	 * Default action, shows the search form
	 *
	 * @Get("/")
	 * @Get("/index")
	 */
	public function indexAction()
	{
		$form = $this->config['form'];
		$this->form = new $form;
		$this->flash->notice('Enter a search criteria or press "Search" to browse all existing ' . $this->config['plural']);
		$this->persistent->searchParams = null;
	}

	/**
	 * Search records
	 *
	 * @Route("/search", "name"="hyperform-search", "methods"={"POST", "GET"})
	 */
	public function searchAction()
	{

		$model = $this->config['model'];
		$formClass = $this->config['form'];

		$form = new $formClass(null);

		$numberPage = 1;
		if ($this->request->isPost()) {

			$data = $this->request->getPost();

			$query = $this->fromInput($model, $data);
			$parameters = $query->getParams();

			$this->persistent->searchParams = $parameters;

		} else {
			$numberPage = $this->request->getQuery("page", "int");
		}

		$parameters = array();
		if ($this->persistent->searchParams) {
			$parameters = $this->persistent->searchParams;
		}

		if (method_exists($this, 'prepareQuery')) {
			$parameters = $this->prepareQuery($parameters);
		}

		$records = $model::find($parameters);
		if (count($records) == 0) {
			$this->flash->notice("Search didn't return any " . $this->config['single']);
			return $this->dispatcher->forward(array(
				"action" => "index"
			));
		}

		$reportType = $this->request->getPost('reportType');

		if ($reportType == 'S' || !$this->request->isPost()) {

			$paginator = new Paginator(array(
				"data"  => $records,
				"limit" => 7,
				"page"  => $numberPage
			));

			$this->page = $paginator->getPaginate();
			$this->form = $form;
			return;
		}

		try {
			switch ($reportType) {
				case 'H':
					$report = new Report('Html', $form, $records);
					$path = $report->generate();
					break;
				case 'E':
					$report = new Report('Excel', $form, $records);
					$path = $report->generate();
					break;
				case 'D':
					$report = new Report('Pdf', $form, $records);
					$path = $report->generate();
					break;
				default:
					$this->flash->error("Unknown report type");
					break;
			}
		} catch (\Exception $e) {
			$this->flash->error($e->getMessage());
		}

		if (isset($path)) {
			echo '<script type="text/javascript">window.open("' . $this->url->getStatic($path) . '");</script>';
		}

		return $this->dispatcher->forward(array(
			"action" => "index"
		));
	}

	/**
	 * Creates Records
	 *
	 * @Route("/create", "name"="hyperform-create", "methods"={"GET", "POST"})
	 */
	public function createAction()
	{
		$formClass = $this->config['form'];

		$form = new $formClass(null, array('create' => true));

		if ($this->request->isPost()) {

			$model  = $this->config['model'];
			$record = new $model();

			$form->bind($this->request->getPost(), $record);

			if ($form->isValid()) {

				if (method_exists($this, 'beforeSave')) {
					$record = $this->beforeSave($record);
				}

				if (method_exists($this, 'beforeCreate')) {
					$record = $this->beforeCreate($record);
				}

				if (!$this->skipOperation) {

					if (!$record->save()) {
						$this->flash->error($record->getMessages());
					} else {

						/*Audit::create(array(
							'module' => $this->dispatcher->getControllerName(),
							'description' => self::$_config['genre'] == 'M' ? 'CREÓ UN ' . \Phalcon\Text::upper(self::$_config['single']) : 'CREÓ UNA ' . \Phalcon\Text::upper(self::$_config['single'])
						));*/

						$this->flash->success(ucfirst($this->config['single']) . " was created successfully");

						$this->tag->resetInput();
						$form->clear();
					}
				}

			} else {
				$this->flash->error('It seems there are some validation problems. Please check and try again');
			}
		}

		$this->form = $form;
	}

	/**
	 * Edits records
	 *
	 * @Route("/edit/{primary-key:[0-9]+}", "name"="hyperform-edit", "methods"={"GET", "POST"})
	 */
	public function editAction($primaryKey)
	{

		$model = $this->config['model'];

		$record = $model::findFirst(array(
			$this->config['primaryKey'] . " = ?0",
			'bind' => array($primaryKey)
		));
		if (!$record) {
			$this->flash->error("The " . $this->config['single'] . " cannot be found");
			return $this->dispatcher->forward(array('action' => 'index'));
		}

		$formClass = $this->config['form'];
		$form      = new $formClass($record, array('edit' => true));

		if ($this->request->isPost()) {

			$form->bind($this->request->getPost(), $record);

			/* beforeSave callback */
			if (method_exists($this, 'beforeSave')) {
				$this->beforeSave($record);
			}

			/* beforeUpdate callback */
			if (method_exists($this, 'beforeUpdate')) {
				$this->beforeUpdate($record);
			}

			if ($form->isValid()) {
				if (!$record->save()) {
					$this->flash->error($record->getMessages());
				} else {

					/* After update callback */
					if (method_exists($this, 'afterUpdate')) {
						$this->afterUpdate($record);
					}

					/*$message = self::$_config['genre'] == 'M' ? 'ACTUALIZÓ EL ' . \Phalcon\Text::upper(self::$_config['single']) : 'ACTUALIZÓ LA ' . \Phalcon\Text::upper(self::$_config['single']);

					Audit::create(array(
						'module'      => $this->dispatcher->getControllerName(),
						'description' => $message
					));*/

					$this->flash->success(ucfirst($this->config['single']) . " was updated successfully");

					$this->tag->resetInput();
				}
			} else {
				$this->flash->error('It seems there are some problems saving the data. Please check below');
			}

		}

		$this->form = $form;
	}

	/**
	 * Allows to see records' revisions
	 *
	 * @Route("/rcs/{primary-key:[0-9]+}", "name"="hyperform-rcs", "methods"="GET")
	 */
	public function rcsAction($pk)
	{

		$primaryKey = $this->config['primaryKey'];

		$model = $this->config['model'];
		$record = $model::findFirst(array($primaryKey . " = ?0", 'bind' => array($pk)));
		if (!$record) {
			$this->flash->error(ucfirst($this->config['single']) . " was not found");
			return $this->dispatcher->forward(array('action' => 'index'));
		}

		$this->revisions = $this->modelsManager->createBuilder()
			->columns('DISTINCT rv.id AS id')
			->from(array('re' => 'Biko\Models\Records'))
			->join('Biko\Models\Revisions', 'rv.id = re.revisionsId', 'rv')
			->where('rv.source = :source:', array('source' => $record->getSource()))
			->andWhere('re.fieldName = :fieldName: AND re.value = :value:', array('fieldName' => 'pro_id', 'value' => $pk))
			->orderBy('rv.createdAt DESC')
			->getQuery()
			->execute();

		$formClass = $this->config['form'];
		$this->form = new $formClass(null);
		$this->record = $record;
	}

	/**
	 * Deletes a record
	 *
	 * @Route("/delete/{primary-key:[0-9]+}", "name"="hyperform-delete", "methods"="GET")
	 */
	public function deleteAction($pk)
	{

		$primaryKey = $this->config['primaryKey'];

		$model = $this->config['model'];

		$record = $model::findFirst(array($primaryKey . " = ?0", 'bind' => array($pk)));
		if (!$record) {
			$this->flash->error(ucfirst($this->config['single']) . " was not found");
			return $this->dispatcher->forward(array('action' => 'index'));
		}

		if (!$record->delete()) {
			$this->flash->error($record->getMessages());
		} else {
			$this->flash->success(ucfirst($this->config['single']) . " was successfully deleted");
		}

		return $this->dispatcher->forward(array('action' => 'index'));
	}

	/**
	 * Creates a User
	 *
	 */
	public function importAction()
	{
		$formClass = self::$_config['form'];
		$form = new $formClass(null);
		$this->form = $form;

		$model = self::$_config['model'];
		if ($this->request->isPost()) {

			foreach ($this->request->getUploadedFiles() as $file) {

				switch ($file->getType()) {
					case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
						break;
					default:
						return $this->flash->error('El archivo debe tener formato de Microsoft Excel 2003 o superior');
				}

				if ($file->getError() > 0) {
					return $this->flash->error('El archivo no pudo ser cargado en el servidor');
				}

				set_time_limit(3600);

				//Include PHPExcel_IOFactory
				include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

				//Read your Excel workbook
				try {
					$inputFileType = \PHPExcel_IOFactory::identify($file->getTempName());
					$objReader     = \PHPExcel_IOFactory::createReader($inputFileType);
					$objReader->setReadDataOnly(true);
					$objPHPExcel   = $objReader->load($file->getTempName());
				} catch (\Exception $e) {
					return $this->flash->error('Error loading file "' . pathinfo($file->getTempName(), PATHINFO_BASENAME) . '": ' . $e->getMessage());
				}

				//  Get worksheet dimensions
				$sheet = $objPHPExcel->getSheet(0);
				$highestRow = $sheet->getHighestRow();
				$highestColumn = $sheet->getHighestColumn();

				$elements = $form->getElements();
				$numberElements = count($elements);

				$dataSelects = array();
				foreach ($elements as $element) {
					if ($element instanceof Select) {
						$dataOptions = array();
						$using = $element->getAttribute('using');
						$options = $element->getOptions();
						if (is_array($options)) {
							foreach ($options as $key => $value) {
								if ($key) {
									$dataOptions[$value] = $key;
									$dataOptions[$key]   = $key;
								}
							}
						} else {
							foreach ($options as $record) {
								$key   = $record->readAttribute($using[0]);
								$value = $record->readAttribute($using[1]);
								$dataOptions[$value] = $key;
								$dataOptions[$key]   = $key;
							}
						}
						$dataSelects[$element->getName()] = $dataOptions;
					}
				}

				if (isset(self::$_config['importKey'])) {
					$importKey = self::$_config['importKey'];
				} else {
					$importKey = null;
				}

				$numberOk = 0;
				try {

					$this->db->begin();

					$error = false;
					$identity = $this->session->get('identity');
					for ($row = 2; $row <= $highestRow; $row++) {

						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
						if (count($rowData[0]) != $numberElements) {
							$this->db->rollback();
							return $this->flash->error('El número de columnas en la línea ' . $row . ' (' . count($rowData[0]) . ') no coincide con el esperado ' . $numberElements);
						}

						$stopValidation = false;

						$position = 0;
						$data = array();
						foreach ($elements as $element) {
							$name = $element->getName();
							$value = $rowData[0][$position];
							if (isset($dataSelects[$name])) {
								if (!isset($dataSelects[$name][mb_strtoupper($value)])) {
									//return $this->flash->error('El valor para el campo "' . $element->getLabel() . '" no es valido en la línea ' . $row);
									if (!$error) {
										$this->flash->error('Ocurrieron errores al importar el archivo, realiza las correcciones y vuelve a subir el archivo de nuevo');
										echo '<div class="errores"><table class="table table-bordered table-striped table-condensed" align="center">
											<thead>
												<tr>
													<th>Campo</th>
													<th>Línea</th>
													<th>Mensaje</th>
												</tr>
											</thead>';
										$error = true;
									}
									echo '<tr>
										<td>', $element->getLabel(), '</td>
										<td align="right">', $row . '</td>
										<td>El valor para el campo "' . $element->getLabel() . '" no es valido</td>
									</tr>';
									$stopValidation = true;
									$value = '....';
								} else {
									$value = $dataSelects[$name][mb_strtoupper($value)];
								}
							}
							$data[$name] = $value;
							$position++;
						}

						if (!$form->isValid($data)) {
							if (!$error) {
								$this->flash->error('Ocurrieron errores al importar el archivo, realiza las correcciones y vuelve a subir el archivo de nuevo');
								echo '<div class="errores"><table class="table table-bordered table-striped table-condensed" align="center">
									<thead>
										<tr>
											<th>Campo</th>
											<th>Línea</th>
											<th>Mensaje</th>
										</tr>
									</thead>';
								$error = true;
							}
							foreach ($form->getMessages() as $message) {
								echo '<tr>
									<td>', $form->getLabel($message->getField()), '</td>
									<td align="right">', $row . '</td>
									<td>' . $message->getMessage() . '</td>
								</tr>';
							}
							$stopValidation = true;
						}

						if (!$stopValidation) {

							$record = false;
							if ($importKey) {
								$record = $model::findFirst(array(
									$importKey . ' = ?0 AND emittersId = ?1',
									'bind' => array($data[$importKey], $identity['emitterId'])
								));
							}
							if (!$record) {
								$record = new $model();
								$record->emittersId = $identity['emitterId'];
							}

							foreach ($data as $key => $value) {
								$record->writeAttribute($key, $value);
							}

							if ($record->save() == false) {
								foreach ($record->getMessages() as $message) {
									if (!$error) {
										$this->flash->error('Ocurrieron errores al importar el archivo, realiza las correcciones y vuelve a subir el archivo de nuevo');
										echo '<div class="errores"><table class="table table-bordered table-striped table-condensed" align="center">
											<thead>
												<tr>
													<th>Campo</th>
													<th>Línea</th>
													<th>Mensaje</th>
												</tr>
											</thead>';
										$error = true;
									}
									echo '<tr>
										<td>', $message->getField(), '</td>
										<td align="right">', $row . '</td>
										<td>' . $message->getMessage() . '</td>
									</tr>';
								}
							} else {
								$numberOk++;
							}
						}

					}

					if (!$error) {
						$this->db->commit();
						return $this->flash->success('Se importó correctamente el archivo. Se importaron ' . $numberOk . ' registros');
					} else {
						echo '</table></div>';
					}

				} catch (\Exception $e) {
					$this->db->rollback();
					return $this->flash->error($e->getMessage());
				}

			}

		}

	}

	public function downloadAction()
	{
		/** PHPExcel */
		include '../vendor/PHPExcel/Classes/PHPExcel.php';

		/** PHPExcel_Writer_Excel2007 */
		include '../vendor/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

		$formClass = self::$_config['form'];
		$form = new $formClass(null);

		$elements = $form->getElements();

		$excel = new \PHPExcel();

		$excel->setActiveSheetIndex(0);
		$sheet = $excel->getActiveSheet();

		$n = 0;
		foreach ($elements as $element) {
			$sheet->setCellValueByColumnAndRow($n, 1, $element->getLabel());
			$n++;
		}

		$file = 'temp/' . uniqid("", true) . '.xlsx';
		$objWriter = new \PHPExcel_Writer_Excel2007($excel);
		$objWriter->save($file);

		return $this->response->redirect($file);
	}

	public function afterExecuteRoute()
	{
		if (!isset($this->view->builder)) {
			$this->view->builder = new Builder($this->form, $this->config, $this->page, $this->record, $this->revisions);
		}
	}

}
